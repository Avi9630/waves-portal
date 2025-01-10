@extends('layouts.app')
@section('content')
    <div class="container-fluid page-body-wrapper">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 stretch-card">
                    <div class="card">

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
                        <div class="card-header">
                            <h4 class="card-title">Assigned CMOT
                                {{ isset($totalAssignedCmot) ? '(Total assigned :-' . $totalAssignedCmot . ')' : '' }}
                            </h4>
                        </div>
                        <div class="card-body overflow-auto">
                            <table class="table table-bordered">
                                @if (count($cmots) > 0)
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Action</th>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Final Score</th>
                                            <th>Feedback</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($cmots as $key => $cmot)
                                            <tr>
                                                <th> {{ $cmot->id }} </th>
                                                <td>
                                                    @php
                                                        $authUser = Auth::user();
                                                        $roleName = Spatie\Permission\Models\Role::select('name')
                                                            ->where('id', $authUser['role_id'])
                                                            ->first();
                                                    @endphp
                                                    @foreach ($cmot->cmotJuryAssign->where('user_id', $authUser->id) as $value)
                                                        @if ($value['active'] === 1)
                                                            <a href="{{ url('review_by', $cmot->id) }}"
                                                                class="btn btn-sm btn-primary">Review</a>
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td> {{ $cmot->name ?? 'None' }} </td>
                                                <td> {{ $cmot->age($cmot->dob) ?? 'None' }} </td>
                                                <td> {{ $cmot->gender ?? '' }} </td>

                                                @php
                                                    $finalScore = App\Models\AssignToJury::select(
                                                        'total_score',
                                                        'feedback',
                                                    )
                                                        ->where([
                                                            'cmot_id' => $cmot->id,
                                                            'user_id' => Auth::user()->id,
                                                        ])
                                                        ->first();
                                                    // ->toSql();
                                                @endphp
                                                <td> {{ $finalScore['total_score'] }} </td>
                                                <td> {{ $finalScore['feedback'] }} </td>
                                            </tr>

                                        @empty
                                            <td colspan="3">
                                                <span class="text-danger">
                                                    <strong>No Ip Application form submitted.!</strong>
                                                </span>
                                            </td>
                                        @endforelse
                                    </tbody>
                                @else
                                    <p>No record found...!!</p>
                                @endif
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{-- {{ $cmots->withQueryString()->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
