<?php

return [
    /**
     * if value is true, package register routes automatically
     * or you must register route manually with LaravelUniqueSluggable::register() method
     */
    'register_route_automatically' => true,

    'default_slug_source' => 'title',

    'seperator' => '-',

    'langauge' => app()->getLocale(),

    'if_slug_exists_get_validation_error' => false,

    'update_slug_when_model_is_updated' => false,
];
