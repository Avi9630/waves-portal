<?php

namespace App\Models;


use App\Models\Country;
use Illuminate\Database\Eloquent\Model;

class OttStreamedCountry extends Model
{

    protected $guarded = [];
    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
    static function createStreamedCountry($payload)
    {
        $updateData = [
            "country_id" => isset($payload['country_id']) ? $payload['country_id'] : null,
            "ott_form_id" => isset($payload['ott_form_id']) ? $payload['ott_form_id'] : null,
            "platform_name" => isset($payload['platform_name']) ? $payload['platform_name'] : null,
            "release_date" => isset($payload['release_date']) ? $payload['release_date'] : null,
        ];
        $application = self::create($updateData);
        if ($application) {
            $response = [
                'status' => true,
                'message' => 'Ott Streamed country has been successfully created.',
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
