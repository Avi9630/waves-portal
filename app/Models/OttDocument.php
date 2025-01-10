<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OttDocument extends Model
{
    //
    protected $guarded = [];
    static function  documentType()
    {
        return [
            "SYNOPSIS"                      =>  1,
            "BRIEF_PROFILE_OF_CREATOR"      =>  2,
            "BRIEF_PROFILE_OF_DIRECTOR"     =>  3,
            "BRIEF_PROFILE_OF_PRODUCER"     =>  4,
            "PAYMENT_RECEIPT"               =>  4,
        ];
    }
    public $form_id;
    public $type_id;
    public function saveDocument()
    {
        $param = [
            "ott_form_id" => $this->form_id,
            "type" => $this->type_id
        ];
        return  $this::create(
            $param
        );
    }
}
