<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use App\Models\UserCmotParticipantSelect;
use App\Models\UserCmotParticipantReject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CmotParticipant;
use App\Models\CmotCategory;
use Illuminate\Http\Request;
use App\Models\User;

class CmotParticipantsController extends Controller
{
    public function index()
    {
        $cmotParticipants   =   CmotParticipant::where(['cmot_edition' => 2024])->get();
        $categories         =   CmotCategory::all();
        return view('cmot-participants.index', [
            'cmots'         =>  $cmotParticipants,
            'categories'    =>  $categories
        ]);
    }

    public function show(CmotParticipant $cmotParticipant)
    {
        return view('cmot-participants.show', [
            'cmotParticipant' => $cmotParticipant,
        ]);
    }

    public function selectByRecruiter($cmotParticipantId)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'cmot_participant_id' => $cmotParticipantId,
        ];
        $exists = CmotParticipant::existsSelected($data);
        if (!$exists) {
            $success = UserCmotParticipantSelect::firstOrCreate($data);
            if ($success) {
                UserCmotParticipantReject::where($data)->delete();
                // return redirect()->back()->with('success', 'You have successfully selected!!');
                return redirect()->route('cmot-participants.index')->with('success', 'You have successfully selected!!');
            } else {
                return redirect()->back()->with('success', 'You have successfully selected!!');
            }
        } else {
            return redirect()->back()->with('danger', 'Alumni already selected by you!');
        }
    }

    public function rejectByRecruiter($cmotParticipantId)
    {
        $data = [
            'user_id'               =>  Auth::user()->id,
            'cmot_participant_id'   =>  $cmotParticipantId,
        ];
        $exists = CmotParticipant::existsRejected($data);
        if (!$exists) {
            $success = UserCmotParticipantReject::firstOrCreate($data);
            if ($success) {
                UserCmotParticipantSelect::where($data)->delete();
                // return redirect()->back()->with('success', 'You have successfully rejected!');
                return redirect()->route('cmot-participants.index')->with('success', 'You have successfully rejected!');
            } else {
                return redirect()->back()->with('success', 'Something went wrong!');
            }
        } else {
            return redirect()->back()->with('danger', 'Something went wrong!');
        }
    }

    public function selectedList()
    {
        $cmotParticipantIds =   UserCmotParticipantSelect::where('user_id', Auth::user()->id)->pluck('cmot_participant_id')->toArray();
        $cmotParticipants   =   CmotParticipant::whereIn('id', $cmotParticipantIds)->get();
        return view('cmot-participants.select', ['cmotParticipants' => $cmotParticipants]);
    }

    public function rejectedList()
    {
        $cmotParticipantIds  =   UserCmotParticipantReject::where('user_id', Auth::user()->id)->pluck('cmot_participant_id')->toArray();
        $cmotParticipants    =   CmotParticipant::whereIn('id', $cmotParticipantIds)->get();
        return view('cmot-participants.reject', ['cmotParticipants' => $cmotParticipants]);
    }

    public function selectedUndo($cmotParticipantId)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'cmot_participant_id' => $cmotParticipantId,
        ];
        $exists = CmotParticipant::existsSelected($data);
        if ($exists) {
            UserCmotParticipantSelect::where($data)->delete();
            return redirect()->back()->with('success', 'Undo successfully 🙂!');
        } else {
            return redirect()->back()->with('danger', 'Something went wrong!');
        }
    }

    public function rejectedUndo($cmotParticipantId)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'cmot_participant_id' => $cmotParticipantId,
        ];
        $exists = CmotParticipant::existsRejected($data);
        if ($exists) {
            UserCmotParticipantReject::where($data)->delete();
            return redirect()->back()->with('success', 'Undo successfully 🙂!');
        } else {
            return redirect()->back()->with('danger', 'Something went wrong!');
        }
    }

    public function interestedBy()
    {
        $cmotparticipants = DB::table('cmot_participants')
            ->join('user_cmot_participant_select', 'cmot_participants.id', '=', 'user_cmot_participant_select.cmot_participant_id')
            ->join('users', 'users.id', '=', 'user_cmot_participant_select.user_id')
            ->select('cmot_participants.*', 'users.id as user_id', 'users.email as user_email', 'users.name as user_name', 'users.production_house as production_house')
            ->get();
        return view('cmot-participants.interested-by', [
            'cmotparticipants'       =>  $cmotparticipants,
        ]);
    }

    public function companySearch(Request $request)
    {
        $payload            =   $request->all();

        $productionHouse    =   !empty($payload['production_house']) ? $payload['production_house'] : '';
        $cmotParticipant    =   !empty($payload['cmot_participant']) ? $payload['cmot_participant'] : '';
        $rejected           =   isset($payload['rejected']) && !empty($payload['rejected']) ? $payload['rejected'] : '';

        $query = CmotParticipant::query();
        if (!empty($productionHouse) || !empty($cmotParticipant)) {

            if (!empty($productionHouse)) {
                $users = User::where('production_house', 'LIKE', "%{$productionHouse}%")->pluck('id')->toArray();
                if (!empty($users)) {
                    if (!empty($rejected)) {
                        $cmotParticipantIds  =   !empty($rejected) ? UserCmotParticipantReject::whereIn('user_id', $users)->pluck('cmot_participant_id')->toArray() : [];
                        $query->whereIn('cmot_participants.id', $cmotParticipantIds)
                            ->join('user_cmot_participant_reject', function ($join) use ($users) {
                                $join->on('cmot_participants.id', '=', 'user_cmot_participant_reject.cmot_participant_id')
                                    ->whereIn('user_cmot_participant_reject.user_id', $users);
                            })
                            ->join('users', function ($join) use ($users) {
                                $join->on('users.id', '=', 'user_cmot_participant_reject.user_id')
                                    ->whereIn('users.id', $users);
                            })->addSelect('cmot_participants.*', 'users.id as user_id', 'users.email as user_email', 'users.name as user_name', 'users.production_house as production_house');
                    } else {
                        $cmotParticipantIds = UserCmotParticipantSelect::whereIn('user_id', $users)
                            ->pluck('cmot_participant_id')
                            ->toArray();

                        $query->whereIn('cmot_participants.id', $cmotParticipantIds)
                            ->join('user_cmot_participant_select', function ($join) use ($users) {
                                $join->on('cmot_participants.id', '=', 'user_cmot_participant_select.cmot_participant_id')
                                    ->whereIn('user_cmot_participant_select.user_id', $users);
                            })
                            ->join('users', function ($join) use ($users) {
                                $join->on('users.id', '=', 'user_cmot_participant_select.user_id')
                                    ->whereIn('users.id', $users);
                            })->addSelect('cmot_participants.*', 'users.id as user_id', 'users.email as user_email', 'users.name as user_name', 'users.production_house as production_house');
                    }
                } else {
                    $query->whereRaw('1 = 0');
                }
            }

            if (!empty($cmotParticipant)) {
                $query      =   CmotParticipant::where('full_name', $cmotParticipant);
                $cmotParticipantIds  =   $query->pluck('id')->toArray();

                if ($cmotParticipantIds) {
                    if (!empty($rejected)) {
                        $users = UserCmotParticipantReject::whereIn('cmot_participant_id', $cmotParticipantIds)->pluck('user_id')->toArray();
                        $query = User::whereIn('users.id', $users)
                            ->join('user_cmot_participant_reject', function ($join) use ($cmotParticipantIds) {
                                $join->on('users.id', '=', 'user_cmot_participant_reject.user_id')
                                    ->whereIn('user_cmot_participant_reject.cmot_participant_id', $cmotParticipantIds);
                            })
                            ->join('cmot_participants', function ($join) use ($cmotParticipantIds) {
                                $join->on('cmot_participants.id', '=', 'user_alumni_reject.cmot_participant_id')
                                    ->whereIn('cmot_participants.id', $cmotParticipantIds);
                            })
                            // ->addSelect('cmot_participants.*', 'users.*');
                            ->addSelect('cmot_participants.*', 'users.id as user_id', 'users.email as user_email', 'users.name as user_name', 'users.production_house as production_house');
                    } else {
                        $users = UserCmotParticipantSelect::whereIn('cmot_participant_id', $cmotParticipantIds)->pluck('user_id')->toArray();
                        if (!empty($users)) {
                            $query = User::whereIn('users.id', $users)
                                ->join('user_cmot_participant_select', function ($join) use ($cmotParticipantIds) {
                                    $join->on('users.id', '=', 'user_cmot_participant_select.user_id')
                                        ->whereIn('user_cmot_participant_select.cmot_participant_id', $cmotParticipantIds);
                                })
                                ->join('alumnis', function ($join) use ($cmotParticipantIds) {
                                    $join->on('alumnis.id', '=', 'user_cmot_participant_select.cmot_participant_id')
                                        ->whereIn('alumnis.id', $cmotParticipantIds);
                                })
                                // ->addSelect('cmot_participants.*', 'users.*');
                                ->addSelect('cmot_participants.*', 'users.id as user_id', 'users.email as user_email', 'users.name as user_name', 'users.production_house as production_house');
                        } else {
                            $query->whereRaw('1 = 0');
                        }
                    }
                } else {
                    $query->whereRaw('1 = 0');
                }
            }
        } else {
            $query->join('user_cmot_participant_select', 'cmot_participants.id', '=', 'user_cmot_participant_select.cmot_participant_id');
            $query->join('users', 'users.id', '=', 'user_cmot_participant_select.user_id');
            $query->select('cmot_participants.*', 'users.id as user_id', 'users.email as user_email', 'users.name as user_name', 'users.production_house as production_house');
            $query->get();
        }
        $cmotParticipants = $query->get();

        return view('cmot-participants.interested-by', [
            'cmotparticipants'  =>  $cmotParticipants,
            'payload'           =>  $payload,
        ]);
    }

    public function search(Request $request)
    {
        $payload            =   $request->all();
        $category           =   !empty($payload['cmot_category_id']) ? $payload['cmot_category_id'] : '';
        $cmotEditionYear    =   !empty($payload['cmot_edition_year']) ? $payload['cmot_edition_year'] : '';

        $cmotParticipants = CmotParticipant::query()
            ->when($payload, function (Builder $builder) use ($payload) {
                if (!empty($payload['cmot_category_id'])) {
                    $builder->where('cmot_category_id', $payload['cmot_category_id']);
                }
                if (!empty($payload['cmot_edition_year'])) {
                    $builder->where('cmot_edition', $payload['cmot_edition_year']);
                }
            })
            ->get();

        // $query = CmotParticipant::query();
        // if (!empty($category)) {
        //     $query->where('cmot_category_id', $category);
        // }
        // if (!empty($cmotEditionYear)) {
        //     $query->where('cmot_edition', $cmotEditionYear);
        // }
        // $filteredData       =   $query->get();
        // $count              =   $query->count();
        // $cmotParticipants   =   $query->paginate(10);
        $categories         =   CmotCategory::all();
        return view('cmot-participants.index', [
            'cmots'         =>  $cmotParticipants,
            'categories'    =>  $categories,
            'payload'       =>  $payload,
        ]);
    }
}
