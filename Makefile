COMPOSER_CMD=composer
PHIVE_CMD=phive

PHPSPEC_CMD=tools/phpspec
BEHAT_CMD=vendor/bin/behat
PHPSTAN_CMD=tools/phpstan
PHPCS_CMD=tools/phpcs
SECURITY_CHECKER_CMD=vendor/bin/security-checker
INROUTE_CMD=tools/inroute

TARGET=workbench-webb.zip

CONTAINER=src/DependencyInjection/ProjectServiceContainer.php
ROUTER=src/Http/HttpRouter.php

SRC_FILES:=$(shell find src/ -type f -name '*.php' ! -path $(CONTAINER) ! -path $(ROUTER))
ETC_FILES:=$(shell find etc/ -type f -name '*')
HTTP_FILES:=$(shell find src/Http/ -type f -name '*.php' ! -path $(ROUTER))

.DEFAULT_GOAL=all

.PHONY: all
all: test analyze preconds build

.PHONY: build
build: $(CONTAINER) $(ROUTER) $(TARGET)

.PHONY: preconds
preconds: composer.lock $(SECURITY_CHECKER_CMD)
	$(SECURITY_CHECKER_CMD) security:check composer.lock

$(TARGET): vendor/installed $(CONTAINER) $(ROUTER) $(SRC_FILES)
	#$(COMPOSER_CMD) install --prefer-dist --no-dev
	# ...
	#$(COMPOSER_CMD) install

$(CONTAINER): vendor/installed $(ETC_FILES) $(SRC_FILES)
	bin/build_container > $@

$(ROUTER): vendor/installed $(HTTP_FILES) $(INROUTE_CMD)
	$(INROUTE_CMD) build

.PHONY: clean
clean: stop
	rm $(TARGET) --interactive=no -f
	rm $(CONTAINER) -f
	rm $(ROUTER) -f
	rm -rf vendor
	rm -rf vendor-bin
	rm -rf tools


# Development webserver

DEV_SERVER_HOST=localhost
DEV_SERVER_PORT=8000
export WORKB_BASE_DIR=server.root
DEV_SERVER_PID_FILE=server.PID

.PHONY: start
start: $(DEV_SERVER_PID_FILE)

.PHONY: stop
stop: $(DEV_SERVER_PID_FILE)
	-kill `cat $<`
	rm $<
	rm -rf $(WORKB_BASE_DIR)

$(DEV_SERVER_PID_FILE): vendor/installed
	mkdir -p $(WORKB_BASE_DIR)
	{ php -S $(DEV_SERVER_HOST):$(DEV_SERVER_PORT) -t $(WORKB_BASE_DIR) public/index.php & echo $$! > $@; }


# Tests and analysis

.PHONY: test
test: phpspec behat

.PHONY: phpspec
phpspec: vendor/installed $(PHPSPEC_CMD)
	$(PHPSPEC_CMD) run

.PHONY: behat
behat: vendor/installed $(CONTAINER) $(ROUTER) start $(BEHAT_CMD)
	$(BEHAT_CMD) --stop-on-failure

.PHONY: analyze
analyze: phpstan phpcs

.PHONY: phpstan
phpstan: vendor/installed $(PHPSTAN_CMD)
	$(PHPSTAN_CMD) analyze -c phpstan.neon -l 7 src

.PHONY: phpcs
phpcs: composer.lock $(PHPCS_CMD)
	$(PHPCS_CMD) src --standard=PSR2 --ignore=$(CONTAINER),$(ROUTER)
	$(PHPCS_CMD) spec --standard=spec/ruleset.xml

.PHONY: ci
ci: vendor/installed start $(BEHAT_CMD) $(PHPSPEC_CMD)
	$(PHPSPEC_CMD) run --verbose
	$(BEHAT_CMD)


# Dependencies

composer.lock: composer.json
	@echo composer.lock is not up to date

vendor/installed: composer.lock
	$(COMPOSER_CMD) install
	touch $@

$(PHPSPEC_CMD):
	$(PHIVE_CMD) install phpspec/phpspec:6 --force-accept-unsigned

$(BEHAT_CMD):
	$(COMPOSER_CMD) bin behat require behat/behat:^3 behat/mink-extension:^2 behat/mink-goutte-driver:^1

$(PHPSTAN_CMD):
	$(PHIVE_CMD) install phpstan

$(PHPCS_CMD):
	$(PHIVE_CMD) install phpcs

$(SECURITY_CHECKER_CMD):
	$(COMPOSER_CMD) bin security-checker require sensiolabs/security-checker

$(INROUTE_CMD):
	$(PHIVE_CMD) install inroutephp/console:1 --force-accept-unsigned
