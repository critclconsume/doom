<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasPhoto extends Model
{
    protected $fillable = ['fasilitas_id', 'photo', 'urutan'];

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }
}