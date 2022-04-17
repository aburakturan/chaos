<?php

namespace App\Http\Controllers\Web;

use App\Models\Entities\Lazanya;
use App\Models\Entities\Page;
use Breadcrumbs;
use Exception;
use Illuminate\View\View;

class LazanyaController extends WebController
{
    public function index()
    {
        // Get page
        $page = cache()->rememberForever('page_lazanya_'.app()->getLocale(), function()  {
            return Page::where('template', 'Lazanya')->firstOrFail();
        });
        view()->share('page', $page);

        // Get data
        $lazanyas = cache()->rememberForever('lazanyas_'.app()->getLocale(), function()  {
            return Lazanya::all();
        });
        view()->share('lazanyas', $lazanyas);

        // Set meta tags
        $page->setMetaTags();

        // Set localization url
        $this->setLocalizationURLS($page);

        // Breadcrumbs
        Breadcrumbs::for('web.'.app()->getLocale().'.lazanya.index', function ($trail) use ($page) {
            $trail->parent('web.'.app()->getLocale().'.home');
            $trail->push($page->getTitle(), $page->getViewLink());
        });

        // Return custom or detail view
        return view($page->getTemplate());
    }

    public function detail($slug)
    {
        // Get page
        $page = cache()->rememberForever('page_lazanya_'.app()->getLocale(), function()  {
            return Page::where('template', 'Lazanya')->firstOrFail();
        });
        view()->share('page', $page);

        // Get row
        $row = cache()->rememberForever('lazanya_'.app()->getLocale().'_'.$slug, function() use ($slug) {
            return lazanya::findBySlug($slug)->firstOrFail();
        });
        view()->share('row', $row);

        // Set meta tags
        $row->setMetaTags();

        // Set localization url
        $this->setLocalizationURLS($row);

        // Breadcrumbs
        Breadcrumbs::for('web.'.app()->getLocale().'.lazanya.detail', function ($trail) use ($page, $row) {
            $trail->parent('web.'.app()->getLocale().'.home');
            $trail->push($page->getTitle(), $page->getViewLink());
            $trail->push($row->getTitle(), $row->getViewLink());
        });

        // Return custom or detail view
        return view('web.'.$row->modelMeta['name'].'.detail');
    }
}
