<?php

namespace App\Models\Entities;

use App\Models\Traits\ActionsTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use ActionsTrait;
    use LogsActivity;

    /**
     * Set model meta properties
     */
    public $modelMeta = [
        'name' => 'permission',
    ];

    /**
     * Set logable fields
     */
    protected static $logAttributes = [
        'name',
        'title',
    ];

    /**
     * Returns permission title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns permission name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
