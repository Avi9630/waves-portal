@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="row">

            <div class="col-md-12">
                <form method="GET" action="{{ route('cmot-participant-company.search') }}" class="forms-sample"
                    id="myForm">
                    @csrf @method('GET')
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Comany Name</label>
                                <div class="col-md-12 stretch-card">
                                    <input type="text" name="production_house" id="production_house" class="form-control"
                                        placeholder="Please enter company name!"
                                        value="{{ isset($payload['production_house']) ? $payload['production_house'] : '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">CMOT Participant</label>
                                <div class="col-md-12 stretch-card">
                                    <input type="text" name="cmot_participant" id="cmot_participant" class="form-control"
                                        placeholder="Please enter cmot participants details!."
                                        value="{{ isset($payload['cmot_participant']) ? $payload['cmot_participant'] : '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">

                            <div class="form-group">

                                <div class="col-md-12 stretch-card">
                                    <input type="checkbox" name="rejected" value="1" style="width: 20px; height:20px;">
                                    &nbsp;<b>Rejected</b>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex" style="margin-left:1px">
                        <button type="submit" class="btn btn-gradient-primary mr-2"
                            style="margin-right: 20px">Search</button>
                        <a href="{{ route('cmot-participant-interested-By') }}"
                            class="btn btn-gradient-primary mr-2">Reset</a>
                    </div>

                </form>
            </div>

            <div class="col-lg-12 stretch-card mt-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">Company shows interest </h4>
                            <a href="{{ route('cmot-participants.index') }}" class="btn btn-sm btn-warning">&larr; Back</a>
                        </div>
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

                        <div class="w-100 overflow-auto">
                            <table class="table table-bordered">
                                @if (count($cmotparticipants) > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr No.</th>
                                            <th scope="col">Company Name</th>
                                            <th scope="col">Recruiter Name</th>
                                            <th scope="col">Participant Name</th>
                                            <th scope="col">Participant Email</th>
                                            <th scope="col">Participant Phone</th>
                                            <th scope="col">CMOT Edition</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse ($cmotparticipants as $key => $participant)
                                            <tr>
                                                <th> {{ $key + 1 }} </th>
                                                <td> {{ $participant->production_house }} </td>
                                                <td> {{ $participant->user_name }} </td>
                                                <td> {{ $participant->full_name ?? '' }} </td>
                                                <td> {{ $participant->email ?? '' }} </td>
                                                <td> {{ $participant->mobile ?? '' }} </td>
                                                <td> {{ $participant->cmot_edition }} </td>
                                            </tr>
                                        @empty
                                            <td colspan="3">
                                                <span class="text-danger">
                                                    <strong>No CMOT participants found!</strong>
                                                </span>
                                            </td>
                                        @endforelse

                                    </tbody>
                                @else
                                    <p>No record found...!!</p>
                                @endif

                            </table>
                        </div>

                    </div>
                    <div class="d-flex justify-content-center">
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
