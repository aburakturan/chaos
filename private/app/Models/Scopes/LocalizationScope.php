<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Request;

class LocalizationScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     * @param Builder $builder
     * @param Model $model
     * @return Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        if (!is_null(Request::route())) {
            if (trim(Request::route()->getPrefix(), '/') != env('APP_ADMIN_PREFIX')) {
                return $builder->whereHas('translations', function ($q) use ($model) {
                    $q->where('locale', '=', app()->getLocale());

                    foreach ($model->requiredLocalizationAttributes as $column) {
                        $q->where($column, '<>', '');
                    }
                });
            }
        }
    }
}
