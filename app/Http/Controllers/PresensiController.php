<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Model\OPD;
use App\Model\Present;

class PresensiController extends Controller
{
    protected $title = 'Kehadiran';
    protected $keterangan = ['Masuk', 'Telat', 'Alpha', 'Cuti', 'Sakit', 'Izin'];

    public function index()
    {
        $title = $this->title;
        $keterangans = $this->keterangan;

        $opds     = OPD::select('id', 'nama')->get();
        $presents = Present::whereIn('keterangan', ['Masuk', 'Telat', 'Izin', 'Sakit', 'Cuti'])
            ->whereTanggal(date('Y-m-d'))
            // ->whereIn('user_id', $us)
            ->orderByRaw('ISNULL(jam_masuk), jam_masuk ASC')
            ->paginate(10);

        return view('pages.presensi.index', compact(
            'title',
            'presents',
            'opds',
            'keterangans'
        ));
    }
}
