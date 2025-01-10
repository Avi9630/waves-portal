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

                            {{-- <div class="mb-3 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->name }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end text-start"><strong>DOB:</strong></label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->age($cmot->dob) }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end text-start"><strong>Gender:</strong></label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->gender }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end text-start"><strong>Contact-Number:</strong></label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->contact_number }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end text-start"><strong>Email:</strong></label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->email }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end text-start"><strong>Bio:</strong></label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->bio }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Reason
                                        To Join:</strong></label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->reason_to_join }}
                                </div>
                            </div> --}}

                            {{-- <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Client Name:</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->client_id }}
                                </div>
                            </div> --}}

                            {{-- <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Name:</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->name }}
                                </div>
                            </div> --}}

                            {{-- <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Dob:</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->dob }}
                                </div>
                            </div> --}}

                            {{-- <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Gender:</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->gender }}
                                </div>
                            </div> --}}

                            {{-- <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Contact Number:</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->contact_number }}
                                </div>
                            </div> --}}

                            {{-- <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Email:</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->email }}
                                </div>
                            </div> --}}

                            {{-- <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Bio:</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->bio }}
                                </div>
                            </div> --}}

                            {{-- <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Reason To Join :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->reason_to_join }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Alternate Number :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->alternate_number }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Website Link :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->website_link }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Twitter Account Link :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->twitter_account_link }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Instagram Account Link :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->instagram_account_link }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Facebook Account Link :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->facebook_account_link }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Linkedin Account Link :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->linkedin_account_link }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>How You Find :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->how_you_find }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Permanent Address :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->permanent_address }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Permanent City :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->permanent_city }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Permanent State :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->permanent_state }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Permanent Country ID :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->permanent_country_id }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Address Confirmation :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->address_confirmation }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Residence Address :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->residence_address }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Residence City :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->residence_city }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Residence State :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->residence_state }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Residence Country Id :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->residence_country_id }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>First Govt Id Number :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->first_govt_id_number }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Second Govt Id Number :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->second_govt_id_number }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Category Id :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->category_id }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Link Of Film :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->link_of_film }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Link Film Password :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->link_film_password }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Project Title :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->project_title }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Film Duration:</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->film_duration }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Awards Recognition :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->awards_recognition }}
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                    <strong>Filmography Url :</strong>
                                </label>
                                <div class="col-md-6" style="line-height: 35px;">
                                    {{ $cmot->filmography_url }}
                                </div>
                            </div> --}}
                            {{-- url('review_by_jury', $cmot->id) --}}

                            <form id="reviewForm" action="{{ url('review_by_grand_jury', $cmot->id) }}" method="POST">
                                @csrf @method('POST')

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                        <strong> Score1:-</strong>
                                    </label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        <input type="text" name="score1" id="score1"
                                            class="form-control @error('score1') is-invalid @enderror"
                                            value="{{ old('score1') }}" placeholder="Please give your score" />
                                        @error('score1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start">
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

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start">
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

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start">
                                        <strong> Score4:-</strong>
                                    </label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        <input type="text" name="score4" id="score4"
                                            class="form-control @error('score4') is-invalid @enderror"
                                            value="{{ old('score4') }}" placeholder="Please give your score" />
                                        @error('score4')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-end text-start"><strong>Feedbak:</strong></label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        <input type="text" name="feedback" value="{{ old('feedback') }}"
                                            class="form-control @error('feedback') is-invalid @enderror"
                                            placeholder="Feedback" />
                                        @error('feedback')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="totalScore" class="col-md-4 col-form-label text-md-end text-start">
                                        <strong>Total Score:</strong>
                                    </label>
                                    <div class="col-md-6" style="line-height: 35px;">
                                        <input type="text" id="totalScore" name="totalScore"
                                            value="{{ old('totalScore') }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-sm btn-info" onclick="confirmSubmission()">
                                        Submit </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmSubmission() {
            const form = document.getElementById('reviewForm');
            const confirmed = confirm(
                "Are you sure you want to submit the form?. After submitted you will not score again.!");
            // if (confirmed) {
            //     form.submit();
            // }
        }
    </script>
    <script>
        $(document).ready(function() {
            function calculateTotalScore() {
                var score1 = parseFloat($('#score1').val()) || 0;
                var score2 = parseFloat($('#score2').val()) || 0;
                var score3 = parseFloat($('#score3').val()) || 0;
                var score4 = parseFloat($('#score4').val()) || 0;
                var totalScore = score1 + score2 + score3 + score4;
                $('#totalScore').val(totalScore);
            }
            $('#score1, #score2, #score3, #score4').on('input', calculateTotalScore);
        });
    </script>
@endsection
