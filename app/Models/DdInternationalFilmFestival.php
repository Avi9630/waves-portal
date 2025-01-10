<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DdInternationalFilmFestival extends Model
{
    use HasFactory;
    protected  $table = 'dd_international_film_festivals';
    protected $guarded = [];

    static function createIpInternationalFilmFestival($payload)
    {
        $application = self::create([
            "ip_application_form_id" => isset($payload['ip_application_form_id']) ? $payload['ip_application_form_id'] : null,
            "name_of_festival" => isset($payload['name_of_festival']) ? $payload['name_of_festival'] : null,
            "address_of_festival" => isset($payload['address_of_festival']) ? $payload['address_of_festival'] : null,
            "date_of_festival" => isset($payload['date_of_festival']) ? $payload['date_of_festival'] : null,
        ]);
        if ($application) {
            $response = [
                'status' => true,
                'message' => 'International film festival has been successfully created.',
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
