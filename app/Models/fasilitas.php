<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $fillable = ['name', 'address', 'type', 'status', 'photo'];

    public function photos()
    {
        return $this->hasMany(FasilitasPhoto::class)->orderBy('urutan');
    }

    // Returns all images as a flat array of filenames
    public function allPhotos(): array
    {
        $all = [];
        if ($this->photo) {
            $all[] = $this->photo;
        }
        foreach ($this->photos as $p) {
            $all[] = $p->photo;
        }
        return $all;
    }
}