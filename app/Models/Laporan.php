<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';    

    protected $fillable = [
        'nama',
        'telepon',
        'lokasi',
        'deskripsi',
        'foto',
        'status',
    ];

    protected $attributes = [
        'status' => 'menunggu',
    ];
}