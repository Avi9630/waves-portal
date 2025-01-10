<?php

namespace App\Models;

use App\Http\Traits\COMMONTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Document;

class OttCoProducer extends Model
{
    // 
    protected $guarded = [];
    public function documents()
    {
        return $this->hasMany(Document::class, 'context_id', 'id')->where(['website_type' => 2])->whereIn('type', [6, 8]);
    }
    static function createCoProducer($payload)
    {
        unset($payload['incorporation_registration_in_india_multi']);
        unset($payload['is_incorporation_registration_in_india_multi']);
        $updateData = [
            "ott_form_id" => isset($payload['ott_form_id']) ? $payload['ott_form_id'] : null,
            "type" => isset($payload['type']) ? $payload['type'] : null,
            "name" => isset($payload['name']) ? $payload['name'] : null,
            "address" => isset($payload['address']) ? $payload['address'] : null,
            "phone" => isset($payload['phone']) ? $payload['phone'] : null,
            "email" => isset($payload['email']) ? $payload['email'] : null,
            "website" => isset($payload['website']) ? $payload['website'] : null,
            "is_follow_it_rules" => isset($payload['is_follow_it_rules']) ? $payload['is_follow_it_rules'] : null,
            "is_original_production" => isset($payload['is_original_production']) ? $payload['is_original_production'] : null,
            "is_registered" => isset($payload['is_registered']) ? $payload['is_registered'] : null,
            "is_residing_in_country" => isset($payload['is_residing_in_country']) ? $payload['is_residing_in_country'] : null,

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
    //uploadDocument

    static function uploadDocument($files, $id)
    {
        $websiteType    =   COMMONTrait::websiteType()['OTT'];
        foreach ($files as $key => $fileinfo) {

            $originalName       =   $fileinfo->getClientOriginalName();

            $file               =   pathinfo($originalName, PATHINFO_FILENAME);

            $extension          =   $fileinfo->getClientOriginalExtension();
            $modifiedName       =   (rand(100000, 999999)) . '_' . time() . '.' . $extension;

            $fileinfo->storeAs('ott/' . $id, $modifiedName);
            $type               =   Document::documentOttType()[strtoupper($key)];
            // print_r($modifiedName);
            //die();
            $fileDetails = [
                "website_type"  =>  $websiteType,
                'type'          =>  $type,
                'file'          =>  $modifiedName,
                'name'          =>  $originalName,
                "context_id"    =>  $id,
            ];
            $args = [
                "context_id"    =>  $id,
                "website_type"  =>  $websiteType,
                "type"          =>  $type,

            ];
            Document::uploadDocument($args, $fileDetails);
        }
    }
}
