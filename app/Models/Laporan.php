<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'status',   // 'menunggu' | 'diterima' | 'selesai'
    ];

    // Default status when a new report is submitted
    protected $attributes = [
        'status' => 'menunggu',
    ];
}
