<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserAlumniReject;
use App\Models\UserAlumniSelect;
use App\Models\CmotCategory;
use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\User;

class AlumniController extends Controller
{
    public function index()
    {
        $alumnis      =   Alumni::get(); //paginate(10);
        $categories   =   CmotCategory::all();
        return view('alumni.index', [
            'alumnis'        =>  $alumnis,
            'categories'    =>  $categories
        ]);
    }

    public function show(Alumni $alumni)
    {
        return view('alumni.show', [
            'alumni' => $alumni,
        ]);
    }

    public function destroy(Alumni $alumni)
    {
        $alumni->delete();
        return redirect()->back()->with('success', 'Alumni deleted successfully.!!');
    }

    public function search(Request $request)
    {
        $payload    =   $request->all();
        $category           =   !empty($payload['category_id']) ? $payload['category_id'] : '';
        $cmotEditionYear    =   !empty($payload['cmot_edition_year']) ? $payload['cmot_edition_year'] : '';

        $alumni = Alumni::query()
            ->when($payload, function (Builder $builder) use ($payload) {
                if (!empty($payload['category_id'])) {
                    $builder->where('category_id', $payload['category_id']);
                }
                if (!empty($payload['cmot_edition_year'])) {
                    $builder->where('cmot_edition', $payload['cmot_edition_year']);
                }
            })
            ->get();

        // $query = Alumni::query();
        // if (!empty($category)) {
        //     $query->where('category_id', $category);
        // }
        // if (!empty($cmotEditionYear)) {
        //     $query->where('cmot_edition', $cmotEditionYear);
        // }
        // $filteredData = $query->get();
        // $count = $query->count();
        // $alumnis = $query->paginate(10);

        $categories   =   CmotCategory::all();
        return view('alumni.index', [
            'alumnis'       =>  $alumni,
            'categories'    =>  $categories,
            'payload'       =>  $payload,
        ]);
    }

    public function cmotEdition(Request $request)
    {
        $alumnis    =   Alumni::paginate(10);
        return view('alumni.cmot-edition', [
            'alumnis'       =>  $alumnis,
        ]);
    }

    public function cmotEditionSearch(Request $request)
    {
        $alumnis = Alumni::query()
            ->when(
                $request->year,
                function (Builder $builder) use ($request) {
                    $builder->where('cmot_edition', $request->year);
                }
            )->paginate(10);
        return view('alumni.cmot-edition', [
            'alumnis'       =>  $alumnis,
        ]);
    }

    public function interestedBy()
    {
        $alumnis = DB::table('alumnis')
            ->join('user_alumni_select', 'alumnis.id', '=', 'user_alumni_select.alumni_id')
            ->join('users', 'users.id', '=', 'user_alumni_select.user_id')
            ->select('alumnis.*', 'users.id as user_id', 'users.email as user_email', 'users.name as user_name', 'users.production_house as production_house') // Selecting necessary user columns
            ->get();
        return view('alumni.interested-by', [
            'alumnis'       =>  $alumnis,
        ]);
    }

