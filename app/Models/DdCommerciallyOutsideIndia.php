<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdCommerciallyOutsideIndia extends Model
{
    use HasFactory;
    protected  $table = 'dd_commercially_outside_indias';
    protected $guarded = [];
    static function createIpCommerciallyOutsideIndia($payload)
    {
        $application = self::create([
            "ip_application_form_id" => isset($payload['ip_application_form_id']) ? $payload['ip_application_form_id'] : null,
            "country" => isset($payload['country']) ? $payload['country'] : null,
            "release_date" => isset($payload['release_date']) ? $payload['release_date'] : null,
        ]);
        if ($application) {
            $response = [
                'status' => true,
                'message' => 'Commercially Outside India has been successfully created.',
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
