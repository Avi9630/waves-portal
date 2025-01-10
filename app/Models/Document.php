<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    protected $guarded = [];

    public function documents()
    {
        return $this->hasMany(IpApplicationDocument::class);
    }

    static function  documentType()
    {
        return [
            "PRODUCER_ID_PROOF"         =>  1,
            "DIRECTOR_ID_PROOF"         =>  2,
            "UNCENSORED_FILE"           =>  3,
            "DECLARATION_CLAUSE_FILE"   =>  3,
            "FILE_CBFC_CERTIFICATE"     =>  4,
            "AUTHORIZATION_LATTER"      =>  5,
            "DECLARATION_LATTER"        =>  6,
            "SYNOPSIS_IN_ENGLISH"       =>  7,
            "DIRECTORS_PROFILE"         =>  8,
            "PRODUCERS_PROFILE"         =>  9,
            "DETAILS_OF_CAST_CREW"      =>  10,
            "GOV_ID_PROOF"              =>  11,
            "PASSPORT_IMAGE"            =>  12,
            "FIRST_GOV_ID_PROOF"        =>  13,
            "SECOND_GOV_ID_PROOF"       =>  14,
            "UPLOAD_CV"                 =>  15,
            "UPLOAD_REEL"               =>  16,
            "CO_PRODUCER_ID_PROOF"      =>  17,  //co_producer_id_proof
            "PASSPORT_IMAGE"            =>  18,  //passport_image
        ];
    }
    static function  documentOttType()
    {
        return [
            "SYNOPSIS"                      =>  1,
            "BRIEF_PROFILE_OF_CREATOR"      =>  2,
            "BRIEF_PROFILE_OF_DIRECTOR"     =>  3,
            "BRIEF_PROFILE_OF_PRODUCER"     =>  4,
            "INCORPORATION_REGISTRATION_IN_INDIA"     =>  5,
            "INCORPORATION_REGISTRATION_IN_INDIA_MULTI"     =>  6,
        ];
    }

    static function  documentCmotType()
    {
        return [
            "FIRST_GOV_ID_PROOF"        =>  1,
            "SECOND_GOV_ID_PROOF"       =>  2,
            "UPLOAD_CV"                 =>  3,
            "UPLOAD_REEL"               =>  4,
            "PASSPORT_PHOTO"            =>  5,
        ];
    }

    public static function uploadDocument($args, $fileDetails)
    {
        //     $website_type = COMMONTrait::websiteType()['CMOT'];
        //     $document   =   new Document();
        //     $document->context_id   =   $request['last_id'];
        //     $document->type         =   $fileDetails['type'];
        //     $document->file         =   $fileDetails['file'];
        //     $document->name         =   $fileDetails['name'];
        //     $fileDetails['website_type'] = $website_type;
        //     $args = [
        //         "context_id"    =>  $request['last_id'],
        //         "website_type"  =>  $website_type,
        //         "type"          =>  $fileDetails['type']
        //     ];
        //      echo "<pre>";
        //      print_r(array_merge($args, $fileDetails));
        //      die();
        $Document = Document::where($args)->first();


        if ($Document) {
            $Document->update($fileDetails);
        } else {
            Document::create($fileDetails);
        }
    }

    public static function saveDocument($data)
    {
        return Document::firstOrCreate($data->toArray());
        // $data['ip_application_form_id'] = $this->ip_application_form_id;
        // return  $this::create($args, array_merge($args, $param));
        // return  Document::firstOrCreate($args, array_merge($args, $param));
    }
}
