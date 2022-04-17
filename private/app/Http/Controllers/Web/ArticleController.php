<?php

namespace App\Http\Controllers\Web;

use App\Models\Entities\Article;
use App\Models\Entities\Page;
use Breadcrumbs;
use Exception;
use Illuminate\View\View;

class ArticleController extends WebController
{
    public function index()
    {
        // Get page
        $page = cache()->rememberForever('page_article_'.app()->getLocale(), function()  {
            return Page::where('template', 'Article')->firstOrFail();
        });
        view()->share('page', $page);

        // Get data
        $articles = cache()->rememberForever('articles_'.app()->getLocale(), function()  {
            return Article::all();
        });
        view()->share('articles', $articles);

        // Set meta tags
        $page->setMetaTags();

        // Set localization url
        $this->setLocalizationURLS($page);

        // Breadcrumbs
        Breadcrumbs::for('web.'.app()->getLocale().'.article.index', function ($trail) use ($page) {
            $trail->parent('web.'.app()->getLocale().'.home');
            $trail->push($page->getTitle(), $page->getViewLink());
        });

        // Return custom or detail view
        return view($page->getTemplate());
    }

    public function detail($slug)
    {
        // Get page
        $page = cache()->rememberForever('page_article_'.app()->getLocale(), function()  {
            return Page::where('template', 'Article')->firstOrFail();
        });
        view()->share('page', $page);

        // Get row
        $row = cache()->rememberForever('article_'.app()->getLocale().'_'.$slug, function() use ($slug) {
            return article::findBySlug($slug)->firstOrFail();
        });
        view()->share('row', $row);

        // Set meta tags
        $row->setMetaTags();

        // Set localization url
        $this->setLocalizationURLS($row);

        // Breadcrumbs
        Breadcrumbs::for('web.'.app()->getLocale().'.article.detail', function ($trail) use ($page, $row) {
            $trail->parent('web.'.app()->getLocale().'.home');
            $trail->push($page->getTitle(), $page->getViewLink());
            $trail->push($row->getTitle(), $row->getViewLink());
        });

        // Return custom or detail view
        return view('web.'.$row->modelMeta['name'].'.detail');
    }
}
