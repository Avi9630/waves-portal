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
                                <a href="{{ route('cmots.index') }}" class="btn btn-sm btn-warning">&larr; Back</a>
                            </div>
                            <h4 class="card-title">Review</h4>
                        </div>

                        <div class="card-body">
                            {{-- Score form  start --}}
                            <form id="reviewForm" action="{{ url('review_by', $cmot->id) }}" method="POST">
                                @csrf @method('POST')
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">

                                            {{-- <div class="col-md-6">
                                                <div class="mb-3 row">
                                                    <label for="name"
                                                        class="col-md-4 col-form-label text-md-end text-start">
                                                        <strong> Score1:-</strong>
                                                    </label>
                                                    <div class="col-md-6" style="line-height: 35px;">
                                                        <input type="text" name="score1" id="score1"
                                                            class="form-control @error('score1') is-invalid @enderror"
                                                            value="{{ old('score1') }}"
                                                            placeholder="Please give your score" />
                                                        @error('score1')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3 row">
                                                    <label for="name"
                                                        class="col-md-4 col-form-label text-md-end text-start">
                                                        <strong> Score2:-</strong>
                                                    </label>
                                                    <div class="col-md-6" style="line-height: 35px;">
                                                        <input type="text" name="score2" id="score2"
                                                            value="{{ old('score2') }}"class="form-control @error('score2') is-invalid @enderror"
                                                            placeholder="Please give your score" />
                                                        @error('score2')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3 row">
                                                    <label for="name"
                                                        class="col-md-4 col-form-label text-md-end text-start">
                                                        <strong> Score3:-</strong>
                                                    </label>
                                                    <div class="col-md-6" style="line-height: 35px;">
                                                        <input type="text" name="score3" id="score3"
                                                            value="{{ old('score3') }}"class="form-control @error('score3') is-invalid @enderror"
                                                            placeholder="Please give your score" />
                                                        @error('score3')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="col-md-6">
                                                <div class="mb-3 row">
                                                    <label for="name"
                                                        class="col-md-4 col-form-label text-md-end text-start">
                                                        <strong>Overall Score:-</strong>
                                                    </label>
                                                    <div class="col-md-6" style="line-height: 35px;">
                                                        <input type="text" name="overall_score" id="overall_score"
                                                            class="form-control @error('overall_score') is-invalid @enderror"
                                                            value="{{ old('overall_score') }}"
                                                            placeholder="Score should be 1 to 10 only" />
                                                        <span><strong>1</strong> (lowest), <strong>10</strong>
                                                            (Highest)</span>
                                                        @error('overall_score')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3 row">
                                                    <label for="name"
                                                        class="col-md-4 col-form-label text-md-end text-start"><strong>Feedback:</strong></label>
                                                    <div class="col-md-6" style="line-height: 35px;">
                                                        <input type="text" name="feedback" id="feedback"
                                                            value="{{ old('feedback') }}"
                                                            class="form-control @error('feedback') is-invalid @enderror"
                                                            placeholder="Feedback" />
                                                        @error('feedback')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-6">
                                                <div class="mb-3 row">
                                                    <label for="totalScore"
                                                        class="col-md-4 col-form-label text-md-end text-start">
                                                        <strong>Total Score:</strong>
                                                    </label>
                                                    <div class="col-md-6" style="line-height: 35px;">
                                                        <input type="text" id="totalScore" name="totalScore"
                                                            value="{{ old('totalScore') }}" class="form-control" readonly />
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-sm btn-info"
                                                    id="submitBtn">Submit</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                            {{-- Score form  end --}}
                            <br>
                            <h2 class="text-center">Client Details</h2>
                            <div class="card">
                                <div class="card-body">
                                    {{-- <div class="heading text-center mb-2"><strong>Personal Details</strong></div> --}}
                                    <div class="row pt-2">

                                        <div class="col-md-4">
                                            <p><strong>Full Name : </strong> {{ $cmot->name ?? 'None' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Age : </strong> {{ $cmot->age($cmot->dob) ?? 'None' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Gender : </strong> {{ $cmot->gender ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Highest Qualification : </strong>
                                                {{ $cmot->highest_qualification_id ?? '' }} </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Name of Degree : </strong> {{ $cmot->degree ?? '' }} </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Year of Passing : </strong>{{ $cmot->year_of_degree ?? '' }} </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>State/ UT of origin : </strong> {{ $cmot->residence_state ?? '' }}
                                            </p>
                                        </div>

                                        <div class="col-md-12 m-2">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-4 p-0">
                                                        <p> <strong>Applicant Brief Bio : </strong> </p>
                                                    </div>
                                                    <div class="col-md-8 p-0">
                                                        <div class="container">
                                                            <p class="text-justify">
                                                                @if (isset($cmot->bio))
                                                                    @php
                                                                        $wrappedText = Str::limit($cmot->bio, 100);
                                                                    @endphp
                                                                    {!! $wrappedText !!}
                                                                    @if (strlen($cmot->bio) > 100)
                                                                        <span id="moreText"
                                                                            style="display:none;">{!! $cmot->bio !!}</span>
                                                                        <a href="javascript:void(0);" id="readMoreBtn"
                                                                            onclick="toggleText()">Read More</a>
                                                                    @endif
                                                                @else
                                                                    {{ $cmot->bio ?? '' }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4 p-0">
                                                    <p> <strong>Why do you want <br> to participate in <br> the program :-
                                                        </strong>
                                                    </p>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="container">
                                                        <p class="text-justify">
                                                            @if (isset($cmot->reason_to_join))
                                                                @php
                                                                    $wrappedText = Str::limit(
                                                                        $cmot->reason_to_join,
                                                                        100,
                                                                    );
                                                                @endphp
                                                                {!! $wrappedText !!}
                                                                @if (strlen($cmot->reason_to_join) > 100)
                                                                    <span id="moreText1"
                                                                        style="display:none;">{!! $cmot->reason_to_join !!}</span>
                                                                    <a href="javascript:void(0);" id="readMoreBtn"
                                                                        onclick="toggleText1()">Read More</a>
                                                                @endif
                                                            @else
                                                                {{ $cmot->reason_to_join ?? '' }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4 p-0">
                                                    <p> <strong>Describe a time <br> when you helped <br> your team succeed
                                                            <br> while also building <br> relationships with <br> new people
                                                            :-
                                                        </strong>
                                                    </p>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="container">
                                                        <p class="text-justify">
                                                            @if (isset($cmot->bio2))
                                                                @php
                                                                    $wrappedText = Str::limit($cmot->bio2, 100);
                                                                @endphp
                                                                {!! $wrappedText !!}
                                                                @if (strlen($cmot->bio2) > 100)
                                                                    <span id="moreText2"
                                                                        style="display:none;">{!! $cmot->bio2 !!}</span>
                                                                    <a href="javascript:void(0);" id="readMoreBtn"
                                                                        onclick="toggleText2()">Read More</a>
                                                                @endif
                                                            @else
                                                                {{ $cmot->bio2 ?? '' }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="col-md-12 m-2">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-4 p-0">
                                                        <p> <strong>Why do you want <br> to participate in <br> the program
                                                                :-
                                                            </strong>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-8 p-0">
                                                        <div class="container">
                                                            <p class="text-justify">
                                                                @if (isset($cmot->reason_to_join))
                                                                    @php
                                                                        $wrappedText = Str::limit(
                                                                            $cmot->reason_to_join,
                                                                            100,
                                                                        );
                                                                    @endphp
                                                                    {!! $wrappedText !!}
                                                                    @if (strlen($cmot->reason_to_join) > 100)
                                                                        <span id="moreText1"
                                                                            style="display:none;">{!! $cmot->reason_to_join !!}</span>
                                                                        <a href="javascript:void(0);" id="readMoreBtn"
                                                                            onclick="toggleText1()">Read More</a>
                                                                    @endif
                                                                @else
                                                                    {{ $cmot->reason_to_join ?? '' }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 m-2">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-4 p-0">
                                                        <p> <strong>Describe a time <br> when you helped <br> your team
                                                                succeed
                                                                <br> while also building <br> relationships with <br> new
                                                                people
                                                                :-
                                                            </strong>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-8 p-0">
                                                        <div class="container">
                                                            <p class="text-justify">
                                                                @if (isset($cmot->bio2))
                                                                    @php
                                                                        $wrappedText = Str::limit($cmot->bio2, 100);
                                                                    @endphp
                                                                    {!! $wrappedText !!}
                                                                    @if (strlen($cmot->bio2) > 100)
                                                                        <span id="moreText2"
                                                                            style="display:none;">{!! $cmot->bio2 !!}</span>
                                                                        <a href="javascript:void(0);" id="readMoreBtn"
                                                                            onclick="toggleText2()">Read More</a>
                                                                    @endif
                                                                @else
                                                                    {{ $cmot->bio2 ?? '' }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>How do you rate <br> yourself as a team player :
                                                </strong>{{ $cmot->scale ?? '' }} </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Film Craft : </strong>{{ $cmot->category->name ?? 'None' }} </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Specialisation : </strong>{{ $cmot->specialization ?? '' }} </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Link to submission :
                                                    <a href="{{ $cmot->link_of_film ?? '' }}">
                                                </strong>{{ $cmot->link_of_film ?? '' }}</a>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Password of link :
                                                </strong>{{ $cmot->link_film_password ?? '' }}
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Project Title : </strong>{{ $cmot->project_title ?? '' }}
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Duration : </strong>{{ $cmot->film_duration ?? '' }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Project Completion Date :
                                                </strong>{{ $cmot->project_completion_date ?? '' }}
                                            </p>
                                        </div>

                                        @php
                                            // $getCv = $cmot->getCv($cmot->id)['file'];
                                            $getCv = $cmot->getCv($cmot->id);
                                            // dd($getCv);
                                        @endphp

                                        <div class="col-md-4">
                                            <p><strong>CV : </strong>
                                                @if (isset($getCv) && !empty($getCv) && $getCv != '')
                                                    <a href="{{ env('NFDC_DEVELOPMENT_URL') . $cmot->id . '/' . $getCv['file'] }}"
                                                        target="_blank"> {{ $getCv['file'] }}
                                                    </a>
                                                @else
                                                    <p>No image available</p>
                                                @endif
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <p><strong>Filmography : </strong>
                                                {{-- <a href="{{ $cmot->filmography_url }}" target="_blank">URL</a> --}}
                                                @if (str_starts_with($cmot->filmography_url, 'http://') || str_starts_with($cmot->filmography_url, 'https://'))
                                                    <a href="{{ $cmot->filmography_url ?? '' }}"
                                                        target="_blank">{{ $cmot->filmography_url ?? '' }}
                                                    </a>
                                                @else
                                                    <a href="http://{{ $cmot->filmography_url ?? '' }}"
                                                        target="_blank">{{ $cmot->filmography_url ?? '' }}
                                                    </a>
                                                @endif
                                            </p>
                                        </div>

                                        @php
                                            // $getReel = $cmot->getReel($cmot->id)['file'];
                                            $getReel = $cmot->getReel($cmot->id);
                                        @endphp

                                        <div class="col-md-4">
                                            <p>
                                                <strong>Showreel : </strong>
                                                @if (isset($getReel) && !empty($getReel) && $getReel != '')
                                                    <a href="{{ env('NFDC_DEVELOPMENT_URL') . $cmot->id . '/' . $getReel['file'] }}"
                                                        target="_blank"> {{ $getReel['file'] }}
                                                    </a>
                                                @else
                                                    <p>No reel available</p>
                                                @endif
                                            </p>
                                        </div>

                                        <div class="col-md-8">
                                            <p><strong> Awards/Recognition :
                                                </strong>
                                                @if (isset($cmot->awards_recognition))
                                                    @php
                                                        $wrappedText = Str::limit($cmot->awards_recognition, 100);
                                                    @endphp
                                                    {!! $wrappedText !!}
                                                    @if (strlen($cmot->awards_recognition) > 100)
                                                        <span id="moreText3"
                                                            style="display:none;">{!! $cmot->awards_recognition !!}</span>
                                                        <a href="javascript:void(0);" id="readMoreBtn"
                                                            onclick="toggleText3()">Read More</a>
                                                    @endif
                                                @else
                                                    {{ $cmot->awards_recognition ?? '' }}
                                                @endif
                                            </p>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.getElementById('reviewForm').addEventListener('submit', function(event) {
                    event.preventDefault();
                    // const score1 = document.getElementById('score1').value;
                    // const score2 = document.getElementById('score2').value;
                    // const score3 = document.getElementById('score3').value;
                    const overall_score = document.getElementById('overall_score').value;
                    const feedback = document.getElementById('feedback').value;

                    // if (score1 === '' || !/^\d+$/.test(score1) || parseInt(score1, 10) > 10) {
                    //     alert(score1 === '' ? 'Score1 cannot be empty.' :
                    //         !/^\d+$/.test(score1) ? 'Score1 must contain only numbers.' :
                    //         'Score1 must be 10 or less.');
                    //     return;
                    // }

                    // if (score2 === '' || !/^\d+$/.test(score2) || parseInt(score2, 10) > 10) {
                    //     alert(score2 === '' ? 'Score2 cannot be empty.' :
                    //         !/^\d+$/.test(score2) ? 'Score2 must contain only numbers.' :
                    //         'Score2 must be 10 or less.');
                    //     return;
                    // }

                    // if (score3 === '' || !/^\d+$/.test(score3) || parseInt(score3, 10) > 10) {
                    //     alert(score3 === '' ? 'Score3 cannot be empty.' :
                    //         !/^\d+$/.test(score3) ? 'score3 must contain only numbers.' :
                    //         'Score3 must be 10 or less.');
                    //     return;
                    // }

                    if (overall_score === '' || !/^\d+$/.test(overall_score) || parseInt(overall_score, 10) > 10) {
                        alert(overall_score === '' ? 'Overall score cannot be empty.' :
                            !/^\d+$/.test(overall_score) ? 'Overall score must contain only numbers.' :
                            'Overall score must be 10 or less.');
                        return;
                    }

                    if (feedback === '') {
                        alert('Feedback cannot be empty');
                        return;
                    }

                    // Check word count in feedback
                    const wordCount = feedback.trim().split(/\s+/).filter(function(word) {
                        return word.length > 0;
                    }).length;

                    if (wordCount > 200) {
                        alert('Feedback must contain less than 200 words.');
                        return;
                    }

                    const confirmed = confirm(
                        "Are you sure you want to submit the form? After submitting, you will not score again!");
                    if (confirmed) {
                        this.submit();
                    }
                });
            </script>

            <script>
                $(document).ready(function() {
                    function calculateTotalScore() {
                        // var score1 = parseFloat($('#score1').val()) || 0;
                        // var score2 = parseFloat($('#score2').val()) || 0;
                        // var score3 = parseFloat($('#score3').val()) || 0;
                        var overall_score = parseFloat($('#overall_score').val()) || 0;
                        // var totalScore = score1 + score2 + score3 + score4;
                        var totalScore = overall_score;
                        $('#totalScore').val(totalScore);
                    }
                    // $('#score1, #score2, #score3, #score4').on('input', calculateTotalScore);
                    $('#overall_score').on('input', calculateTotalScore);
                });
            </script>

            <script>
                function toggleText() {
                    var moreText = document.getElementById("moreText");
                    if (moreText.style.display === "none") {
                        moreText.style.display = "inline";
                    } else {
                        moreText.style.display = "none";
                    }
                }

                function toggleText1() {
                    var moreText1 = document.getElementById("moreText1");
                    if (moreText1.style.display === "none") {
                        moreText1.style.display = "inline";
                    } else {
                        moreText1.style.display = "none";
                    }
                }

                function toggleText2() {
                    var moreText2 = document.getElementById("moreText2");
                    if (moreText2.style.display === "none") {
                        moreText2.style.display = "inline";
                    } else {
                        moreText2.style.display = "none";
                    }
                }

                function toggleText3() {
                    var moreText3 = document.getElementById("moreText3");
                    if (moreText3.style.display === "none") {
                        moreText3.style.display = "inline";
                    } else {
                        moreText3.style.display = "none";
                    }
                }
            </script>
        @endsection
