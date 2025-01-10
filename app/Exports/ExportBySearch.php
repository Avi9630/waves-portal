<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use App\Models\IpCoProducer;
use App\Models\Transaction;
use App\Models\IpDirector;
use App\Models\Client;

class ExportBySearch implements FromCollection, WithHeadings, WithMapping  //FromView
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    // public function view(): View
    // {
    //     return view('ips.search', [
    //         'ips' => IpApplicationForm::select('*')->where('category', 1)->get(),
    //     ]);
    // }

    public function collection()
    {
        $searchData = $this->data;
        return $searchData;
        // $ipDetails = IpApplicationForm::select('*')->where('category', 1)->get();
        // return $ipDetails;
    }

    public function map($ip): array
    {
        $langauges = DB::table('languages')->get();        
        foreach ($langauges as $langauge) {
            if ($langauge->id == $ip->language_id) {
                $languageName = $langauge->name;
            }
        }
        if (!empty($ip->producer_is) && $ip->producer_is == 1) {
            if ($ip->firm_is_owned_by_individual == 1) {
                $firmName = $ip->name_of_firm;
            } else {
                $firmName = $ip->name_of_the_producer_making_entry;
            }
        } else {
            $firmName = '';
        }
        if (!empty($ip->producer_is) && $ip->producer_is == 2) {
            $firmName = $ip->name_of_production_house;
        } else {
            $firmName = '';
        }
        // $return_address_name    =   !empty($ip->return_address_name) ? $ip->return_address_name : $firmName;
        // $return_address_email   =   !empty($ip->return_address_email) ? $ip->return_address_email : $ip->producer_email;
        // $return_address_mobile  =   !empty($ip->return_address_mobile) ? $ip->return_address_mobile : $ip->producer_mobile;
        // $return_address_fax     =   !empty($ip->return_address_fax) ? $ip->return_address_fax : $ip->producer_mobile;
        // $return_address         =   !empty($ip->return_address) ? $ip->return_address : $ip->producer_address;
        $client =   Client::find($ip->client_id);
        if (!is_null($client)) {
            $clientName = $client->name;
            $clientEmail = $client->email;
        } else {
            $clientName = '';
            $clientEmail = '';
        }
        // IP Director Details ( All 5)
        $ipDirectors = IpDirector::where('ip_application_form_id',$ip->id)->get();        
        foreach($ipDirectors as $key => $ipDirector){
            if($key == 0){
                $Director1Name          =   $ipDirector->name;
                $Director1Email         =   $ipDirector->email;
                $Director1Address       =   $ipDirector->address;
                $Director1Nationality   =   isset($ipDirector->indian_nationality) && $ipDirector->indian_nationality == 1 ? 'Indian' : NULL;
            }
            if($key == 1){
                $Director2Name          =   $ipDirector->name;
                $Director2Email         =   $ipDirector->email;
                $Director2Address       =   $ipDirector->address;
                $Director2Nationality   =   isset($ipDirector->indian_nationality) && $ipDirector->indian_nationality == 1 ? 'Indian' : NULL;
            }
            if($key == 2){
                $Director3Name          =   $ipDirector->name;
                $Director3Email         =   $ipDirector->email;
                $Director3Address       =   $ipDirector->address;
                $Director3Nationality   =   isset($ipDirector->indian_nationality) && $ipDirector->indian_nationality == 1 ? 'Indian' : NULL;
            }
            if($key == 3){
                $Director4Name          =   $ipDirector->name;
                $Director4Email         =   $ipDirector->email;
                $Director4Address       =   $ipDirector->address;
                $Director4Nationality   =   isset($ipDirector->indian_nationality) && $ipDirector->indian_nationality == 1 ? 'Indian' : NULL;
            }
            if($key == 4){
                $Director5Name          =   $ipDirector->name;
                $Director5Email         =   $ipDirector->email;
                $Director5Address       =   $ipDirector->address;
                $Director5Nationality   =   isset($ipDirector->indian_nationality) && $ipDirector->indian_nationality == 1 ? 'Indian' : NULL;
            }
        }

        //  IP Co-producers Details ( All 5)
        $ipCoProcers = IpCoProducer::where('ip_application_form_id',$ip->id)->get();        
        foreach($ipCoProcers as $key => $ipCoProcer){

            if($key == 0){
                $Producer1Name          =   $ipCoProcer->name;
                $Producer1Email         =   $ipCoProcer->email;
                $Producer1Address       =   $ipCoProcer->address;
            }

            if($key == 1){
                $Producer2Name          =   $ipCoProcer->name;
                $Producer2Email         =   $ipCoProcer->email;
                $Producer2Address       =   $ipCoProcer->address;
            }

            if($key == 2){
                $Producer3Name          =   $ipCoProcer->name;
                $Producer3Email         =   $ipCoProcer->email;
                $Producer3Address       =   $ipCoProcer->address;
            }
            if($key == 3){
                $Producer4Name          =   $ipCoProcer->name;
                $Producer4Email         =   $ipCoProcer->email;
                $Producer4Address       =   $ipCoProcer->address;
            }
            if($key == 4){
                $Producer5Name          =   $ipCoProcer->name;
                $Producer5Email         =   $ipCoProcer->email;
                $Producer5Address       =   $ipCoProcer->address;
            }
        }
        $payment   =   Transaction::where([
            'website_type'  =>  1,
            'client_id'     =>  $ip['client_id'],
            'context_id'    =>  $ip['id'],
            'auth_status'   =>  '0300',
        ])->first();

        if (!is_null($payment)) {
            $paymentDate    =   $payment->payment_date;
            $paymentAmount  =   $payment->amount;
            $paymentReceipt =   $payment->bank_ref_no;
        } else {
            $paymentDate    =   '';
            $paymentAmount  =   '';
            $paymentReceipt =   '';
        }
        // dd($ip);
        $data =  [
            $ip->id,
            $clientName,
            $clientEmail,
            $ip->category == 1 ? 'Feature' : ($ip->category == 2 ? 'Non Feature' : 'No Category Added'),
            $ip->title_of_film_in_roman,
            $ip->english_translation_of_film,
            $languageName,
            $ip->duration_running_time,
            $ip->dcp == 1 ? 'DCP' : ($ip->dcp == 2 ? 'Blueray' : ($ip->dcp == 3 ? 'Pendrive' : 'Not Selected')),
            $ip->film_is_certified_by_cbfc_or_uncensored == 1 ? 'DBFC' : ($ip->category == 2 ? 'Uncensored' : NULL),
            $ip->date_of_cbfc_certificate,

            // Director Details (All - 5)
            isset($Director1Name) ? $Director1Name : '',
            isset($Director1Email) ? $Director1Email : '',
            isset($Director1Address) ? $Director1Address : '',
            isset($Director1Nationality) ? $Director1Nationality : '',
            // $Director1Email,
            // $Director1Address,
            // $Director1Nationality,
            
            isset($Director2Name) ? $Director2Name : '',
            isset($Director2Email) ? $Director2Email : '',
            isset($Director2Address) ? $Director2Address : '',
            isset($Director2Nationality) ? $Director2Nationality : '',
            // $Director2Name,
            // $Director2Email,
            // $Director2Address,
            // $Director2Nationality,

            isset($Director3Name) ? $Director3Name : '',
            isset($Director3Email) ? $Director3Email : '',
            isset($Director3Address) ? $Director3Address : '',
            isset($Director3Nationality) ? $Director3Nationality : '',
            // $Director3Name,
            // $Director3Email,
            // $Director3Address,
            // $Director3Nationality,

            isset($Director4Name) ? $Director4Name : '',
            isset($Director4Email) ? $Director4Email : '',
            isset($Director4Address) ? $Director4Address : '',
            isset($Director4Nationality) ? $Director4Nationality : '',
            // $Director4Name,
            // $Director4Email,
            // $Director4Address,
            // $Director4Nationality,

            isset($Director5Name) ? $Director5Name : '',
            isset($Director5Email) ? $Director5Email : '',
            isset($Director5Address) ? $Director5Address : '',
            isset($Director5Nationality) ? $Director5Nationality : '',
            // $Director5Name,
            // $Director5Email,
            // $Director5Address,
            // $Director5Nationality,

            //Producers Details (All 5)

            $firmName,
            $ip->producer_email,
            $ip->producer_address,

            isset($Producer1Name) ? $Producer1Name : '',
            isset($Producer1Email) ? $Producer1Email : '',
            isset($Producer1Address) ? $Producer1Address : '',
            // $Producer1Name,
            // $Producer1Email,
            // $Producer1Address,

            isset($Producer2Name) ? $Producer2Name : '',
            isset($Producer2Email) ? $Producer2Email : '',
            isset($Producer2Address) ? $Producer2Address : '',
            // $Producer2Name,
            // $Producer2Email,
            // $Producer2Address,

            isset($Producer3Name) ? $Producer3Name : '',
            isset($Producer3Email) ? $Producer3Email : '',
            isset($Producer3Address) ? $Producer3Address : '',
            // $Producer3Name,
            // $Producer3Email,
            // $Producer3Address,

            isset($Producer4Name) ? $Producer4Name : '',
            isset($Producer4Email) ? $Producer4Email : '',
            isset($Producer4Address) ? $Producer4Address : '',
            // $Producer4Name,
            // $Producer4Email,
            // $Producer4Address,

            isset($Producer5Name) ? $Producer5Name : '',
            isset($Producer5Email) ? $Producer5Email : '',
            isset($Producer5Address) ? $Producer5Address : '',
            // $Producer5Name,
            // $Producer5Email,
            // $Producer5Address,

            $paymentDate,
            $paymentAmount,
            $paymentReceipt,
        ];
        return $data;
    }

    public function headings(): array
    {
        return [
            'Movie Ref',
            'Client Name',
            'Client Email',
            'Category',
            'Film Title in Roman',
            'Film Title in English',
            'Language',
            'Duration',
            'Format',
            'Censorship Type',
            'Censorship Date',

            'Director 1 Name',
            'Director 1 Email',
            'Director 1 Address',
            'Director 1 Nationality',

            'Director 2 Name',
            'Director 2 Email',
            'Director 2 Address',
            'Director 2 Nationality',
            
            'Director 3 Name',
            'Director 3 Email',
            'Director 3 Address',
            'Director 3 Nationality',
            
            'Director 4 Name',
            'Director 4 Email',
            'Director 4 Address',
            'Director 4 Nationality',
            
            'Director 5 Name',
            'Director 5 Email',
            'Director 5 Address',
            'Director 5 Nationality',

            'Producer Name',
            'Producer Email',
            'Producer Address',

            'Co-Producer 1 Name',
            'Co-Producer 1 Email',
            'Co-Producer 1 Address',
            
            'Co-Producer 2 Name',
            'Co-Producer 2 Email',
            'Co-Producer 2 Address',
            
            'Co-Producer 3 Name',
            'Co-Producer 3 Email',
            'Co-Producer 3 Address',
           
            'Co-Producer 4 Name',
            'Co-Producer 4 Email',
            'Co-Producer 4 Address',
            
            'Co-Producer 5 Name',
            'Co-Producer 5 Email',
            'Co-Producer 5 Address',

            'Payment Date & Time',
            'Payment Amount',
            'Payment Receipt No',
        ];
    }
}
