<?php

namespace App\Exports;

use App\Models\IpApplicationForm;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportAllIp implements FromCollection, WithHeadings, WithMapping
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // $ipDetails = IpApplicationForm::select('*')->get();
        // return $ipDetails;
        return $this->data;
    }

    public function map($ip): array
    {
        // $langauges = DB::table('languages')->get();
        // foreach ($langauges as $langauge) {
        //     if ($langauge->id == $ip->language_id) {
        //         $languageName = $langauge->name;
        //     }
        // }

        if (is_string(gettype($ip->producer_is))) {
            if ($ip->producer_is === '1') {
                if ($ip->firm_is_owned_by_individual == 1) {
                    $firmName = $ip->name_of_firm;
                } elseif ($ip->firm_is_owned_by_individual == 0) {
                    $firmName = $ip->name_of_the_producer_making_entry;
                } else {
                    $firmName = '';
                }
            }
            if ($ip->producer_is === '2') {
                $firmName = $ip->name_of_production_house;
            }
        } elseif (is_numeric(gettype($ip->producer_is))) {
            if ($ip->producer_is === 1) {
                if ($ip->firm_is_owned_by_individual == 1) {
                    $firmName = $ip->name_of_firm;
                } else {
                    $firmName = $ip->name_of_the_producer_making_entry;
                }
            }
            if ($ip->producer_is === 2) {
                $firmName = $ip->name_of_production_house;
            }
        } else {
            $firmName = '';
        }

        $return_address_name    =   !empty($ip->return_address_name) ? $ip->return_address_name : (isset($firmName) && !empty($firmName) ? $firmName : '');
        $return_address_email   =   !empty($ip->return_address_email) ? $ip->return_address_email : $ip->producer_email;
        $return_address_mobile  =   !empty($ip->return_address_mobile) ? $ip->return_address_mobile : $ip->producer_mobile;
        $return_address_fax     =   !empty($ip->return_address_fax) ? $ip->return_address_fax : $ip->producer_mobile;
        $return_address         =   !empty($ip->return_address) ? $ip->return_address : $ip->producer_address;

        // Transaction Details
        if ($ip->payment_status == 2) {
            $transaction = Transaction::where(
                [
                    'client_id'     =>  $ip['client_id'],
                    'website_type'  =>  1,
                    'context_id'    =>  $ip['id']
                ]
            )->first();
        } else {
            $paymentDate =  date('Y-m-d H:i:s');
            $amount = 0;
            $bankReceiptNo = '';
        }

        $data =  [
            $ip->id,
            isset($ip->client->name) ? $ip->client->name : '',
            isset($ip->client->email) ? $ip->client->email : '',
            $ip->category == 1 ? 'Feature' : ($ip->category == 2 ? 'Non Feature' : 'No Category Added'),
            $ip->title_of_film_in_roman,
            $ip->english_translation_of_film,
            $ip::getLanguage($ip->language_id),
            $ip->duration_running_time,
            $ip->dcp == 1 ? 'DCP' : ($ip->dcp == 2 ? 'Blueray' : ($ip->dcp == 3 ? 'Pendrive' : 'Not Selected')),
            $ip->film_is_certified_by_cbfc_or_uncensored == 1 ? 'DBFC' : ($ip->category == 2 ? 'Uncensored' : NULL),
            $ip->date_of_cbfc_certificate,
            $ip->date_of_completion_production,
            $ip->director_name,
            $ip->director_email,
            $ip->director_address,
            $ip->director_mobile,
            $ip->producer_is == 1 ? 'Individual' : ($ip->producer_is == 2 ? 'Company' : NULL),
            isset($firmName) && !empty($firmName) ? $firmName : '',
            $ip->name_of_firm,
            $ip->producer_email,
            $ip->producer_address,
            $ip->producer_landline,
            $ip->producer_mobile,
            $ip->producer_website,
            // 6. Is the address same as Producer
            // (b) Whether the Indian and Foreign right holder is
            $ip->right_holder_name,
            $ip->right_holder_email,
            $ip->right_holder_landline,
            $ip->right_holder_mobile,
            $ip->right_holder_address,

            $transaction->payment_date,
            $transaction->amount,
            $transaction->bank_ref_no,

            $return_address_name,
            $return_address_email,
            $return_address_mobile,
            $return_address_fax,
            $return_address,
            $ip->is_directore_debute_film ? 'Yes' : 'No',
            //8. Crew Details
            $ip->story_write_aurthor,
            $ip->screenplay_script_write,
            $ip->director_of_photography,
            $ip->editor,
            $ip->art_director,
            $ip->costume_designer,
            $ip->music_director,
            $ip->sound_recordist,
            $ip->sound_re_recordist,
            $ip->principal_cast,
            $ip->duration_running_time,
            $ip->color_b_w,
            $ip->aspect_ratio,
            $ip->sound_system,
        ];
        return $data;
    }

    public function headings(): array
    {
        return [
            'Movie Ref',
            'Client Name',
            "Client Email",
            'Category',
            'Film Title in Roman',
            'Film Title in English',
            'Language',
            'Duration',
            'Format',
            'Censorship Type',
            'Date Of CBFC Certificate',
            'Date Of Completion Production',
            'Director Name',
            'Director Email',
            'Director Address',
            'Director Mobile',
            'Production Type',
            'Name of firm/Producer/Production Company Name',
            //Producer(s) Details
            'Name of Production House',
            "Producer's Email",
            "Producer's Address",
            "Producer's Landline",
            "Producer's Mobile",
            "Producer's Website",
            // 6. Is the address same as Producer
            'Right Holder Name',
            'Right Holder Email',
            'Right Holder Landline',
            'Right Holder Mobile Number',
            'Right Holder Address',
            //Payment
            "Payment Date & Time",
            "Payment Amount",
            "Payment Receipt No",

            "Return Name",
            "Return Email",
            "Return Mobile",
            "Return Fax",
            "Return Address",
            "Director Debut",
            //8. Crew Details
            'Story Writer/ Author',
            'Screenplay/ Script Writer',
            'Director of Photography',
            'Editor',
            'Art Director',
            'Costume Designer (Optional)',
            'Music Director',
            'Sound Recordist',
            'Sound Re-recordist (Optional)',
            'Principal Cast (Optional)',
            'Duration/Running time (in minutes)',
            'Colour or B&W',
            'Aspect Ratio',
            'Sound System',
        ];
    }
}
