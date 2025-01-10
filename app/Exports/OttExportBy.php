<?php

namespace App\Exports;

use App\Models\OttBroadcasted;
use App\Models\OttCoProducer;
use App\Models\OttCreatorsDetail;
use App\Models\OttEpisode;
use App\Models\OttInternationalCompetition;
use App\Models\OttStreamedCountry;
use App\Models\OttThreatricalScreening;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class OttExportBy implements FromArray
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    // public function collection()
    public function array(): array
    {
        $array = [];
        $array[0] = [
            'S.No.',
            'Title of Web Series',
            'English translation of the title',
            'Genre',
            'Other, If avaialble',
            'Language of Web Series',
            'Other, If avaialble',
            'subtitle Language',
            'Other subtitle Language',
            'Whether the series is subtitled in English',
            'Season',
            'Total Runtime',
            'Number of Episode',
            'Release Date',
            'Whether the miminum duration of each episode of the season is 25 mins',
            'Whether all the episodes were released on the same date?',
            'Episodes with Release Date',
            'Has Coproducer',
            'Coproducer Type',
            'coproducer Name',
            'coproducer address',
            'coproducer phone',
            'coproducer email',

            'coproducer Details',
            'Name of the OTT platform',
            'Other OTT platform(s) available',
            'Other OTT platform(s) name',
            'Whether the Web Series has been streamed outside India',
            'Details',
            ' Whether the Web Series has been presented for any festival/theatrical screening',
            'Details',
            'Whether the Web Series has been streamed/broadcasted on the Internet/TV or any other media',
            'Details',
            'Whether the Web Series has participated in any International Competition',
            'Details',
            'Creator name',
            'Creator country',
            'Creator phone',
            'Creator email',
            'Creator website',
            'Other Creators Details',
            'Director name',
            'Director country',
            'Director phone',
            'Director email',
            'Director website',
            'Other Director Details',
            'story_writer',
            'screening_writer',
            'director_of_photography',
            'editior',
            'art_director',
            'costume_director',
            'music_director',
            'sound_designer',
            'principal_cast',
            'name_of_the_applicant',
            'designation',
            'date',
            'email',
            'contact_number',
        ];
        $i = 0;
        foreach ($this->data as $data) {
            $i++;
            $array[$i] = array();
            array_push($array[$i], $data->id);
            array_push($array[$i], $data->title);
            array_push($array[$i], $data->title_in_english);
            array_push($array[$i], $data->genre->name);
            array_push($array[$i], $data->other_genre);
            array_push($array[$i], $data->language->name);
            array_push($array[$i], $data->other_language);
            array_push($array[$i], $data->subtitleOther?->name);
            array_push($array[$i], $data->other_subtitle_language);
            array_push($array[$i], 'Yes');
            array_push($array[$i], $data->season);
            array_push($array[$i], $data->runtime);
            array_push($array[$i], $data->number_of_episode);
            array_push($array[$i], $data->release_date);
            array_push($array[$i], 'yes');
            array_push($array[$i], ($data->is_episode_have_same_date) ? 'yes' : 'no');
            $OttEpisodequery    =   OttEpisode::where('ott_form_id', $data->id)->get();
            $OttEpisodestring   =   '';
            if ($OttEpisodequery) {
                foreach ($OttEpisodequery as $OttEpisode) {
                    $OttEpisodestring .= " Episode Number" . $OttEpisode->episode_number . " Episode date " . $OttEpisode->release_date . "|| \n";
                }
            }
            array_push($array[$i], $OttEpisodestring);
            $details_ott_data = "";
            if ($data->has_coproduction) {
                array_push($array[$i], 'yes');
                $OttCoProducerdata = OttCoProducer::where('ott_form_id', $data->id)->get();
                $OttEpisodestring = '';
                if ($OttCoProducerdata) {
                    $j = 0;
                    foreach ($OttCoProducerdata as $OttCoProducer) {
                        if ($OttCoProducer->type == 1) {
                            $datatodisplay = 'OTT';
                        } else
                        if ($OttCoProducer->type == 2) {
                            $datatodisplay = 'Production House';
                        } else
                        if ($OttCoProducer->type == 3) {
                            $datatodisplay = 'Individual Producer';
                        }
                        if ($j == 0) {
                            array_push($array[$i], $datatodisplay);
                            array_push($array[$i], $OttCoProducer->name);
                            array_push($array[$i], $OttCoProducer->address);
                            array_push($array[$i], $OttCoProducer->phone);
                            array_push($array[$i], $OttCoProducer->email);
                        } else {
                            $details_ott_data .= "
                            Type : " . $datatodisplay .
                                " Name :" . $OttCoProducer->name .
                                " address :" . $OttCoProducer->address .
                                " phone :" . $OttCoProducer->phone .
                                " email :" . $OttCoProducer->email . " || \n";
                        }
                        $j++;
                    }
                }
            } else {
                array_push($array[$i], 'no');
                $datatodisplay = "";
                if ($data->coproducer_type == 1) {
                    $datatodisplay = 'OTT';
                } else
                if ($data->coproducer_type == 2) {
                    $datatodisplay = 'Production House';
                } else
                if ($data->coproducer_type == 3) {
                    $datatodisplay = 'Individual Producer';
                }
                array_push($array[$i], $datatodisplay);
                array_push($array[$i], $data->coproducer_name);
                array_push($array[$i], $data->coproducer_address);
                array_push($array[$i], $data->coproducer_phone);
                array_push($array[$i], $data->coproducer_email);
            }
            array_push($array[$i], $details_ott_data);
            array_push($array[$i], $data->ott_released_platform);
            array_push($array[$i], ($data->is_other_released_platform_available) ? 'yes' : 'no');
            array_push($array[$i], $data->other_released_platform_available);
            array_push($array[$i], ($data->is_released_other_country) ? 'yes' : 'no');
            // OttStreamedCountry
            $OttStreamedCountry = OttStreamedCountry::where('ott_form_id', $data->id)->get();
            $datatodisplay = '';
            if ($OttEpisodequery) {
                foreach ($OttStreamedCountry as $OttStreamed) {
                    $datatodisplay .= "Country : " . $OttStreamed->country->country_name . " Platform name: " . $OttStreamed->platform_name . " Episode date: " . $OttStreamed->release_date . "|| \n";
                }
            }
            array_push($array[$i], $datatodisplay);

            array_push($array[$i], ($data->is_thretrical_screening) ? 'yes' : 'no');

            $OttThreatricalScreening = OttThreatricalScreening::where('ott_form_id', $data->id)->get();
            $datatodisplay = '';
            if ($OttEpisodequery) {
                foreach ($OttThreatricalScreening as $OttThreatrical) {
                    $datatodisplay .= "Festival Name : " . $OttThreatrical->festival_name . " Date: " . $OttThreatrical->date_of_festival . " Address: " . $OttThreatrical->address . "|| \n";
                }
            }
            array_push($array[$i], $datatodisplay);


            array_push($array[$i], ($data->is_streamed_other_media) ? 'yes' : 'no');
            $OttBroadcasteds = OttBroadcasted::where('ott_form_id', $data->id)->get();
            $datatodisplay = '';
            if ($OttBroadcasteds) {
                foreach ($OttBroadcasteds as $OttBroadcasted) {
                    $datatodisplay .= "Platform Name : " . $OttBroadcasted->festival_name . " Date: " . $OttBroadcasted->stream_date . "|| \n";
                }
            }
            array_push($array[$i], $datatodisplay);
            array_push($array[$i], ($data->is_international_competition) ? 'yes' : 'no');
            $OttInternationalCompetitions = OttInternationalCompetition::where('ott_form_id', $data->id)->get();
            $datatodisplay = '';
            if ($OttInternationalCompetitions) {
                foreach ($OttInternationalCompetitions as $OttInternationalCompetition) {
                    $datatodisplay .= "competition name: " . $OttInternationalCompetition->competition_name . " Date: " . $OttInternationalCompetition->competition_date . " Details: " . $OttInternationalCompetition->details . "|| \n";
                }
            }
            array_push($array[$i], $datatodisplay);
            // creator
            $OttCreatorsDetails = OttCreatorsDetail::where('ott_form_id', $data->id)->where('type', 1)->get();
            $details_ott_data = '';
            if ($OttCreatorsDetails) {
                $j = 0;
                foreach ($OttCreatorsDetails as $OttCreatorsDetail) {

                    if ($j == 0) {
                        array_push($array[$i], $OttCreatorsDetail->name);
                        array_push($array[$i], $OttCreatorsDetail->country?->country_name);
                        array_push($array[$i], $OttCreatorsDetail->phone);
                        array_push($array[$i], $OttCreatorsDetail->email);
                        array_push($array[$i], $OttCreatorsDetail->website);
                    } else {
                        $details_ott_data .=
                            " Name :" . $OttCreatorsDetail->name .
                            " Country :" . $OttCreatorsDetail->country?->country_name .
                            " Phone :" . $OttCreatorsDetail->phone .
                            " Email :" . $OttCreatorsDetail->email .
                            " website :" . $OttCreatorsDetail->website .
                            " || \n";
                    }
                    $j++;
                }
            }
            array_push($array[$i], $details_ott_data);
            $OttCreatorsDetails = OttCreatorsDetail::where('ott_form_id', $data->id)->where('type', 2)->get();
            $details_ott_data = '';
            if ($OttCreatorsDetails) {
                $j = 0;
                foreach ($OttCreatorsDetails as $OttCreatorsDetail) {

                    if ($j == 0) {
                        array_push($array[$i], $OttCreatorsDetail->name);
                        array_push($array[$i], $OttCreatorsDetail->country?->country_name);
                        array_push($array[$i], $OttCreatorsDetail->phone);
                        array_push($array[$i], $OttCreatorsDetail->email);
                        array_push($array[$i], $OttCreatorsDetail->website);
                    } else {
                        $details_ott_data .=
                            " Name :" . $OttCreatorsDetail->name .
                            " Country :" . $OttCreatorsDetail->country?->country_name .
                            " Phone :" . $OttCreatorsDetail->phone .
                            " Email :" . $OttCreatorsDetail->email .
                            " website :" . $OttCreatorsDetail->website .
                            " || \n";
                    }
                    $j++;
                }
            }
            array_push($array[$i], $details_ott_data);
            array_push($array[$i], $data->story_writer);
            array_push($array[$i], $data->screening_writer);
            array_push($array[$i], $data->director_of_photography);
            array_push($array[$i], $data->editior);
            array_push($array[$i], $data->art_director);
            array_push($array[$i], $data->costume_director);
            array_push($array[$i], $data->music_director);
            array_push($array[$i], $data->sound_designer);
            array_push($array[$i], $data->principal_cast);
            array_push($array[$i], $data->name_of_the_applicant);
            array_push($array[$i], $data->designation);
            array_push($array[$i], $data->date);
            array_push($array[$i], $data->email);
            array_push($array[$i], $data->contact_number);
        }
        return $array;
    }
}
