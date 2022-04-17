<?php

namespace App\Models\Entities;

use App\Models\Traits\ActionsTrait;
use Avatar;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use PharIo\Manifest\Email;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use ActionsTrait;
    use HasRoles;
    use LogsActivity;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Set model meta properties
     */
    public $modelMeta = [
        'name' => 'user',
    ];

    /**
     * Set logable fields
     */
    protected static $logAttributes = [
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Merge user first name and last name
     *
     * @return string
     */
    public function getFullName()
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }

    /**
     * Alias
     */
    public function getTitle()
    {
        return $this->getFullName();
    }

    /**
     * Create user avatar on the fly via user full name
     *
     * @return string
     */
    public function getAvatar()
    {
        return Avatar::create($this->getFullName())->toBase64();
    }

    /**
     * Returns user email
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
