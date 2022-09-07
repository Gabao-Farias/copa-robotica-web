<?php

namespace App\Components\Helpers;

use Illuminate\Support\Facades\Facade;

class HelpersFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'helpers'; }
}