<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OttInternationalCompetition extends Model
{
    protected $guarded = [];
    static function createInternationalCompetition($payload)
    {
        $updateData = [
            "competition_name" => isset($payload["competition_name"]) ? $payload["competition_name"] : null,
            "competition_date" => isset($payload["competition_date"]) ? $payload["competition_date"] : null,
            "details" => isset($payload["details"]) ? $payload["details"] : null,
            "ott_form_id" => isset($payload["ott_form_id"]) ? $payload["ott_form_id"] : null,
        ];
        $application = self::create($updateData);
        if ($application) {
            $response = [
                'status' => true,
                'message' => 'Threatrical Screening has been successfully created.',
                'data' => ['last_id' => $application->id]
            ];
            // return $this->response('success', $response);
        } else {
            $response = [
                'status' => false,
                'message' => 'Something went wrong.!',
            ];
            //return $this->response('exception', $response);
        }
        return $response;
    }
}
