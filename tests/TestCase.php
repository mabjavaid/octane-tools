<?php

namespace Mabjavaid\OctaneTools\Tests;

use Mabjavaid\OctaneTools\OctaneToolsServiceProvider;
use Orchestra\Testbench\TestCase as Test;

class TestCase extends Test
{
    protected function getPackageProviders($app)
    {
        return [
            OctaneToolsServiceProvider::class,
        ];
    }
}
