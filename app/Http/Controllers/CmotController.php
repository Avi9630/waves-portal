<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use App\Exports\ExportByGrandJury;
use App\Models\CmotJuryAssign;
use App\Exports\ExportByJury;
use Illuminate\Http\Request;
use App\Models\CmotCategory;
use App\Models\AssignToJury;
use App\Exports\CmotExport;
use App\Models\State;
use App\Models\User;
use App\Models\Cmot;
use App\Models\City;

class CmotController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        // V-1
        // $roleName = Role::select('name')
        //     ->where('id', $this->user->role_id)
        //     ->first();
        // if (in_array($roleName['name'], ['JURY', 'GRANDJURY'])) {
        //     $cmotIds = CmotJuryAssign::where('user_id', $this->user->id)->pluck('cmot_id');
        //     // $cmots = Cmot::whereIn('id', $cmotIds)->paginate(5);
        //     $query = Cmot::query();
        //     $query->whereIn('id', $cmotIds);
        //     // $query->orderBy('id','ASC');
        //     $totalAssignedCmot = $query->count();
        //     // $cmots = $query->paginate(10);
        //     $cmots = $query->get();
        //     return view('review.index', ['cmots' => $cmots, 'totalAssignedCmot' => $totalAssignedCmot]);
        // } else {
        //     // $cmots = Cmot::where(['step' => 5])->orderBy('id', 'ASC')->paginate(10);
        //     $query = Cmot::query();
        //     $query->where('step', 5);
        //     $query->orderBy('id', 'ASC');
        //     $totalPaidCmot = $query->count();
        //     // $cmots = $query->paginate(10);
        //     $cmots = $query->get();
        //     return view('cmots.index', ['cmots' => $cmots, 'totalPaidCmot' => $totalPaidCmot]);
        // }

        $roleName = Role::where('id', $this->user->role_id)->value('name');
        if (in_array($roleName, ['JURY', 'GRANDJURY'])) {
            $cmotIds = CmotJuryAssign::where('user_id', $this->user->id)->pluck('cmot_id');
            $cmots = Cmot::whereIn('id', $cmotIds)->paginate(10);
            $totalAssignedCmot = $cmots->count();

            return view('review.index', [
                'cmots' => $cmots,
                'totalAssignedCmot' => $totalAssignedCmot,
            ]);
        } else {
            $query = Cmot::where('step', 5)->orderBy('id', 'ASC');
            $cmots = $query->paginate(10);
            $totalPaidCmot = $query->count();

            return view('cmots.index', [
                'cmots' => $cmots,
                'totalPaidCmot' => $totalPaidCmot,
            ]);
        }
    }

    public function search(Request $request)
    {
        $payload    =   $request->all();
        $query      =   Cmot::query();
        $query->when($payload, function (Builder $builder) use ($payload) {
            $builder->where('step', 5);
        });
        $totalPaidCmot = $query->count();
        $query->when($payload, function (Builder $builder) use ($payload) {
            if (!empty($payload['search'])) {
                $builder->where('category_id', $payload['search']);
            }
        });
        $query->orderBy('id', 'ASC');        
        $totalCmotByCategory    =   $query->count();
        $cmots                  =   $query->paginate(10);
        return view('cmots.index', [
            'cmots'                 =>  $cmots,
            'totalPaidCmot'         =>  $totalPaidCmot,
            'totalCmotByCategory'   =>  $totalCmotByCategory,
            'payload'               =>  $payload
        ]);
    }

    public function autoAsign()
    {
        // $cmots      =   Cmot::select('id', 'category_id')->where(['step' => 5, 'stage' => NULL])->get();
        $cmots = Cmot::select('id', 'category_id')
            ->where('step', 5)
            ->where(function ($query) {
                $query->where('stage', 0)->orWhereNull('stage');
            })
            ->get();
        // dd($cmots);
        $oddIds = [];
        $juryRole = Role::where('name', 'jury')->first();
        $users = User::whereHas('roles', function ($query) use ($juryRole) {
            $query->where('id', $juryRole->id);
        })
            ->get()
            ->toArray();
        $cat_jury = [];
        foreach ($users as $user) {
            $cat_jury[$user['cmot_category_id']][] = $user['id'];
        }
        foreach ($cmots as $cmot) {
            if (isset($cmot->category_id)) {
                if (empty($cat_jury[$cmot->category_id][0])) {
                    continue;
                }
                if ($cmot->id % 2 == 0) {
                    $evenIds[] = $cmot->id;
                    $checkRecords = CmotJuryAssign::where([
                        'user_id' => $cat_jury[$cmot->category_id][0],
                        'cmot_id' => $cmot->id,
                    ])->first();
                    if (empty($checkRecords)) {
                        Cmot::where('id', $cmot->id)->update(['stage' => Cmot::cmotStages()['ASSIGNED_TO_JURY']]);
                        CmotJuryAssign::insert([
                            'user_id' => $cat_jury[$cmot->category_id][0],
                            'cmot_id' => $cmot->id,
                            'assigned_by' => Auth::user()->id,
                        ]);
                    }
                } else {
                    if (empty($cat_jury[$cmot->category_id][1])) {
                        continue;
                    }
                    $oddIds[] = $cmot->id;
                    $checkRecords = CmotJuryAssign::where([
                        'user_id' => $cat_jury[$cmot->category_id][1],
                        'cmot_id' => $cmot->id,
                    ])->first();
                    if (empty($checkRecords)) {
                        Cmot::where('id', $cmot->id)->update(['stage' => Cmot::cmotStages()['ASSIGNED_TO_JURY']]);
                        CmotJuryAssign::insert([
                            'user_id' => $cat_jury[$cmot->category_id][1],
                            'cmot_id' => $cmot->id,
                            'assigned_by' => Auth::user()->id,
                        ]);
                    }
                }
            }
        }
        return redirect()->back()->with('success', 'Details successfully assigned.!');
    }

    // public function autoAsign()
    // {
    //     $cmots      =   Cmot::select('id', 'category_id')
    //         ->where('stage', 0)
    //         ->orWhereNull('stage')
    //         ->get();
    //     $oddIds     =   [];

    //     $juryRole   =   Role::where('name', 'jury')->first();
    //     $users      =   User::whereHas('roles', function ($query) use ($juryRole) {
    //         $query->where('id', $juryRole->id);
    //     })->get()->toArray();
    //     $cat_jury = [];
    //     foreach ($users as $user) {
    //         $cat_jury[$user['cmot_category_id']][] = $user['id'];
    //     }
    //     // echo "<pre>";
    //     // print_r($cat_jury);
    //     // die();
    //     $user_assigned = [];
    //     foreach ($cmots as $cmot) {
    //         // dd($cmot);
    //         $get_jury = $cat_jury[$cmot->category_id];
    //         // echo "<pre>";
    //         // print_r($get_jury);
    //         // die();
    //         if (!isset($user_assigned[$get_jury[0]]))
    //             $user_assigned[$get_jury[0]] = 0;
    //         if (!isset($user_assigned[$get_jury[1]]))
    //             $user_assigned[$get_jury[1]] = 0;
    //         $assigned_user = $get_jury[0];

    //         if ($user_assigned[$get_jury[0]] > $user_assigned[$get_jury[1]])
    //             $assigned_user = $get_jury[1];
    //         $user_assigned[$assigned_user] = 1 + $user_assigned[$assigned_user];
    //         echo "<pre>";
    //         echo $cmot->category_id . "<br>";
    //         print_r($get_jury);
    //         echo "first_jury" . $user_assigned[$get_jury[0]] .  "<br>";
    //         echo "second_jury" . $user_assigned[$get_jury[1]] . "<br>";
    //         print_r($assigned_user);
    //         $assignTo = [
    //             'user_id' => $assigned_user,
    //             'cmot_id' => $cmot->id,
    //             'assigned_by' => Auth::user()->id,
    //         ];
    //         $checkRecords = CmotJuryAssign::where([
    //             'user_id' => $assigned_user,
    //             'cmot_id' => $cmot->id
    //         ])->first();
    //         if (empty($checkRecords)) {
    //             Cmot::where('id', $assignTo['cmot_id'])->update(['stage' => Cmot::cmotStages()['ASSIGNED_TO_JURY']]);
    //             CmotJuryAssign::insert($assignTo);
    //         }
    //         $assigned_user;
    //     }
    // }

    public function autoAsignOld()
    {
        // $cmots      =   Cmot::select('id')->get();
        $cmots = Cmot::select('id')->where('stage', 0)->orWhereNull('stage')->get();
        $juryRole = Role::where('name', 'jury')->first();
        $users = User::whereHas('roles', function ($query) use ($juryRole) {
            $query->where('id', $juryRole->id);
        })->get();
        $oddIds = [];
        foreach ($cmots as $cmot) {
            if ($cmot->id % 2 == 0) {
                $evenIds[] = $cmot->id;
                $assignTo = [
                    'user_id' => $users[0]['id'],
                    'cmot_id' => $cmot->id,
                    'assigned_by' => Auth::user()->id,
                ];
                $roleName = Role::select('name')
                    ->where('id', $users[0]['role_id'])
                    ->first();
                if (in_array($roleName['name'], ['JURY'])) {
                    $checkRecords = CmotJuryAssign::where([
                        'user_id' => $users[1]['id'],
                        'cmot_id' => $cmot->id,
                    ])->first();
                    if (empty($checkRecords)) {
                        Cmot::where('id', $assignTo['cmot_id'])->update(['stage' => Cmot::cmotStages()['ASSIGNED_TO_JURY']]);
                        CmotJuryAssign::insert($assignTo);
                    }
                }
            } else {
                $oddIds[] = $cmot->id;
                $assignTo = [
                    'user_id' => $users[1]['id'],
                    'cmot_id' => $cmot->id,
                    'assigned_by' => Auth::user()->id,
                ];
                $roleName = Role::select('name')
                    ->where('id', $users[1]['role_id'])
                    ->first();
                if (in_array($roleName['name'], ['JURY'])) {
                    $checkRecords = CmotJuryAssign::where([
                        'user_id' => $users[1]['id'],
                        'cmot_id' => $cmot->id,
                    ])->first();
                    if (empty($checkRecords)) {
                        Cmot::where('id', $assignTo['cmot_id'])->update(['stage' => Cmot::cmotStages()['ASSIGNED_TO_JURY']]);
                        CmotJuryAssign::insert($assignTo);
                    }
                }
            }
        }
        return redirect()->back()->with('success', 'Details successfully assigned.!');
    }

    public function assignTo(Request $request, $id)
    {
        $payload = $request->all();
        $request->validate([
            'user_id' => 'required|numeric',
        ]);
        $assignTo = [
            'user_id' => $payload['user_id'],
            'cmot_id' => $id,
            'assigned_by' => Auth::user()->id,
        ];

        $user = User::find($payload['user_id']);
        $roleName = Role::select('name')
            ->where('id', $user['role_id'])
            ->first();

        if (in_array($roleName['name'], ['JURY', 'GRANDJURY'])) {
            $checkRecords = CmotJuryAssign::where([
                'user_id' => $payload['user_id'],
                'cmot_id' => $id,
            ])->first();

            if (!empty($checkRecords)) {
                return redirect()->back()->with('warning', 'Details already assigned.!');
            }

            if ($roleName['name'] === 'GRANDJURY') {
                $cmot = Cmot::where(['id' => $id, 'stage' => 2])->first();
                if (empty($cmot)) {
                    return redirect()->back()->with('warning', 'Score still pending from Jury side.!');
                }
            }

            $x = CmotJuryAssign::insert($assignTo);
            if ($x) {
                if ($roleName['name'] === 'JURY') {
                    Cmot::where('id', $assignTo['cmot_id'])->update(['stage' => Cmot::cmotStages()['ASSIGNED_TO_JURY']]);
                }
                if ($roleName['name'] === 'GRANDJURY') {
                    Cmot::where('id', $assignTo['cmot_id'])->update(['stage' => Cmot::cmotStages()['ASSIGNED_TO_GRAND_JURY']]);
                }
                return redirect()->back()->with('success', 'Details successfully assigned.!');
            } else {
                return redirect()->back()->with('warning', 'Something went wrong.!');
            }
        }
        return redirect()->back()->with('warning', 'Something went wrong.!');
    }

    public function assignToOld(Request $request, $id)
    {
        $payload = $request->all();
        $request->validate([
            'user_id' => 'required|numeric',
        ]);

        $assignTo = [
            'user_id' => $payload['user_id'],
            'cmot_id' => $id,
            'assigned_by' => Auth::user()->id,
        ];

        $user = User::find($payload['user_id']);
        $roleName = Role::select('name')
            ->where('id', $user['role_id'])
            ->first();

        if (in_array($roleName['name'], ['JURY', 'GRANDJURY'])) {
            $checkRecords = CmotJuryAssign::where([
                'user_id' => $payload['user_id'],
                'cmot_id' => $id,
            ])->first();

            if (!empty($checkRecords)) {
                return redirect()->back()->with('warning', 'Details already assigned.!');
            }

            if ($roleName['name'] === 'GRANDJURY') {
                $cmot = Cmot::where(['id' => $id, 'stage' => 2])->first();
                if (empty($cmot)) {
                    return redirect()->back()->with('warning', 'Score still pending from Jury side.!');
                }
            }

            $x = CmotJuryAssign::insert($assignTo);
            if ($x) {
                if ($roleName['name'] === 'JURY') {
                    Cmot::where('id', $assignTo['cmot_id'])->update(['stage' => Cmot::cmotStages()['ASSIGNED_TO_JURY']]);
                }
                if ($roleName['name'] === 'GRANDJURY') {
                    Cmot::where('id', $assignTo['cmot_id'])->update(['stage' => Cmot::cmotStages()['ASSIGNED_TO_GRAND_JURY']]);
                }
                return redirect()->back()->with('success', 'Details successfully assigned.!');
            } else {
                return redirect()->back()->with('warning', 'Something went wrong.!');
            }
        }
        return redirect()->back()->with('warning', 'Something went wrong.!');
    }

    public function show(Cmot $cmot)
    {
        $scores = AssignToJury::where('cmot_id', $cmot->id)->get();
        $states = State::all();
        $cities = City::all();
        return view('cmots.show', [
            'cmot' => $cmot,
            'scores' => $scores,
            'states' => $states,
            'cities' => $cities,
        ]);
    }

    public function review($id)
    {
        $cmot = Cmot::find($id);
        return view('review.view', ['cmot' => $cmot]);
    }

    public function feedback(Request $request, $id)
    {
        $payload = $request->all();
        $request->validate([
            'overall_score' => 'required|numeric|min:1|max:10',
            'feedback' => 'required',
        ]);

        $finData = CmotJuryAssign::where(['user_id' => $this->user->id, 'cmot_id' => $id])->first();

        if ($finData) {
            $roleName = Role::select('name')
                ->where('id', $this->user->role_id)
                ->first();
            if (!$roleName) {
                return redirect()->back()->with('warning', 'Role not valid.!');
            }
            $finData->overall_score = isset($payload['overall_score']) && !empty($payload['overall_score']) ? $payload['overall_score'] : $finData->overall_score;
            $finData->feedback = isset($payload['feedback']) && !empty($payload['feedback']) ? $payload['feedback'] : $finData->feedback;
            $finData->total_score = $payload['overall_score'];
            $finData->active = 0;

            if ($roleName['name'] === 'JURY') {
                $finData->level = 1;
            }

            if ($roleName['name'] === 'GRANDJURY') {
                $finData->level = 2;
            }

            if ($finData->save()) {
                if ($roleName['name'] === 'JURY') {
                    $feedbackGivenByJury = Cmot::cmotStages()['FEEDBACK_GIVEN_BY_JURY'];
                    Cmot::where('id', $id)->update(['stage' => $feedbackGivenByJury]);
                }
                if ($roleName['name'] === 'GRANDJURY') {
                    $feedbackGivenByGrnadJury = Cmot::cmotStages()['FEEDBACK_GIVEN_BY_GRAND_JURY'];
                    Cmot::where('id', $id)->update(['stage' => $feedbackGivenByGrnadJury]);
                }
                $cmotIds = CmotJuryAssign::where('user_id', $this->user->id)->pluck('cmot_id');
                // $cmots      =   Cmot::whereIn('id', $cmotIds)->paginate(5);
                $cmots = Cmot::whereIn('id', $cmotIds)->get();
                return view('review.index', ['cmots' => $cmots])->with('success', 'You have successfully submited your scores and feedback.!!');
            } else {
                return redirect()->back()->with('warning', 'Review not updated.!');
            }
        } else {
            return redirect()->back()->with('Something went wrong.!');
        }
    }

    public function deleteAssignJury($id)
    {
        $asignedRecord = CmotJuryAssign::where('cmot_id', $id)->first();
        $asignedRecord->delete();
        $cmotIds = CmotJuryAssign::pluck('cmot_id');
        $cmots = Cmot::whereIn('id', $cmotIds)->paginate(5);
        return view('jury.index', ['cmots' => $cmots])->with('success', 'You have successfully submited your rating and feedback.!!');
    }

    public function dashboard()
    {
        $totalCmots = Cmot::all();
        $categories = CmotCategory::all();
        foreach ($categories as $category) {
            $categoryCounts[$category->name] = Cmot::where('category_id', $category->id)->count();
        }
        $cmotAssignTolevel1 = Cmot::where('stage', 1)->get();
        $cmotAssignTolevel2 = Cmot::where('stage', 3)->get();
        $feedbackBylevel1 = Cmot::where('stage', 2)->get();
        $feedbackBylevel2 = Cmot::where('stage', 4)->get();
        return view('dashboard.cmot-dashboard', [
            'totalCmots' => $totalCmots,
            'categoryCounts' => $categoryCounts,
            'cmotAssignTolevel1' => $cmotAssignTolevel1,
            'cmotAssignTolevel2' => $cmotAssignTolevel2,
            'feedbackBylevel1' => $feedbackBylevel1,
            'feedbackBylevel2' => $feedbackBylevel2,
        ]);
    }

    function export()
    {
        return Excel::download(new CmotExport(), 'cmots.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    function exportByJury(Request $request)
    {
        $payload = $request->all();
        $message = [
            'user_id' => 'Please select jury to export record!',
        ];
        $request->validate(
            [
                'user_id' => 'required',
            ],
            $message,
        );

        $users = User::with(['cmotJuryAssigns.cmot'])->find($payload['user_id']);
        if ($users && $users->cmotJuryAssigns->isNotEmpty()) {
            $fileName = 'JuryScore.xls';
            return Excel::download(new ExportByJury($users), $fileName);
        } else {
            return redirect()->back()->with('danger', 'No records found to export! || User not found!');
        }
    }

    function exportByGrandJury(Request $request)
    {
        $payload = $request->all();
        $message = [
            'user_id' => 'Please select grand jury to export record!',
        ];
        $request->validate(
            [
                'user_id' => 'required',
            ],
            $message,
        );

        $users = User::with(['cmotJuryAssigns.cmot'])->find($payload['user_id']);
        if ($users && $users->cmotJuryAssigns->isNotEmpty()) {
            $fileName = 'JuryScore.xls';
            return Excel::download(new ExportByGrandJury($users), $fileName);
        } else {
            return redirect()->back()->with('danger', 'No records found to export! || User not found!');
        }
    }
}
