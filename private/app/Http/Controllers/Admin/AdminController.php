<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Controller;
use App\Models\Entities\Role;
use Breadcrumbs;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Route;

class AdminController extends Controller
{
    /**
     * Set page meta tags
     *
     * @var array
     */
    protected $pageMeta = [
        'title' => '',
        'desc' => '',
    ];

    /**
     * Set model localizations
     */
    protected $modelMeta = [
        'name' => '',
        'singularTitle' => '',
        'pluralTitle' => '',
        'deleteTitle' => '',
    ];

    /**
     * Base controller for admin controller panel
     */
    public function __construct()
    {
        $this->controlMiddleware();
        $this->generatePageMeta();
        $this->generateBreadCrumb();
        $this->generateModelMeta();
        $this->cacheFlush();
    }

    /**
     * Flush all cache object
     * @throws Exception
     */
    public function cacheFlush()
    {
        cache()->flush();
    }

    /**
     * Create alias for permission name via route get
     * Example: admin.model.restore-confirmation (route name) => admin.model.restore (permission name)
     * @return mixed
     */
    public function controlMiddleware()
    {
        $routeName = Route::currentRouteName();

        if (isset($this->excludeThisRouteForControlMiddleware) && in_array($routeName, $this->excludeThisRouteForControlMiddleware)) {
            return;
        }

        $permissionName = $routeName;

        $routeAction = explode('.', $routeName);
        $routeAction = '.'.last($routeAction);

        $routeChange = [
            'current' => [
                '.restore-confirmation',
                '.store',
                '.update',
                '.destroy',
                '.delete-confirmation',
                '.hard-delete',
                '.hard-delete-confirmation',
                '.trash',
                '.sort',
                '.rebuild-tree',
                '.gallery-rebuild-tree',
                '.show',
            ],
            'change' => [
                '.restore',
                '.create',
                '.edit',
                '.delete',
                '.delete',
                '.hard-delete',
                '.hard-delete',
                '.hard-delete',
                '.edit',
                '.edit',
                '.edit',
                '.index',
            ],
        ];

        if (in_array($routeAction, $routeChange['current'])) {
            $permissionName = str_replace($routeChange['current'], $routeChange['change'], $routeName);
        }

        $this->middleware('permission:'.$permissionName);
    }

    /**
     * Generate page meta tags
     */
    public function generatePageMeta()
    {
        view()->share('pageMeta', (object) $this->pageMeta);
    }

    /**
     * These properties will use on admin pages on model page
     */
    public function generateModelMeta()
    {
        view()->share('modelMeta', (object) $this->modelMeta);
    }

    /**
     * Generate breadcrumb on the fly via use current route name
     * This breadcrumb name defined on routes/breadcrumb.php file
     */
    public function generateBreadCrumb()
    {
        // Home > Model
        if ($this->modelMeta['name'] && !Breadcrumbs::exists('admin.'.$this->modelMeta['name'].'.index')) {
            Breadcrumbs::for('admin.'.$this->modelMeta['name'].'.index', function ($breadcrumbs) {
                $breadcrumbs->parent('admin.home');

                if (Route::has('admin.'.$this->modelMeta['name'].'.index')) {
                    $breadcrumbs->push($this->modelMeta['pluralTitle'], route('admin.'.$this->modelMeta['name'].'.index'));
                } elseif (Route::has('admin.'.$this->modelMeta['name'].'.edit')) {
                    $breadcrumbs->push($this->modelMeta['singularTitle'], route('admin.'.$this->modelMeta['name'].'.edit'));
                }
            });
        }

        // Share breadcrumb
        $breadCrumbName = Route::currentRouteName();
        view()->share('breadCrumbName', $breadCrumbName);
    }

    /**
     * Generate view path for admin pages
     * @param string $path blade name
     * @param string $name model name
     * @return string
     */
    public function getViewPath($path, $name = null)
    {
        if (is_null($name) && isset($this->modelMeta)) {
            $name = $this->modelMeta['name'];
        }

        if ($path) {
            if (view()->exists('admin.'.$name.'.'.$path)) {
                return 'admin.'.$name.'.'.$path;
            } else {
                return $this->getGeneralViewPath($path);
            }
        }

        return 'admin.{$name}';
    }

    public function getGeneralViewPath($name)
    {
        return 'admin.template.model.'.$name;
    }

