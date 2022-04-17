<?php

namespace App\Http\Controllers\Admin;

use App\Models\Entities\Activity;
use Illuminate\Http\Response;

class ActivityLogController extends AdminController
{
    /**
     * Set page meta values
     * @var array
     */
    protected $pageMeta = [
        'title' => 'Etkinlik Kayıtları',
        'desc' => 'kullanıcıların yaptığı değişiklikleri görüntüle',
    ];

    /**
     * Set model localizations
     */
    protected $modelMeta = [
        'name' => 'activity-log',
        'singularTitle' => 'Etkinlik Kaydı',
        'pluralTitle' => 'Etkinlik Kayıtları',
        'deleteTitle' => 'Sayfayı',
    ];

    /**
     * Display a listing of the resource.
     *
     * @param null $rows
     * @return Response
     */
    public function index($rows = null)
    {
        $rows = Activity::orderBy('created_at', 'DESC')->get();

        return parent::index($rows);
    }

    /**
     * Show of the resource.
     *
     * @param null $id
     * @return Response
     */
    public function show($id = null)
    {
        $row = Activity::findOrFail($id);

        return parent::show($row);
    }
}
