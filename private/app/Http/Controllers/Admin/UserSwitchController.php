<?php

namespace App\Http\Controllers\Admin;

use App\Models\Entities\User;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Session;

class UserSwitchController extends AdminController
{
    /**
     * Set page meta values
     * @var array
     */
    protected $pageMeta = [
        'title' => 'Kullanıcı Değiştir',
        'desc' => 'bu sayfadan diğer kullanıcıların hesaplarına geçici olarak geçiş yapabilirsiniz',
    ];

    /**
     * Set model localizations
     */
    protected $modelMeta = [
        'name' => 'user-switch',
        'pluralTitle' => 'Kullanıcı Değiştir',
        'singularTitle' => 'Kullanıcı Değiştir',
    ];

    protected $excludeThisRouteForControlMiddleware = [
        'admin.user-switch.stop',
    ];

    /**
     * Show the user-switch dashboard
     *
     * @param null $rows
     * @return View
     */
    public function index($rows = null)
    {
        $rows = User::where('id', '<>', Auth::id())->get();

        return parent::index($rows);
    }

    /**
     * Start session
     * @param mixed $id
     * @return RedirectResponse
     */
    public function start($id)
    {
        // Get target user data
        $targetUser = User::findOrFail($id);

        // Remember defualt user id
        Session::put('user_switch_original_id', Auth::id());

        // Authentication as target user
        Auth::login($targetUser);

        // Set status
        $this->generateFlashMessage('success', 'Başka kullanıcıya geçiş yapıldı!');

        // Redirect to home page
        return redirect()->route('admin.dashboard.index');
    }

    /**
     * Stop session
     */
    public function stop()
    {
        // Remember defualt user id
        $originalUserId = Session::pull('user_switch_original_id');

        // Get target user data
        $targetUser = User::findOrFail($originalUserId);

        // Authentication as target user
        Auth::login($targetUser);

        // Set status
        $this->generateFlashMessage('success', 'Kendi kullanıcınıza geçiş yapıldı!');

        // Redirect to home page
        return redirect()->route('admin.dashboard.index');
    }
}
