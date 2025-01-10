<?php

namespace App\Models;

use App\Http\Traits\COMMONTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Document;
use App\Models\Language;

class OttForm extends Model
{
    protected $guarded = [];

    public function Genre()
    {
        return $this->belongsTo(Genre::class);
    }
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    public function subtitleOther()
    {
        return $this->belongsTo(Language::class, 'subtitle_other_language');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    static function steps()
    {
        return [
            'DETAILS'                => 1,
            'SEASON_AND_EPISODE'     => 2,
            'PRODUCER'               => 3,
            'OTT_PLATFORM'           => 4,
            'DIRECTOR'               => 5,
            'PAYMENT'                => 6,
            'DECLARATION'            => 7,
            'FINAL_SUBMIT'           => 8
        ];
    }

    public function validateStepDetails()
    {
        $validatorArray = [
            "title" => 'required|string',
            "title_in_english" => 'required|string',
            "genre_id" => 'numeric',
            "language_id" => 'numeric',
            "is_subtitle_language_eng" => 'numeric',
            "subtitle_other_language" => 'numeric',
        ];
        return $validatorArray;
    }

    public function validateStepSeasonEpisode()
    {
        $validatorArray = [
            "season" => 'required|string',
            "runtime" => 'required|string',
            "number_of_episode" => 'numeric',
            "is_long_duration_timing" => 'required|string',
            "release_date" => 'numeric',
            "ott_episodes" => 'json',
        ];
        return $validatorArray;
    }

    public function validateStepProducer()
    {
        $validatorArray = [
            "has_coproduction" => 'required|numeric',

        ];
        return $validatorArray;
    }

    public function validateStepOttPlatform()
    {
        $validatorArray = [
            "ott_released_platform" => 'required|string',
            "other_released_platform" => 'string',
            "is_other_released_platform_available" => 'numeric',
            "is_released_other_country" => 'numeric',
            "is_thretrical_screening" => 'numeric',
            "is_streamed_other_media" => 'numeric',
            "is_international_competition" => 'numeric',

        ];
        return $validatorArray;
    }

    public function validateStepDirector()
    {
        $validatorArray = [
            "story_writer" => 'string',
            "screening_writer" => 'string',
            "director_of_photography" => 'string',
            "editior" => 'string',
            "art_director" => 'string',
            "costume_director" => 'string',
            "music_director" => 'string',
            "sound_designer" => 'string',
            "principal_cast" => 'string',
        ];
        return $validatorArray;
    }

    public function validateStepPayment()
    {
        $validatorArray = [
            "payment_date" => 'string',
            "receipt_number" => 'string',
        ];
        return $validatorArray;
    }

    public function validateStepDeclaration()
    {
        $validatorArray = [
            "conscent" => 'numeric',
            "name_of_the_applicant" => 'string',
            "date" => 'string',
            "email" => 'string',
            "contact_number" => 'string',
        ];
        return $validatorArray;
    }

    static function buldValidateData($payload)
    {
        $validatorArray['step'] = 'required';
        $payload['step'] = "1";
        $messagesArray = [];
        $OttForm = new OttForm;
        if (isset($payload['step'])) {
            $validatorArray = array_merge($validatorArray, match ($payload['step']) {
                "1" => $OttForm->validateStepDetails(),
                "2" => $OttForm->validateStepSeasonEpisode(),
                "3" => $OttForm->validateStepProducer(),
                "4" => $OttForm->validateStepOttPlatform(),
                "5" => $OttForm->validateStepDirector(),
                "6" => $OttForm->validateStepPayment(),
                "7" => $OttForm->validateStepDeclaration(),
            });
        }
        $messagesArray = [];

        return [
            'validatorArray'    =>  $validatorArray,
            'messagesArray'     =>  $messagesArray
        ];
    }

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

    static function createOttform($payload)
    {
        $application = self::create($payload);
        if ($application) {
            $response = [
                'status' => true,
                'message' => 'Ott request has been successfully created.',
                'data' => ['id' => encryptAndDecrypt($application->id, 'e')]
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

    public function updateDataDetails($data)
    {
        //  print_r($data);
        return [
            "title" => $data["title"],
            "title_in_english" => $data["title_in_english"],
            "genre_id" => $data["genre_id"],
            "other_genre" => !empty($data["other_genre"]) ? $data["other_genre"] : '',
            "other_language" => !empty($data["other_language"]) ? $data["other_language"] : '',
            "other_subtitle_language" => !empty($data["other_subtitle_language"]) ? $data["other_subtitle_language"] : '',
            "language_id" => $data["language_id"],
            "is_subtitle_language_eng" => $data["is_subtitle_language_eng"],
            "subtitle_other_language" => isset($data["subtitle_other_language"]) ? $data["subtitle_other_language"] : null,
            "step" => 1,
        ];
    }

    public function updateDataSeasonEpisode($data)
    {
        return [
            "season" => $data["season"],
            "runtime" => $data["runtime"],
            "number_of_episode" => $data["number_of_episode"],
            "is_long_duration_timing" => $data["is_long_duration_timing"],
            "release_date" => $data["release_date"],
            "step" => 2,

        ];
    }

    public function updateDataProducer($data)
    {
        if ($data["has_coproduction"])
            return [
                "step" => 3,
                "has_coproduction" => $data["has_coproduction"],
            ];

        return [
            "has_coproduction" => $data["has_coproduction"],
            "step" => 3,
            "coproducer_type" => $data["coproducer_type"],
            "coproducer_name" => $data["coproducer_name"],
            "coproducer_address" => $data["coproducer_address"],
            "coproducer_phone" => $data["coproducer_phone"],
            "coproducer_email" => $data["coproducer_email"],
            "coproducer_website" => $data["coproducer_website"],
            "coproducer_is_follow_it_rules" => isset($data["coproducer_is_follow_it_rules"]) ? $data["coproducer_is_follow_it_rules"] : null,
            "coproducer_is_original_production" => isset($data["coproducer_is_original_production"]) ? $data["coproducer_is_original_production"] : null,
            "coproducer_is_registered" => isset($data["coproducer_is_registered"]) ? $data["coproducer_is_registered"] : null,
            "coproducer_is_residing_in_country" => isset($data["coproducer_is_residing_in_country"]) ? $data["coproducer_is_residing_in_country"] : null,
        ];
    }

    public function updateDataOttPlatform($data)
    {
        return [
            "ott_released_platform" => $data["ott_released_platform"],
            "other_released_platform_available" => isset($data["other_released_platform_available"]) ? $data["other_released_platform_available"] : null,
            "is_other_released_platform_available" => isset($data["is_other_released_platform_available"]) ? $data["is_other_released_platform_available"] : null,
            "other_released_platform" => isset($data["other_released_platform"]) ? $data["other_released_platform"] : null,
            "is_released_other_country" => isset($data["is_released_other_country"]) ? $data["is_released_other_country"] : null,
            "is_thretrical_screening" => isset($data["is_thretrical_screening"]) ? $data["is_thretrical_screening"] : null,
            "is_international_competition" => isset($data["is_international_competition"]) ? $data["is_international_competition"] : null,
            "is_streamed_other_media" => isset($data["is_streamed_other_media"]) ? $data["is_streamed_other_media"] : null,
            "is_streamed_other_media" => isset($data["is_streamed_other_media"]) ? $data["is_streamed_other_media"] : null,
            "step" => 4,
        ];
    }

    public function updateDataDirector($data)
    {
        return [

            "step" => 5,
            "story_writer" => $data["story_writer"],
            "screening_writer" => $data["screening_writer"],
            "director_of_photography" => $data["director_of_photography"],
            "editior" => $data["editior"],
            "art_director" => $data["art_director"],
            "costume_director" => $data["costume_director"],
            "music_director" => $data["music_director"],
            "sound_designer" => $data["sound_designer"],
            "principal_cast" => $data["principal_cast"],
        ];
    }

    public function updateDocument($data)
    {
        return [

            "step" => 6,
        ];
    }

    public function updateDeclaration($data)
    {
        return [
            "name_of_the_applicant" => !empty($data["name_of_the_applicant"]) ? $data["name_of_the_applicant"] : '',
            "date" => !empty($data["date"]) ? $data["date"] : '',
            "email" => !empty($data["email"]) ? $data["email"] : '',
            "contact_number" => !empty($data["contact_number"]) ? $data["contact_number"] : '',
            "step" => 7,
        ];
    }

    static function updateOttform($payload, $id)
    {
        $updateData = [];
        $OttForm = new OttForm;
        if (isset($payload['step'])) {
            $updateData =  match ($payload['step']) {
                "1" => $OttForm->updateDataDetails($payload),
                "2" => $OttForm->updateDataSeasonEpisode($payload),
                "3" => $OttForm->updateDataProducer($payload),
                "4" => $OttForm->updateDataOttPlatform($payload),
                "5" => $OttForm->updateDataDirector($payload),
                "6" => $OttForm->updateDocument($payload),
                "7" => $OttForm->updateDeclaration($payload),
                //"7" => $OttForm->updateDataDeclaration($payload),
            };
        }
        $application    =   self::where('id', $id)->update($updateData);

        if ($application) {
            $response = [
                'status' => true,
                'message' => 'Ott request has been successfully updated.',

            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Something went wrong.!',
                'id' => $id
            ];
        }
        return $response;
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'context_id', 'id')->where(
            'website_type',
            2
        )->whereNotIn('type', [6, 8])->where('type', '!=', 6)->where('type', '!=', 8);
    }
}
