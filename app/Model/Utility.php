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

    public static function getTotalJam($jam_masuk, $jam_keluar)
    {
        $jamMasuk  = Carbon::parse($jam_masuk);
        $jamKeluar = Carbon::parse($jam_keluar);

        //* get total
        $diff = $jamMasuk->diff($jamKeluar);
        $diffHours   = $diff->h;
        $diffMinutes = $diff->i;
        $diffSecound = $diff->s;

        $totalJam = $diffHours . ' jam ' . $diffMinutes . ' menit ' . $diffSecound . ' detik';
        $total = $diffHours . ':' . $diffMinutes . ':' . $diffSecound;

        return [$totalJam, $total];
    }
}
