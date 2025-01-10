<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
class OttCreatorsDetail extends Model
{
    //
    protected $guarded = [];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    static function createCreatos($payload)
    {
        $updateData = [
            "ott_form_id" => isset($payload['ott_form_id']) ? $payload['ott_form_id'] : null,
            "name" => isset($payload['name']) ? $payload['name'] : null,
            "type" => isset($payload['type']) ? $payload['type'] : null,
            "country_id" => isset($payload['country_id']) ? $payload['country_id'] : null,
            "phone" => isset($payload['phone']) ? $payload['phone'] : null,
            "email" => isset($payload['email']) ? $payload['email'] : null,
            "website" => isset($payload['website']) ? $payload['website'] : null,
        ];
        $application = self::create($payload);

        if ($application) {
            $response = [
                'status' => true,
                'message' => 'Episode  has been successfully created.',
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
