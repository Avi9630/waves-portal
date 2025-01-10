<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OttHistory extends Model
{
    //
    protected $guarded = [];
    public function saveHistory()
    {
        // echo "<pre>";
        // print_r($this->request);
        // die();
        $this->step = $this->request['step'];

        $param = [
            "ott_form_id" => $this->ott_form_id,
            "step" => ($this->step),
            "request" => json_encode($this->request),
        ];
        return  $this::create(
            $param
        );
    }
}
