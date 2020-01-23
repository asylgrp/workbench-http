<?php

namespace workbench\webb\Db\Yayson;

use workbench\webb\Db\ContactPersonRepository;
use workbench\webb\Db\TransactionHandlerInterface;
use asylgrp\decisionmaker\Normalizer\ContactPersonNormalizer;
use hanneskod\yaysondb\Yaysondb;
use hanneskod\yaysondb\Engine\FlysystemEngine;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

class YaysondbFactory
{
    private const CONTACTS_FNAME = 'contacts.json';

    private Yaysondb $yaysondb;

    public function __construct(string $dsn)
    {
        $fs = new Filesystem(new Local($dsn));

        $this->assertFile($fs, self::CONTACTS_FNAME);

        $this->yaysondb = new Yaysondb([
            'contacts' => new FlysystemEngine(self::CONTACTS_FNAME, $fs)
        ]);
    }

    public function createContactPersonRepository(ContactPersonNormalizer $normalizr): ContactPersonRepository
    {
        return new YaysonContactPersonRepository($this->yaysondb->collection('contacts'), $normalizr);
    }

    public function createTransactionHandler(): TransactionHandlerInterface
    {
        return new YaysonTransactionHandler($this->yaysondb);
    }

    private function assertFile(Filesystem $fs, string $fname): void
    {
        if (!$fs->has($fname)) {
            $fs->write($fname, '');
        }
    }
}
