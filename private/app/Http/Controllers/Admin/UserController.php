<?php

namespace App\Http\Controllers\Admin;

use App\Models\Entities\Permission;
use App\Models\Entities\Role;
use App\Models\Entities\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserController extends AdminController
{
    /**
     * Set page meta values
     * @var array
     */
    protected $pageMeta = [
        'title' => 'Kullanıcılar',
        'desc' => 'yeni kullanıcı ekle, düzenle, sil, rol ata, rol sil, yetki ata, yetki sil',
    ];

    /**
     * Set model localizations
     */
    protected $modelMeta = [
        'name' => 'user',
        'singularTitle' => 'Kullanıcı',
        'pluralTitle' => 'Kullanıcılar',
        'deleteTitle' => 'Kullanıcıyı',
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
            $row = new User;
        } else {
            $row = User::findOrFail($id);
        }

        // Update
        $row->first_name = $request->input('first_name');
        $row->last_name = $request->input('last_name');
        $row->email = $request->input('email');

        if (!is_null($request->input('password')) && !is_null($request->input('password_confirmation'))) {
            if ($request->input('password') && $request->input('password_confirmation')) {
                $row->password = bcrypt($request->input('password'));
            }
        }

        // Sync selected roles
        $row->syncRoles($request->input('roles'));

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
        $rows = User::all();

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
        $row = new User;

        // Generate checkbox inputs and share this all view
        $roles = Role::all();
        $roleInputs = [];
        $i = 0;
        foreach ($roles as $role) {
            $roleInputs[$i]['name'] = 'roles[]';
            $roleInputs[$i]['value'] = $role->getName();
            $roleInputs[$i]['label'] = $role->getTitle();
            $roleInputs[$i]['class'] = 'col-xs-12 col-sm-6 col-md-4';
            $i++;
        }
        view()->share('roleInputs', $roleInputs);

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
        $row = User::findOrFail($id);

        // Generate checkbox inputs and share this all view
        $roles = Role::all();
        $roleInputs = [];
        $i = 0;
        foreach ($roles as $role) {
            $roleInputs[$i]['name'] = 'roles[]';
            $roleInputs[$i]['value'] = $role->getName();
            $roleInputs[$i]['label'] = $role->getTitle();
            $roleInputs[$i]['class'] = 'col-xs-12 col-sm-6 col-md-4';
            $roleInputs[$i]['checked'] = $row->roles->contains($role);
            $i++;
        }
        view()->share('roleInputs', $roleInputs);

        $permissions = Permission::all();
        $permissionInputs = [];
        $i = 0;
        foreach ($permissions as $permission) {
            $permissionInputs[$i]['name'] = 'permissions[]';
            $permissionInputs[$i]['value'] = $permission->getName();
            $permissionInputs[$i]['label'] = $permission->getTitle();
            $permissionInputs[$i]['class'] = 'col-xs-12 col-sm-6 col-md-4';
            $permissionInputs[$i]['checked'] = $row->hasPermissionTo($permission);
            $i++;
        }
        view()->share('permissionInputs', $permissionInputs);

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
        $row = User::findOrFail($id);

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
        $row = User::findOrFail($id);

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
