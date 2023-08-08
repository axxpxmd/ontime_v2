<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    protected $table = 'personal_information';
    protected $guarded = [];

    public function opd()
    {
        return $this->belongsTo(OPD::class, 'opd_id')->withDefault([
            'nama' => '-'
        ]);
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id')->withDefault([
            'nama' => '-'
        ]);
    }
}
