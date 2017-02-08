<?php

namespace SqlCs\Console;

use Symfony\Component\Console\Application as BaseApplication;

final class Application extends BaseApplication
{
    const VERSION = '0.0.1-DEV';

    /**
     * Constructor.
     */
    public function __construct()
    {
        error_reporting(-1);

        parent::__construct('SQL CS', self::VERSION);

    }
}
