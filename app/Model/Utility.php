<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    public static function keterangan()
    {
        $ket = ['Masuk', 'Telat', 'Alpha', 'Cuti', 'Sakit', 'Izin'];

        return $ket;
    }
}