    public function companySearch(Request $request)
    {
        $payload            =   $request->all();
        $productionHouse    =   !empty($payload['production_house']) ? $payload['production_house'] : '';
        $alumni             =   !empty($payload['alumni']) ? $payload['alumni'] : '';
        $rejected           =   isset($payload['rejected']) && !empty($payload['rejected']) ? $payload['rejected'] : '';

        $query = Alumni::query();

        if (!empty($productionHouse) || !empty($alumni)) {

            if (!empty($productionHouse)) {

                // $users = User::where('production_house', $productionHouse)->pluck('id')->toArray();
                $users = User::where('production_house', 'LIKE', "%{$productionHouse}%")->pluck('id')->toArray();

                if (!empty($users)) {
                    if (!empty($rejected)) {
                        $alumniIds  =   !empty($rejected) ? UserAlumniReject::whereIn('user_id', $users)->pluck('alumni_id')->toArray() : [];
                        $query->whereIn('alumnis.id', $alumniIds)
                            ->join('user_alumni_reject', function ($join) use ($users) {
                                $join->on('alumnis.id', '=', 'user_alumni_reject.alumni_id')
                                    ->whereIn('user_alumni_reject.user_id', $users);
                            })
                            ->join('users', function ($join) use ($users) {
                                $join->on('users.id', '=', 'user_alumni_reject.user_id')
                                    ->whereIn('users.id', $users);
                                // })->addSelect('alumnis.*','users.*');
                            })->addSelect('alumnis.*', 'users.id as user_id', 'users.email as user_email', 'users.name as user_name', 'users.production_house as production_house');
                    } else {

                        $alumniIds = UserAlumniSelect::whereIn('user_id', $users)->pluck('alumni_id')->toArray();

                        $query->whereIn('alumnis.id', $alumniIds)
                            ->join('user_alumni_select', function ($join) use ($users) {
                                $join->on('alumnis.id', '=', 'user_alumni_select.alumni_id')
                                    ->whereIn('user_alumni_select.user_id', $users);
                            })
                            ->join('users', function ($join) use ($users) {
                                $join->on('users.id', '=', 'user_alumni_select.user_id')
                                    ->whereIn('users.id', $users);
                                // })->addSelect('alumnis.*','users.*');
                            })->addSelect('alumnis.*', 'users.id as user_id', 'users.email as user_email', 'users.name as user_name', 'users.production_house as production_house');
                    }
                } else {
                    $query->whereRaw('1 = 0');
                }
            }

            if (!empty($alumni)) {
                $query      =   Alumni::where('full_name', $alumni);
                $alumniIds  =   $query->pluck('id')->toArray();

                if ($alumniIds) {
                    if (!empty($rejected)) {
                        $users = UserAlumniReject::whereIn('alumni_id', $alumniIds)->pluck('user_id')->toArray();
                        $query = User::whereIn('users.id', $users)
                            ->join('user_alumni_reject', function ($join) use ($alumniIds) {
                                $join->on('users.id', '=', 'user_alumni_reject.user_id')
                                    ->whereIn('user_alumni_reject.alumni_id', $alumniIds);
                            })
                            ->join('alumnis', function ($join) use ($alumniIds) {
                                $join->on('alumnis.id', '=', 'user_alumni_reject.alumni_id')
                                    ->whereIn('alumnis.id', $alumniIds);
                            })
                            ->addSelect('alumnis.*', 'users.*');
                    } else {
                        $users = UserAlumniSelect::whereIn('alumni_id', $alumniIds)->pluck('user_id')->toArray();
                        if (!empty($users)) {
                            $query = User::whereIn('users.id', $users)
                                ->join('user_alumni_select', function ($join) use ($alumniIds) {
                                    $join->on('users.id', '=', 'user_alumni_select.user_id')
                                        ->whereIn('user_alumni_select.alumni_id', $alumniIds);
                                })
                                ->join('alumnis', function ($join) use ($alumniIds) {
                                    $join->on('alumnis.id', '=', 'user_alumni_select.alumni_id')
                                        ->whereIn('alumnis.id', $alumniIds);
                                })
                                ->addSelect('alumnis.*', 'users.*');
                        } else {
                            $query->whereRaw('1 = 0');
                        }
                    }
                } else {
                    $query->whereRaw('1 = 0');
                }
            }
        } else {
            // $query->join('user_alumni_select', 'alumnis.id', '=', 'user_alumni_select.alumni_id');
            // $query->join('users', 'users.id', '=', 'user_alumni_select.user_id');
            // $query->select('alumnis.*', 'users.*');
            // $query->get();
            $query->join('user_alumni_select', 'alumnis.id', '=', 'user_alumni_select.alumni_id');
            $query->join('users', 'users.id', '=', 'user_alumni_select.user_id');
            $query->select('alumnis.*', 'users.id as user_id', 'users.email as user_email', 'users.name as user_name', 'users.production_house as production_house'); // Selecting necessary user columns
            $query->get();
        }

        $alumnis = $query->get();
        return view('alumni.interested-by', [
            'alumnis'       =>  $alumnis,
            'payload'       =>  $payload,
        ]);
    }

    public function selectByRecruiter(Request $request, $alumniId)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'alumni_id' => $alumniId,
        ];
        $exists = UserAlumniSelect::where('user_id', Auth::user()->id)
            ->where('alumni_id', $alumniId)
            ->exists();
        if (!$exists) {
            $success = UserAlumniSelect::firstOrCreate($data);
            if ($success) {
                UserAlumniReject::where($data)->delete();
                return redirect()->back()->with('success', 'You have successfully selected this alumni!');
            } else {
                return redirect()->back()->with('success', 'You have successfully selected this alumni!');
            }
        } else {
            return redirect()->back()->with('danger', 'Alumni already selected by you!');
        }
    }

    public function rejectByRecruiter($alumniId)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'alumni_id' => $alumniId,
        ];
        $exists = UserAlumniReject::where('user_id', Auth::user()->id)
            ->where('alumni_id', $alumniId)
            ->exists();
        if (!$exists) {
            $success = UserAlumniReject::firstOrCreate($data);
            if ($success) {
                UserAlumniSelect::where($data)->delete();
                return redirect()->back()->with('success', 'You have successfully rejected!');
            } else {
                return redirect()->back()->with('success', 'Something went wrong!');
            }
        } else {
            return redirect()->back()->with('danger', 'Something went wrong!');
        }
    }

    public function selectedList()
    {
        $alumniIds  =   UserAlumniSelect::where('user_id', Auth::user()->id)->pluck('alumni_id')->toArray();
        $alumnis    =   Alumni::whereIn('id', $alumniIds)->get();
        return view('alumni.select', ['alumnis' => $alumnis]);
    }

    public function rejectedList()
    {
        $alumniIds  =   UserAlumniReject::where('user_id', Auth::user()->id)->pluck('alumni_id')->toArray();
        $alumnis    =   Alumni::whereIn('id', $alumniIds)->get();
        return view('alumni.reject', ['alumnis' => $alumnis]);
    }

    public function selectedUndo($alumniId)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'alumni_id' => $alumniId,
        ];
        $exists = UserAlumniSelect::where('user_id', Auth::user()->id)
            ->where('alumni_id', $alumniId)
            ->exists();
        if ($exists) {
            UserAlumniSelect::where($data)->delete();
            return redirect()->back()->with('success', 'Undo successfully 🙂!');
        } else {
            return redirect()->back()->with('danger', 'Something went wrong!');
        }
    }

    public function rejectedUndo($alumniId)
    {
        $data = [
            'user_id' => Auth::user()->id,
            'alumni_id' => $alumniId,
        ];
        $exists = UserAlumniReject::where('user_id', Auth::user()->id)
            ->where('alumni_id', $alumniId)
            ->exists();
        if ($exists) {
            UserAlumniReject::where($data)->delete();
            return redirect()->back()->with('success', 'Undo successfully 🙂!');
        } else {
            return redirect()->back()->with('danger', 'Something went wrong!');
        }
    }
}
