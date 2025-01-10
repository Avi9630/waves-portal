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
                            <h4 class="card-title">PREVIEW</h4>
                        </div>

                        <div class="card-body">

                            <h2 class=" permissions">Personal Detail</h2>


                            {{-- text-center --}}
                            <div class="row pt-2">

                                <div class="col-md-4">
                                    <p><strong>Full Name : </strong> {{ $cmot->name ?? '' }}</p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Age : </strong> {{ $cmot->age($cmot->dob) }}</p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Gender : </strong> {{ $cmot->gender }}</p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Email : </strong> {{ $cmot->email ?? '' }}</p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Contact Number : </strong> {{ $cmot->country_code ?? '' }} -
                                        {{ $cmot->contact_number ?? '' }}</p>
                                </div>

                                @php
                                    $getProfile = $cmot->getProfile($cmot->id);
                                    // downloadfile
                                @endphp
                                <div class="col-md-4">
                                    <p><strong>Profile Image : </strong>
                                        @if (!empty($getProfile))
                                            <a href="{{ env('NFDC_DEVELOPMENT_URL') . $cmot->id . '/' . $getProfile['file'] }}"
                                                target="_blank"> {{ $getProfile['file'] }}
                                            </a>
                                        @else
                                            <p><i class="fa fa-file-image-o" aria-hidden="true"></i>
                                            </p>
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Highest Qualification : </strong>
                                        @if ($cmot->highest_qualification_id != 0)
                                            @php
                                                // dd($cmot->highestQualification());
                                            @endphp
                                            {{ isset($cmot->highestQualification()[$cmot->highest_qualification_id]) ? $cmot->highestQualification()[$cmot->highest_qualification_id] : '' }}
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Name of Degree : </strong> {{ $cmot->degree ?? '' }} </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Year of Passing : </strong>{{ $cmot->year_of_degree ?? '' }} </p>
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
                                                                $wrappedText = Str::limit($cmot->reason_to_join, 100);
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
                                    <p>
                                        <strong>Alternate Number : </strong>{{ $cmot->alternate_country_code }} -
                                        {{ $cmot->alternate_number ?? 'None' }}
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p> <strong>Website Link : </strong>
                                        {{-- <a href="{{ $cmot->website_link ?? '' }}"
                                                    target="_blank">{{ $cmot->website_link ?? '' }}
                                                </a> --}}
                                        @if (str_starts_with($cmot->website_link, 'http://') || str_starts_with($cmot->website_link, 'https://'))
                                            <a href="{{ $cmot->website_link ?? '' }}"
                                                target="_blank">{{ $cmot->website_link ?? '' }}
                                            </a>
                                        @else
                                            <a href="http://{{ $cmot->website_link ?? '' }}"
                                                target="_blank">{{ $cmot->website_link ?? '' }}
                                            </a>
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p>
                                        <strong>Twitter : </strong>
                                        @if (str_starts_with($cmot->twitter_account_link, 'http://') || str_starts_with($cmot->twitter_account_link, 'https://'))
                                            <a href="{{ $cmot->twitter_account_link ?? '' }}"
                                                target="_blank">{{ $cmot->twitter_account_link ?? '' }}
                                            </a>
                                        @else
                                            <a href="http://{{ $cmot->twitter_account_link ?? '' }}"
                                                target="_blank">{{ $cmot->twitter_account_link ?? '' }}
                                            </a>
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p>
                                        <strong>Instagram : </strong>
                                        {{-- <a href="{{ $cmot->instagram_account_link ?? '' }}"
                                                    target="_blank">{{ $cmot->instagram_account_link ?? '' }}
                                                </a> --}}
                                        @if (str_starts_with($cmot->instagram_account_link, 'http://') ||
                                                str_starts_with($cmot->instagram_account_link, 'https://'))
                                            <a href="{{ $cmot->instagram_account_link ?? '' }}"
                                                target="_blank">{{ $cmot->instagram_account_link ?? '' }}
                                            </a>
                                        @else
                                            <a href="http://{{ $cmot->instagram_account_link ?? '' }}"
                                                target="_blank">{{ $cmot->instagram_account_link ?? '' }}
                                            </a>
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p>
                                        <strong>Facebook : </strong>
                                        {{-- <a href="{{ $cmot->facebook_account_link ?? 'None' }}"
                                                    target="_blank">{{ $cmot->facebook_account_link ?? 'None' }}
                                                </a> --}}
                                        @if (str_starts_with($cmot->facebook_account_link, 'http://') ||
                                                str_starts_with($cmot->facebook_account_link, 'https://'))
                                            <a href="{{ $cmot->facebook_account_link ?? '' }}"
                                                target="_blank">{{ $cmot->facebook_account_link ?? '' }}
                                            </a>
                                        @else
                                            <a href="http://{{ $cmot->facebook_account_link ?? '' }}"
                                                target="_blank">{{ $cmot->facebook_account_link ?? '' }}
                                            </a>
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p> <strong>Linkedin : </strong>
                                        {{-- <a href="{{ $cmot->linkedin_account_link ?? '' }}"
                                                    target="_blank">{{ $cmot->linkedin_account_link ?? '' }}
                                                </a> --}}
                                        @if (str_starts_with($cmot->linkedin_account_link, 'http://') ||
                                                str_starts_with($cmot->linkedin_account_link, 'https://'))
                                            <a href="{{ $cmot->linkedin_account_link ?? '' }}"
                                                target="_blank">{{ $cmot->linkedin_account_link ?? '' }}
                                            </a>
                                        @else
                                            <a href="http://{{ $cmot->linkedin_account_link ?? '' }}"
                                                target="_blank">{{ $cmot->linkedin_account_link ?? '' }}
                                            </a>
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-6">
                                    <p><strong>How did you find About CMOT:
                                        </strong>{{ $cmot->how_you_find ?? '' }}
                                    </p>
                                </div>


                            </div>


                            <h2 class=" permissions">Addresses and Identifications</h2>



                            <div class="row pt-2">

                                {{-- <p class="text-center"><strong>Permanent Address</strong></p> --}}
                                <div class="col-md-4">
                                    <p><strong>Permanent Address : </strong>{{ $cmot->permanent_address ?? '' }}
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>State/ UT : </strong>
                                        @if (isset($cmot->permanent_state) && !empty($cmot->permanent_state))
                                            @foreach ($states as $state)
                                                @if ($cmot->permanent_state == $state->id)
                                                    {{ $state['name'] }}
                                                @endif
                                            @endforeach
                                        @else
                                            {{ $cmot->permanent_state ?? '' }}
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>City : </strong>
                                        @if (isset($cmot->permanent_city) && !empty($cmot->permanent_city))
                                            @foreach ($cities as $city)
                                                @if ($cmot->permanent_city == $city->id)
                                                    {{ $city['city'] }}
                                                @endif
                                            @endforeach
                                        @else
                                            {{ $cmot->permanent_city ?? '' }}
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-12">
                                    <p><strong>State/ UT of origin : </strong>
                                        @if (isset($cmot->state_of_origin_id) && !empty($cmot->state_of_origin_id))
                                            @foreach ($states as $state)
                                                @if ($cmot->state_of_origin_id == $state->id)
                                                    {{ $state['name'] }}
                                                @endif
                                            @endforeach
                                        @else
                                            {{ $cmot->state_of_origin_id ?? '' }}
                                        @endif
                                        {{-- {{ $cmot->state_of_origin_id ?? '' }} --}}
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Residence Address : </strong>
                                        {{ $cmot->residence_address ?? '' }}
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Residence State/UT : </strong>
                                        @if (isset($cmot->residence_state) && !empty($cmot->residence_state))
                                            @foreach ($states as $state)
                                                @if ($cmot->residence_state == $state->id)
                                                    {{ $state['name'] }}
                                                @endif
                                            @endforeach
                                        @else
                                            {{ $cmot->residence_state ?? '' }}
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Residence City : </strong>
                                        @if (isset($cmot->residence_city) && !empty($cmot->residence_city))
                                            @foreach ($cities as $city)
                                                @if ($cmot->residence_city == $city->id)
                                                    {{ $city['city'] }}
                                                @endif
                                            @endforeach
                                        @else
                                            {{ $cmot->residence_city ?? '' }}
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>First Govt. ID Number : </strong>
                                        {{ $cmot->first_govt_id_number ?? '' }}
                                    </p>
                                </div>

                                @php
                                    $firstGovtProof = $cmot->firstGovtProof($cmot->id);
                                @endphp
                                <div class="col-md-4">
                                    <p>
                                        <strong>First Govt. Id Proof : </strong>
                                        @if (!empty($firstGovtProof))
                                            <a href="{{ env('NFDC_DEVELOPMENT_URL') . $cmot->id . '/' . $firstGovtProof['file'] }}"
                                                target="_blank"> {{ $firstGovtProof['file'] }}
                                            </a>
                                        @else
                                            <p><i class="fa fa-file-image-o" aria-hidden="true"></i>
                                            </p>
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Second Govt. ID Number : </strong>
                                        {{ $cmot->second_govt_id_number ?? '' }}
                                    </p>
                                </div>

                                @php
                                    $secondGovtProof = $cmot->secondGovtProof($cmot->id);
                                @endphp
                                <div class="col-md-4">
                                    <p>
                                        <strong>Second Govt. Id Proof : </strong>
                                        @if (!empty($secondGovtProof))
                                            <a href="{{ env('NFDC_DEVELOPMENT_URL') . $cmot->id . '/' . $secondGovtProof['file'] }}"
                                                target="_blank"> {{ $secondGovtProof['file'] }}
                                            </a>
                                        @else
                                            <p><i class="fa fa-file-image-o" aria-hidden="true"></i>
                                            </p>
                                        @endif
                                    </p>
                                </div>


                            </div>


                            <h2 class=" permissions">Films Details</h2>

                            <div class="row pt-2">

                                <div class="col-md-4">
                                    <p><strong>Film Craft : </strong>{{ $cmot->category->name ?? '' }}
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p>
                                        <strong>Link to Film : </strong>
                                        {{-- <a href="{{ $cmot->link_of_film ?? '' }}">
                                                    {{ $cmot->link_of_film ?? '' }}
                                                </a> --}}
                                        @if (str_starts_with($cmot->link_of_film, 'http://') || str_starts_with($cmot->link_of_film, 'https://'))
                                            <a href="{{ $cmot->link_of_film ?? '' }}"
                                                target="_blank">{{ $cmot->link_of_film ?? '' }}
                                            </a>
                                        @else
                                            <a href="https://{{ $cmot->link_of_film ?? '' }}"
                                                target="_blank">{{ $cmot->link_of_film ?? '' }}
                                            </a>
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Link film password :
                                        </strong>{{ $cmot->link_film_password ?? 'None' }}
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Project Title : </strong>{{ $cmot->project_title ?? 'None' }}
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Duration : </strong>{{ $cmot->film_duration ?? 'None' }}</p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Project Completion Date :
                                        </strong>{{ $cmot->project_completion_date ?? 'None' }}
                                    </p>
                                </div>

                                @php
                                    $getCv = $cmot->getCv($cmot->id);
                                @endphp

                                <div class="col-md-4">
                                    <p><strong>CV : </strong>
                                        @if (!empty($getCv))
                                            <a href="{{ env('NFDC_DEVELOPMENT_URL') . $cmot->id . '/' . $getCv['file'] }}"
                                                target="_blank"> {{ $getCv['file'] }}
                                            </a>
                                        @else
                                            <p><i class="fa fa-file-image-o" aria-hidden="true"></i>
                                            </p>
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Filmography : </strong>
                                        {{-- <a href="{{ $cmot->filmography_url ?? '' }}"
                                                    target="_blank">{{ $cmot->filmography_url ?? '' }}</a> --}}
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
                                    $getReel = $cmot->getReel($cmot->id);
                                @endphp

                                <div class="col-md-4">
                                    <p>
                                        <strong>Showreel : </strong>
                                        @if (!empty($getReel))
                                            <a href="{{ env('NFDC_DEVELOPMENT_URL') . $cmot->id . '/' . $getReel['file'] }}"
                                                target="_blank"> {{ $getReel['file'] }}
                                            </a>
                                        @else
                                            <p><i class="fa fa-file-image-o" aria-hidden="true"></i>
                                            </p>
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-12">
                                    <p><strong> Awards/Recognition :
                                        </strong>
                                        @if (isset($cmot->awards_recognition))
                                            @php
                                                $wrappedText = Str::limit($cmot->awards_recognition, 100);
                                            @endphp
                                            {!! $wrappedText !!}
                                            @if (strlen($cmot->awards_recognition) > 100)
                                                <span id="moreText3" style="display:none;">{!! $cmot->awards_recognition !!}</span>
                                                <a href="javascript:void(0);" id="readMoreBtn"
                                                    onclick="toggleText3()">Read More</a>
                                            @endif
                                        @else
                                            {{ $cmot->awards_recognition ?? '' }}
                                        @endif
                                    </p>
                                </div>

                            </div>



                            <h2 class=" permissions">Scores</h2>

                            <div class="row pt-2">

                                @foreach ($scores as $key => $score)
                                    @if (isset($key) && $key === 0)
                                        @if ($score->level === 1)
                                            @php
                                                $overall_score1 = $score->overall_score;
                                                $level1TotalScore = $score->total_score;
                                            @endphp
                                        @else
                                            @php
                                                $overall_score1 = 0;
                                                $level1TotalScore = 0;
                                                $level2TotalScore = 0;
                                            @endphp
                                        @endif
                                    @endif

                                    @if (isset($key) && $key === 1)
                                        @if ($score->level === 2)
                                            @php
                                                $overall_score2 = $score->overall_score;
                                                $level2TotalScore = $score->total_score;
                                            @endphp
                                        @else
                                            @php
                                                $overall_score2 = 0;
                                                $level2TotalScore = 0;
                                            @endphp
                                        @endif
                                    @endif

                                    @php
                                        // $level1TotalScore;
                                        // $level2TotalScore;
                                    @endphp
                                @endforeach

                                <div class="col-md-4">
                                    <p><strong>Level 1 : </strong></p>
                                    <ul>
                                        <li>Overall Score :-
                                            {{ isset($overall_score1) && !empty($overall_score1) ? $overall_score1 : '' }}
                                        </li>

                                        <li>Total Score :-
                                            {{ isset($level1TotalScore) && !empty($level1TotalScore) ? $level1TotalScore : '' }}
                                        </li>
                                        {{-- @if ($score->level === 1)
                                                    <li>Overall Score :-
                                                        {{ !empty($score->overall_score) ? $score->overall_score : '' }}
                                                    </li>

                                                    <li>Total Score :-
                                                        {{ !empty($score->total_score) ? $score->total_score : '' }}
                                                    </li>
                                                @else
                                                    <li>Overall Score :- </li>
                                                    <li>Total Score :- </li>
                                                @endif --}}
                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Level 2 : <strong></p>
                                    <ul>
                                        <li>Overall Score :-
                                            {{ isset($overall_score2) && !empty($overall_score2) ? $overall_score2 : '' }}
                                        </li>

                                        <li>Total Score :-
                                            {{ isset($level2TotalScore) && !empty($level2TotalScore) ? $level2TotalScore : '' }}
                                        </li>

                                        {{-- @if ($score->level === 2)
                                                    <li>Overall Score :-
                                                        {{ !empty($score->overall_score) ? $score->overall_score : '' }}
                                                    </li>

                                                    <li>Total Score :-
                                                        {{ !empty($score->total_score) ? $score->total_score : '' }}
                                                    </li>
                                                @else
                                                    <li>Overall Score :- </li>
                                                    <li>Total Score :- </li>
                                                @endif --}}
                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Final Score :</strong>

                                        {{-- @if ($score->level === 1)
                                                    @php
                                                        $level1TotalScore = $score->total_score;
                                                    @endphp
                                                @else
                                                    @php
                                                        $level1TotalScore = 0;
                                                    @endphp
                                                @endif
                                                --}}
                                        @if ($score->level === 2)
                                            @php
                                                $level2TotalScore = $score->total_score;
                                            @endphp
                                        @else
                                            @php
                                                $level2TotalScore = 0;
                                            @endphp
                                        @endif

                                        @if ((isset($level1TotalScore) && !empty($level1TotalScore)) || (isset($level2TotalScore) && !empty($level2TotalScore)))
                                            {{ $cmot->calculateScore($level1TotalScore, $level2TotalScore) }}
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
