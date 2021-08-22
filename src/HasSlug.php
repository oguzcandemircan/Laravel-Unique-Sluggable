<?php

namespace OguzcanDemircan\LaravelUniqueSluggable;

use LogicException;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use OguzcanDemircan\LaravelUniqueSluggable\Models\Slug;

/**
 * Slug Trait
 */
trait HasSlug
{
    public static function bootHasSlug(): void
    {
        if (!property_exists(self::class, 'route')) {
            throw new LogicException(self::class . ' must have a $route property');
        }

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

    public function getSlug(): string
    {
        $slugSource = $this->getSlugSource();
        return $this->getAttribute($slugSource);
    }

    public function getSlugSource(): string
    {
        if (property_exists($this, 'slugSource')) {
            return $this->slugSource;
        }
        return config('laravel-unique-sluggable.default_slug_source');
    }

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
        $seperator = config('laravel-unique-sluggable.seperator');
        $language = config('laravel-unique-sluggable.language');
        $slug = Str::slug(
            $this->getSlug(),
            $seperator,
            $language
        );

        $slugModel = $this->sluggable;

        if (config('laravel-unique-sluggable.if_slug_exists_get_validation_error')) {
            if ($this->checkSlugExists($slug, optional($slugModel)->slug)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'slug' => ["[$slug] already taken"],
            ]);
            }
        } else {
            $i = 1;
            $originalSlug = $slug;
            while ($this->checkSlugExits($slug, optional($slugModel)->slug)) {
                $i++;
                $slug = $originalSlug.$seperator.$i;
            }
        }

        if ($slugModel) {
            if (config('laravel-unique-sluggable.update_slug_when_model_is_updated')) {
                $this->sluggable()->update(['slug' => $slug]);
            }
        } else {
            $this->sluggable()->create(['slug' => $slug]);
        }
    }


    public function checkSlugExits($newSlug, $originalSlug): bool
    {
        return Slug::where('slug', '!=', $originalSlug)
            ->where('slug', $newSlug)
            ->exists();
    }

    /**
     * Remove slug
     *
     * @return void
     */
    public function removeSlugAttribute(): void
    {
        $this->sluggable()->where('slug', $this->slug)->delete();
    }

    public function getController()
    {
        list($controller, $method) = $this->route;
        return app($controller)->$method($this);
    }
}
