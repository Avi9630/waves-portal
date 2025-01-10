@extends('layouts.app')
@section('title')
{{ 'DIRECTOR-DEBUTE-list' }}
@endsection
@section('content')
    <div class="container-fluid">
        {{-- Search --}}
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
            <div class="g-4">
                <div>
                    <form method="GET" action="{{ route('dd-search') }}" class="filter-project">@csrf
                        @method('GET')
                        <div class="row">

                            {{-- From Date --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="from_date" class="form-label"><strong>From Date</strong></label>
                                    <input type="date" name="from_date" id="from_date" class="form-control"
                                        value="{{ isset($payload['from_date']) ? $payload['from_date'] : '' }}"
                                        placeholder="Please select start date">
                                </div>
                            </div>

                            {{-- From Date --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="to_date"><strong>To Date</strong></label>
                                    <input type="date" name="to_date" id="to_date" class="form-control"
                                        value="{{ isset($payload['to_date']) ? $payload['to_date'] : '' }}"
                                        placeholder="Please select date">
                                </div>
                            </div>

                            {{-- Payments Status --}}
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
                                    <label for="step"><strong>Steps</strong></label>
                                    <select name="step" id="payment_status" class="form-select">
                                        <option value="">Select steps</option>
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
                            </div>
                            
                        </div>
                    </form>
                    <div class="text-end">
                        <a href="{{ route('dds.index') }}" class="btn common-btn">RESET</a>
                        <a href="{{ route('dd-all-excel-export') }}" class="btn common-btn">EXPORT-ALL</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table  --}}
        <div class="row">
            <div class="col-md-12 col-sm-12 d-flex">
                <div class="card card-animate w-100">
                    <div class="card-header">
                        <h4 class="card-title mb-0 project-title">
                            DIRECTOR-DEBUT (Count :- {{ isset($count) ? $count : '' }})
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
                                @if (count($dds) > 0)
                                    <thead>
                                        <tr>
                                            <th>PDF</th>
                                            <th>ZIP</th>
                                            <th>Movie Ref</th>
                                            <th>Steps</th>
                                            <th>Client Name</th>
                                            <th>Client Email</th>
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
                                        @foreach ($dds as $key => $ip)
                                            <tr>
                                                <td>
                                                    @if ($ip->step == 9)
                                                        <a href="{{ route('dd-pdf', ['id' => $ip->id]) }}"
                                                            class="text-danger" target="_blank">
                                                            <i class="ri-file-pdf-line"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ip->step == 9)
                                                        <a href="{{ route('dd-zip', ['id' => $ip->id]) }}"
                                                            class="text-danger"><i class="ri-folder-zip-line"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td> {{ $ip->id }} </td>
                                                <td>
                                                    @foreach ($ip::steps() as $key => $value)
                                                        {{ isset($ip->step) && $ip->step === $value ? ($key === 'SUBMISSION' ? 'PAID' : $key) : '' }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $ip->client->name ?? '' }}</td>
                                                <td>{{ $ip->client->email ?? '' }}</td>
                                                <td>{{ $ip->title_of_film_in_roman }}</td>
                                                <td>{{ $ip->english_translation_of_film }}</td>
                                                <td>{{ $ip->language->name ?? '' }}</td>
                                                <td>{{ $ip->duration_running_time }}</td>
                                                <td>{{ $ip->dcp == 1 ? 'DCP' : ($ip->dcp == 2 ? 'Blueray' : 'Not selected') }}
                                                </td>
                                                <td>{{ $ip->film_is_certified_by_cbfc_or_uncensored == 1 ? 'DBFC' : ($ip->category == 2 ? 'Uncensored' : null) }}
                                                </td>
                                                <td>{{ $ip->date_of_cbfc_certificate }}</td>

                                                @php
                                                    $ddDirectors = App\Models\DdDirectors::where(
                                                        'dd_application_form_id',
                                                        $ip->id,
                                                    )->get();

                                                    foreach ($ddDirectors as $key => $ipDirector) {
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
                                                    $ipCoProcers = App\Models\DdCoProducer::where(
                                                        'dd_application_form_id',
                                                        $ip->id,
                                                    )->get();
                                                    foreach ($ipCoProcers as $key => $ipCoProcer) {
                                                        if ($key == 0) {
                                                            $Producer1Name = $ipCoProcer->name;
                                                            $Producer1Email = $ipCoProcer->email;
                                                            $Producer1Address = $ipCoProcer->address;
                                                        }

                                                        if ($key == 1) {
                                                            $Producer2Name = $ipCoProcer->name;
                                                            $Producer2Email = $ipCoProcer->email;
                                                            $Producer2Address = $ipCoProcer->address;
                                                        }

                                                        if ($key == 2) {
                                                            $Producer3Name = $ipCoProcer->name;
                                                            $Producer3Email = $ipCoProcer->email;
                                                            $Producer3Address = $ipCoProcer->address;
                                                        }
                                                        if ($key == 3) {
                                                            $Producer4Name = $ipCoProcer->name;
                                                            $Producer4Email = $ipCoProcer->email;
                                                            $Producer4Address = $ipCoProcer->address;
                                                        }
                                                        if ($key == 4) {
                                                            $Producer5Name = $ipCoProcer->name;
                                                            $Producer5Email = $ipCoProcer->email;
                                                            $Producer5Address = $ipCoProcer->address;
                                                        }
                                                    }
                                                @endphp

                                                @php
                                                    $payment = App\Models\Transaction::where([
                                                        'website_type' => 4,
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
                                {{ $dds->withQueryString()->links() }}
                            </ul>
                        </nav>
                        <!-- Pagination End-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
