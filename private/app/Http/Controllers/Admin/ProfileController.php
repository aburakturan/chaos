<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends AdminController
{
    /**
     * Set page meta values
     * @var array
     */
    protected $pageMeta = [
        'title' => 'Profil',
        'desc' => 'profil bilgilerini görüntüle, şifre değiştir, kişisel bilgileri güncelle',
    ];

    /**
     * Set model localizations
     */
    protected $modelMeta = [
        'name' => 'profile',
        'singularTitle' => 'Profil',
    ];

    /**
     * Show the profile dashboard
     *
     * @param null $row
     * @return View
     */
    public function edit($row = null)
    {
        $row = Auth::user();

        return parent::edit($row);
    }

    /**
     * Update user datas
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $row = Auth::user();

        // Update
        $row->first_name = $request->input('first_name');
        $row->last_name = $request->input('last_name');
        $row->email = $request->input('email');

        if (!is_null($request->input('password')) && !is_null($request->input('password_confirmation'))) {
            if ($request->input('password') && $request->input('password_confirmation')) {
                $row->password = bcrypt($request->input('password'));
            }
        }

        // Update
        $row->update();

        // Set status
        $this->generateFlashMessage('success', 'Profil Güncellendi');

        return redirect()->back();
    }
}
