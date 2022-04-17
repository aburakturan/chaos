<?php

namespace App\Models\Entities;

use App\Models\Traits\ActionsTrait;
use App\Models\Traits\MetaTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Sentence extends Model
{
    use ActionsTrait;
    use LogsActivity;
    use MetaTrait;
    use SoftDeletes;
    use Translatable;

    /**
     * Set model meta properties
     */
    public $modelMeta = [
        'name' => 'sentence',
    ];

    /**
     * Set translatable fields
     */
    public $translatedAttributes = [
        'content',
    ];

    /**
     * Set logable fields
     */
    protected static $logAttributes = [
        'name',
    ];

    /**
     * Set fillable fields
     */
    protected $fillable = [
        'name',
        'content',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * Returns service name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns service name
     * @return string
     */
    public function getTitle()
    {
        return $this->getName();
    }

    /**
     * Returns sentence content
     * @param null $locale
     * @return string
     */
    public function getContent($locale = null)
    {
        return is_null($this->translate($locale)) ? null : $this->translate($locale)->content;
    }

    /**
     * Returns sentence excerpt
     * @param int $limit
     * @param null $locale
     * @return string
     */
    public function getExcerpt($limit = 200, $locale = null)
    {
        return strLimit($this->getContent($locale), $limit);
    }
}
