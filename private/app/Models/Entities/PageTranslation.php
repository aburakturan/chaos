<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PageTranslation extends Model
{
    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'slug',
        'force_slug',
        'content',
        'meta_title',
        'meta_description',
    ];

    /**
     * Set logable fields
     */
    protected static $logAttributes = [
        'page_id',
        'locale',
        'title',
        'slug',
        'force_slug',
        'content',
        'meta_title',
        'meta_description',
    ];
}
