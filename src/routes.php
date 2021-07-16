<?php

use Illuminate\Support\Facades\Route;
use OguzcanDemircan\LaravelUniqueSluggable\Controllers\SlugController;

Route::get('/{slug}', [SlugController::class, 'index'])->where('any', '.*');