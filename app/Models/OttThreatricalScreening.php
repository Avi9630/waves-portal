<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OttThreatricalScreening extends Model
{
    //
    protected $guarded = [];

    static function createThreatricalScreening($payload)
    {
        $updateData = [
            "ott_form_id" => isset($payload['ott_form_id']) ? $payload['ott_form_id'] : null,
            "festival_name" => isset($payload['festival_name']) ? $payload['festival_name'] : null,
            "date_of_festival" => isset($payload['date_of_festival']) ? $payload['date_of_festival'] : null,
            "address" => isset($payload['address']) ? $payload['address'] : null,
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
