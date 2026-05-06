<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';

    protected $fillable = [
        'name',
        'address',
        'type',
        'status',   // 'open' | 'maintenance'
        'photo',    // filename only, stored in public/images/fasilitas/
    ];
}