    /**
     * Generate auto resource message
     * @param  string $page action page name
     */
    public function generateFlashMessagePage($page)
    {
        // Soft delete or Hard delete message override $page variable
        if ($page == 'destroy' && !Route::has('admin.'.$this->modelMeta['name'].'.trash')) {
            $page = 'hard-delete';
        }

        switch ($page) {
            case 'store':
                $this->generateFlashMessage('success', sprintf('Yeni %s Eklendi!', $this->modelMeta['singularTitle']));
            break;
            case 'update':
                $this->generateFlashMessage('success', sprintf('%s Bilgileri Güncellendi', $this->modelMeta['singularTitle']));
            break;
            case 'destroy':
                $this->generateFlashMessage('success', sprintf('%s Çöp Kutusuna Taşındı', $this->modelMeta['singularTitle']));
            break;
            case 'hard-delete':
                $this->generateFlashMessage('success', sprintf('%s Kalıcı Olarak Silindi', $this->modelMeta['singularTitle']));
            break;
            case 'restore':
                $this->generateFlashMessage('success', sprintf('%s Geri Alındı', $this->modelMeta['singularTitle']));
            break;
        }
    }

    public function generateFlashMessage($type, $message)
    {
        return session()->flash($type, $message);
    }

    public function processAfter($row, $type) {
        if ($type == 'store') {
            $row->save();
        } else {
            $row->update();
        }

        // Set status
        $this->generateFlashMessagePage($type);

        if ($type == 'store') {
            $redirect = redirect()->route('admin.'.$this->modelMeta['name'].'.edit', $row);
        } else {
            $redirect = redirect()->back();
        }

        return $redirect;
    }

    /**
     * Create model methods for override after usage
     */
    public function index($rows)
    {
        // Share rows
        view()->share('rows', $rows);

        // Show index page
        return view($this->getViewPath('index'));
    }

    public function sort($rows)
    {
        // Home > Model > Create
        Breadcrumbs::for('admin.'.$this->modelMeta['name'].'.sort', function ($breadcrumbs) {
            $breadcrumbs->parent('admin.'.$this->modelMeta['name'].'.index');
            $breadcrumbs->push('Sırala');
        });

        // Share rows
        view()->share('rows', $rows);

        // MaxDepth
        view()->share('maxDepth', (isset($this->modelMeta['maxDepth']) ? $this->modelMeta['maxDepth'] : 5));

        // Show index page
        return view($this->getViewPath('sort'));
    }

    public function show($row)
    {
        // Home > Model > Show
        Breadcrumbs::for('admin.'.$this->modelMeta['name'].'.show', function ($breadcrumbs) use ($row) {
            $breadcrumbs->parent('admin.'.$this->modelMeta['name'].'.index');

            if (!is_null($row)) {
                $breadcrumbs->push($row->getTitle(), $row->getEditLink());
            }

            $breadcrumbs->push('Görüntüle');
        });

        // Share row
        view()->share('row', $row);

        // Show show page
        return view($this->getViewPath('show'));
    }

