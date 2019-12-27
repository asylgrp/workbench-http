<?php

declare(strict_types = 1);

namespace workbench\webb\DependencyInjection;

use workbench\webb\Validation\InputValidator;

/**
 * Use this trait to automatically inject an inpput validator
 */
trait ValidatorProperty
{
    protected InputValidator $validator;

    /**
     * @required
     */
    public function setInputValidator(InputValidator $validator): void
    {
        $this->validator = $validator;
    }
}
