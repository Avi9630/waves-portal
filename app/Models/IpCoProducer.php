<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpCoProducer extends Model
{
    protected $guarded = [];
    protected  $table = 'ip_co_producers';

    static function  documentType()
    {
        return [
            "PRODUCER_ID_PROOF"         =>  1,
            "DIRECTOR_ID_PROOF"         =>  2,
            "DECLARATION_CLAUSE_FILE"   =>  3,
            "FILE_CBFC_CERTIFICATE"     =>  4,
            "AUTHORIZATION_LATTER"      =>  5,
            "DECLARATION_LATTER"        =>  6,
            "SYNOPSIS_IN_ENGLISH"       =>  7,
            "DIRECTORS_PROFILE"         =>  8,
            "PRODUCERS_PROFILE"         =>  9,
            "DETAILS_OF_CAST_CREW"      =>  10,
        ];
    }
}
