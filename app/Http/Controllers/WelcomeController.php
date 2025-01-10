<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Cmot;
use App\Models\CmotCategory;
use App\Models\CmotJuryAssign;
use App\Models\DdApplicationForm;
use App\Models\IpApplicationForm;
use App\Models\OttForm;
use App\Models\UserAlumniPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index (){
        return view('welcome');
    }

    public function indexOld()
    {
        //IP
        $ipCounts = IpApplicationForm::selectRaw('
                    COUNT(*) as totalForms,
                    SUM(step = 9) as paidForms,
                    SUM(category = 1) as featured,
                    SUM(category = 2) as nonFeatured,
                    SUM(CASE WHEN category = 1 AND step = 9 THEN 1 ELSE 0 END) AS featureCount,
                    SUM(CASE WHEN category = 2 AND step = 9 THEN 1 ELSE 0 END) AS nonFeaturedCount
                ')->first();
        $totalIpForms       =   $ipCounts->totalForms;
        $paidIpForms        =   $ipCounts->paidForms;
        $featuredIp         =   $ipCounts->featured;
        $nonFeaturedIp      =   $ipCounts->nonFeatured;
        $featureCount       =   $ipCounts->featureCount;
        $nonFeaturedCount   =   $ipCounts->nonFeaturedCount;

        //OTT
        $ottCounts = OttForm::selectRaw('
                    COUNT(*) as totalForms,
                    SUM(step = 8) as paidForms
                ')->first();

        $totalOttForms   =   $ottCounts->totalForms;
        $paidOttForms    =   $ottCounts->paidForms;

        //CMOT
        $cmotCounts = Cmot::selectRaw('
                    COUNT(*) as totalEntries,
                    SUM(step = 5) as completeForm,
                    SUM(stage = 1) as assignedToLevel1,
                    SUM(stage = 2) as feedbackByLevel1,
                    SUM(stage = 3) as assignedToLevel2,
                    SUM(stage = 4) as feedbackByLevel2,
                    SUM(step = 5 AND (stage IS NULL OR stage = 0 OR stage = "")) as yetToAssign
                ')->first();

        $totalEntries       =   $cmotCounts->totalEntries;
        $cmotCompleteForm   =   $cmotCounts->completeForm;
        $assignedToLevel1   =   $cmotCounts->assignedToLevel1;
        $feedbackByLevel1   =   $cmotCounts->feedbackByLevel1;
        $assignedToLevel2   =   $cmotCounts->assignedToLevel2;
        $feedbackByLevel2   =   $cmotCounts->feedbackByLevel2;
        $yetToAssign        =   $cmotCounts->yetToAssign;

        //DD
        $ddCounts = DdApplicationForm::selectRaw('
                    COUNT(*) as totalForms,
                    SUM(step = 9) as paidForms
                ')->first();
        $totalDdForms   =   $ddCounts->totalForms;
        $paidDdForms    =   $ddCounts->paidForms;

        $totalAssignedToLevel1 = [];
        $totalAssignedToLevel2 = [];
        $marksGivenByLevel1 = [];
        $marksGivenByLevel2 = [];

        if (Auth::user()->hasRole('JURY')) {
            $totalAssignedToLevel1 = CmotJuryAssign::select('*')->where('user_id', Auth::user()->id)->get();
            $cmotids = [];
            foreach ($totalAssignedToLevel1 as $totalAssigned) {
                $cmotids[] = $totalAssigned['cmot_id'];
            }
            $marksGivenByLevel1 = Cmot::whereIn('id', $cmotids)
                ->where('stage', 2)
                ->pluck('id');
        }

        if (Auth::user()->hasRole('GRANDJURY')) {
            $totalAssignedToLevel2 = CmotJuryAssign::select('*')->where('user_id', Auth::user()->id)->get();
            $cmotids = [];
            foreach ($totalAssignedToLevel2 as $totalAssigned) {
                $cmotids[] = $totalAssigned['cmot_id'];
            }
            $marksGivenByLevel2 = Cmot::whereIn('id', $cmotids)
                ->where('stage', 4)
                ->pluck('id');
        }

        $categories = CmotCategory::all();
        foreach ($categories as $category) {
            $categoryCounts[$category->name] = Cmot::where('category_id', $category->id)->count();
        }

        return view('welcome', [
            //IP
            'totalIpForms'      =>  $totalIpForms,
            'paidIpForms'       =>  $paidIpForms,
            'featuredIp'        =>  $featuredIp,
            'nonFeaturedIp'     =>  $nonFeaturedIp,
            'featureCount'      =>  $featureCount,
            'nonFeaturedCount'  =>  $nonFeaturedCount,
            //OTT
            'totalOttForms' =>  $totalOttForms,
            'paidOttForms'  =>  $paidOttForms,
            //CMOT
            'totalEntries'      =>  $totalEntries,
            'cmotCompleteForm'  =>  $cmotCompleteForm,
            'assignedToLevel1'  =>  $assignedToLevel1,
            "feedbackByLevel1"  =>  $feedbackByLevel1,
            "assignedToLevel2"  =>  $assignedToLevel2,
            "feedbackByLevel2"  =>  $feedbackByLevel2,
            'categoryCounts'    =>  $categoryCounts,
            'yetToAssign'    =>  $yetToAssign,

            //DD
            'totalDdForms' =>  $totalDdForms,
            'paidDdForms'  =>  $paidDdForms,

            //JURY
            'totalAssignedToLevel1' => $totalAssignedToLevel1,
            'marksGivenByLevel1'    => $marksGivenByLevel1,
            //GRAND-JURY
            'totalAssignedToLevel2' => $totalAssignedToLevel2,
            'marksGivenByLevel2'    => $marksGivenByLevel2,

            //RECRUITER
            // 'alumniRecords' => $alumniRecords,
        ]);
    }
}
