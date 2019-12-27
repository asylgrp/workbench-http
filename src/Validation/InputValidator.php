<?php

declare(strict_types = 1);

namespace workbench\webb\Validation;

use byrokrat\banking\AccountFactoryInterface;

// TODO implement validation
class InputValidator
{
    private AccountFactoryInterface $accountFactory;

    public function __construct(AccountFactoryInterface $accountFactory)
    {
        $this->accountFactory = $accountFactory;
    }

    public function validateName(string $tainted): ResultInterface
    {
        return new Valid($tainted);
    }

    public function validateId(string $tainted): ResultInterface
    {
        return new Valid($tainted);
    }

    public function validateStatus(string $tainted): ResultInterface
    {
        // TODO ACTIVE, BANNED eller BLOCKED
        return new Valid($tainted);
    }

    public function validateAccount(string $tainted): ResultInterface
    {
        //  TODO måste göra ordentlig input validation först för att kolla tecken..
        try {
            $this->accountFactory->createAccount($tainted);
            return new Valid($tainted);
        } catch (\Exception $e) {
            return new Invalid($e->getMessage());
        }
    }

    public function validateMail(string $tainted): ResultInterface
    {
        return new Valid($tainted);
    }

    public function validatePhone(string $tainted): ResultInterface
    {
        return new Valid($tainted);
    }

    public function validateComment(string $tainted): ResultInterface
    {
        return new Valid($tainted);
    }
}
