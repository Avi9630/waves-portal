@extends('layouts.app')
@section('content')
    <main id="main" class="main">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header">
                        <div class="float-start"> User Information</div>
                        <div class="float-end">
                            <a href="{{ route('users.index') }}" class="btn btn-warning">&larr; Back</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="mb-3 row">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Email:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Mobile:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->mobile }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Username:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->username }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Role:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->role_id == 1 ? 'SUPERADMIN' : ($user->role_id == 2 ? 'ADMIN' : ($user->role_id == 3 ? 'JURY' : ($user->role_id == 4 ? 'GRAND-JURY' : ($user->role_id == 5 ? 'OTHERS' : 'Not Define')))) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
