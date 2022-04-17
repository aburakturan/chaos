<?php

namespace App\Http\Controllers\Admin;

use App\Models\Entities\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionController extends AdminController
{
    /**
     * Set page meta values
     * @var array
     */
    protected $pageMeta = [
        'title' => 'Yetkiler',
        'desc' => 'yeni yetki ekle, düzenle, sil',
    ];

    /**
     * Set model localizations
     */
    protected $modelMeta = [
        'name' => 'permission',
        'singularTitle' => 'Yetki',
        'pluralTitle' => 'Yetkiler',
        'deleteTitle' => 'Yetkiyi',
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
            $row = new Permission;
        } else {
            $row = Permission::findOrFail($id);
        }

        // Update
        $row->title = $request->input('title');
        $row->name = str_slug($request->input('name'), '.');

        if ($request->input('name')) {
            $row->name = str_slug($request->input('name'), '.');
        } else {
            $row->name = str_slug($request->input('title'), '.');
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
        $rows = Permission::all();

        return parent::index($rows);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param null $row
     * @return View
     */
    public function create($row = null)
    {
        $row = new Permission;

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
        $row = Permission::findOrFail($id);

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $row = Permission::findOrFail($id);

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
        $row = Permission::findOrFail($id);

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
        return $this->destroy($id);
    }
}
