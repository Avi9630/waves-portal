<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\IpApplicationForm;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class ExportFeature implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        $ipDetails = IpApplicationForm::select('*')->where('category', 1)->get();
        return $ipDetails;
    }

    public function map($ip): array
    {
        $langauges = DB::table('languages')->get();
        foreach ($langauges as $langauge) {
            if ($langauge->id == $ip->language_id) {
                $languageName = $langauge->name;
            }
        }
        if ($ip->producer_is == 1) {
            if ($ip->firm_is_owned_by_individual == 1) {
                $firmName = $ip->name_of_firm;
            } else {
                $firmName = $ip->name_of_the_producer_making_entry;
            }
        }
        if ($ip->producer_is == 2) {
            $firmName = $ip->name_of_production_house;
        }

        $return_address_name    =   !empty($ip->return_address_name) ? $ip->return_address_name : $firmName;
        $return_address_email   =   !empty($ip->return_address_email) ? $ip->return_address_email : $ip->producer_email;
        $return_address_mobile  =   !empty($ip->return_address_mobile) ? $ip->return_address_mobile : $ip->producer_mobile;
        $return_address_fax     =   !empty($ip->return_address_fax) ? $ip->return_address_fax : $ip->producer_mobile;
        $return_address         =   !empty($ip->return_address) ? $ip->return_address : $ip->producer_address;

        $data =  [
            $ip->id,
            $ip->user->name,
            $ip->user->email,
            $ip->category == 1 ? 'Feature' : ($ip->category == 2 ? 'Non Feature' : 'No Category Added'),
            $ip->title_of_film_in_roman,
            $ip->english_translation_of_film,
            $languageName,
            $ip->duration_running_time,
            $ip->dcp == 1 ? 'DCP' : ($ip->dcp == 2 ? 'Blueray' : ($ip->dcp == 3 ? 'Pendrive' : 'Not Selected')),
            $ip->film_is_certified_by_cbfc_or_uncensored == 1 ? 'DBFC' : ($ip->category == 2 ? 'Uncensored' : NULL),
            $ip->date_of_cbfc_certificate,
            $ip->director_name,
            $ip->director_email,
            $ip->director_address,
            $ip->producer_is == 1 ? 'Individual' : ($ip->producer_is == 2 ? 'Company' : NULL),
            $firmName,
            $ip->producer_email,
            $ip->producer_address,
            date('Y-m-d H:i:s'),
            '100',
            '6483d',
            $return_address_name,
            $return_address_email,
            $return_address_mobile,
            $return_address_fax,
            $return_address,
            $ip->is_directore_debute_film ? 'Yes' : 'No',
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
            'Date',
            'Director Name',
            'Director Email',
            'Director Address',
            'Production Type',
            'Name of firm/Producer/Production Company Name',
            "Producer's Email",
            "Producer's Address",
            "Payment Date & Time",
            "Payment Amount",
            "Payment Receipt No",
            "Return Name",
            "Return Email",
            "Return Mobile",
            "Return Fax",
            "Return Address",
            "Director Debut"
        ];
    }
}
