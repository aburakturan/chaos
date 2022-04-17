<?php

namespace App\Http\Controllers\Web;

use App\Models\Entities\Page;
use Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PageController extends WebController
{
    /**
     * Show the page index
     *
     * @param null $slug
     * @return View|RedirectResponse
     * @throws Exception
     */
    public function index($slug = null)
    {
        // Get page
        $page = cache()->rememberForever('page_'.app()->getLocale().'_'.$slug, function() use ($slug) {
            return Page::with('children')->findBySlugPath($slug);
        });
        view()->share('page', $page);

        // Spam or invalid URL check
        if (!request()->fullUrlIs($page->getViewLink(app()->getLocale()))) {
            return redirect($page->getViewLink(), 301);
        }

        // Set meta tags
        $page->setMetaTags();

        // Set localization url
        $this->setLocalizationURLS($page);

        // Breadcrumbs
        Breadcrumbs::for('web.'.app()->getLocale().'.page', function ($trail) use ($page) {
            $trail->parent('web.'.app()->getLocale().'.home');
            $trail->push($page->getTitle(), $page->getViewLink());
        });

        // Return custom or detail view
        return view($page->getTemplate());
    }
}
