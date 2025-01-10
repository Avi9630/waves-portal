<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdAward extends Model
{
    use HasFactory;
    protected  $table = 'dd_awards';
    protected $guarded = [];
    static function createIpAward($payload)
    {
        $application = self::create([
            "ip_application_form_id" => isset($payload['ip_application_form_id']) ? $payload['ip_application_form_id'] : null,
            "details" => isset($payload['details']) ? $payload['details'] : null,
        ]);
        if ($application) {
            $response = [
                'status' => true,
                'message' => 'Award has been successfully created.',
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
