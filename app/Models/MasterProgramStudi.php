<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterProgramStudi extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'master_program_studi';

    protected $fillable = [
        'kode',
        'nama',
        'jenjang',
        'akreditasi',
    ];
}
