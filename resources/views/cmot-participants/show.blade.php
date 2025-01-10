@extends('layouts.app')
@section('content')
    <div class="container-fluid page-body-wrapper">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 stretch-card">
                    <div class="card">

                        @foreach (['success', 'info', 'danger', 'warning'] as $msg)
                            @if (Session::has($msg))
                                <div id="flash-message" class="alert alert-{{ $msg }}" role="alert">
                                    {{ Session::get($msg) }}
                                </div>
                            @endif
                        @endforeach

                        <div class="card-header">
                            <div class="float-end">
                                <a href="{{ route('cmot-participants.index') }}" class="btn btn-sm btn-warning">&larr;
                                    Back</a>
                            </div>
                            <h4 class="card-title">Preview</h4>
                        </div>

                        <div class="card-body">
                            <br>

                            <div class="card">
                                <div class="card-body">
                                    <div class="row pt-2">

                                        <div class="col-md-4">
                                            <p><strong>Full Name : </strong> {{ $cmotParticipant->full_name ?? '' }}</p>
                                        </div>

                                        @if (Auth::check() && !Auth::user()->hasRole('RECRUITER'))
                                            <div class="col-md-4">
                                                <p><strong>Email : </strong> {{ $cmotParticipant->email ?? '' }}</p>
                                            </div>

                                            <div class="col-md-4">
                                                <p><strong>Mobile : </strong> {{ $cmotParticipant->mobile ?? '' }}</p>
                                            </div>
                                        @endif

                                        <div class="col-md-4">
                                            <p><strong>Age : </strong> {{ $cmotParticipant->age ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Gender : </strong> {{ $cmotParticipant->gender ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Film Craft : </strong> {{ $cmotParticipant->category->name ?? '' }}
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Current Designation : </strong>
                                                {{ $cmotParticipant->current_designation ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Edition : </strong> {{ $cmotParticipant->cmot_edition ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Resume : </strong>
                                                <a href="{{ $cmotParticipant->resume ?? '' }}"
                                                    target="_blank">{{ $cmotParticipant->resume ?? '' }}
                                                </a>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Showreel : </strong>
                                                <a href="{{ $cmotParticipant->works ?? '' }}"
                                                    target="_blank">{{ $cmotParticipant->works ?? '' }}
                                                </a>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="d-flex" style="margin-left:400px; margin-top: 15px;">
                                @if (Auth::check() && Auth::user()->hasRole('RECRUITER'))
                                    <a href="{{ route('cmot-participant.select', $cmotParticipant->id) }}"
                                        class="btn btn-sm btn-primary" style="margin-right: 5px;">Select</a>

                                    <a href="{{ route('cmot-participant.reject', $cmotParticipant->id) }}"
                                        class="btn btn-sm btn-primary">Reject</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
