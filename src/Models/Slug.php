<?php

namespace OguzcanDemircan\LaravelUniqueSluggable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Slug extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;

    protected $guarded = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug'
            ]
        ];
    }

    /**
     * Get the owning sluggable model.
     */
    public function model()
    {
        return $this->morphTo('sluggable');
    }
}
