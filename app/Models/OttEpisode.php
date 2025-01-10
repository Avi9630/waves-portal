<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OttEpisode extends Model
{
    //
    protected $guarded = [];

    static function createOttEpisode($payload)
    {
        $updateData = [
            "ott_form_id" => isset($payload['ott_form_id']) ? $payload['ott_form_id'] : null,
            "episode_number" => isset($payload['episode_number']) ? $payload['episode_number'] : null,
            "release_date" => isset($payload['release_date']) ? $payload['release_date'] : null,
        ];
        $application = self::create($updateData);
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
