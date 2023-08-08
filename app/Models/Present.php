<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model
use App\User;

class Present extends Model
{
    protected $table = 'presents';
    protected $guarded = [];

    public function fotoDatang()
    {
        return config('app.sftp_src') . $this->foto_datang;
    }
    public function fotoPulang()
    {
        return config('app.sftp_src') . $this->foto_pulang;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function personalInformation()
    {
        return $this->belongsTo(PersonalInformation::class, 'user_id', 'user_id');
    }

    public static function queryPresent($tanggal, $ket, $opd_id, $nama_pegawai)
    {
        $data = Present::select('presents.id', 'presents.user_id', 'keterangan', 'jam_masuk', 'jam_keluar', 'foto_datang', 'foto_pulang', 'lokasi_datang', 'lokasi_pulang', 'total_jam', 'tanggal')
            ->with(['user:id,username', 'user.personalInformation:id,user_id,nama'])
            ->WhereIn('keterangan', array_values(Utility::keterangan()))
            ->when($tanggal, function ($q) use ($tanggal) {
                return $q->where('tanggal', $tanggal);
            })
            ->when($ket, function ($q) use ($ket) {
                return $q->where('keterangan', $ket);
            })
            ->when($opd_id, function ($q) use ($opd_id) {
                return $q->join('personal_information', 'personal_information.user_id', '=', 'presents.user_id')
                    ->where('personal_information.opd_id', $opd_id);
            })
            ->when($nama_pegawai, function ($q) use ($nama_pegawai, $opd_id) {
                if ($opd_id) {
                    return $q->where('personal_information.nama', 'like', '%' . $nama_pegawai . '%');
                } else {
                    return $q->join('personal_information', 'personal_information.user_id', '=', 'presents.user_id')
                        ->where('personal_information.nama', 'like', '%' . $nama_pegawai . '%');
                }
            });

        return $data->orderByRaw('ISNULL(jam_masuk), jam_masuk ASC')->get();
    }
}
