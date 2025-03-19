<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'region_id',
        'province_id',
        'name',
    ];

    public function Region()
    {
        return $this->belongsTo(Region::class);
    }

    public function Province(){
        return $this->belongsTo(Province::class);
    }
}