    public function create($row = null)
    {
        // Home > Model > Create
        Breadcrumbs::for('admin.'.$this->modelMeta['name'].'.create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin.'.$this->modelMeta['name'].'.index');
            $breadcrumbs->push('Yeni Ekle');
        });

        // Share row
        view()->share('row', $row);

        // Show create page
        return view($this->getViewPath('create'));
    }

    public function edit($row)
    {
        // Home > Model > Edit
        Breadcrumbs::for('admin.'.$this->modelMeta['name'].'.edit', function ($breadcrumbs) use ($row) {
            $breadcrumbs->parent('admin.'.$this->modelMeta['name'].'.index');

            if (!is_null($row) && auth()->user()->can('admin.'.$row->modelMeta['name'].'.edit')) {
                $breadcrumbs->push($row->getTitle(), $row->getEditLink());
            }

            $breadcrumbs->push('Düzenle');
        });

        // Share row
        view()->share('row', $row);

        // Show edit page
        return view($this->getViewPath('edit'));
    }

    public function deleteConfirmation($row)
    {
        // Home > Model > Delete Confirmation
        Breadcrumbs::for('admin.'.$this->modelMeta['name'].'.delete-confirmation', function ($breadcrumbs) use ($row) {
            $breadcrumbs->parent('admin.'.$this->modelMeta['name'].'.index');

            if (!is_null($row)) {
                $breadcrumbs->push($row->getTitle(), $row->getEditLink());
            }

            $breadcrumbs->push('Çöpe Taşı');
        });

        // Share row
        view()->share('row', $row);

        // Show delete confirmation page
        return view($this->getViewPath('delete-confirmation'));
    }

    public function destroy($row)
    {
        // Process
        $row->delete();

        // Set status
        $this->generateFlashMessagePage('destroy');

        // Redirect to model index page
        return redirect()->route('admin.'.$this->modelMeta['name'].'.index');
    }

    public function hardDeleteConfirmation($row)
    {
        // Home > Model > Hard Delete Confirmation
        Breadcrumbs::for('admin.'.$this->modelMeta['name'].'.hard-delete-confirmation', function ($breadcrumbs) use ($row) {
            $breadcrumbs->parent('admin.'.$this->modelMeta['name'].'.index');

            if (!is_null($row)) {
                $breadcrumbs->push($row->getTitle(), $row->getEditLink());
            }

            $breadcrumbs->push('Kalıcı Olarak Sil');
        });

        // Share row
        view()->share('row', $row);

        // Show hard delete confirmation page
        return view($this->getViewPath('hard-delete-confirmation'));
    }

    public function hardDelete($row)
    {
        // Process
        $row->forceDelete();

        // Set status
        $this->generateFlashMessagePage('hard-delete');

        // Redirect to model index page
        return redirect()->route('admin.'.$this->modelMeta['name'].'.index');
    }

    public function restoreConfirmation($row)
    {
        // Home > Model > Restore Confirmation
        Breadcrumbs::for('admin.'.$this->modelMeta['name'].'.restore-confirmation', function ($breadcrumbs) use ($row) {
            $breadcrumbs->parent('admin.'.$this->modelMeta['name'].'.index');

            if (!is_null($row)) {
                $breadcrumbs->push($row->getTitle(), $row->getEditLink());
            }

            $breadcrumbs->push('Geri Al');
        });

        // Share row
        view()->share('row', $row);

        // Show restore confirmation page
        return view($this->getViewPath('restore-confirmation'));
    }

    public function restore($row)
    {
        // Process
        $row->restore();

        // Set status
        $this->generateFlashMessagePage('restore');

        // Redirect to model index page
        return redirect()->route('admin.'.$this->modelMeta['name'].'.index');
    }

    public function trash($rows)
    {
        // Home > Model > Trash
        Breadcrumbs::for('admin.'.$this->modelMeta['name'].'.trash', function ($breadcrumbs) {
            $breadcrumbs->parent('admin.'.$this->modelMeta['name'].'.index');
            $breadcrumbs->push('Çöp Kutusu');
        });

        // Share rows
        view()->share('rows', $rows);

        // Show trash page via index page view blade
        return view($this->getViewPath('index'));
    }

    public function galleryIndex($row)
    {
        // Regenerate page metas
        $this->pageMeta['title'] = $this->pageMeta['title'] . ' - Galeri';
        $this->pageMeta['desc'] = 'yeni galeri görseli ekle, düzenle, sırala, sil';
        $this->generatePageMeta();

        // Home > Model > Gallery Index
        Breadcrumbs::register('admin.'.$this->modelMeta['name'].'.gallery-index', function ($breadcrumbs) use ($row) {
            $breadcrumbs->parent('admin.'.$this->modelMeta['name'].'.index');

            if (!is_null($row)) {
                $breadcrumbs->push($row->getTitle(), $row->getEditLink());
            }

            $breadcrumbs->push('Galeri');
        });

        // Share row
        view()->share('row', $row);

        return view($this->getViewPath('gallery'));
    }

    public function gallerySort($row, $galleries)
    {
        // Regenerate page metas
        $this->pageMeta['title'] = $this->pageMeta['title'] . ' - Galeri';
        $this->pageMeta['desc'] = 'galerideki görselleri sırala';
        $this->generatePageMeta();

        // Home > Model > Gallery Sort
        Breadcrumbs::register('admin.'.$this->modelMeta['name'].'.gallery-sort', function ($breadcrumbs) use ($row) {
            $breadcrumbs->parent('admin.'.$this->modelMeta['name'].'.index');

            if (!is_null($row)) {
                $breadcrumbs->push($row->getTitle(), $row->getEditLink());
                $breadcrumbs->push('Galeri', $row->getGalleryLink());
            }

            $breadcrumbs->push('Sırala');
        });

        // Share variables
        view()->share('row', $row);
        view()->share('galleries', $galleries);

        // MaxDepth
        view()->share('maxDepth', (isset($row->gallery()->getRelated()->modelMeta['maxDepth']) ? $row->gallery()->getRelated()->modelMeta['maxDepth'] : 5));

        // Show index page
        return view($this->getViewPath('gallery-sort'));
    }

    public function galleryHardDelete($gallery)
    {
        // Delete images
        $gallery->destroyGalleryImage();

        // Process
        $gallery->delete();

        // Response
        $response = [];
        $response['files'][$gallery->image] = true;

        return response()->json($response);
    }
}
