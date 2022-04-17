<?php

namespace App\Models\Entities;

use Spatie\Activitylog\Models\Activity as SpatieActivity;
use App\Models\Traits\ActionsTrait;

class Activity extends SpatieActivity
{
    use ActionsTrait;

    /**
     * Set model meta properties
     */
    public $modelMeta = [
        'name' => 'activity-log',
    ];

    public function getTitle()
    {
        $class = get_class($this->subject);
        $className = class_basename($class);

        if (method_exists($this->subject, 'getTitle')) {
            return $this->subject->getTitle();
        }

        if (strpos($className, 'Translation') !== false) {
            $model = str_replace('Translation', '', $class);
            $model = new $model;
            $attributes = $this->changes()['attributes'];

            if (isset($attributes[$model->modelMeta['name'] . '_id'])) {
                $row = $model::find($attributes[$model->modelMeta['name'] . '_id']);

                if (!is_null($row) && method_exists($row, 'getTitle')) {
                    return sprintf('%s (Translation - %s)', $row->getTitle(), $attributes['locale']);
                }
            }
        }

        return $className;
    }
}
