<?php

namespace OguzcanDemircan\LaravelUniqueSluggable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Slug extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function model()
    {
        return $this->morphTo('sluggable');
    }

    public function scopeWhereSlug(Builder $scope, string $slug): Builder
    {
        return $scope->where('slug', $slug);
    }
  
    public static function findBySlug(string $slug, array $columns = ['*'])
    {
        return static::whereSlug($slug)->first($columns);
    }

    public static function findBySlugOrFail(string $slug, array $columns = ['*'])
    {
        return static::whereSlug($slug)->firstOrFail($columns);
    }
}
