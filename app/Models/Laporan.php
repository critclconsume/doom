<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'nama', 'telepon', 'lokasi', 'deskripsi', 'foto', 'status'
    ];

    protected $attributes = [
        'status' => 'menunggu',
    ];

    // Add this
    public const STATUS = [
        'menunggu',
        'diterima',
        'selesai',
        'ditolak'
    ];
}