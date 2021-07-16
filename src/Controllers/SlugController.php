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
        $model = $slug->model;
        if($model){
            return $model->getController();
        }
    }
}