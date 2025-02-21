<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mavinoo\Batch\Traits\HasBatch;

class Penilaian extends Model
{
    protected $table = 'penilaian';
    protected $primaryKey = 'id_penilaian';

    use HasBatch;
}