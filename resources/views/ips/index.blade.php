@extends('layouts.app')
@section('title')
{{ 'IP-LIST' }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
            <div class="g-4">
                <div>
                    <form action="{{ route('ip.search') }}" method="GET" class="filter-project">@csrf @method('GET')
                        <div class="row">
                            {{-- From Date --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label"><strong>From Date</strong></label>
                                    <input type="date" name="from_date" class="form-control"
                                        value="{{ isset($payload['from_date']) ? $payload['from_date'] : '' }}"
                                        placeholder="Please select date">
                                </div>
                            </div>

                            {{-- From Date --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email"><strong>To Date</strong></label>
                                    <input type="date" name="to_date" class="form-control"
                                        value="{{ isset($payload['to_date']) ? $payload['to_date'] : '' }}"
                                        placeholder="Please select date">
                                </div>
                            </div>

                            {{-- Select Category --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category"><strong>Category</strong></label>
                                    <select name="category" class="form-select">
                                        <option value="" selected>Select category</option>
                                        @foreach ($categories as $key => $value)
                                            <option name="category" value="{{ $key }}"
                                                {{ isset($payload['category']) && $payload['category'] == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Payment Status --}}
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
                                    1 => 'Film details',
                                    2 => 'Producers details',
                                    3 => 'Directors details',
                                    4 => 'Crew details',
                                    5 => 'Cbfc certifications',
                                    6 => 'Other details',
                                    7 => 'Documents',
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
                                @can('ip-non_featured_download')
                                    <a href="{{ route('export.search') }}" class="btn common-btn">
                                        SEARCH-EXPORT</a>
                                @endcan
                            </div>
                        </div>
                    </form>
                    <div class="text-end">
                        <a href="{{ route('ips.index') }}" class="btn common-btn">RESET</a>
                        <a href="{{ route('ip.all_record') }}" class="btn common-btn">EXPORT-ALL </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 d-flex">
                <div class="card card-animate w-100 ">
                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            INDIAN PANORAMA - (COUNT :- {{ isset($count) ? $count : '' }})
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
                                @if (count($ips) > 0)
                                    <thead>
                                        <tr>
                                            <th>PDF</th>
                                            <th>ZIP</th>
                                            <th>Movie Ref</th>
                                            <th>Steps</th>
                                            <th>Client Name</th>
                                            <th>Client Email</th>
                                            <th>Category</th>
                                            <th>Film Title in Roman</th>
                                            <th>Film Title in English</th>
                                            <th>Language</th>
                                            <th>Duration</th>
                                            <th>Format</th>
                                            <th>Censorship Type</th>
                                            <th>Censorship Date</th>
                                            <th>Producer Name</th>
                                            <th>Producer Email</th>
                                            <th>Producer Address</th>
                                            <th>Payment Date & Time</th>
                                            <th>Payment Amount</th>
                                            <th>Payment Receipt No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ips as $key => $ip)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('ip.pdf', ['id' => $ip->id]) }}" class="text-danger"
                                                        target="_blank">
                                                        <i class="ri-file-pdf-line"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('ip.zip', ['id' => $ip->id]) }}"
                                                        class="text-danger"><i class="ri-folder-zip-line"></i>
                                                    </a>
                                                </td>
                                                <td> {{ $ip->id }} </td>
                                                <td>
                                                    @foreach ($ip::steps() as $key => $value)
                                                        {{ isset($ip->step) && $ip->step === $value ? ($key === 'SUBMISSION' ? 'PAID' : $key) : '' }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $ip->client->name ?? '' }}</td>
                                                <td>{{ $ip->client->email ?? '' }}</td>
                                                <td> {{ $ip->category == 1 ? 'Featured Flim' : ($ip->category == 2 ? 'Non Featured Film' : '') }}
                                                </td>
                                                <td>{{ $ip->title_of_film_in_roman }}</td>
                                                <td>{{ $ip->english_translation_of_film }}</td>
                                                <td>{{ $ip->language->name ?? '' }}</td>
                                                <td>{{ $ip->duration_running_time }}</td>
                                                <td>{{ $ip->dcp == 1 ? 'DCP' : ($ip->dcp == 2 ? 'Blueray' : ($ip->dcp == 3 ? 'Pendrive' : 'Not Selected')) }}
                                                </td>
                                                <td>{{ $ip->film_is_certified_by_cbfc_or_uncensored == 1 ? 'DBFC' : ($ip->category == 2 ? 'Uncensored' : null) }}
                                                </td>
                                                <td>{{ $ip->date_of_cbfc_certificate }}</td>

                                                @php
                                                    $ipDirectors = App\Models\IpDirector::where(
                                                        'ip_application_form_id',
                                                        $ip->id,
                                                    )->get();

                                                    foreach ($ipDirectors as $key => $ipDirector) {
                                                        if ($key == 0) {
                                                            $Director1Name = $ipDirector->name;
                                                            $Director1Email = $ipDirector->email;
                                                            $Director1Address = $ipDirector->address;
                                                            $Director1Nationality =
                                                                isset($ipDirector->indian_nationality) &&
                                                                $ipDirector->indian_nationality == 1
                                                                    ? 'Indian'
                                                                    : null;
                                                        }
                                                        if ($key == 1) {
                                                            $Director2Name = $ipDirector->name;
                                                            $Director2Email = $ipDirector->email;
                                                            $Director2Address = $ipDirector->address;
                                                            $Director2Nationality =
                                                                isset($ipDirector->indian_nationality) &&
                                                                $ipDirector->indian_nationality == 1
                                                                    ? 'Indian'
                                                                    : null;
                                                        }
                                                        if ($key == 2) {
                                                            $Director3Name = $ipDirector->name;
                                                            $Director3Email = $ipDirector->email;
                                                            $Director3Address = $ipDirector->address;
                                                            $Director3Nationality =
                                                                isset($ipDirector->indian_nationality) &&
                                                                $ipDirector->indian_nationality == 1
                                                                    ? 'Indian'
                                                                    : null;
                                                        }
                                                        if ($key == 3) {
                                                            $Director4Name = $ipDirector->name;
                                                            $Director4Email = $ipDirector->email;
                                                            $Director4Address = $ipDirector->address;
                                                            $Director4Nationality =
                                                                isset($ipDirector->indian_nationality) &&
                                                                $ipDirector->indian_nationality == 1
                                                                    ? 'Indian'
                                                                    : null;
                                                        }
                                                        if ($key == 4) {
                                                            $Director5Name = $ipDirector->name;
                                                            $Director5Email = $ipDirector->email;
                                                            $Director5Address = $ipDirector->address;
                                                            $Director5Nationality =
                                                                isset($ipDirector->indian_nationality) &&
                                                                $ipDirector->indian_nationality == 1
                                                                    ? 'Indian'
                                                                    : null;
                                                        }
                                                    }
                                                @endphp
                                                @php
                                                    if (!empty($ip->producer_is) && $ip->producer_is == 1) {
                                                        if ($ip->firm_is_owned_by_individual == 1) {
                                                            $firmName = $ip->name_of_firm;
                                                        } else {
                                                            $firmName = $ip->name_of_the_producer_making_entry;
                                                        }
                                                    } else {
                                                        $firmName = '';
                                                    }
                                                    if (!empty($ip->producer_is) && $ip->producer_is == 2) {
                                                        $firmName = $ip->name_of_production_house;
                                                    } else {
                                                        $firmName = '';
                                                    }
                                                @endphp

                                                <td>{{ $firmName }}</td>
                                                <td>{{ $ip->producer_email }}</td>
                                                <td>{{ $ip->producer_address }}</td>
                                                @php
                                                    $payment = App\Models\Transaction::where([
                                                        'website_type' => 1,
                                                        'client_id' => $ip['client_id'],
                                                        'context_id' => $ip['id'],
                                                        'auth_status' => '0300',
                                                    ])->first();

                                                    if (!is_null($payment)) {
                                                        $paymentDate = $payment->payment_date;
                                                        $paymentAmount = $payment->amount;
                                                        $paymentReceipt = $payment->bank_ref_no;
                                                    } else {
                                                        $paymentDate = '';
                                                        $paymentAmount = '';
                                                        $paymentReceipt = '';
                                                    }
                                                @endphp
                                                <td>{{ $paymentDate ?? '' }}</td>
                                                <td>{{ $paymentAmount ?? '' }}</td>
                                                <td>{{ $paymentReceipt ?? '' }}</td>
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
                                {{ $ips->withQueryString()->links() }}
                            </ul>
                        </nav>
                        <!-- Pagination End-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
