<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CmotParticipant extends Model
{
    use HasFactory;
    protected  $table   =   'cmot_participants';
    protected $guarded  =   [];

    public function category(): HasOne
    {
        return $this->hasOne(CmotCategory::class, 'id', 'cmot_category_id');
    }

    static function existsSelected($data)
    {
        $exists =    UserCmotParticipantSelect::where('user_id', $data['user_id'])
                ->where('cmot_participant_id', $data['cmot_participant_id'])
                ->exists();
        if ($exists) {
            return true;
        } else {
            return false;
        }
    }

    static function existsRejected($data)
    {
        $exists =    UserCmotParticipantReject::where('user_id', $data['user_id'])
                ->where('cmot_participant_id', $data['cmot_participant_id'])
                ->exists();        
        if ($exists) {
            return true;
        } else {
            return false;
        }
    }

    static function selected($alumniId)
    {
        $exists = UserCmotParticipantSelect::where('user_id', Auth::user()->id)
            ->where('cmot_participant_id', $alumniId)
            ->exists();

        if ($exists) {
            return true;
        } else {
            return false;
        }
    }

    static function rejected($alumniId)
    {
        $exists = UserCmotParticipantReject::where('user_id', Auth::user()->id)
            ->where('cmot_participant_id', $alumniId)
            ->exists();

        if ($exists) {
            return true;
        } else {
            return false;
        }
    }

}
