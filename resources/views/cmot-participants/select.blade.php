@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="row">

            {{-- Table Section --}}
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">SELECTED CMOT PARTICIPANTS</h4>
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
                                @if (count($cmotParticipants) > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr.Nom</th>
                                            <th scope="col">Full Name</th>
                                            @if (Auth::check() && !Auth::user()->hasRole('RECRUITER'))
                                                <th scope="col">Email ID</th>
                                                <th scope="col">Phone Number</th>
                                            @endif
                                            <th scope="col">Age</th>
                                            <th scope="col">Film Craft</th>
                                            <th scope="col">CMOT Edition</th>
                                            <th scope="col" width="280px">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse ($cmotParticipants as $key => $participant)
                                            <tr>
                                                <th> {{ $participant->id }} </th>
                                                <td> {{ $participant->full_name }} </td>

                                                @if (Auth::check() && !Auth::user()->hasRole('RECRUITER'))
                                                    <td> {{ $participant->mobile }} </td>
                                                    <td> {{ $participant->email }} </td>
                                                @endif

                                                <td> {{ $participant->age }} </td>
                                                <td> {{ $participant->category->name ?? '' }} </td>
                                                <td> {{ $participant->cmot_edition }} </td>
                                                <td>
                                                    {{-- @can('view') --}}
                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ route('cmot-participant-selected-undo', $participant->id) }}">Undo</a>
                                                    {{-- @endcan --}}
                                                    @can('delete')
                                                        <form
                                                            action="{{ route('cmot-participants.destroy', $participant->id) }}"
                                                            method="post" style="display: inline"
                                                            onsubmit="return confirmDelete()">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>

                                        @empty
                                            <td colspan="3">
                                                <span class="text-danger">
                                                    <strong>No illuminae Found!</strong>
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
                </div>
            </div>

        </div>
    </div>
@endsection
