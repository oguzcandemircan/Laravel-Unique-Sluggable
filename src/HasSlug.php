<?php

namespace App\Traits;

use LogicException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Cviebrock\EloquentSluggable\Services\SlugService;
use OguzcanDemircan\LaravelUniqueSluggable\Models\Slug;

/**
 * Slug Trait
 */
trait HasSlug
{
    //public $controller;

    public function __construct()
    {
        if(!$this->route) {
            throw new LogicException(get_class($this) . ' must have a $route');
        }
        if(! is_array($this->route)) {
            throw new LogicException('$controller must array');
        }
    }

    public function getController()
    {
        list($controller, $method) = $this->route;
        return app($controller)->$method($this);
    }

    public static function bootSlugTrait()
    {
        static::deleted(function (Model $model) {
            $model->removeSlugAttribute();
        });

        static::saved(function (Model $model) {
            $model->createOrUpdateSlug();
        });

        static::updated(function (Model $model) {
            $model->createOrUpdateSlug();
        });
    }

    public function getSlug()
    {
        $slugSource = $this->slugSource ?? 'name';
        return $this->attributes[$slugSource];
    }

    /**
     * Sluggable Relation
     *
     * @return object
     */
    public function sluggable(): MorphOne
    {
        return $this->morphOne(Slug::class, 'sluggable');
    }

    /**
     * Get Slug Attribute
     *
     * @return string
     */
    public function getSlugAttribute(): string | null
    {
        return optional($this->sluggable)->slug;
    }

    /**
     * Create or update slug
     *
     * @param string $slug
     * @return void
     */
    public function createOrUpdateSlug(): void
    {
        $slug = SlugService::createSlug(Slug::class, 'slug', $this->getSlug());
        $this->sluggable()->updateOrCreate($this->getWhere(), [
            'slug' => $slug
        ]);
    }


    public function getWhere(): array
    {
        return [
            'sluggable_id' => $this->id,
            'sluggable_type' => get_class($this)
        ];
    }


    /**
     * Remove slug
     *
     * @return void
     */
    public function removeSlugAttribute(): void
    {
        $this->sluggable()->findBySlug($this->slug)->delete();
    }
}
