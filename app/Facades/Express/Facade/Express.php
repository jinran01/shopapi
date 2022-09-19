<?php

namespace App\Facades\Express\Facade;
use Illuminate\Support\Facades\Facade;

class Express extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Express';
    }
}
