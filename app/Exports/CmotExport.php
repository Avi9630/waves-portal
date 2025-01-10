<?php

namespace App\Exports;

use App\Models\Cmot;
use App\Models\CmotJuryAssign;
use App\Models\Document;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;

class CmotExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithStyles
{
    public function collection()
    {
        $cmots = Cmot::where(['step'=>5])->get();
        // $cmots = Cmot::where(['step'=>5,'stage' => 4])->get();
        // dd($cmots);
        return $cmots;
    }

    public function map($cmots): array
    {
        $dataAssign = CmotJuryAssign::where(['cmot_id'=>$cmots->id])->get();
        $scoreByJury = 0;
        $scoreByGrandJury = 0;
        foreach($dataAssign as $value){
            $user = User::find($value->user_id);
            if ($user && $user->hasRole('JURY')) {
                $scoreByJury = $value->overall_score;
            } else if($user && $user->hasRole('GRANDJURY')) {
                $scoreByGrandJury = $value->overall_score;
            }            
        }
        $finalScore = (new Cmot)->calculateScore($scoreByJury,$scoreByGrandJury);
        // Document
        $getFiles = Document::where(['website_type' => 3, 'context_id' => $cmots->id ])->get();
        $doc1 = $doc2 = $doc3 = $doc4 = $doc5 = $doc6 = '';
        foreach ($getFiles as $key => $document) {
            $fileUrl = '';
            if ($key == 0) {
                $doc1 = $fileUrl = 'https://iffigoa.org/backend/api/downloadfile/cmot/' . $cmots->id . '/' . $document->file;
            } elseif ($key == 1) {
                $doc2 = $fileUrl = 'https://iffigoa.org/backend/api/downloadfile/cmot/' . $cmots->id . '/' . $document->file;
            } elseif ($key == 2) {
                $doc3 = $fileUrl = 'https://iffigoa.org/backend/api/downloadfile/cmot/' . $cmots->id . '/' . $document->file;
            } elseif ($key == 3) {
                $doc4 = $fileUrl = 'https://iffigoa.org/backend/api/downloadfile/cmot/' . $cmots->id . '/' . $document->file;
            } elseif ($key == 4) {
                $doc5 = $fileUrl = 'https://iffigoa.org/backend/api/downloadfile/cmot/' . $cmots->id . '/' . $document->file;
            } elseif ($key == 5) {
                $doc6 = $fileUrl = 'https://iffigoa.org/backend/api/downloadfile/cmot/' . $cmots->id . '/' . $document->file;
            }
        }
        $data =  [
            $cmots->id,
            $cmots->client_id,
            $cmots->name,
            $cmots->dob,
            $cmots->age($cmots->dob),
            $cmots->gender,
            $cmots->other_gender,
            $cmots->contact_number,
            $cmots->email,
            $cmots->bio,
            $cmots->reason_to_join,
            $cmots->alternate_number,
            $this->createHyperlink($cmots->website_link),
            $this->createHyperlink($cmots->twitter_account_link),
            $this->createHyperlink($cmots->instagram_account_link),
            $this->createHyperlink($cmots->facebook_account_link),
            $this->createHyperlink($cmots->linkedin_account_link),
            $cmots->how_you_find,
            $cmots->permanent_address,
            $cmots->permanent_country_id,
            $cmots->permanent_city,
            $cmots->permanent_state,
            $cmots->residence_address,
            $cmots->residence_country_id,
            $cmots->residence_state,
            $cmots->residence_city,
            $cmots->first_govt_id_number,
            $cmots->second_govt_id_number,
            isset($cmots->category->name) ? $cmots->category->name : '',
            $cmots->link_of_film,
            $cmots->link_film_password,
            $cmots->project_title,
            $cmots->film_duration,
            $cmots->awards_recognition,
            $this->createHyperlink($cmots->filmography_url),
            $cmots->submission_date_and_time,
            $cmots->specialization_id,
            $cmots->state_of_origin_id,
            $cmots->project_completion_date,
            $cmots->highest_qualification_id,
            $scoreByJury,
            $scoreByGrandJury,
            $finalScore,
            //documents
            $doc1,
            $doc2,
            $doc3,
            $doc4,
            $doc5,
            $doc6,
        ];
        return $data;
    }

    public function headings(): array
    {
        return [
            'Ref-No',
            'Client Name',
            "Name",
            "Dob",
            "Age",
            'Gender',
            'Other Gender',
            'Contact Number',
            'Email',
            'Bio',
            'Reason To Join',
            'Alternate Number',
            'Website Link',
            'Twitter',
            'Instagram',
            'Facebook',
            'Linkedin',
            'How Did You Find',
            'Permanent Address',
            'Permanent Country',
            'Permanent State',
            'Permanent City',
            'Residence Address',
            'Residence Country',
            'Residence State',
            'Residence City',
            'Govt ID1',
            'Govt ID2',
            'Category',
            'Film Link',
            'Film Link Password',
            'Project Title',
            'Film Duration',
            'Awards Recognition',
            'Filmography URL',
            'Submission Date&Time',
            'Specialization',
            'State of origin',
            'Project Completion Date',
            'Highest Qualification',

            //Jury Scores

            'Jury Score',
            'Grand-Jury Score',
            'Final Score',

            'Doc 1',
            'Doc 2',
            'Doc 3',
            'Doc 4',
            'Doc 5',
            'Doc 6',
        ];
    }

    private function createHyperlink($url)
    {
        return $url ? '=HYPERLINK("' . $url . '", "' . $url . '")' : '';
    }

    public function styles(Worksheet $sheet)
    {
        $hyperlinkColumns = ['M', 'N', 'O', 'P', 'Q', 'AI', 'AR','AS','AT','AU','AV','AW'];
        foreach ($hyperlinkColumns as $column) {
            $sheet->getStyle($column)
                ->getFont()
                ->getColor()
                ->setARGB('FF0000FF');
        }
        return [];
    }

    public function columnFormats(): array
    {
        return [
            'M' => DataType::TYPE_STRING, // Website Link
            'N' => DataType::TYPE_STRING, // Twitter
            'O' => DataType::TYPE_STRING, // Instagram
            'P' => DataType::TYPE_STRING, // Facebook
            'Q' => DataType::TYPE_STRING, // LinkedIn
            'AI' => DataType::TYPE_STRING, // LinkedIn
            'AR' => DataType::TYPE_STRING, // DOC 1
            'AS' => DataType::TYPE_STRING, // DOC 2
            'AT' => DataType::TYPE_STRING, // DOC 3
            'AU' => DataType::TYPE_STRING, // DOC 4
            'AV' => DataType::TYPE_STRING, // DOC 5
            'AW' => DataType::TYPE_STRING, // DOC 6
        ];
    }
}
