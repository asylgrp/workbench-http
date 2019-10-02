<?php

namespace workbench\webb\Config;

interface RepositoryInterface
{
    /**
     * Get mixed configurations loaded in repository
     */
    public function getConfigs(): array;
}
