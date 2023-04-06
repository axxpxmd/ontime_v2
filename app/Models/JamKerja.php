<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamKerja extends Model
{
    protected $table = "jam_kerja";
    protected $fillable = ['shift_id', 'N', 'hari', 'mulai_absen', 'mulai_kerja', 'selesai_kerja', 'mulai_checkout', 'mulai_sanksi', 'mulai_sanksi2', 'maks_absen', 'created_at'];

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
