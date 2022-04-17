<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller as Controller;
use App\Models\Entities\Page;
use App\Models\Entities\Sentence;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public $localizationURLs;

    /**
     * Base controller for admin controller panel
     */
    public function __construct()
    {
        $this->getPages();
        $this->getSentences();
        $this->setLocalizationURLS(null, '');
    }

    public function getPages()
    {
        // Get All Pages
        if (cache()->get('allPages_'.app()->getLocale())) {
            config()->set('pages_'.app()->getLocale(), cache()->get('allPages_'.app()->getLocale()));
        } else {
            $pages = collect();

            foreach (Page::with('children', 'ancestors')->get() as $page) {
                $pages->push([
                    'id' => $page->id,
                    'template' => $page->template,
                    'title' => $page->getTitle(app()->getLocale()),
                    'viewLink' => $page->getViewLink(app()->getLocale()),
                    'slug' => $page->getSlug(app()->getLocale()),
                ]);
            }

            cache()->forever('allPages_'.app()->getLocale(), $pages);
            config()->set('pages_'.app()->getLocale(), $pages);
        }
    }

    public function getSentences()
    {
        $getAllSentences = cache()->remember('sentences_'.app()->getLocale(), 60 * 24, function () {
            return Sentence::all();
        });
        $sentences = [];
        $locale = app()->getLocale();

        foreach ($getAllSentences as $sentence) {
            $sentences[$sentence->name] = $sentence->getContent($locale);
        }

        config()->set('sentences', $sentences);
    }

    /**
     * Localization custom urls
     *
     * @param mixed $row
     * @param mixed $url
     */
    public function setLocalizationURLS($row = null, $url = null)
    {
        if (!is_null($row)) {
            foreach (config('app.locales') as $key => $locale) {
                $url = $row->getViewLink($key);

                if (is_null($url)) {
                    continue;
                }

                $this->localizationURLs[$key] = Request::create($url, 'GET', request()->all())->fullUrl();
            }
        } elseif (!is_null($url)) {
            foreach (config('app.locales') as $key => $locale) {
                $this->localizationURLs[$key] = Request::create(url($key.'/'.$url), 'GET', request()->all())->fullUrl();
            }
        }

        view()->share('localizationURLs', $this->localizationURLs);
    }
}
