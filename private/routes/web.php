<?php

if (!Schema::hasTable('pages')) {
    return;
}

use Spatie\Honeypot\ProtectAgainstSpam;

foreach (config('app.locales') as $locale => $localeData) {
    Route::group(['prefix' => $locale], function () use ($locale) {
        // Home
        Route::get('/', 'HomeController@index')->name('web.'.$locale.'.home');

        // Article Resource
        $articlePage = App\Models\Entities\Page::whereTemplate('Article')->first();
        if (!is_null($articlePage) && !is_null($articlePage->getSlug($locale))) {
            Route::get($articlePage->getSlug($locale), [
                'uses' => 'ArticleController@index',
                'as' => 'web.' . $locale . '.article.index',
            ]);

            Route::get($articlePage->getSlug($locale) . '/{slug}', [
                'uses' => 'ArticleController@detail',
                'as' => 'web.' . $locale . '.article.detail',
            ]);
        }
        
        // Lazanya Resource
        $lazanyaPage = App\Models\Entities\Page::whereTemplate('Lazanya')->first();
        if (!is_null($lazanyaPage) && !is_null($lazanyaPage->getSlug($locale))) {
            Route::get($lazanyaPage->getSlug($locale), [
                'uses' => 'LazanyaController@index',
                'as' => 'web.' . $locale . '.lazanya.index',
            ]);

            Route::get($lazanyaPage->getSlug($locale) . '/{slug}', [
                'uses' => 'LazanyaController@detail',
                'as' => 'web.' . $locale . '.lazanya.detail',
            ]);
        }
        
        // Category Resource
        $categoryPage = App\Models\Entities\Page::whereTemplate('Category')->first();
        if (!is_null($categoryPage) && !is_null($categoryPage->getSlug($locale))) {
            Route::get($categoryPage->getSlug($locale), [
                'uses' => 'CategoryController@index',
                'as' => 'web.' . $locale . '.category.index',
            ]);

            Route::get($categoryPage->getSlug($locale) . '/{slug}', [
                'uses' => 'CategoryController@detail',
                'as' => 'web.' . $locale . '.category.detail',
            ]);
        }
        
        //INNER_PART_FOR_STUB_GENERATION_DONT_DELETE

        // Other Pages
        Route::get('/{slug?}', [
            'uses' => 'PageController@index',
            'as' => 'web.'.$locale.'.page',
            'except' => '_debugbar',
        ]);
    });
}
