<?php

namespace OguzcanDemircan\LaravelUniqueSluggable\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelUniqueSluggable extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laraveluniquesluggable';
    }
}
