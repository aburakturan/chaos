<?php

namespace App\Http\Controllers\Admin;

use App\Models\Entities\Role;
use App\Models\Entities\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends AdminController
{
    /**
     * Set page meta values
     * @var array
     */
    protected $pageMeta = [
        'title' => 'Roller',
        'desc' => 'yeni rol ekle, düzenle, sil',
    ];

    /**
     * Set model localizations
     */
    protected $modelMeta = [
        'name' => 'role',
        'singularTitle' => 'Rol',
        'pluralTitle' => 'Roller',
        'deleteTitle' => 'Rolü',
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
            $row = new Role;
        } else {
            $row = Role::findOrFail($id);
        }

        // Update
        $row->title = $request->input('title');

        if ($request->input('name')) {
            $row->name = str_slug($request->input('name'));
        } else {
            $row->name = str_slug($request->input('title'));
        }

        // Sync selected permissions
        $row->syncPermissions($request->input('permissions'));

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
        $rows = Role::all();

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
        $row = new Role;

        // Generate checkbox inputs and share this all view
        $permissions = Permission::all();
        $permissionInputs = [];
        $i = 0;
        foreach ($permissions as $permission) {
            $permissionInputs[$i]['name'] = 'permissions[]';
            $permissionInputs[$i]['value'] = $permission->getName();
            $permissionInputs[$i]['label'] = $permission->getTitle();
            $permissionInputs[$i]['class'] = 'col-xs-12 col-sm-6 col-md-4';
            $i++;
        }
        view()->share('permissionInputs', $permissionInputs);

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
        $row = Role::findOrFail($id);

        // Generate checkbox inputs and share this all view
        $permissions = Permission::all();
        $permissionInputs = [];
        $i = 0;
        foreach ($permissions as $permission) {
            $permissionInputs[$i]['name'] = 'permissions[]';
            $permissionInputs[$i]['value'] = $permission->getName();
            $permissionInputs[$i]['label'] = $permission->getTitle();
            $permissionInputs[$i]['class'] = 'col-xs-12 col-sm-6 col-md-4';
            $permissionInputs[$i]['checked'] = $row->permissions->contains($permission);
            $i++;
        }
        view()->share('permissionInputs', $permissionInputs);

        return parent::edit($row);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param mixed $id
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
        $row = Role::findOrFail($id);

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
        $row = Role::findOrFail($id);

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
