<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmotCategory extends Model
{
    use HasFactory;

    protected  $table = 'cmot_categories';
    protected $guarded  =   [];

    public function cmot(): BelongsTo
    {
        return $this->belongsTo(Cmot::class);
    }
}
