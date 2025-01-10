<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Alumni extends Model
{
    use HasFactory;
    protected  $table   =   'alumnis';
    protected $guarded  =   [];

    public function category(): HasOne
    {
        return $this->hasOne(CmotCategory::class, 'id', 'category_id');
    }

    static function exists($alumniId)
    {
        $exists = UserAlumniPreference::where('user_id', Auth::user()->id)
            ->where('alumni_id', $alumniId)
            ->exists();

        if ($exists) {
            return true;
        } else {
            return false;
        }
    }
    static function selected($alumniId)
    {
        $exists = UserAlumniSelect::where('user_id', Auth::user()->id)
            ->where('alumni_id', $alumniId)
            ->exists();

        if ($exists) {
            return true;
        } else {
            return false;
        }
    }
    static function rejected($alumniId)
    {
        $exists = UserAlumniReject::where('user_id', Auth::user()->id)
            ->where('alumni_id', $alumniId)
            ->exists();

        if ($exists) {
            return true;
        } else {
            return false;
        }
    }
}
