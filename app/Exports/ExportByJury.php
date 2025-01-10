<?php

namespace App\Exports;

use App\Models\CmotCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportByJury implements FromCollection, WithHeadings // WithMapping //FromView 
{
    protected $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        $data = collect();
        foreach ($this->user->cmotJuryAssigns as $assign) {
            $category = CmotCategory::select('name')->where('id',isset($assign->cmot->category_id) ? $assign->cmot->category_id : '')->first();//->pluck('name');
            $data->push([
                'Jury ID'       =>  $this->user->id,
                'Jury Name'     =>  $this->user->name,
                'Jury Email'    =>  $this->user->email,
                'Assign ID'     =>  $assign->id,
                'Total Score'   =>  $assign->total_score,
                'Feedback'      =>  $assign->feedback,
                'CMOT Id'       =>  $assign->cmot->id,
                'CMOT Name'     =>  $assign->cmot->name,
                'CMOT Email'    =>  $assign->cmot->email,
                'Film Craft'    =>  isset($category['name']) ? $category['name'] : '',
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Jury ID',
            'Jury Name',
            'Jury Email',
            'Assign ID',
            'Total Score',
            'Feedback',
            'CMOT Id',
            'CMOT Name',
            'CMOT Email',
            'Film Craft',
        ];
    }
}
