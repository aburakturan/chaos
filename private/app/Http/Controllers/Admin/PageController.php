<?php

namespace App\Http\Controllers\Admin;

use App\Models\Entities\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends AdminController
{
    /**
     * Set page meta values
     * @var array
     */
    protected $pageMeta = [
        'title' => 'Sayfalar',
        'desc' => 'yeni sayfa ekle, düzenle, alt-üst sayfa ata, sırala, sil',
    ];

    /**
     * Set model localizations
     */
    protected $modelMeta = [
        'name' => 'page',
        'singularTitle' => 'Sayfa',
        'pluralTitle' => 'Sayfalar',
        'deleteTitle' => 'Sayfayı',
    ];

    /**
     * Store and Update process
     * @param Request $request
     * @param string $type
     * @param null $id
     * @return RedirectResponse
     */
    public function process(Request $request, string $type, $id = null)
    {
        if ($type == 'store') {
            $row = new Page;
        } else {
            $row = Page::withTrashed()->withDepth()->findOrFail($id);
        }

        // Set Fields
        $row->fill($request->all());

        // Set Images
        if ($row->imageAttributes) {
            foreach ($row->imageAttributes as $imageKey => $imageAttributes) {
                $row->setImage($request, $imageKey);
            }
        }

        return $this->processAfter($row, $type);
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $rows
     * @return View
     */
    public function index($rows = null)
    {
        $rows = Page::withDepth()->defaultOrder()->get();

        return parent::index($rows);
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $rows
     * @return View
     */
    public function sort($rows = null)
    {
        $rows = Page::withDepth()->defaultOrder()->get()->toTree();

        return parent::sort($rows);
    }

    /**
     * Rebuild Tree
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function rebuildTree(Request $request)
    {
        $nestedSet = json_decode($request->nestable_list, true);

        Page::rebuildTree($nestedSet);

        $this->generateFlashMessage('success', 'Sıralamalar ve alt öğeler güncellendi!');

        return redirect()->route('admin.'.$this->modelMeta['name'].'.sort');
    }

    /**
     * Display soft deleted a listing of the resource.
     *
     * @param null $rows
     * @return View
     */
    public function trash($rows = null)
    {
        $rows = Page::onlyTrashed()->withDepth()->defaultOrder()->get();

        return parent::trash($rows);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param null $row
     * @return View
     */
    public function create($row = null)
    {
        $row = new Page;

        return parent::create($row);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        return $this->process($request, 'store');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id)
    {
        $row = Page::withTrashed()->findOrFail($id);

        return parent::edit($row);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  mixed  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        return $this->process($request, 'update', $id);
    }

    /**
     * Soft Delete confirm the specified resource from storage.
     *
     * @param  int  $id
     * @return View
     */
    public function deleteConfirmation($id)
    {
        $row = Page::findOrFail($id);

        return parent::deleteConfirmation($row);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $row = Page::findOrFail($id);

        return parent::destroy($row);
    }

    /**
     * Hard Delete confirm the specified resource from storage.
     *
     * @param  int  $id
     * @return View
     */
    public function hardDeleteConfirmation($id)
    {
        $row = Page::withTrashed()->findOrFail($id);

        return parent::hardDeleteConfirmation($row);
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function hardDelete($id)
    {
        $row = Page::withTrashed()->findOrFail($id);

        return parent::hardDelete($row);
    }

    /**
     * Restore confirm the specified resource from storage.
     *
     * @param  int  $id
     * @return View
     */
    public function restoreConfirmation($id)
    {
        $row = Page::withTrashed()->findOrFail($id);

        return parent::restoreConfirmation($row);
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function restore($id)
    {
        $row = Page::withTrashed()->findOrFail($id);

        return parent::restore($row);
    }
}
