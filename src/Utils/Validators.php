<?php

declare(strict_types = 1);

namespace workbench\webb\Utils;

use hanneskod\clean\Rule;
use hanneskod\clean\ValidatorInterface;

// TODO implementations and tests
class Validators
{
    public static function nameValidator(): ValidatorInterface
    {
        return (new Rule);
    }

    public static function idValidator(): ValidatorInterface
    {
        return (new Rule);
    }

    public static function statusValidator(): ValidatorInterface
    {
        // TODO ACTIVE, BANNED eller BLOCKED
        return (new Rule);
    }

    public static function accountValidator(): ValidatorInterface
    {
        return (new Rule);
    }

    public static function mailValidator(): ValidatorInterface
    {
        return (new Rule);
    }

    public static function phoneValidator(): ValidatorInterface
    {
        return (new Rule);
    }

    public static function textValidator(): ValidatorInterface
    {
        return (new Rule);
    }
}
