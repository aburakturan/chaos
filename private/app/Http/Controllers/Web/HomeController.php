<?php

namespace App\Http\Controllers\Web;

use App\Models\Entities\Page;
use Exception;
use Illuminate\View\View;

class HomeController extends WebController
{
    /**
     * Show the application home page
     *
     * @return View
     * @throws Exception
     */
    public function index()
    {
        // Get page
        $page = cache()->rememberForever('page_home_'.app()->getLocale(), function()  {
            return Page::where('template', 'Home')->firstOrFail();
        });
        view()->share('page', $page);

        // Set meta tags
        $page->setMetaTags();

        // Set Localization
        $this->setLocalizationURLS($page);

        return view($page->getTemplate());
    }
}
