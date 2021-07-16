<?php

namespace OguzcanDemircan\LaravelUniqueSluggable\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use OguzcanDemircan\LaravelUniqueSluggable\Models\Slug;

class SlugController extends Controller
{
    public function index(Request $request, $slug)
    {
        $slug = Slug::findBySlug($slug);
        if ($slug) {
            $model = $slug->model;
            if ($model) {
                return $model->getController();
            }
        }
        abort(404, 'slug not found');
    }
}