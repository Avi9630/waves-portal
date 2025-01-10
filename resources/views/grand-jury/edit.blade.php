@extends('layouts.app')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            @foreach (['success', 'info', 'danger', 'warning'] as $msg)
                @if (Session::has($msg))
                    <div id="flash-message" class="alert alert-{{ $msg }}" role="alert">
                        {{ Session::get($msg) }}
                    </div>
                @endif
            @endforeach
        </div>

        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Create New Role</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-warning" href="{{ route('users.index') }}"> Back</a><br><br>
                </div>
            </div>
        </div>

        <section class="section">

            <div class="row">

                <div class="col-lg-12">

                    <div class="card">

                        <div class="card-body">

                            <h5 class="card-title">User Update</h5>
                            <form action="{{ route('users.update', $user->id) }}" method="POST" class="row g-3"> @csrf
                                @method('PUT')

                                <div class="row gy-4">

                                    <div class="col-md-6 form-group">
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" placeholder="Full Name"
                                            value="{{ $user->name }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 ">
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                            value="{{ $user->email }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="mobile"
                                            class="form-control @error('mobile') is-invalid @enderror"
                                            value="{{ $user->mobile }}" placeholder="Mobile">
                                        @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <select name="role_id" id="role_id"
                                            class="form-control @error('role_id') is-invalid @enderror">
                                            <option value="" selected>Select Role</option>
                                            @forelse ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ $role->id == $user['role_id'] ? 'selected' : '' }}>
                                                    {{ $role->name }}</option>

                                                </option>
                                            @empty
                                            @endforelse

                                        </select>
                                        @error('usertype')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <input type="password" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="Confirm Password">
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>

                </div>

            </div>

        </section>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <script>
            $(document).ready(function() {

                $('#state_id').on('change', function() {
                    var options = '';
                    var state_id = this.value;
                    $("#city_id").html('');
                    $.ajax({
                        url: "{{ url('api/all_cities') }}",
                        type: "POST",
                        data: {
                            state_id: state_id,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            options = '<option value="">-- Select City --</option>';
                            $.each(result.data, function(key, value) {
                                options += `<option value="` + value.id + `">` + value
                                    .city_name + `</option>`;
                            });
                            $('#city_id').html(options);
                        }
                    });
                });

                // $('#state-dropdown').on('change', function () {
                //     var idState = this.value;
                //     $("#city-dropdown").html('');
                //     $.ajax({
                //         url: "{{ url('api/fetch-cities') }}",
                //         type: "POST",
                //         data: {
                //             state_id: idState,
                //             _token: '{{ csrf_token() }}'
                //         },
                //         dataType: 'json',
                //         success: function (res) {
                //             $('#city-dropdown').html('<option value="">-- Select City --</option>');
                //             $.each(res.cities, function (key, value) {
                //                 $("#city-dropdown").append('<option value="' + value
                //                     .id + '">' + value.name + '</option>');
                //             });
                //         }
                //     });
                // });

            });
        </script>

    </main>
@endsection
