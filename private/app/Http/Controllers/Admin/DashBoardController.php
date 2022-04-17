<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;

class DashBoardController extends AdminController
{
    /**
     * Set page meta values
     * @var array
     */
    protected $pageMeta = [
        'title' => 'Başlangıç',
        'desc' => 'hoşgeldiniz!',
    ];

    /**
     * Show the application dashboard.
     *
     * @param null $rows
     * @return View
     */
    public function index($rows = null)
    {
        return view('admin.home.index');
    }
}
