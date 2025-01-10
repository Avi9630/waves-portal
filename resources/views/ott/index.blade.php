@extends('layouts.app')
@section('title')
{{ 'OTT-LIST' }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
            <div class="g-4">
                <div>
                    <form action="{{ route('ott.search') }}" method="GET" class="filter-project">@csrf @method('GET')
                        <div class="row">
                            {{-- From Date --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="created_at_start" class="form-label"><strong>From Date</strong></label>
                                    <input type="date" name="created_at_start" id="created_at_start" class="form-control"
                                        value="{{ isset($payload['created_at_start']) ? $payload['created_at_start'] : '' }}"
                                        placeholder="Please select date">
                                </div>
                            </div>

                            {{-- From Date --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="created_at_end"><strong>To Date</strong></label>
                                    <input type="date" name="created_at_end" id="created_at_end" class="form-control"
                                        value="{{ isset($payload['created_at_end']) ? $payload['created_at_end'] : '' }}"
                                        placeholder="Please select date">
                                </div>
                            </div>

                            {{-- Select Genre --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="genre_id"><strong>Genre</strong></label>
                                    <select name="genre_id" id="genre_id" class="form-select">
                                        <option value="">Select genre</option>
                                        @foreach ($genre as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ isset($payload['genre_id']) && $payload['genre_id'] == $value->id ? 'selected' : '' }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @php
                                $paids = [
                                    8 => 'Paid',
                                    1 => 'Unpaid',
                                ];
                            @endphp
                            {{-- Select Category --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_status"><strong>Payment status</strong></label>
                                    <select name="payment_status" id="payment_status" class="form-select">
                                        <option value="">Select status</option>
                                        @foreach ($paids as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ isset($payload['payment_status']) && $payload['payment_status'] == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @php
                                $steps = [
                                    1 => 'Details',
                                    2 => 'Seasons and episode',
                                    3 => 'Producers',
                                    4 => 'Ott Plateform',
                                    5 => 'Director',
                                ];
                            @endphp

                            <div class="col-md-6" id="step-selection" style="display: none;">
                                <div class="mb-3">
                                    <label for="payment_status"><strong>Select steps</strong></label>
                                    <select name="step" class="form-select">
                                        <option value="">Select status</option>
                                        @foreach ($steps as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ isset($payload['step']) && $payload['step'] == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="name" class="form-label w-100">&nbsp;</label>
                                <button type="submit" class="btn common-btn">SEARCH</button>
                                <a href="{{ route('export_by.search') }}" class="btn common-btn">
                                    SEARCH-EXPORT</a>
                            </div>
                        </div>
                    </form>
                    <div class="text-end">
                        <a href="{{ route('otts.index') }}" class="btn common-btn">RESET</a>
                        <a href="{{ url('/ott/export') }}?{{ http_build_query(request()->all()) }}"
                            class="btn common-btn">EXPORT-ALL </a>
                        {{-- <a href="{{ route('ott-pdf-generator') }}" class="btn common-btn">PDF</a> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 d-flex">
                <div class="card card-animate w-100 ">
                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            OTT ( Count :- {{ isset($count) ? $count : '' }})
                        </h4>
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
                        <div class="table table-responsive">
                            <table class="table custom-table">
                                @if (count($ottlist) > 0)
                                    <thead>
                                        <tr>
                                            <th>VIEW</th>
                                            <th>PDF</th>
                                            <th>ZIP</th>
                                            <th>Sr.No</th>
                                            <th>Steps</th>
                                            <th>Client Name</th>
                                            <th>Client Email</th>
                                            <th>Title of Web Series</th>
                                            <th>English translation of the title</th>
                                            <th>Genre</th>
                                            {{-- <th>Other,If avaialble</th> --}}
                                            <th>Language of Web Series</th>
                                            <th>Subtitle Language</th>
                                            <th>Other subtitle Language</th>
                                            <th>Season</th>
                                            <th>Total Runtime</th>
                                            <th>Number of Episode</th>
                                            <th>Release Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ottlist as $key => $value)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('ott.view', ['id' => $value->id]) }}"
                                                        class="text-info"> <i class="ri-eye-line"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('ott.pdf', ['id' => $value->id]) }}"
                                                        class="text-danger" target="_blank">
                                                        <i class="ri-file-pdf-line"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('ott.zip', ['id' => $value->id]) }}"
                                                        class="text-warning"><i class="ri-folder-zip-line"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $value->id }}</td>
                                                <td>
                                                    @foreach ($value::steps() as $key => $v)
                                                        {{ isset($value->step) && $value->step === $v ? ($key === 'FINAL_SUBMIT' ? 'PAID' : $key) : '' }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $value->client->name ?? '' }}</td>
                                                <td>{{ $value->client->email ?? '' }}</td>
                                                <td>{{ $value->title }}</td>
                                                <td>{{ $value->title_in_english }}</td>
                                                <td>{{ $value->genre->name }}</td>
                                                <td>{{ $value->language->name }}</td>
                                                {{-- <td>{{ $value->other_language }}</td> --}}
                                                {{-- <td>{{ $value->is_subtitle_language_eng }}</td> --}}
                                                <td>{{ $value->subtitleOther?->name }}</td>
                                                <td>{{ $value->other_subtitle_language }}</td>
                                                <td>{{ $value->season }}</td>
                                                <td>{{ $value->runtime }}</td>
                                                <td>{{ $value->number_of_episode }}</td>
                                                <td>{{ $value->release_date }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                @else
                                    <p>No record found...!!</p>
                                @endif
                            </table>
                        </div>
                        <!-- Pagination -->
                        <nav aria-label="...">
                            <ul class="pagination">
                                {{ $ottlist->withQueryString()->links() }}
                            </ul>
                        </nav>
                        <!-- Pagination End-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
