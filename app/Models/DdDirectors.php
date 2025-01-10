<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdDirectors extends Model
{
    use HasFactory;
    protected  $table = 'dd_directors';
    protected $guarded = [];
    public function documents()
    {
        return $this->hasMany(Document::class, 'context_id', 'id')->where(['type' => 2, 'website_type' => 4]);
    }
}
