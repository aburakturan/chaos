<?php

namespace App\Providers;

use Route;
use Schema;
use Illuminate\Support\ServiceProvider;
use Twitter;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        URL::forceRootUrl(config('app.url'));
        Schema::defaultStringLength(191);

        $this->metaTagsOverride();
        $this->panelResources();
    }

    /*
     *  Admin Panel Routes
     */
    public function panelResources() {
        Route::macro('panelResource', function($name, $controller, array $options) {
            if (!isset($options['except'])) {
                $options['except'] = ['show'];
            }

            Route::resource('/'.$name, $controller, [
                'names' => [
                    'index' => 'admin.' . $name . '.index',
                    'create' => 'admin.' . $name . '.create',
                    'store' => 'admin.' . $name . '.store',
                    'show' => 'admin.' . $name . '.show',
                    'edit' => 'admin.' . $name . '.edit',
                    'update' => 'admin.' . $name . '.update',
                    'destroy' => 'admin.' . $name . '.destroy',
                ],
                'except' => $options['except']
            ]);

            if (isset($options['sortable']) && $options['sortable'] == true) {
                Route::get('/' . $name . '/sort', [
                    'uses' => $controller.'@sort',
                    'as' => 'admin.' . $name . '.sort',
                ]);

                Route::put('/' . $name . '/sort/rebuild-tree', [
                    'uses' => $controller.'@rebuildTree',
                    'as' => 'admin.' . $name . '.rebuild-tree',
                ]);
            }

            Route::get('/' . $name . '/{'.$name.'}/hard-delete-confirmation', [
                'uses' => $controller . '@hardDeleteConfirmation',
                'as' => 'admin.' . $name . '.hard-delete-confirmation',
            ]);

            Route::delete('/' . $name . '/{'.$name.'}/hard-delete', [
                'uses' => $controller . '@hardDelete',
                'as' => 'admin.' . $name . '.hard-delete',
            ]);

            if (isset($options['softDelete']) && $options['softDelete'] == true) {
                Route::get('/' . $name . '/trash', [
                    'uses' => $controller . '@trash',
                    'as' => 'admin.' . $name . '.trash',
                ]);

                Route::get('/' . $name . '/{'.$name.'}/delete-confirmation', [
                    'uses' => $controller . '@deleteConfirmation',
                    'as' => 'admin.' . $name . '.delete-confirmation',
                ]);

                Route::get('/' . $name . '/{'.$name.'}/restore-confirmation', [
                    'uses' => $controller . '@restoreConfirmation',
                    'as' => 'admin.' . $name . '.restore-confirmation',
                ]);

                Route::put('/' . $name . '/{'.$name.'}/restore', [
                    'uses' => $controller . '@restore',
                    'as' => 'admin.' . $name . '.restore',
                ]);
            }

            if (isset($options['gallery']) && $options['gallery'] == true) {
                Route::get('/'.$name.'/{'.$name.'}/gallery', [
                    'uses' => $controller . '@galleryIndex',
                    'as' => 'admin.' . $name . '.gallery-index',
                ]);

                Route::post('/'.$name.'/{'.$name.'}/gallery/gallery-store', [
                    'uses' => $controller . '@galleryStore',
                    'as' => 'admin.' . $name . '.gallery-store',
                ]);

                Route::put('/'.$name.'/{'.$name.'}/gallery/gallery-update', [
                    'uses' => $controller . '@galleryUpdate',
                    'as' => 'admin.' . $name . '.gallery-update',
                ]);

                Route::delete('/'.$name.'/{'.$name.'}/gallery/gallery-hard-delete', [
                    'uses' => $controller . '@galleryHardDelete',
                    'as' => 'admin.' . $name . '.gallery-hard-delete',
                ]);

                Route::get('/'.$name.'/{'.$name.'}/gallery/sort', [
                    'uses' => $controller . '@gallerySort',
                    'as' => 'admin.' . $name . '.gallery-sort',
                ]);

                Route::put('/'.$name.'/{'.$name.'}/gallery/sort/rebuild-tree', [
                    'uses' => $controller . '@galleryRebuildTree',
                    'as' => 'admin.' . $name . '.gallery-rebuild-tree',
                ]);
            }
        });
    }

    /**
     * Override default seo tool variables
     */
    public function metaTagsOverride()
    {
        // Title
        config()->set('seotools.meta.defaults.title', setting('title_'.app()->getLocale()));
        config()->set('seotools.opengraph.defaults.title', setting('title_'.app()->getLocale()));

        // Description
        config()->set('seotools.meta.defaults.description', setting('meta_description_'.app()->getLocale()));
        config()->set('seotools.opengraph.defaults.description', setting('meta_description_'.app()->getLocale()));

        // Twitter
        if (setting('social_twitter')) {
            Twitter::setSite('@'.basename(setting('social_twitter')));
            Twitter::setType('summary_large_image');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function () {
            return base_path().'/../public_html';
        });
    }
}
