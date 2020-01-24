<?php

use Behat\MinkExtension\Context\MinkContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

class FeatureContext extends MinkContext
{
    const DOCUMENT_ROOT = __DIR__ . '/../../server.root';
    const CONTACTS_FILE = self::DOCUMENT_ROOT . '/data/contacts.json';

    /**
     * @Given a clean setup
     */
    public function aCleanSetup()
    {
        file_put_contents(self::CONTACTS_FILE, '{}');
    }

    /**
     * @Given contact persons:
     */
    public function contactPersons(TableNode $table)
    {
        $contacts = [];

        foreach ($table->getRowsHash() as $id => $hash) {
            $contacts[$id] = [
                'id' => $id,
                'name' => $hash[0] ?? '',
                'account' => $hash[1] ?? '',
                'mail' => $hash[2] ?? '',
                'phone' => $hash[3] ?? '',
                'comment' => $hash[4] ?? '',
                'status' => $hash[5] ?? 'ACTIVE',
            ];
        }

        file_put_contents(self::CONTACTS_FILE, json_encode($contacts));
    }
}
