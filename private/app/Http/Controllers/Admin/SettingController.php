<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;

class SettingController extends AdminController
{
    /**
     * Set page meta values
     * @var array
     */
    protected $pageMeta = [
        'title' => 'Ayarlar',
        'desc' => 'genel ayarlar, meta etiketleri, iletişim bilgileri, sosyal medya hesapları',
    ];

    /**
     * Show the application dashboard.
     *
     * @param null $rows
     * @return View
     */
    public function edit($rows = null)
    {
        return view('admin.settings.edit');
    }

    /**
     * Update all settings via Setting package
     */
    public function update()
    {
        // Update all setting key values
        foreach (request()->input('key') as $key => $value) {
            if (is_null($value)) {
                setting()->set($key, '');
            } else {
                setting()->set($key, $value);
            }
        }
        setting()->save();

        // Set status
        $this->generateFlashMessage('success', 'Ayarlar Güncellendi');

        return redirect()->back();
    }
}
