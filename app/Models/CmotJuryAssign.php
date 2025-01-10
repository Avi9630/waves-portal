<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmotJuryAssign extends Model
{
    use HasFactory;
    protected  $table = 'cmot_jury_assigns';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cmot()
    {
        return $this->belongsTo(Cmot::class, 'cmot_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
