<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        $diffHours   = Str::length($diff->h) == 1 ? '0' . $diff->h : $diff->h;
        $diffMinutes = substr($diff->i,0,1) == 0 ? $diff->i .'0' : $diff->i;
        $diffSecound = substr($diff->s,0,1) == 0 ? $diff->s .'0' : $diff->s;

        $totalJam = $diffHours . ' jam ' . $diffMinutes . ' menit ' . $diffSecound . ' detik';
        $total = $diffHours . ':' . $diffMinutes . ':' . $diffSecound;

        return [$totalJam, $total];
    }
}
