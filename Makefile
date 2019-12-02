PHPSPEC=vendor/bin/phpspec
BEHAT=vendor/bin/behat
PHPSTAN=vendor/bin/phpstan
PHPCS=vendor/bin/phpcs
SECURITY_CHECKER=vendor/bin/security-checker
INROUTE=vendor/bin/inroute

COMPOSER_CMD=composer

TARGET=workbench-webb.zip

CONTAINER=src/DependencyInjection/ProjectServiceContainer.php
ROUTER=src/Http/HttpRouter.php

SRC_FILES:=$(shell find src/ -type f -name '*.php' ! -path $(CONTAINER))
ETC_FILES:=$(shell find etc/ -type f -name '*')
HTTP_FILES:=$(shell find src/Http/ -type f -name '*.php' ! -path $(ROUTER))

DEV_SERVER_HOST=localhost
DEV_SERVER_PORT=8888

.DEFAULT_GOAL=all

.PHONY: all build clean

all: test build

build: preconds $(TARGET)

$(TARGET): deps $(CONTAINER) $(ROUTER) $(SRC_FILES) composer.lock
	#$(COMPOSER_CMD) install --prefer-dist --no-dev
	# ...
	#$(COMPOSER_CMD) install

$(CONTAINER): vendor/installed $(ETC_FILES) $(SRC_FILES)
	bin/build_container > $@

$(ROUTER): vendor/installed $(HTTP_FILES)
	$(INROUTE) build

clean: stop
	rm $(TARGET) --interactive=no -f
	rm $(CONTAINER) -f
	rm $(ROUTER) -f
	rm -rf vendor
	rm -rf vendor-bin

#
# Build preconditions
#

.PHONY: preconds dependency_check security_check

preconds: dependency_check security_check

dependency_check: vendor/installed
	$(COMPOSER_CMD) validate --strict
	$(COMPOSER_CMD) outdated --strict --minor-only

security_check: deps
	$(SECURITY_CHECKER) security:check composer.lock

#
# Development webserver
#

.PHONY: start stop

DOCUMENT_ROOT=server.root
SERVER_PID_FILE=server.PID
export WORKBENCH_INI=$(DOCUMENT_ROOT)/workbench.ini

start: $(SERVER_PID_FILE)

stop: $(SERVER_PID_FILE)
	-kill `cat $<`
	rm $<
	rm -rf $(DOCUMENT_ROOT)

$(SERVER_PID_FILE): vendor/installed
	mkdir -p $(DOCUMENT_ROOT)
	cp workbench.ini.dist $(WORKBENCH_INI)
	{ php -S $(DEV_SERVER_HOST):$(DEV_SERVER_PORT) -t $(DOCUMENT_ROOT) public/index.php & echo $$! > $@; }

#
# Tests and analysis
#

.PHONY: test phpspec behat phpstan phpcs

test: phpspec behat phpstan phpcs

phpspec: deps
	$(PHPSPEC) run

behat: deps $(CONTAINER) $(ROUTER) start
	$(BEHAT) --stop-on-failure

phpstan: deps
	$(PHPSTAN) analyze -c phpstan.neon -l 7 src

phpcs: deps
	$(PHPCS) src --standard=PSR2 --ignore=$(CONTAINER),$(ROUTER)
	$(PHPCS) spec --standard=spec/ruleset.xml

#
# Dependencies
#

.PHONY: deps

deps: vendor/installed vendor-bin/installed

composer.lock: composer.json
	@echo composer.lock is not up to date

vendor/installed: composer.lock
	$(COMPOSER_CMD) install
	touch $@

vendor-bin/installed:
	$(COMPOSER_CMD) bin phpspec require phpspec/phpspec:^6
	$(COMPOSER_CMD) bin behat require behat/behat:^3 behat/mink-extension:^2 behat/mink-goutte-driver:^1
	$(COMPOSER_CMD) bin phpstan require "phpstan/phpstan:<2"
	$(COMPOSER_CMD) bin phpcs require squizlabs/php_codesniffer:^3
	$(COMPOSER_CMD) bin security-checker require sensiolabs/security-checker
	touch $@
