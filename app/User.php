<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'department', 'is_active', 'notify'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::Class);
    }

    public function hasRole(string $role)
    {
        return $this->roles->pluck('name')->contains($role);
    }

    public function updateStatus(int $status)
    {
        return $this->update([
            'is_active' => $status
        ]);
    }

    public function hasNotifications()
    {
        return $this->unreadNotifications->count() > 0;
    }

    public function setActivity(string $event)
    {
        return activity('users')
            ->causedBy(auth()->user())
            ->performedOn($this)
            ->withProperties([
                'attributes' => [
                    'Name' => $this->name,
                    'E-Mail' => $this->email,
                    'Department' => $this->department,
                    'Roles' => implode(',<br>', $this->roles->pluck('name')->toArray()),
                    'Status' => $this->is_active ? 'Active' : 'Inactive',
                ]
            ])
            ->log($event);
    }
}
