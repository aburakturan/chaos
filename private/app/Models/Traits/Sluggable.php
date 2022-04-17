<?php

namespace App\Models\Traits;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

trait Sluggable
{
    public $slugableSeperator = '-';
    public $slugableField = 'slug';

    /**
     * Auto boot trait
     *
     * https://github.com/laravel/framework/blob/5.8/src/Illuminate/Database/Eloquent/Model.php#L207
     */
    public static function bootSluggable()
    {
        static::saving(function ($model) {
            foreach (config('app.locales') as $locale => $localeMeta) {
                $model->{'slug:'.$locale} = $model->generateSlug($locale);
            }
        });

        static::updating(function ($model) {
            foreach (config('app.locales') as $locale => $localeMeta) {
                $model->{'slug:'.$locale} = $model->generateSlug($locale);
            }
        });
    }

    /**
     * @param null $locale
     * @return string|null
     */
    public function getSlugSource($locale = null) {
        if (is_null($locale)) {
            $locale = app()->getLocale();
        }

        if ($this->getForceSlug($locale)) {
            return $this->getForceSlug($locale);
        }

        return $this->getTitle($locale);
    }

    /**
     * Generate new slug from source variable
     * @param string $locale Example: tr, en, fr
     * @param integer $i Counter for exists slugs
     * @return string          Generated slug text via slugify
     * @throws Exception
     */
    public function generateSlug($locale = null, $i = 0)
    {
        $source = $this->getSlugSource($locale);

        // Set default locale
        if (is_null($locale)) {
            $locale = app()->getLocale();
        }

        // Return blank
        if (!$source) {
            throw new Exception('Source is null!');
        }

        // Generate slug via slugify package
        if ($i == 0) {
            $slug = $this->slugify($source);
        } else {
            $slug = $this->slugify($source.$this->slugableSeperator.$i);
        }

        // Get model and model transition model
        $model = get_class($this);
        $modelTranslation = $model.config('translatable.translation_suffix', 'Translation');

        // Create models
        $model = new $model;
        $modelTranslation = new $modelTranslation;

        // Control slug is exists
        $isExists = $modelTranslation::where($this->slugableField, $slug)
            ->where(config('translatable.locale_key', 'locale'), $locale);

        $modelMetaName = str_replace('-', '_', $model->modelMeta['name']);

        // Create or Edit query
        if (is_null($this->id)) {
            $isExists = $isExists->exists();
        } else {
            $isExists = $isExists->where($modelMetaName.'_id', '<>', $this->id)->exists();
        }

        if (!$isExists) {
            return $slug;
        } else {
            $i++;
            return $this->generateSlug($locale, $i);
        }
    }

    /**
     * Source convert to slug type
     * @param  string $source
     * @return string
     */
    public function slugify($source)
    {
        $source = strip_tags($source);
        return str_slug($source, $this->slugableSeperator, 'tr');
    }

    /**
     * Returns generated slug
     * @param  string $locale
     * @return string
     */
    public function getSlug($locale = null)
    {
        return is_null($this->translate($locale)) ? null : $this->translate($locale)->slug;
    }

    /**
     * Returns force slug
     * @param  string $locale
     * @return string
     */
    public function getForceSlug($locale = null)
    {
        return is_null($this->translate($locale)) ? null : $this->translate($locale)->force_slug;
    }

    /**
     * Scope - for slug field query
     * @param  Builder $query
     * @param  string $slug
     * @param  string $locale
     * @return Collection
     */
    public function scopefindBySlug($query, $slug, $locale = null)
    {
        if (is_null($locale)) {
            $locale = app()->getLocale();
        }

        return $query->whereHas('translations', function ($slugQuery) use ($slug, $locale) {
            $slugQuery->where(config('translatable.locale_key', 'locale'), $locale)
                ->where($this->slugableField, $slug);
        });
    }

    /**
     * Scope - for slug and parent slug field query
     * @param  string $query
     * @param  string $slug
     * @param  string $locale
     * @return Collection
     */
    public function scopefindBySlugPath($query, $slug, $locale = null)
    {
        $slugs = explode('/', $slug);

        if (count($slugs) == 1) {
            return $this->findBySlug($slug, $locale)->where('parent_id', null)->firstOrFail();
        }

        // Nested
        $firstSlug = $slugs[0];
        $firstNode = $this->findBySlug($firstSlug, $locale);

        return $this->searchBySlug($firstNode->firstOrFail(), $slugs);
    }

    public function searchBySlug($node, $nestedSlugs, $depth = 1)
    {
        foreach ($node->children as $child) {
            if (isset($nestedSlugs[$depth])) {
                if ($child->getSlug() == $nestedSlugs[$depth]) {
                    $node = $child;

                    if ($child->children) {
                        $depth++;
                        $node = $this->searchBySlug($child, $nestedSlugs, $depth);
                    }
                }
            }
        }

        return $node;
    }
}
