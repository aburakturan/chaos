<?php

namespace App\Models\Entities;

use App\Models\Scopes\DefaultOrderScope;
use App\Models\Traits\ActionsTrait;
use App\Models\Traits\ImageTrait;
use App\Models\Traits\MetaTrait;
use App\Models\Traits\Sluggable;
use Astrotomic\Translatable\Translatable;
use Exception;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Route;
use Spatie\Activitylog\Traits\LogsActivity;

class Page extends Model
{
    use ActionsTrait;
    use ImageTrait;
    use LogsActivity;
    use MetaTrait;
    use NodeTrait;
    use Sluggable;
    use SoftDeletes;
    use Translatable;

    /**
     * Set model meta properties
     */
    public $modelMeta = [
        'name' => 'page',
        'defaultTemplate' => 'web.page.index',
    ];

    /**
     * Set translatable fields
     */
    public $translatedAttributes = [
        'title',
        'slug',
        'force_slug',
        'content',
        'meta_title',
        'meta_description',
    ];

    /**
     * Set required fields for localization
     */
    public $requiredLocalizationAttributes = [
        'title',
    ];

    /**
     * Set logable fields
     */
    protected static $logAttributes = [
        'parent_id',
        'template',
    ];

    /**
     * Set fillable fields
     */
    protected $fillable = [
        'template',
    ];

    /**
     * Set image attributes
     */
    public $imageAttributes = [
        'image' => [
            [
                'w' => 900,
                'h' => 350,
                'template' => 'image',
            ],
        ],
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DefaultOrderScope());
    }

    /**
     * Generate viewable link
     * @param string $locale
     * @return mixed
     * @throws Exception
     */
    public function getViewLink($locale = null)
    {
        if (is_null($locale)) {
            $locale = app()->getLocale();
        }

        $routeName = 'web.'.$locale.'.page';

        if (!Route::has($routeName)) {
            throw new Exception('Route not found: ' . $routeName);
        }

        if ($this->isRoot()) {
            $slug = $this->getSlug($locale);
        } else {
            $slug = '';

            foreach ($this->ancestors as $parent) {
                $slug .= '/'.$parent->getSlug($locale);
            }

            $slug .= '/'.$this->getSlug($locale);
        }

        $slug = ltrim($slug, '/');

        return route($routeName, ['slug' => $slug]);
    }

    /**
     * Returns page title
     * @param null $locale
     * @return string
     */
    public function getTitle($locale = null)
    {
        return is_null($this->translate($locale)) ? null : $this->translate($locale)->title;
    }

    /**
     * Returns page content
     * @param null $locale
     * @return string
     */
    public function getContent($locale = null)
    {
        return is_null($this->translate($locale)) ? null : $this->translate($locale)->content;
    }

    /**
     * Return custom template path
     * @return string
     */
    public function getTemplate()
    {
        if ($this->template) {
            return 'web.page.templates.'.$this->template;
        }

        return $this->modelMeta['defaultTemplate'];
    }

    /**
     * Get all avaible template blades for select on admin panel
     * @return array
     */
    public function getAllTemplates()
    {
        $fileArray = [];

        $files = File::allFiles(base_path().'/resources/views/web/page/templates');
        foreach ($files as $file) {
            $fileName = str_replace('.blade.php', '', $file->getFileName());
            $fileArray[] = [
                'value' => $fileName,
                'label' => $fileName,
                'selected' => ($this->template == $fileName ? true : false),
            ];
        }

        return $fileArray;
    }

    /**
     * SEO
     */
    public function seoMetaTitle($locale = null)
    {
        return is_null($this->translate($locale)) ? null : $this->translate($locale)->meta_title;
    }

    public function seoMetaDescription($locale = null)
    {
        return is_null($this->translate($locale)) ? null : $this->translate($locale)->meta_description;
    }
}
