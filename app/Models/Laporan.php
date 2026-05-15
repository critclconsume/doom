<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'nama', 'telepon', 'email',
        'lokasi', 'deskripsi', 'keterangan',
        'foto', 'status',
    ];

    protected $attributes = [
        'status' => 'menunggu',
    ];
}