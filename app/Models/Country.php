<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $guarded = [];

    public function permanentCmots()
    {
        return $this->hasOne(Cmot::class, 'permanent_country_id');
    }

    public function residenceCmots()
    {
        return $this->hasOne(Cmot::class, 'residence_country_id');
    }
}
