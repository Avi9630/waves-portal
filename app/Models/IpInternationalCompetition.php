<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpInternationalCompetition extends Model
{
    protected $guarded = [];
    static function createIpInternationalCompetition($payload)
    {
        $application = self::create([
            "ip_application_form_id" => isset($payload['ip_application_form_id']) ? $payload['ip_application_form_id'] : null,
            "name" => isset($payload['name']) ? $payload['name'] : null,
        ]);
        if ($application) {
            $response = [
                'status' => true,
                'message' => 'International Competition has been successfully created.',
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
