<?php

namespace App\Http\Controllers;

use DataTables;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Models
use App\Model\OPD;
use App\Model\Present;
use App\Model\Utility;
use App\Models\JamKerja;

class PresensiController extends Controller
{
    protected $title = 'Kehadiran';

    public function index(Request $request)
    {
        $title = $this->title;
        $shift = Auth::user()->shift_id;
        $dateToday = date('Y-m-d');
        $user_id   = Auth::user()->id;

        $opds = OPD::select('id', 'nama')->get();
        $keterangans = Utility::keterangan();
        $jamKerja    = JamKerja::whereN(date('N'))->where('shift_id', $shift)->first();
        $absen       = Present::where('tanggal', $dateToday)->where('user_id', $user_id)->first();

        // Get Params
        $ket = $request->ket;
        $opd_id = $request->opd_id;
        $tanggal = $request->tanggal;
        $nama_pegawai = $request->nama_pegawai;

        if ($request->ajax()) {
            return $this->dataTable($tanggal, $ket, $opd_id, $nama_pegawai);
        }

        return view('pages.presensi.index', compact(
            'title',
            'opds',
            'keterangans',
            'jamKerja',
            'absen',
            'dateToday'
        ));
    }

    public function dataTable($tanggal, $ket, $opd_id, $nama_pegawai)
    {
        $data = Present::present($tanggal, $ket, $opd_id, $nama_pegawai);

        return DataTables::of($data)
            ->addColumn('action', function ($p) {
                return 'action';
            })
            ->addColumn('username', function ($p) {
                return $p->user->username;
            })
            ->addColumn('nama', function ($p) {
                return $p->user->personalInformation ? $p->user->personalInformation->nama : '-';
            })
            ->addColumn('ket', function ($p) {
                return $p->keterangan;
            })
            ->addColumn('jam_masuk', function ($p) {
                $nama_pegawai =  $p->user->personalInformation ? $p->user->personalInformation->nama : '-';
                $foto_datang  = "<br><a data-fancybox data-caption='Foto Datang : " . $nama_pegawai . "' href='" . $p->fotoDatang() . "'><img src='" . $p->fotoDatang() . "' width='50px' height='50px'></a>";
                
                return $p->jam_masuk ? $p->jam_masuk . $foto_datang : '-';
            })
            ->addColumn('jam_keluar', function ($p) {
                $nama_pegawai =  $p->user->personalInformation ? $p->user->personalInformation->nama : '-';
                $foto_pulang  = "<br><a data-fancybox data-caption='Foto Pulang : " . $nama_pegawai . "' href='" . $p->fotoPulang() . "'><img src='" . $p->fotoPulang() . "' width='50px' height='50px'></a>";
                
                return $p->jam_keluar ? $p->jam_keluar . $foto_pulang : '-';
            })
            ->addColumn('jam_kerja', function ($p) {
                return '-';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'jam_masuk', 'jam_keluar'])
            ->make(true);
    }
}
