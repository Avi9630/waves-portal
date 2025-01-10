<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpDirector extends Model
{
    use HasFactory;
    protected  $table = 'ip_directors';
    public function documents()
    {
        return $this->hasMany(Document::class, 'context_id', 'id')->where(['type' => 2, 'website_type' => 1]);
    }
}
