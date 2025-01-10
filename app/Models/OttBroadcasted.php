<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OttBroadcasted extends Model
{
    protected $guarded = [];

    static function createBroadCast($payload)
    {
        $application = self::create([
            "ott_form_id" => isset($payload['ott_form_id']) ? $payload['ott_form_id'] : null,
            "stream_date" => isset($payload['stream_date']) ? $payload['stream_date'] : null,
            "platform_name" => isset($payload['platform_name']) ? $payload['platform_name'] : null,
        ]);
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
