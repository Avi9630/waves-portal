@extends('layouts.app')
@section('title')
    {{ 'CMOT-List' }}
@endsection
@section('content')
    <div class="container-fluid">
        {{-- Search --}}
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-1">
            <div class="g-4">
                <div>
                    <form method="GET" action="{{ route('film_creaft.search') }}" class="filter-project">@csrf
                        @method('GET')
                        <div class="row">
                            {{-- Select Category --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="search"><strong>Category</strong></label>
                                    <select name="search" class="form-select">
                                        <option value="">Select category</option>
                                        @foreach (App\Models\CmotCategory::all() as $category)
                                            <option name="search" value="{{ $category->id }}" {{ isset($payload['search']) && $payload['search'] == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 cmots-buttons ">
                                <label for="name" class="form-label w-100">&nbsp;</label>
                                <button type="submit" class="btn common-btn">SEARCH</button>
                                {{-- <div class="text-end"> --}}
                                <a href="{{ route('cmots.index') }}" class="btn common-btn">RESET</a>
                                <a href="{{ route('cmot.export') }}" class="btn common-btn">EXPORT-ALL </a>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </form>

                    {{-- <div class="text-end">
                        <a href="{{ route('cmots.index') }}" class="btn common-btn">RESET</a>
                        <a href="{{ route('cmot.export') }}" class="btn common-btn">EXPORT-ALL </a>
                    </div> --}}

                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <form method="GET" action="{{ route('export-by-jury') }}" class="filter-project">@csrf
                                    @method('GET')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="user_id"><strong>Jury</strong></label>
                                                <select name="user_id"
                                                    class="form-select @error('user_id') is-invalid @enderror">
                                                    <option value="">Select jury</option>
                                                    @foreach (App\Models\User::where('role_id', 3)->get() as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('user_id')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 cmots-buttons">
                                            <label for="name" class="form-label w-100">&nbsp;</label>
                                            <button type="submit" class="btn common-btn">EXPORT-JURY</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div>
                                <form method="GET" action="{{ route('export-by-grand-jury') }}" class="filter-project">
                                    @csrf
                                    @method('GET')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="user_id"><strong>Grand-Jury</strong></label>
                                                <select name="user_id"
                                                    class="form-select @error('user_id') is-invalid @enderror">
                                                    <option value="">Select Grand Jury</option>
                                                    @foreach (App\Models\User::where('role_id', 4)->get() as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('user_id')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 cmots-buttons">
                                            <label for="name" class="form-label w-100">&nbsp;</label>
                                            <button type="submit" class="btn common-btn">EXPORT-GRANDJURY</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table  --}}
    <div class="row">
        <div class="col-md-12 col-sm-12 d-flex">
            <div class="card card-animate w-100 ">
                <div class="card-header">
                    <h4 class="card-title mb-0 project-title">
                        CMOT
                        {{ isset($totalPaidCmot) ? '(Total Paid :-' . $totalPaidCmot . ')' : '' }}
                        {{ isset($totalCmotByCategory) ? '(Total entries by Category :-' . $totalCmotByCategory . ')' : '' }}
                        <a href="{{ url('auto_asign') }}" class="btn btn-sm btn-warning">AUTO-ASSIGN</a>
                    </h4>
                </div>
                <div class="card-body">
                    <span>
                        <h4 class="alert-danger"></h4>
                    </span>
                    @foreach (['success', 'info', 'danger', 'warning'] as $msg)
                        @if (Session::has($msg))
                            <div id="flash-message" class="alert alert-{{ $msg }}" role="alert">
                                {{ Session::get($msg) }}
                            </div>
                        @endif
                    @endforeach
                    <div class="table table-responsive">
                        <table class="table custom-table">
                            @if (count($cmots) > 0)
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Film Craft</th>
                                        <th>Lavel 1 </th>
                                        <th>Level 2 </th>
                                        <th>Final Score</th>
                                        <th>Asign To Level1</th>
                                        <th>Asign To Level2</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cmots as $key => $cmot)
                                        <tr>
                                            <td> {{ $cmot->id }} </td>
                                            <td> {{ $cmot->name }} </td>
                                            <td> {{ $cmot->age($cmot->dob) }} </td>
                                            <td> {{ $cmot->gender }} </td>
                                            <td> {{ $cmot->category->name ?? '' }} </td>
                                            @php
                                                $level1 = [];
                                                $level2 = [];
                                                $level1FinalScore = null;
                                                $level2FinalScore = null;
                                            @endphp
                                            @foreach ($cmot->cmotJuryAssign as $value)
                                                @php
                                                    $authUser = App\Models\User::find($value['user_id']);
                                                    $roleName = Spatie\Permission\Models\Role::select('name')
                                                        ->where('id', $authUser['role_id'])
                                                        ->first();
                                                @endphp

                                                @if ($roleName['name'] === 'JURY')
                                                    @php
                                                        $level1[] = $value;
                                                    @endphp
                                                @elseif ($roleName['name'] === 'GRANDJURY')
                                                    @php
                                                        $level2[] = $value;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            <td>
                                                <ul>
                                                    @if (!empty($level1))
                                                        @foreach ($level1 as $val)
                                                            @if (isset($val['overall_score']) && !empty($val['overall_score']))
                                                                <li>Overall Score :- {{ $val['overall_score'] }}</li>
                                                            @endif
                                                            @if (isset($val['total_score']) && !empty($val['total_score']))
                                                                <li>Total Score :- {{ $val['total_score'] }}</li>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </td>

                                            <td>
                                                <ul>
                                                    @if (!empty($level2))
                                                        @foreach ($level2 as $val)
                                                            @if (isset($val['overall_score']) && !empty($val['overall_score']))
                                                                <li>Overall Score :- {{ $val['overall_score'] }}</li>
                                                            @endif
                                                            @if (isset($val['total_score']) && !empty($val['total_score']))
                                                                <li>Total Score :- {{ $val['total_score'] }}</li>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </td>

                                            <td>
                                                <ul>
                                                    @if (!empty($level1))
                                                        @foreach ($level1 as $val)
                                                            @if (isset($val['total_score']) && !empty($val['total_score']))
                                                                <li>Level 1 Score :- {{ $val['total_score'] }} </li>
                                                            @endif
                                                            @php
                                                                $level1FinalScore = $val['total_score'];
                                                            @endphp
                                                        @endforeach
                                                    @endif
                                                    @if (!empty($level2))
                                                        @foreach ($level2 as $val)
                                                            @if (isset($val['total_score']) && !empty($val['total_score']))
                                                                <li>Level 2 Score :- {{ $val['total_score'] }} </li>
                                                            @endif
                                                            @php
                                                                $level2FinalScore = $val['total_score'];
                                                            @endphp
                                                        @endforeach
                                                    @endif

                                                    @if (isset($level1FinalScore))
                                                        <li>Weightage of level 1 :-
                                                            {{ $cmot->weightageLevel1($level1FinalScore) }}
                                                        </li>
                                                    @endif
                                                    @if (isset($level2FinalScore))
                                                        <li>Weightage of level 2 :-
                                                            {{ $cmot->weightageLevel2($level2FinalScore) }}
                                                        </li>
                                                    @endif
                                                    @if (isset($level1FinalScore) && isset($level2FinalScore))
                                                        <li><strong><b>Final Score :-</b></strong>
                                                            {{ $cmot->calculateScore($level1FinalScore, $level2FinalScore) }}
                                                        </li>
                                                    @endif
                                                </ul>
                                            </td>

                                            <td>
                                                @if ($cmot->stage === '0' || $cmot->stage === null)
                                                    @php
                                                        $juryRole = Spatie\Permission\Models\Role::where(
                                                            'name',
                                                            'jury',
                                                        )->first();
                                                        $users = App\Models\User::whereHas('roles', function (
                                                            $query,
                                                        ) use ($juryRole) {
                                                            $query->where('id', $juryRole->id);
                                                        })
                                                            ->where(['cmot_category_id' => $cmot->category_id])
                                                            ->get();
                                                    @endphp
                                                    <form action="{{ url('assign_to', $cmot->id) }}" method="POST">
                                                        @csrf @method('POST')
                                                        <select name="user_id" id="user_id"
                                                            class="form-select @error('user_id') is-invalid @enderror">
                                                            <option value="" selected>Select Jury</option>
                                                            @forelse ($users as $user)
                                                                <option value="{{ $user->id }}"
                                                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                                    {{ $user->name }}</option>
                                                                </option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                        @error('user_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <button type="submit" id="submitButton"
                                                            class="btn btn-sm btn-info">Assign Level1</button>
                                                    </form>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($cmot->stage === '2')
                                                    @php
                                                        $grandJuryRole = Spatie\Permission\Models\Role::where(
                                                            'name',
                                                            'GRANDJURY',
                                                        )->first();

                                                        $users = App\Models\User::whereHas('roles', function (
                                                            $query,
                                                        ) use ($grandJuryRole) {
                                                            $query->where('id', $grandJuryRole->id);
                                                        })
                                                            ->where(['cmot_category_id' => $cmot->category_id])
                                                            ->get();
                                                    @endphp
                                                    <form action="{{ url('assign_to', $cmot->id) }}" method="POST">
                                                        @csrf @method('POST')
                                                        <select name="user_id" id="user_id"
                                                            class="form-select @error('user_id') is-invalid @enderror">
                                                            <option value="" selected>Select Jury</option>
                                                            @forelse ($users as $user)
                                                                <option value="{{ $user->id }}"
                                                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                                    {{ $user->name }}</option>
                                                                </option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                        @error('user_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <button type="submit" id="submitButton"
                                                            class="btn btn-sm btn-info">Assign Level 2</button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ route('cmots.show', $cmot->id) }}">Preview</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            @else
                                <p>No record found...!!</p>
                            @endif
                        </table>
                    </div>
                    <!-- Pagination -->
                    <nav aria-label="...">
                        <ul class="pagination">
                            {{ $cmots->withQueryString()->links() }}
                        </ul>
                    </nav>
                    <!-- Pagination End-->
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
