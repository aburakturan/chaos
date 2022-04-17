<?php

/**
 * Web Pages Breadcrumbs
 */

foreach (config('app.locales') as $locale => $localeData) {
    // Home
    Breadcrumbs::for('web.'.$locale.'.home', function ($breadcrumbs) {
        $breadcrumbs->push(getPageByTemplate('Home')['title'], getPageByTemplate('Home')['viewLink']);
    });
}
