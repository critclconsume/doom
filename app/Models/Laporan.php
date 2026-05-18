<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'nama', 'telepon','email', 'lokasi', 'deskripsi', 'keterangan', 'foto', 'fotos', 'status'
    ];

    protected $attributes = [
        'status' => 'menunggu',
    ];

    protected $casts = [
    'fotos' => 'array',
];

    // Add this
    public const STATUS = [
        'menunggu',
        'diterima',
        'selesai',
        'ditolak'
    ];
}