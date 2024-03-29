<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\PersonalInformation;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $guarded = ['id', 'username'];

    public function getPhoto()
    {
        if (Storage::disk('sftp')->exists($this->foto)) {
            return config('app.sftp_src') . $this->foto;
        } else {
            return config('app.sftp_src') . 'default.png';
        }
    }

    public function personalInformation()
    {
        return $this->hasOne(PersonalInformation::class, 'user_id');
    }

}
