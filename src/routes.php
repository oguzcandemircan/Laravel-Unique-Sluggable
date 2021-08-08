<?php

use Illuminate\Support\Facades\Route;
use OguzcanDemircan\LaravelUniqueSluggable\Controllers\SlugController;

if (config('laravel-unique-sluggable.register_route_automatically')) {
    Route::fallback(function (string $slug) {
        $params = request()->segments();
        app(SlugController::class)->index(request(), end($params), $params);
    });
}
