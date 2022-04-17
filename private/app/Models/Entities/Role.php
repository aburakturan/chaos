<?php

namespace App\Models\Entities;

use App\Models\Traits\ActionsTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use ActionsTrait;
    use LogsActivity;

    /**
     * Set model meta properties
     */
    public $modelMeta = [
        'name' => 'role',
    ];

    /**
     * Set logable fields
     */
    protected static $logAttributes = [
        'name',
        'title',
    ];

    /**
     * Returns role title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns role name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
