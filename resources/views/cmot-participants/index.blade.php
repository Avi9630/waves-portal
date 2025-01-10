@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="row">

            <div class="col-md-12">
                <form method="GET" action="{{ route('cmot-participant.search') }}" class="forms-sample" id="myForm">
                    @csrf @method('GET')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Film Craft</label>
                                <div class="col-md-12 stretch-card">
                                    <select name="cmot_category_id" class="form-select">
                                        <option value="">Select film craft</option>
                                        @foreach ($categories as $category)
                                            <option name="cmot_category_id" value="{{ $category->id }}"
                                                {{ isset($payload['cmot_category_id']) && $payload['cmot_category_id'] == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">CMOT Edition</label>
                                <div class="col-md-12 stretch-card">
                                    <input type="number" name="cmot_edition_year" id="cmot_edition_year"
                                        class="form-control" placeholder="Please select edition year!."
                                        value="{{ isset($payload['cmot_edition_year']) ? $payload['cmot_edition_year'] : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="name" class="form-label w-100">&nbsp;</label>
                        <button type="submit" class="btn common-btn">SEARCH</button>
                        <a href="{{ route('cmot-participants.index') }}" class="btn common-btn">RESET</a>
                    </div>
                </form>
                {{-- <div class="text-end">
                </div> --}}
            </div>

            {{-- Table Section --}}
            <div class="col-lg-12 stretch-card">
                <div class="card">

                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">2024 CMOT Participants</h4>
                            @if (Auth::check() && !Auth::user()->hasRole('RECRUITER'))
                                <a class="btn btn-sm btn-success" href="{{ route('cmot-participant-interested-By') }}">
                                    Interested By Company
                                </a>
                            @endif
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
                            <table class="table custom-table">
                                @if (count($cmots) > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr.No</th>
                                            <th scope="col">Full Name</th>
                                            @if (Auth::check() && !Auth::user()->hasRole('RECRUITER'))
                                                <th scope="col">Email ID</th>
                                                <th scope="col">Phone Number</th>
                                            @endif
                                            <th scope="col">Age</th>
                                            <th scope="col">Film Craft</th>
                                            <th scope="col">CMOT Edition</th>
                                            {{-- @if (Auth::check() && !Auth::user()->hasRole('RECRUITER')) --}}
                                            <th scope="col" width="280px">Action</th>
                                            {{-- @endif --}}
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($cmots as $key => $cmot)
                                            <tr>
                                                <th> {{ $cmot->id }} </th>
                                                <td> {{ $cmot->full_name }} </td>
                                                @if (Auth::check() && !Auth::user()->hasRole('RECRUITER'))
                                                    <td> {{ $cmot->mobile }} </td>
                                                    <td> {{ $cmot->email }} </td>
                                                @endif
                                                <td> {{ $cmot->age }} </td>
                                                <td> {{ $cmot->category->name ?? '' }} </td>
                                                <td> {{ $cmot->cmot_edition }} </td>

                                                <td class="action-btn">
                                                    <div class="view-edit-delete">

                                                        @can('view')
                                                            <a href="{{ route('cmot-participants.show', $cmot->id) }}">
                                                                <i class="ri-eye-fill black-text"></i>
                                                            </a>
                                                        @endcan

                                                        @can('delete')
                                                            <form action="{{ route('alumnis.destroy', $cmot->id) }}"
                                                                method="post" style="display: inline"
                                                                onsubmit="return confirmDelete()">
                                                                @csrf @method('DELETE')
                                                                <button type="submit " class="deletebtn">
                                                                    <i class="ri-delete-bin-fill "></i>
                                                                </button>
                                                            </form>
                                                        @endcan

                                                        @if (Auth::check() && Auth::user()->hasRole('RECRUITER'))
                                                            @if ($cmot::selected($cmot->id))
                                                                <span class="selected-alumni"
                                                                    style="width: 10px; height: 10px; border-radius: 100%; background-color: green; display: inline-block;"></span>
                                                            @elseif($cmot::rejected($cmot->id))
                                                                <span class="selected-rejected"
                                                                    style="width: 10px; height: 10px; border-radius: 100%; background-color: red; display: inline-block;"></span>
                                                            @else
                                                                <span class="selected-rejected"
                                                                    style="width: 10px; height: 10px; border-radius: 100%; background-color: yellow; display: inline-block;"></span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <td colspan="3">
                                                <span class="text-danger">
                                                    <strong>No CMOT Application form submitted.!</strong>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notInterestedButtons = document.querySelectorAll('.not-interested-button');
        notInterestedButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                button.innerHTML = 'Not Interested ✗';
                button.classList.remove('btn-info');
                button.classList.add('btn-danger');
                button.disabled = true;
                window.location.href = button.href;
            });
        });

        const interestedButtons = document.querySelectorAll('.interested-button');
        interestedButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                button.innerHTML = 'Interested ✓';
                button.classList.remove('btn-success');
                button.classList.add('btn-success');
                button.disabled = true;
                window.location.href = button.href;
            });
        });
    });
</script>

<style>
    .form-control {
        border-radius: 0.375rem !important;
        font-size: 1rem !important;
        font-weight: 400 !important;
        line-height: 1.5 !important;
        padding: 6px 15px !important;
        height: 40px;
    }

    input[type="checkbox"]:checked {
        accent-color: green;
    }
</style>
