<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $guarded = [];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    private function getUserRole()
    {
        return $this->role()->getResults();
    }

    private function checkRole($role)
    {
        return (strtolower($role) == strtolower($this->have_role->role)) ? true : false;
    }

    public function hasRole($roles)
    {
        $this->have_role = $this->getUserRole();

        if (is_array($roles)) {
            foreach ($roles as $need_role) {
                if ($this->checkRole($need_role)) {
                    return true;
                }
            }
        } else {
            return $this->checkRole($roles);
        }
    }

    public function getPhoto()
    {
        if (Storage::disk('sftp')->exists($this->foto)) {
            return config('app.sftp_src') . $this->foto;
        } else {
            return config('app.sftp_src') . 'default.png';
        }
    }
}
