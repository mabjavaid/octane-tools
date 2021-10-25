<?php

namespace Mabjavaid\OctaneTools\Facades;

use Illuminate\Support\Facades\Facade;

class OctaneTools extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'octane-tools';
    }
}
