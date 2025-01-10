@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="row">

            <div class="col-md-12">
                <form method="GET" action="{{ route('ott.list') }}" class="forms-sample">
                    @csrf @method('GET')
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="created_at_start">From Date</label>
                                <div class="col-md-12 stretch-card">
                                    <input type="date" name="created_at_start" id="created_at_start" class="form-control"
                                        placeholder="Please select start date"
                                        value="{{ isset($payload['created_at_start']) ? $payload['created_at_start'] : '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="created_at_end">To Date</label>
                                <div class="col-md-12 stretch-card">
                                    <input type="date" name="created_at_end" id="created_at_end" class="form-control"
                                        placeholder="Please select end date"
                                        value="{{ isset($payload['created_at_end']) ? $payload['created_at_end'] : '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_status">Genre :</label>
                                <select name="genre_id" id="genre_id" class="form-select">
                                    <option value="">Select Genre</option>
                                    @foreach ($genre as $key => $value)
                                        <option value="{{ $value->id }}">
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_id">Client :</label>
                                <select name="client_id" id="client_id" class="form-select">
                                    <option value="">Select Client</option>
                                    @foreach ($clientList as $key => $value)
                                        <option value="{{ $value->id }}"
                                            {{ request('client_id') == $value->id ? 'selected' : '' }}>
                                            {{ $value->email }}
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

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_status">Payment status</label>
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

                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="mb-3">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="d-flex gap-3">
                                        <button type="submit" class="btn btn-sm btn-gradient-primary me-2">Search</button>
                                        @can('ip-non_featured_download')
                                            <a href="{{ route('export.search') }}"
                                                class="btn btn-sm btn-primary pull-left">Export
                                                Search</a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row mb-3">
                    <div class="d-flex gap-2">
                        <div>
                            <div class="d-flex gap-3">
                                <a href="{{ route('ott.list') }}" class="btn btn-sm btn-primary pull-left">Reset</a>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex gap-3">
                                <a href="{{ url('/ott/export') }}?{{ http_build_query(request()->all()) }}"
                                    class="btn btn-sm btn-primary pull-left">Export
                                    All</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                        <h4 class="card-title">OTT</h4>
                    </div>
                    <div class="card-body">
                        <div class="w-100 overflow-auto">
                            <table class="table table-bordered">
                                @if (count($ottlist) > 0)
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>
                                                <a href="{{ route('ott.list', ['sort' => 'id', 'order' => $sortField == 'id' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="{{ $sortField == 'id' ? 'sort-' . $sortOrder : '' }}">S.No.</a>
                                            </th>
                                            <th><a href="{{ route('ott.list', ['sort' => 'title', 'order' => $sortField == 'title' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="{{ $sortField == 'title' ? 'sort-' . $sortOrder : '' }}">Title
                                                    of
                                                    Web
                                                    Series</a>
                                            </th>
                                            <th><a href="{{ route('ott.list', ['sort' => 'title_in_english', 'order' => $sortField == 'title_in_english' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="{{ $sortField == 'title_in_english' ? 'sort-' . $sortOrder : '' }}">English
                                                    translation
                                                    of the
                                                    title</a>
                                            </th>
                                            <th><a href="{{ route('ott.list', ['sort' => 'genre_id', 'order' => $sortField == 'genre_id' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="{{ $sortField == 'genre_id' ? 'sort-' . $sortOrder : '' }}">Genre</a>
                                            </th>

                                            <th><a href="{{ route('ott.list', ['sort' => 'other_genre', 'order' => $sortField == 'other_genre' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="{{ $sortField == 'other_genre' ? 'sort-' . $sortOrder : '' }}">Other,
                                                    If
                                                    avaialble</a>
                                            </th>
                                            <th><a href="{{ route('ott.list', ['sort' => 'language_id', 'order' => $sortField == 'language_id' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="{{ $sortField == 'language_id' ? 'sort-' . $sortOrder : '' }}">Language
                                                    of
                                                    Web
                                                    Series</a>
                                            </th>
                                            <th><a href="{{ route('ott.list', ['sort' => 'other_language', 'order' => $sortField == 'other_language' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="{{ $sortField == 'other_language' ? 'sort-' . $sortOrder : '' }}">Other,
                                                    If
                                                    avaialble</a>
                                            </th>
                                            <th><a href="{{ route('ott.list', ['sort' => 'subtitle_other_language', 'order' => $sortField == 'subtitle_other_language' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="{{ $sortField == 'subtitle_other_language' ? 'sort-' . $sortOrder : '' }}">
                                                    subtitle Language</a></th>
                                            <th><a href="{{ route('ott.list', ['sort' => 'other_subtitle_language', 'order' => $sortField == 'other_subtitle_language' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="{{ $sortField == 'other_subtitle_language' ? 'sort-' . $sortOrder : '' }}">
                                                    Other subtitle Language</a></th>

                                            <th><a href="{{ route('ott.list', ['sort' => 'season', 'order' => $sortField == 'season' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="{{ $sortField == 'season' ? 'sort-' . $sortOrder : '' }}">Season</a>
                                            </th>
                                            <th><a href="{{ route('ott.list', ['sort' => 'runtime', 'order' => $sortField == 'runtime' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="{{ $sortField == 'runtime' ? 'sort-' . $sortOrder : '' }}">Total
                                                    Runtime</a>
                                            </th>
                                            <th><a href="{{ route('ott.list', ['sort' => 'number_of_episode', 'order' => $sortField == 'number_of_episode' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="{{ $sortField == 'number_of_episode' ? 'sort-' . $sortOrder : '' }}">Number
                                                    of
                                                    Episode</a>
                                            </th>
                                            <th><a href="{{ route('ott.list', ['sort' => 'release_date', 'order' => $sortField == 'release_date' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                                    class="{{ $sortField == 'release_date' ? 'sort-' . $sortOrder : '' }}">Release
                                                    Date</a>
                                            </th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ottlist as $value)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('ott.view', ['id' => $value->id]) }}"
                                                        class="btn btn-xs">View</a>
                                                    {{-- <a href="{{ route('ott.pdf', ['id' => $value->id]) }}"
                                                        class="btn btn-xs">Download
                                                        Pdf</a>
                                                    <a href="{{ route('ott.zip', ['id' => $value->id]) }}"
                                                        class="btn btn-xs">Download
                                                        all
                                                        File</a> --}}
                                                    <a href="{{ route('ott.pdf', ['id' => $value->id]) }}"
                                                        class="btn btn-xs" target="_blank">
                                                        <i class="fa fa-file-pdf-o" aria-hidden="true"
                                                            style="color: red"></i>
                                                    </a>
                                                    <a href="{{ route('ott.zip', ['id' => $value->id]) }}"
                                                        class="btn btn-xs"><i class="fa fa-file-zip-o"
                                                            style="color: red"></i>
                                                    </a>





                                                </td>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->title }}</td>
                                                <td>{{ $value->title_in_english }}</td>
                                                <td>{{ $value->genre->name }}</td>
                                                <td>{{ $value->other_genre }}</td>
                                                <td>{{ $value->language->name }}</td>
                                                <td>{{ $value->other_language }}</td>
                                                <!--  <td>{{ $value->is_subtitle_language_eng }}</td>-->
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
                    </div>
                    <div class="d-flex justify-content-center">
                        {{-- {{ $ottlist->withQueryString()->links() }} --}}
                        {{ $ottlist->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
