<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SentenceTranslation extends Model
{
    use LogsActivity;

    public $timestamps = false;

    /**
     * Set fillable fields
     */
    protected $fillable = [
        'content',
    ];

    /**
     * Set logable fields
     */
    protected static $logAttributes = [
        'sentence_id',
        'locale',
        'content',
    ];
}
