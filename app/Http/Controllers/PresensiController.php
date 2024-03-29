<?php

namespace App\Http\Controllers;

use DataTables;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\OPD;
use App\Models\Present;
use App\Models\Utility;
use App\Models\JamKerja;

class PresensiController extends Controller
{
    protected $title = 'Kehadiran';

    public function index(Request $request)
    {
        $title = $this->title;
        $shift = Auth::user()->shift_id;
        $dataUser  = Auth::user();
        $dateToday = date('Y-m-d');
        $user_id   = Auth::user()->id;
        $role_id   = Auth::user()->role_id;
        $opd_id_user = $role_id == 1 ? null : Auth::user()->personalInformation->opd_id;

        $opds  = OPD::select('id', 'nama')->get();
        $absen = Present::where('tanggal', $dateToday)->where('user_id', $user_id)->first();
        $jamKerja    = JamKerja::whereN(date('N'))->where('shift_id', $shift)->first();
        $keterangans = Utility::keterangan();

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
            'dateToday',
            'keterangans',
            'opd_id_user',
            'dataUser'
        ));
    }

    public function dataTable($tanggal, $ket, $opd_id, $nama_pegawai)
    {
        $data = Present::queryPresent($tanggal, $ket, $opd_id, $nama_pegawai);

        return DataTables::of($data)
            ->addColumn('action', function ($p) {
                $lokasi = "<a href='#' class='text-success fs-16 m-r-15' title='Lokasi Absen' onclick='modalMap(" . $p->id . ")' ><i class='fa fa-map-location-dot'></i></a>";
                $hapus  = "<a href='#' class='text-danger fs-16 m-r-15' title='Hapus Absen' onclick='remove(" . $p->id . ")' ><i class='fa fa-trash-can'></i></a>";
                $edit   = "<a href='#' class='text-info fs-16' title='Edit Absen' onclick='editAbsen(" . $p->id . ")'><i class='fa fa-pen-to-square'></i></a>";

                if ($p->lokasi_datang || $p->lokasi_pulang) {
                    return $lokasi . $hapus . $edit;
                } else {
                    return $hapus;
                }
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
                $foto_datang  = "<br><a data-fancybox data-caption='Foto Datang : " . $nama_pegawai . "' href='" . $p->fotoDatang() . "'><img class='rounded mt-1' src='" . $p->fotoDatang() . "' width='50px' height='50px'></a>";

                return $p->jam_masuk ? $p->jam_masuk . $foto_datang : '-';
            })
            ->addColumn('jam_keluar', function ($p) {
                $nama_pegawai =  $p->user->personalInformation ? $p->user->personalInformation->nama : '-';
                $foto_pulang  = "<br><a data-fancybox data-caption='Foto Pulang : " . $nama_pegawai . "' href='" . $p->fotoPulang() . "'><img class='rounded' src='" . $p->fotoPulang() . "' width='50px' height='50px'></a>";

                return $p->jam_keluar ? $p->jam_keluar . $foto_pulang : '-';
            })
            ->addColumn('jam_kerja', function ($p) {
                return $p->total_jam;
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'jam_masuk', 'jam_keluar', 'jam_kerja'])
            ->make(true);
    }

    public function getTotalAbsen(Request $request)
    {
        $tanggal = $request->tanggal;
        $ket = $request->ket;
        $opd_id = $request->opd_id;
        $nama_pegawai = $request->nama_pegawai;

        $totalAbsen = Present::queryPresent($tanggal, $ket, $opd_id, $nama_pegawai);

        return ['totalAbsen' => count($totalAbsen)];
    }

    public function getDataAbsen(Request $request)
    {
        $present = Present::findOrFail($request->id);
        $dataJson = [
            'lokasi_datang' => $present->lokasi_datang,
            'lokasi_pulang' => $present->lokasi_pulang,
            'nama' => $present->personalInformation->nama,
            'keterangan' => $present->keterangan,
            'jam_masuk' => $present->jam_masuk,
            'jam_keluar' => $present->jam_keluar,
            'tanggal' => $present->tanggal
        ];

        echo json_encode($dataJson);
    }

    public function updateAbsen(Request $request, $id)
    {
        //* Validation
        $request->validate([
            'keterangan' => 'required'
        ]);

        $keterangan = $request->keterangan;
        $jam_keluar = $request->jam_keluar;
        $jam_masuk  = $request->jam_masuk;

        //* Check total jam
        $total = '';
        if ($jam_keluar) {
            list($totalJam, $total) = Utility::getTotalJam($jam_masuk, $jam_keluar);
        }

        $kehadiran = Present::find($id);
        $kehadiran->update([
            'keterangan' => $keterangan,
            'jam_masuk'  => $jam_masuk,
            'jam_keluar' => $jam_keluar,
            'total_jam'  => $total,
            'updated_by' => Auth::user()->username
        ]);

        return response()->json(['message' => 'Kehadiran tanggal "' . date('d F Y', strtotime($kehadiran->tanggal)) . '" berhasil diubah']);
    }

    public function deleteAbsen($id)
    {
        try {
            Present::whereid($id)->delete();

            return response()->json(["message" => "Berhasil Hapus Absen"]);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Gagal Hapus Absen"], 400);
        }
    }

    public function cetakAbsen(Request $request)
    {
        // Get params
        $tanggal = $request->tanggal;
        $ket = $request->ket;
        $opd_id = $request->opd_id;
        $nama_pegawai = $request->nama_pegawai;

        $datas = Present::queryPresent($tanggal, $ket, $opd_id, $nama_pegawai);

        $opd = OPD::find($opd_id);

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->setPaper('legal', 'landscape');
        $pdf->loadView('pages.presensi.report', compact(
            'datas',
            'tanggal',
            'ket',
            'opd_id',
            'nama_pegawai',
            'opd'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('Laporan Kehadiran - ' . $tanggal . ".pdf");
    }
}
