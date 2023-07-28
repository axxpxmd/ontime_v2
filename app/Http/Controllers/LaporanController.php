<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Models
use App\Model\OPD;

class LaporanController extends Controller
{
    protected $title = 'Laporan';

    public function index(Request $request)
    {
        $title = $this->title;
        $opd_id_user = Auth::user()->personalInformation->opd_id;

        $opds = OPD::select('id', 'nama')->get();

        if ($request->ajax()) {
            return $this->dataTable();
        }

        return view('pages.laporan.index', compact(
            'title',
            'opds',
            'opd_id_user'
        ));
    }

    public function dataTable()
    {
        // 
    }
}
