<?php

use Behat\MinkExtension\Context\MinkContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

class FeatureContext extends MinkContext
{
    const DOCUMENT_ROOT = __DIR__ . '/../../server.root';

    /**
     * @Given a clean setup
     */
    public function aCleanSetup()
    {
        // TODO empty database and perform other cleaning tasks..
    }
}
