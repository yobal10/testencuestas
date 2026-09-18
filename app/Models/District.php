<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['province_id', 'name', 'code'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function region()
    {
        return $this->hasOneThrough(
            Region::class,
            Province::class,
            'id',
            'id',
            'province_id',
            'region_id',
        );
    }
}
