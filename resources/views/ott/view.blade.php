@extends('layouts.app')

@section('content')

    <div class="container">

        {{-- 1. Details of Web Series --}}
        <div class="card m-1">
            <div class="card-body">
                <h6>1. Details of Web Series</h6>
                <div class="row view-ott">
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(a) Title of Web Series (in the original language of
                                release) :</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield">{{ $data_array['title'] }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(b) English translation of the title :</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield">{{ $data_array['title_in_english'] }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(c) Genre :</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield">{{ $data->genre->name }}</span></p>
                    </div>
                    @if ($data_array['genre_id'] == 25)
                        <div class="col-md-6">
                            <p class="m-0"><span class="titleoffield">Other Genre:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="m-0"><span class="inputoffield">{{ $data_array['other_genre'] }}</span></p>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(d) Language in which the Web Series was originally
                                released :</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield">{{ $data->language->name }}</span></p>
                    </div>
                    @if ($data_array['language_id'] == 20)
                        <div class="col-md-12">
                            <p class="m-0"><span class="titleoffield">Other Language :</span></p>
                        </div>
                        <div class="col-md-12">
                            <p class="m-0"><span class="inputoffield">{{ $data_array['other_language'] }}</span></p>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(e) Whether Subtitle in English:</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span
                                class="inputoffield">{{ $data_array['is_subtitle_language_eng'] == 1 ? 'Yes' : 'No' }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(f) Other languages in which subtitles are available
                                (if any):</span></p>
                    </div>
                    <div class="col-md-6">

                    </div>
                    @if ($data_array['subtitle_other_language'] == 20)
                        <div class="col-md-6">
                            <p class="m-0"><span class="titleoffield">Other Subtitle Langauge :</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="m-0"><span class="inputoffield">{{ $data_array['other_subtitle_language'] }}</span>
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- 2. Details of Season & Episodes --}}
        <div class="card m-1">
            <div class="card-body">
                <h6>2. Details of Season & Episodes</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(a) Season :</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield">{{ $data_array['season'] }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(b) Total Runtime (in minutes) :</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield">{{ $data_array['runtime'] }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(c) Number of episodes :</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield">{{ $data_array['number_of_episode'] }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(d) Release date of the season :</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield">{{ $data_array['release_date'] }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(e) Whether the minimum duration of each episode of the
                                season is 25 mins:</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span
                                class="inputoffield">{{ $data_array['is_long_duration_timing'] == 1 ? 'Yes' : 'No' }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield-view"> (f) Whether all the episodes were released on the
                                same date? </span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span
                                class="titleoffield-view-span-ott">{{ $data_array['is_episode_have_same_date'] == 1 ? 'Yes' : 'No' }}
                            </span></p>
                    </div>

                    @foreach ($OttEpisode as $item)
                        <Container>
                            <div class='card m-1'>
                                <div class='card-body'>
                                    <div class='row'>
                                        <div class="col-md-6">
                                            <p class="m-0"><span class=""> Episode Number : </span><span
                                                    class="titleoffield-view-span-ott">{{ $item->episode_number }}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="m-0"><span class=""> Release Date : </span><span
                                                    class="titleoffield-view-span-ott"> {{ $item->release_date }} </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Container>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 3. Details Of Production --}}
        <div class="card m-1">
            <div class="card-body">
                <h6>3. Details Of Production</h6>
                <div class="row">
                    <div class="col-md-12">

                        <div class='row'>
                            <div class='col-md-6'>
                                <p class="m-0"><span class="titleoffield-view">A. Whether the Web Series is a
                                        co-production : </span></p>
                            </div>
                            <div class='col-md-6'>
                                <p class="m-0"><span
                                        class="titleoffield-view-span-ott">{{ $data_array['has_coproduction'] == 1 ? 'Yes' : 'No' }}
                                    </span></p>
                            </div>
                        </div>
                        @if ($data_array['has_coproduction'] == 1)
                            <div class="row">
                                @foreach ($OttCoProducer as $item)
                                    <div class="col-md-12">
                                        <div class="card m-1">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class='col-md-6'>
                                                        <p class="m-0"><span class="titleoffield">Production Type
                                                                :</span></p>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <p class="m-0"><span
                                                                class="inputoffield">{{ $item->type === 1 ? 'OTT' : ($item->type === 2 ? 'Production House' : 'Individual Producer') }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="container">
                                                    <div class="row">
                                                        <div class='col-md-6'>
                                                            <p class="m-0"><span class="titleoffield">(a) Name :</span>
                                                            </p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <p class="m-0"><span
                                                                    class="inputoffield">{{ $item->name }}</span></p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <p class="m-0"><span class="titleoffield">(b) Address
                                                                    :</span></p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <p class="m-0"><span
                                                                    class="inputoffield">{{ $item->address }}</span></p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <p class="m-0"><span class="titleoffield">(c) Mobile
                                                                    :</span></p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <p class="m-0"><span
                                                                    class="inputoffield">{{ $item->phone }}</span></p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <p class="m-0"><span class="titleoffield">(d) Email
                                                                    :</span></p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <p class="m-0"><span
                                                                    class="inputoffield">{{ $item->email }}</span></p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <p class="m-0"><span class="titleoffield">(e) Website
                                                                    :</span></p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <p class="m-0"><span
                                                                    class="inputoffield">{{ $item->website }}</span></p>
                                                        </div>
                                                        @if ($item->type == 1)
                                                            <div class='col-md-6'>
                                                                <p class="m-0"><span class="titleoffield">(f) Whether
                                                                        the OTT Platform has furnished information under
                                                                        Rule 18 of IT Rules, 2021 to the Ministry of
                                                                        Information and Broadcasting, Government of
                                                                        India:</span></p>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <p class="m-0"><span
                                                                        class="inputoffield">{{ $item->is_follow_it_rules == 1 ? 'Yes' : 'No' }}</span>
                                                                </p>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <p class="m-0"><span class="titleoffield">(g) Whether
                                                                        the web series is its original production:</span>
                                                                </p>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <p class="m-0"><span
                                                                        class="inputoffield">{{ $item->is_original_production == 1 ? 'yes' : 'No' }}</span>
                                                                </p>
                                                            </div>
                                                        @elseif($item->type == 2)
                                                            <div class='col-md-6'>
                                                                <p class="m-0"><span class="titleoffield">(f) Whether
                                                                        the production house(s) is/are
                                                                        incorporated/registered in India:</span></p>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <p class="m-0"><span
                                                                        class="inputoffield">{{ $item->is_registered == 1 ? 'yes' : 'No' }}</span>
                                                                </p>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <p class="m-0"><span class="titleoffield">(g)
                                                                        Document:</span></p>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <p class="m-0"><span class="inputoffield"><a
                                                                            href="">{{ isset($item['documents'][0]['name']) ? $item['documents'][0]['name'] : '' }}</a>
                                                                    </span></p>
                                                            </div>
                                                        @else
                                                            <div class='col-md-6'>
                                                                <p class="m-0"><span class="titleoffield">(f) Whether
                                                                        the individual Producer(s) is/are normally working
                                                                        and residing in India:</span></p>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <p class="m-0"><span
                                                                        class="inputoffield">{{ $item->is_residing_in_country == 1 ? 'yes' : 'No' }}</span>
                                                                </p>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <p class="m-0"><span class="titleoffield">(g)
                                                                        Nationality:</span></p>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <p class="m-0"><span
                                                                        class="inputoffield">{{ $item->nationality }}</span>
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if ($data_array['has_coproduction'] == 0)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="m-0"><span class="titleoffield">Production Type :</span>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="m-0"><span
                                                            class="inputoffield">{{ $data_array['coproducer_type'] == 1 ? 'OTT' : ($data_array['coproducer_type'] == 2 ? 'Production House' : 'Individual Producer') }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="m-0"><span class="titleoffield">(a) Name :</span></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="m-0"><span
                                                                class="inputoffield">{{ $data_array['coproducer_name'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="m-0"><span class="titleoffield">(b) Address :</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="m-0"><span
                                                                class="inputoffield">{{ $data_array['coproducer_address'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="m-0"><span class="titleoffield">(c) Mobile :</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="m-0"><span
                                                                class="inputoffield">{{ $data_array['coproducer_phone'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="m-0"><span class="titleoffield">(d) Email :</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="m-0"><span
                                                                class="inputoffield">{{ $data_array['coproducer_email'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="m-0"><span class="titleoffield">(e) Website :</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="m-0"><span
                                                                class="inputoffield">{{ $data_array['coproducer_website'] }}</span>
                                                        </p>
                                                    </div>
                                                    @if ($data_array['coproducer_type'] == 1)
                                                        <div class="col-md-6">
                                                            <p class="m-0"><span class="titleoffield">(f) Whether the
                                                                    OTT Platform has furnished information under Rule 18 of
                                                                    IT Rules, 2021 to the Ministry of Information and
                                                                    Broadcasting, Government of India:</span></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="m-0"><span
                                                                    class="inputoffield">{{ $data_array['coproducer_is_follow_it_rules'] == 1 ? 'Yes' : 'No' }}</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="m-0"><span class="titleoffield">(g) Whether the
                                                                    web series is its original production:</span></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="m-0"><span
                                                                    class="inputoffield">{{ $data_array['coproducer_is_original_production'] == 1 ? 'yes' : 'No' }}</span>
                                                            </p>
                                                        </div>
                                                    @elseif($data_array['coproducer_type'] == 2)
                                                        <div class="col-md-6">
                                                            <p class="m-0"><span class="titleoffield">(f) Whether the
                                                                    production house(s) is/are incorporated/registered in
                                                                    India:</span></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="m-0"><span
                                                                    class="inputoffield">{{ $data_array['coproducer_is_registered'] == 1 ? 'yes' : 'No' }}</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="m-0"><span class="titleoffield">(g)
                                                                    Document:</span></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="m-0"><span class="inputoffield"><a
                                                                        href="">{{ !empty($OttDoc[5]['name']) ? $OttDoc[5]['name'] : '' }}</a>
                                                                </span></p>
                                                        </div>
                                                    @else
                                                        <div class="col-md-6">
                                                            <p class="m-0"><span class="titleoffield">(f) Whether the
                                                                    individual Producer is normally working and residing in
                                                                    India:</span></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="m-0"><span
                                                                    class="inputoffield">{{ $data_array['coproducer_is_residing_in_country'] == 1 ? 'yes' : 'No' }}</span>
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. OTT - Platform --}}
        <div class="card m-1">
            <div class="card-body">
                <h6>4. OTT - Platform</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">Name of the OTT Platform where the web series was
                                originally released:</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield">{{ $data_array['ott_released_platform'] }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">Other OTT platform(s) on which the Web Series is
                                currently available, if any :</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span
                                class="inputoffield">{{ $data_array['is_other_released_platform_available'] ? 'yes' : 'NO' }}</span>
                        </p>
                    </div>
                    <h6>Other Information</h6>
                    {{-- (A) Whether web series has been streamed outside India --}}
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(A) Whether web series has been streamed outside
                                India :</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span
                                class="inputoffield">{{ $data_array['is_released_other_country'] ? 'Yes' : 'No' }}</span>
                        </p>
                    </div>
                    @if ($data_array['is_released_other_country'] == 1 && isset($OttStreamedCountry) && count($OttStreamedCountry) > 0)
                        @foreach ($OttStreamedCountry as $item)
                            <div class="container">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="m-0"><span class="titleoffield">Country : </span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="m-0"><span
                                                        class="inputoffield">{{ $Country[$item->country_id] ?? '' }}</span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="m-0"><span class="titleoffield"> Platform Name : </span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="m-0"><span
                                                        class="inputoffield">{{ $item->platform_name }}</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="m-0"><span class="titleoffield"> Release Date : </span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="m-0"><span
                                                        class="inputoffield">{{ $item->release_date }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- (B) Whether web series has been presented for festival/theatrical screening --}}
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(B) Whether web series has been presented for
                                festival/theatrical screening :</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span
                                class="inputoffield">{{ $data_array['is_thretrical_screening'] ? 'Yes' : 'No' }}</span>
                        </p>
                    </div>
                    @if ($data_array['is_thretrical_screening'] && isset($OttThreatricalScreening) && count($OttThreatricalScreening) > 0)
                        @foreach ($OttThreatricalScreening as $item)
                            <div class="container">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="m-0"><span class="titleoffield">Name of the festival: </span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="m-0"><span
                                                        class="inputoffield">{{ $item->festival_name }}</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="m-0"><span class="titleoffield"> Date of the festival:
                                                    </span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="m-0"><span
                                                        class="inputoffield">{{ $item->date_of_festival }}</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="m-0"><span class="titleoffield"> Address of the festival:
                                                    </span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="m-0"><span class="inputoffield">{{ $item->address }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="m-0">



                            </p>
                        @endforeach
                    @endif


                    {{-- (C) Whether web series has been streamed/broadcasted on the Internet/TV or other media --}}
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(C) Whether web series has been streamed/broadcasted
                                on the Internet/TV or other media :</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield">
                                {{ $data_array['is_streamed_other_media'] ? 'Yes' : 'No' }}</span></p>
                    </div>
                    @if ($data_array['is_streamed_other_media'] && isset($OttBroadcasted) && count($OttBroadcasted) > 0)
                        @foreach ($OttBroadcasted as $item)
                            <div class="container">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="m-0"><span class="titleoffield">Date of the Streaming :
                                                    </span><span class="inputoffield">{{ $item->stream_date }}</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="m-0"><span class="titleoffield"> Name of the platform :
                                                    </span><span class="inputoffield">{{ $item->platform_name }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- (D) Whether web series has been participated in any International Competition --}}
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(D) Whether web series has been participated in any
                                International Competition :</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span
                                class="inputoffield">{{ $data_array['is_international_competition'] ? 'Yes' : 'No' }}</span>
                        </p>
                    </div>
                    @if (
                        $data_array['is_international_competition'] &&
                            isset($OttInternationalCompetition) &&
                            count($OttInternationalCompetition) > 0)
                        @foreach ($OttInternationalCompetition as $row)
                            <div class="container">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="m-0"><span class="titleoffield">Name of the Competition :
                                                    </span><span class="inputoffield">{{ $row->competition_name }}</span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="m-0"><span class="titleoffield"> Date of the Competition :
                                                    </span><span class="inputoffield">{{ $row->competition_date }}</span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="m-0"><span class="titleoffield"> Details of the Awards won(if
                                                        any) : </span><span
                                                        class="inputoffield">{{ $row->details }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="card m-1">
            <div class="card-body">
                <h6>5. Director's / Creator's Details</h6>
                @if ($createrDetails && count($createrDetails) > 0)
                    <h6 class="text-center mt-1">Director's</h6>
                    @foreach ($createrDetails as $row)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="titleoffield">Name : </span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="inputoffield">{{ $row->name }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="titleoffield">Country :</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span
                                                class="inputoffield">{{ $row->country->country_name }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="titleoffield">Mobile : </span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="inputoffield">{{ $row->phone }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="titleoffield">Email : </span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="inputoffield">{{ $row->email }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="titleoffield">Website : </span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="inputoffield">{{ $row->website }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                @if ($OttDirectorDetail && count($OttDirectorDetail) > 0)
                    <h6 class="text-center mt-1">Creator's Details</h6>
                    @foreach ($OttDirectorDetail as $row)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="titleoffield">Name : </span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="inputoffield">{{ $row->name }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="titleoffield">Country :</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span
                                                class="inputoffield">{{ $row->country->country_name }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="titleoffield">Mobile : </span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="inputoffield">{{ $row->phone }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="titleoffield">Email : </span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="inputoffield">{{ $row->email }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="titleoffield">Website : </span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><span class="inputoffield">{{ $row->website }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <h6 class="text-center mt-1">Other Details</h6>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="m-0"><span class="titleoffield">(I) Story Writer : </span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="inputoffield">{{ $data_array['story_writer'] }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="titleoffield">(II) Screenplay Writer :</span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="inputoffield">{{ $data_array['screening_writer'] }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="titleoffield">(III) Director of Photography : </span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span
                                        class="inputoffield">{{ $data_array['director_of_photography'] }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="titleoffield">(IV) Editor : </span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="inputoffield">{{ $data_array['editior'] }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="titleoffield">(V) Art Director : </span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="inputoffield">{{ $data_array['art_director'] }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="titleoffield">(VI) Costume Designer : </span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="inputoffield">{{ $data_array['costume_director'] }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="titleoffield">(VII) Director of Music : </span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="inputoffield">{{ $data_array['music_director'] }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="titleoffield">(VIII) Sound Designer : </span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="inputoffield">{{ $data_array['sound_designer'] }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="titleoffield">(IX) Principal cast : </span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="m-0"><span class="inputoffield">{{ $data_array['principal_cast'] }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card m-1">
            <div class="card-body">
                <h6>6. Document's</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(a) Synopsis Of The Web-Series(Precise, Not Exceeding
                                200 words):</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield"> <a
                                    href="">{{ !empty($OttDoc[1]['name']) ? $OttDoc[1]['name'] : '' }}</a></span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(b) Brief Profile Of Creator's (Precise, Not
                                Exceeding 200 words):</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield"><a
                                    href="">{{ !empty($OttDoc[2]['name']) ? $OttDoc[2]['name'] : '' }}</a> </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(c) Brief Profile Of Director's (Precise, Not
                                Exceeding 200 words):</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield"><a
                                    href="">{{ !empty($OttDoc[3]['name']) ? $OttDoc[3]['name'] : '' }}</a> </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">(d) Brief Profile Of Producer's (Precise, Not
                                Exceeding 200 words):</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="inputoffield"><a
                                    href="">{{ !empty($OttDoc[4]['name']) ? $OttDoc[4]['name'] : '' }}</a> </span>
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <!-- <div class="card m-1">
            <div class="card-body">
                <h6>7. Additional Info</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">Name Of The Applicant : </span><span class="inputoffield">{ $data_array.name_of_the_applicant}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">Contact number : </span><span class="inputoffield">{ $data_array.contact_number}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">Print Date :- </span><span class="inputoffield">{currDate} {currTime}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="m-0"><span class="titleoffield">Email : </span><span class="inputoffield"> { $data_array.email}</span></p>
                    </div>

                </div>
            </div>
        </div> -->
    </div>



@endsection
