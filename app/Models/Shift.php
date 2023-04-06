<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = "shifts";
    protected $fillable = ['name', 'created_by'];

    public function jamKerja()
    {
        return $this->hasMany(JamKerja::class, 'shift_id');
    }
}
