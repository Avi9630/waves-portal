<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use App\Models\DdCoProducer;
use App\Models\DdDirectors;
use App\Models\Transaction;
use App\Models\Client;

class ExportAllDd implements FromCollection, WithHeadings, WithMapping
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($dd): array
    {
        $langauges = DB::table('languages')->get();

        foreach ($langauges as $langauge) {
            if ($langauge->id == $dd->language_id) {
                $languageName = $langauge->name;
            }
        }

        $firmName = $dd->name_of_firm;
        $client =   Client::find($dd->client_id);

        if (!is_null($client)) {
            $clientName = $client->name;
            $clientEmail = $client->email;
        } else {
            $clientName = '';
            $clientEmail = '';
        }

        // IP Director Details ( All 5)
        $ddDirectors = DdDirectors::where('dd_application_form_id', $dd->id)->get();
        foreach ($ddDirectors as $key => $ipDirector) {
            if ($key == 0) {
                $Director1Name          =   $ipDirector->name;
                $Director1Email         =   $ipDirector->email;
                $Director1Address       =   $ipDirector->address;
                $Director1Landline      =   $ipDirector->landline;
                $Director1Mobile        =   $ipDirector->mobile;
                $Director1Website        =   $ipDirector->website;
                $Director1Nationality   =   isset($ipDirector->indian_nationality) && $ipDirector->indian_nationality == 1 ? 'Indian' : NULL;
            }
            if ($key == 1) {
                $Director2Name          =   $ipDirector->name;
                $Director2Email         =   $ipDirector->email;
                $Director2Address       =   $ipDirector->address;
                $Director2Nationality   =   isset($ipDirector->indian_nationality) && $ipDirector->indian_nationality == 1 ? 'Indian' : NULL;
            }
            if ($key == 2) {
                $Director3Name          =   $ipDirector->name;
                $Director3Email         =   $ipDirector->email;
                $Director3Address       =   $ipDirector->address;
                $Director3Nationality   =   isset($ipDirector->indian_nationality) && $ipDirector->indian_nationality == 1 ? 'Indian' : NULL;
            }
            if ($key == 3) {
                $Director4Name          =   $ipDirector->name;
                $Director4Email         =   $ipDirector->email;
                $Director4Address       =   $ipDirector->address;
                $Director4Nationality   =   isset($ipDirector->indian_nationality) && $ipDirector->indian_nationality == 1 ? 'Indian' : NULL;
            }
            if ($key == 4) {
                $Director5Name          =   $ipDirector->name;
                $Director5Email         =   $ipDirector->email;
                $Director5Address       =   $ipDirector->address;
                $Director5Nationality   =   isset($ipDirector->indian_nationality) && $ipDirector->indian_nationality == 1 ? 'Indian' : NULL;
            }
        }
        //  IP Co-producers Details ( All 5)
        $ddCoProcers = DdCoProducer::where('dd_application_form_id', $dd->id)->get();
        foreach ($ddCoProcers as $key => $ipCoProcer) {

            if ($key == 0) {
                $Producer1Name          =   $ipCoProcer->name;
                $Producer1Email         =   $ipCoProcer->email;
                $Producer1Address       =   $ipCoProcer->address;
            }

            if ($key == 1) {
                $Producer2Name          =   $ipCoProcer->name;
                $Producer2Email         =   $ipCoProcer->email;
                $Producer2Address       =   $ipCoProcer->address;
            }

            if ($key == 2) {
                $Producer3Name          =   $ipCoProcer->name;
                $Producer3Email         =   $ipCoProcer->email;
                $Producer3Address       =   $ipCoProcer->address;
            }
            if ($key == 3) {
                $Producer4Name          =   $ipCoProcer->name;
                $Producer4Email         =   $ipCoProcer->email;
                $Producer4Address       =   $ipCoProcer->address;
            }
            if ($key == 4) {
                $Producer5Name          =   $ipCoProcer->name;
                $Producer5Email         =   $ipCoProcer->email;
                $Producer5Address       =   $ipCoProcer->address;
            }
        }
        //Payment
        if ($dd->payment_status == 2) {
            $transaction = Transaction::select('*')->where(
                [
                    'client_id'     =>  $dd['client_id'],
                    'website_type'  =>  4,
                    'context_id'    =>  $dd['id'],
                    'auth_status'   =>  '0300',
                ]
            )->first();
        } else {
            $transaction['payment_date']    =   date('Y-m-d H:i:s');
            $transaction['amount']          =   '';
            $transaction['bank_ref_no']     =   '';
        }

        $data =  [
            $dd->id,
            $clientName,
            $clientEmail,
            $dd->is_directore_debute_film === 1 ? 'Yes' : 'No',
            $dd->category == 1 ? 'Feature' : ($dd->category == 2 ? 'Non Feature' : 'No Category Added'),
            //2. Title of the film  
            $dd->title_of_film_in_roman,
            $dd->english_translation_of_film,
            $dd->title_of_script_langauge,
            //3. Language of the Film
            $languageName,
            $dd->whether_subtitle_english,
            //4. Format of the submitted Film
            $dd->dcp == 1 ? 'DCP' : ($dd->dcp == 2 ? 'Blueray' : 'Not Selected'),
            $dd->dci_compliant_jpeg_2000 == 1 ? 'Yes' : 'No',
            $dd->subtitle_to_be_burned_in_picture == 1 ? 'Yes' : 'No',
            $dd->hard_disk_format_ext2_ext3 == 1 ? 'Yes' : 'No',
            $dd->dcp_should_cru_hard_disk == 1 ? 'Yes' : 'No',
            $dd->is_dcp_unencrypted == 1 ? 'Yes' : 'No',
            $dd->value_of_dcp_or_blueray,
            // 5. Producer(s) Details
            $dd->producer_is == 1 ? 'Individual' : ($dd->producer_is == 2 ? 'Company' : NULL),
            $firmName,
            $dd->producer_email,
            $dd->producer_address,
            $dd->producer_landline,
            $dd->producer_mobile,
            $dd->producer_website,
            //COP1
            isset($Producer1Name) ? $Producer1Name : '',
            isset($Producer1Email) ? $Producer1Email : '',
            isset($Producer1Address) ? $Producer1Address : '',
            //COP2
            isset($Producer2Name) ? $Producer2Name : '',
            isset($Producer2Email) ? $Producer2Email : '',
            isset($Producer2Address) ? $Producer2Address : '',
            //COP3
            isset($Producer3Name) ? $Producer3Name : '',
            isset($Producer3Email) ? $Producer3Email : '',
            isset($Producer3Address) ? $Producer3Address : '',
            //COP4
            isset($Producer4Name) ? $Producer4Name : '',
            isset($Producer4Email) ? $Producer4Email : '',
            isset($Producer4Address) ? $Producer4Address : '',
            //COP5
            isset($Producer5Name) ? $Producer5Name : '',
            isset($Producer5Email) ? $Producer5Email : '',
            isset($Producer5Address) ? $Producer5Address : '',
            // 6. DCP/Blu-ray of the Film to be returned to
            $dd->is_address_same_as_producer == 1 ? 'Yes' : 'No',

            isset($dd->return_address_name) ? $dd->return_address_name : '',
            isset($dd->return_address_email) ? $dd->return_address_email : '',
            isset($dd->return_address_landline) ? $dd->return_address_landline : '',
            isset($dd->return_address_mobile) ? $dd->return_address_mobile : '',
            isset($dd->return_address_fax) ? $dd->return_address_fax : '',
            isset($dd->return_address) ? $dd->return_address : '',

            $dd->whether_indian_foreign_right_holder_same == 1 ? 'Yes' : 'No',

            isset($dd->right_holder_name) ? $dd->right_holder_name : '',
            isset($dd->right_holder_email) ? $dd->right_holder_email : '',
            isset($dd->right_holder_landline) ? $dd->right_holder_landline : '',
            isset($dd->right_holder_mobile) ? $dd->right_holder_mobile : '',
            isset($dd->right_holder_fax) ? $dd->right_holder_fax : '',
            isset($dd->right_holder_address) ? $dd->right_holder_address : '',

            //  // 7. Director(s) Details
            isset($Director1Name) ? $Director1Name : '',
            isset($Director1Email) ? $Director1Email : '',
            isset($Director1Address) ? $Director1Address : '',
            isset($Director1Landline) ? $Director1Landline : '',
            isset($Director1Mobile) ? $Director1Mobile : '',
            isset($Director1Website) ? $Director1Website : '',
            isset($Director1Nationality) ? $Director1Nationality : '',
            //D2
            isset($Director2Name) ? $Director2Name : '',
            isset($Director2Email) ? $Director2Email : '',
            isset($Director2Address) ? $Director2Address : '',
            isset($Director2Nationality) ? $Director2Nationality : '',
            //D3
            isset($Director3Name) ? $Director3Name : '',
            isset($Director3Email) ? $Director3Email : '',
            isset($Director3Address) ? $Director3Address : '',
            isset($Director3Nationality) ? $Director3Nationality : '',
            //D4
            isset($Director4Name) ? $Director4Name : '',
            isset($Director4Email) ? $Director4Email : '',
            isset($Director4Address) ? $Director4Address : '',
            isset($Director4Nationality) ? $Director4Nationality : '',
            //D5
            isset($Director5Name) ? $Director5Name : '',
            isset($Director5Email) ? $Director5Email : '',
            isset($Director5Address) ? $Director5Address : '',
            isset($Director5Nationality) ? $Director5Nationality : '',

            //8. Crew Details
            $dd->story_write_aurthor,
            $dd->screenplay_script_write,
            $dd->director_of_photography,
            $dd->editor,
            $dd->art_director,
            $dd->costume_designer,
            $dd->music_director,
            $dd->sound_recordist,
            $dd->sound_re_recordist,
            $dd->principal_cast,
            $dd->duration_running_time,
            $dd->color_b_w,
            $dd->aspect_ratio,
            $dd->sound_system,

            // 9. CBFC Certification
            $dd->film_is_certified_by_cbfc_or_uncensored == 1 ? 'CBFC' : ($dd->category == 2 ? 'Uncensored' : NULL),
            $dd->date_of_cbfc_certificate,
            $dd->date_of_completion_production,
            $dd->certificate_no,

            //10. Other Details
            $dd->film_comletion_during_12month == 1 ? 'Yes' : 'No',
            $dd->name_of_festival,
            $dd->address_of_festival,
            $dd->date_of_festival,
            $dd->film_broadcast_tv,
            $dd->film_screened_inside_india,
            $dd->date_of_release_india,
            $dd->name_of_country,
            $dd->date_of_release_outside,

            //payment
            $transaction->payment_date,
            $transaction->amount,
            $transaction->bank_ref_no,
            // $dd->aspect_ratio
        ];
        // dd($data);
        return $data;
    }

    public function headings(): array
    {
        return [
            'Movie Ref',
            'Client Name',
            'Client Email',
            'Director Bebute Film',
            'Category',
            //2. Title of the film  
            'Original title of film',
            'English Translation of the Film',
            'Title of the Film in the script of the language of the Film ',
            //3. Language of the Film
            'Language',
            'Whether Subtitled in English',
            //4. Format of the submitted Film
            'Format of the Film',
            'DCI Compliant',
            'TI CineCanvas™ Format',
            'EXT2/EXT3',
            'CRU Hard Disk',
            'DCP Unencrypted',
            'Value of the DCP/Blu-ray',
            // 5. Producer(s) Details
            'Whether Producer is',
            'Name of the Firm',
            'Producer Email',
            'Producer Address',
            'Producer Landline',
            'Producer Mobile',
            'Producer Website',
            //COP1
            'Co-Producer 1 Name',
            'Co-Producer 1 Email',
            'Co-Producer 1 Address',
            //COP2
            'Co-Producer 2 Name',
            'Co-Producer 2 Email',
            'Co-Producer 2 Address',
            //COP3
            'Co-Producer 3 Name',
            'Co-Producer 3 Email',
            'Co-Producer 3 Address',
            //COP4
            'Co-Producer 4 Name',
            'Co-Producer 4 Email',
            'Co-Producer 4 Address',
            //COP5
            'Co-Producer 5 Name',
            'Co-Producer 5 Email',
            'Co-Producer 5 Address',
            // 6. DCP/Blu-ray of the Film to be returned to
            'Is the address same as Producer',

            "Return Name",
            "Return Email",
            "Return Landline",
            "Return Mobile",
            "Return Fax",
            "Return Address",

            'Whether the Indian and Foreign Right(s) Holders is same',

            'Right Holder Name',
            'Right Holder Email',
            'Right Holder Landline',
            'Right Holder Mobile Number',
            'Right Holder Address',

            // 7. Director(s) Details
            'Director 1 Name',
            'Director 1 Email',
            'Director 1 Address',
            'Director 1 Landline',
            'Director 1 Mobile',
            'Director 1 Website',
            'Nationality',
            //D2
            'Director 2 Name',
            'Director 2 Email',
            'Director 2 Address',
            'Director 2 Nationality',
            //D3
            'Director 3 Name',
            'Director 3 Email',
            'Director 3 Address',
            'Director 3 Nationality',
            //D4
            'Director 4 Name',
            'Director 4 Email',
            'Director 4 Address',
            'Director 4 Nationality',
            //D5
            'Director 5 Name',
            'Director 5 Email',
            'Director 5 Address',
            'Director 5 Nationality',
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
            // 9. CBFC Certification
            'Censorship Type',
            'Date of CBFC certificate',
            'Date of Completion of Production',
            'Certification No',
            //10. Other Details
            'Film completed during the last 12 months',
            'Name of the Festival',
            'Address of the Festival',
            'Date of the Festival',
            'Film broadcasted Internet/TV',
            'Film screened commercially',
            'Date Of Release',
            'Name of the Country',
            'Release Date',
            //payment                        
            'Payment Date & Time',
            'Payment Amount',
            'Payment Receipt No',
        ];
    }
}
