<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Gejala;
use App\Models\Diagnosa;

class Kasus extends Model
{
    protected $table = 'kasus';
    public $timestamps = false;

    // 🔥 relasi ke gejala (many-to-many)
    public function gejala()
    {
        return $this->belongsToMany(
            Gejala::class,
            'kasus_gejala',
            'kasus_id',
            'gejala_id',
            'id',
            'id'
        )->withPivot('bobot');
    }

    // 🔥 relasi ke diagnosa (one-to-one / belongsTo)
    public function diagnosa()
    {
        return $this->belongsTo(
            Diagnosa::class,
            'diagnosa_id',
            'id'
        );
    }
}