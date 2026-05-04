<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    protected $table = 'gejala';

    // penting: kasih tau PK bukan gejala_id
    protected $primaryKey = 'id';

    public $timestamps = true;
}