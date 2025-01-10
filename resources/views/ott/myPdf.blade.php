<style>
    .container {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
        max-width: 1140px;
        /* Adjust according to your desired maximum width */
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
    }

    .card-body {
        flex: 1 1 auto;
        padding: 1.25rem;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        /* margin-right: -15px;
        margin-left: -15px; */
    }

    /* .row {
        display: flex;

        flex-wrap: wrap;

        margin-right: -15px;

        margin-left: -15px;
    } */

    .col-md-6 {
        width: 50%;
        /* Two columns per row in print */
        float: left;
    }

    /* .col-md-12 {
        position: relative;

        width: 100%;

        padding-right: 15px;

        padding-left: 15px;
        flex: 0 0 100%;

        max-width: 100%;
    } */

    @media (min-width: 768px) {
        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    .m-0 {
        margin: 0 !important;
    }

    .m-1 {
        margin: 0.25rem !important;
        /* 0.25rem is equivalent to 1/16th of the font size */
    }

    p {
        margin: 0;
    }

    .center-text {
        width: 100%;
    }

    .text-center {
        display: flex;
        justify-content: center;
    }
</style>

<div class="container">

    <h1 class="text-center">{{ $title }} || {{ $date }}</h1>
    {{-- 1. Details of Web Series --}}
    <div class="card m-1">
        <div class="card-body">
            <h3>1. Details of Web Series</h3>
            <div class="row view-ott">

                <div class="col-md-12">
                    <p class="m-0">
                        <span class="titleoffield">(a) Title of Web Series (in the original language of
                            release) :-
                        </span>
                        {{ $data_array['title'] }}
                    </p>

                </div>
                <br>

                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(b) English translation of the title :</span>
                        {{ $data_array['title_in_english'] }}</p>
                </div>
                <br>
                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(c) Genre :</span>
                        {{ isset($data->genre->name) ?? $data->genre->name }}</p>
                </div>
                <br>
                @if ($data_array['genre_id'] == 25)
                    <div class="col-md-12">
                        <p class="m-0"><span class="titleoffield">Other Genre:</span>{{ $data_array['other_genre'] }}
                        </p>
                    </div>
                @endif
                <div class="col-md-12">
                    <p class="m-0">
                        <span class="titleoffield">(d) Language in which the Web Series was originally released :</span>
                        {{ isset($data->language->name) ?? $data->language->name }}
                    </p>
                </div>
                <br>

                @if ($data_array['language_id'] == 20)
                    <div class="col-md-12">
                        <p class="m-0"><span class="titleoffield">Other Language :</span>
                            {{ $data_array['other_language'] }}</p>
                    </div>
                @endif

                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(e) Whether Subtitle in English:</span>
                        {{ $data_array['is_subtitle_language_eng'] == 1 ? 'Yes' : 'No' }}</p>
                </div>

                <div class="col-md-12">
                    <p class="m-0">
                        <span class="titleoffield">(f) Other languages in which subtitles are available (if any):</span>
                        @if ($data_array['subtitle_other_language'] == 20)
                            <div class="col-md-6">
                                <p class="m-0"><span class="titleoffield">Other Subtitle Langauge
                                        :</span>{{ $data_array['other_subtitle_language'] }}</p>
                            </div>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Details of Season & Episodes --}}
    <div class="card m-1">
        <div class="card-body">
            <h3>2. Details of Season & Episodes</h3>
            <div class="row">
                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(a) Season :</span> {{ $data_array['season'] }}</p>
                </div>
                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(b) Total Runtime (in minutes) :</span>
                        {{ $data_array['runtime'] }}</p>
                </div>

                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(c) Number of episodes :</span>
                        {{ $data_array['number_of_episode'] }}</p>
                </div>
                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(d) Release date of the season :</span>
                        {{ $data_array['release_date'] }}</p>
                </div>
                <div class="col-md-12">
                    <p class="m-0">
                        <span class="titleoffield">(e) Whether the minimum duration of each episode of the season is 25
                            mins:</span>
                        {{ $data_array['is_long_duration_timing'] == 1 ? 'Yes' : 'No' }}
                    </p>
                </div>

                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield-view"> (f) Whether all the episodes were released on the
                            same date? </span>
                        {{ $data_array['is_episode_have_same_date'] == 1 ? 'Yes' : 'No' }}
                    </p>
                </div>

                @foreach ($OttEpisode as $item)
                    <Container>
                        <div class='card m-1'>
                            <div class='card-body'>
                                <div class='row'>
                                    <div class="col-md-12">
                                        <p class="m-0"><span class=""> Episode Number : </span>
                                            <span class="titleoffield-view-span-ott">{{ $item->episode_number }}</span>
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
            <h3>3. Details Of Production</h3>
            <div class="row">

                <p class="mb-1"><span class="titleoffield-view">A. Whether the Web Series is a
                        co-production : </span>
                    {{ $data_array['has_coproduction'] == 1 ? 'Yes' : 'No' }}
                </p>

                @if ($data_array['has_coproduction'] == 1)
                    @foreach ($OttCoProducer as $item)
                        <div class='col-md-12'>
                            <p class="m-0">
                                <span class="titleoffield-view">Production Type : </span>
                                {{ $item->type === 1 ? 'OTT' : ($item->type === 2 ? 'Production House' : 'Individual Producer') }}
                            </p>
                        </div>

                        <div class='col-md-12'>
                            <p class="m-0">
                                <span class="titleoffield">(a) Name :</span>
                                {{ $item->name }}
                            </p>
                        </div>

                        <div class='col-md-12'>
                            <p class="m-0">
                                <span class="titleoffield">(b) Address :</span>
                                {{ $item->address }}
                            </p>
                        </div>

                        <div class='col-md-12'>
                            <p class="m-0">
                                <span class="titleoffield">(c) Mobile : </span>
                                {{ $item->phone }}
                            </p>
                        </div>

                        <div class='col-md-12'>
                            <p class="m-0">
                                <span class="titleoffield">(d) Email :</span>
                                {{ $item->email }}
                            </p>
                        </div>

                        <div class='col-md-12'>
                            <p class="m-0">
                                <span class="titleoffield">(e) Website :</span>
                                {{ $item->website }}
                            </p>
                        </div>

                        @if ($item->type == 1)
                            <div class='col-md-12'>
                                <p class="m-0">
                                    <span class="titleoffield">(f) Whether the OTT Platform has furnished information
                                        under Rule 18 of IT Rules, 2021 to the Ministry of Information and Broadcasting,
                                        Government of India:</span>
                                    {{ $item->is_follow_it_rules == 1 ? 'Yes' : 'No' }}
                                </p>
                            </div>

                            <div class='col-md-12'>
                                <p class="m-0">
                                    <span class="titleoffield">(g) Whether the web series is its original
                                        production:</span>
                                    {{ $item->is_original_production == 1 ? 'yes' : 'No' }}
                                </p>
                            </div>
                        @elseif($item->type == 2)
                            <div class='col-md-12'>
                                <p class="m-0">
                                    <span class="titleoffield">(f) Whether the production house(s) is/are
                                        incorporated/registered in India:</span>
                                    {{ $item->is_registered == 1 ? 'yes' : 'No' }}
                                </p>
                            </div>

                            <div class='col-md-12'>
                                <p class="m-0">
                                    <span class="titleoffield">(g) Document:</span>
                                    {{ isset($item['documents'][0]['name']) ? $item['documents'][0]['name'] : '' }}
                                </p>
                            </div>
                        @else
                            <div class='col-md-12'>
                                <p class="m-0">
                                    <span class="titleoffield">(f) Whether the individual Producer(s) is/are normally
                                        working and residing in India :</span>
                                    {{ $item->is_residing_in_country == 1 ? 'yes' : 'No' }}
                                </p>
                            </div>
                            <div class='col-md-6'>
                                <p class="m-0">
                                    <span class="titleoffield">(g) Nationality :</span>
                                    {{ $item->nationality }}
                                </p>
                            </div>
                        @endif
                    @endforeach
                @endif
                @if ($data_array['has_coproduction'] == 0)

                    <div class="col-md-12">
                        <p class="m-0"><span class="titleoffield">Production Type
                                :</span>{{ $data_array['coproducer_type'] == 1 ? 'OTT' : ($data_array['coproducer_type'] == 2 ? 'Production House' : 'Individual Producer') }}
                        </p>
                    </div>

                    <div class="col-md-12">
                        <p class="m-0"><span class="">(a) Name
                                :</span>{{ $data_array['coproducer_name'] }}</p>
                    </div>

                    <div class="col-md-12">
                        <p class="m-0"><span class="titleoffield">(b) Address
                                :</span>{{ $data_array['coproducer_address'] }}
                        </p>
                    </div>

                    <div class="col-md-12">
                        <p class="m-0"><span class="titleoffield">(c) Mobile
                                :</span>{{ $data_array['coproducer_phone'] }}
                        </p>
                    </div>

                    <div class="col-md-12">
                        <p class="m-0"><span class="titleoffield">(d) Email
                                :</span>{{ $data_array['coproducer_email'] }}
                        </p>
                    </div>

                    <div class="col-md-12">
                        <p class="m-0"><span class="titleoffield">(e) Website
                                :</span>{{ $data_array['coproducer_website'] }}
                        </p>
                    </div>

                    @if ($data_array['coproducer_type'] == 1)
                        <div class="col-md-12">
                            <p class="m-0"><span class="titleoffield">(f) Whether the
                                    OTT Platform has furnished information under Rule 18 of
                                    IT Rules, 2021 to the Ministry of Information and
                                    Broadcasting, Government of
                                    India:</span>{{ $data_array['coproducer_is_follow_it_rules'] == 1 ? 'Yes' : 'No' }}
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p class="m-0"><span class="titleoffield">(g) Whether the web series is its original
                                    production:</span>
                                {{ $data_array['coproducer_is_original_production'] == 1 ? 'yes' : 'No' }}
                            </p>
                        </div>
                    @elseif($data_array['coproducer_type'] == 2)
                        <div class="col-md-12">
                            <p class="m-0"><span class="titleoffield">(f) Whether the
                                    production house(s) is/are incorporated/registered in
                                    India:</span>{{ $data_array['coproducer_is_registered'] == 1 ? 'yes' : 'No' }}
                            </p>
                        </div>

                        <div class="col-md-12">
                            <p class="m-0"><span class="titleoffield">(g)
                                    Document:</span>{{ !empty($OttDoc[5]['name']) ? $OttDoc[5]['name'] : '' }}
                            </p>
                        </div>
                    @else
                        <div class="col-md-12">
                            <p class="m-0"><span class="titleoffield">(f) Whether the
                                    individual Producer is normally working and residing in
                                    India:</span>{{ $data_array['coproducer_is_residing_in_country'] == 1 ? 'yes' : 'No' }}
                            </p>
                        </div>
                    @endif


                @endif

            </div>
        </div>
    </div>

    {{-- 4. OTT - Platform --}}
    <div class="card m-1">
        <div class="card-body">
            <h3>4. OTT - Platform</h3>
            <div class="row">
                <div class="col-md-12">
                    <p class="m-0">
                        <span class="titleoffield">Name of the OTT Platform where the web series was
                            originally released:</span>
                        {{ $data_array['ott_released_platform'] }}
                    </p>
                </div>

                <div class="col-md-12">
                    <p class="m-0">
                        <span class="titleoffield">Other OTT platform(s) on which the Web Series is
                            currently available, if any :</span>
                        {{ $data_array['is_other_released_platform_available'] ? 'yes' : 'NO' }}
                    </p>
                </div>

                <h4>Other Information</h4>
                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(A) Whether web series has been streamed
                            outside
                            India :</span>{{ $data_array['is_released_other_country'] ? 'Yes' : 'No' }}</p>
                </div>

                @if ($data_array['is_released_other_country'] == 1 && isset($OttStreamedCountry) && count($OttStreamedCountry) > 0)
                    @foreach ($OttStreamedCountry as $item)
                        <div class="container">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="m-0"><span class="titleoffield">Country :
                                                </span>{{ $Country[$item->country_id] ?? '' }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <p class="m-0"><span class="titleoffield"> Platform Name :
                                                </span>{{ $item->platform_name }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <p class="m-0"><span class="titleoffield"> Release Date :
                                                </span>{{ $item->release_date }}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                {{-- (B) Whether web series has been presented for festival/theatrical screening --}}
                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(B) Whether web series has been presented
                            for
                            festival/theatrical screening
                            :</span>{{ $data_array['is_thretrical_screening'] ? 'Yes' : 'No' }}</p>
                </div>

                @if ($data_array['is_thretrical_screening'] && isset($OttThreatricalScreening) && count($OttThreatricalScreening) > 0)
                    @foreach ($OttThreatricalScreening as $item)
                        <div class="container">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="m-0"><span class="titleoffield">Name of the
                                                    festival: </span>
                                                {{ $item->festival_name }}
                                            </p>
                                        </div>

                                        <div class="col-md-12">
                                            <p class="m-0"><span class="titleoffield"> Date of the
                                                    festival:
                                                </span>{{ $item->date_of_festival }}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <p class="m-0"><span class="titleoffield"> Address of the
                                                    festival:
                                                </span>{{ $item->address }}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif


                {{-- (C) Whether web series has been streamed/broadcasted on the Internet/TV or other media --}}
                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(C) Whether web series has been
                            streamed/broadcasted
                            on the Internet/TV or other media
                            :</span>{{ $data_array['is_streamed_other_media'] ? 'Yes' : 'No' }}</p>
                </div>

                @if ($data_array['is_streamed_other_media'] && isset($OttBroadcasted) && count($OttBroadcasted) > 0)
                    @foreach ($OttBroadcasted as $item)
                        <div class="container">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="m-0"><span class="titleoffield">Date of the
                                                    Streaming :
                                                </span><span class="inputoffield">{{ $item->stream_date }}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="m-0"><span class="titleoffield"> Name of the
                                                    platform :
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
                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(D) Whether web series has been
                            participated in any
                            International Competition
                            :</span>{{ $data_array['is_international_competition'] ? 'Yes' : 'No' }}</p>
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
                                        <div class="col-md-12">
                                            <p class="m-0"><span class="titleoffield">Name of the
                                                    Competition :
                                                </span><span class="inputoffield">{{ $row->competition_name }}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="m-0"><span class="titleoffield"> Date of the
                                                    Competition :
                                                </span><span class="inputoffield">{{ $row->competition_date }}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="m-0"><span class="titleoffield"> Details of the
                                                    Awards won(if
                                                    any) : </span><span
                                                    class="inputoffield">{{ $row->details }}</span>
                                            </p>
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
            <div class="row">
                <h4>5. Director's / Creator's Details</h4>

                @if ($createrDetails && count($createrDetails) > 0)

                    <h3 class="text-center mt-1">Director's</h3>

                    @foreach ($createrDetails as $row)
                        <div class="col-md-12">
                            <p class="m-0">
                                <span class="titleoffield">Name :</span>
                                {{ $row->name }}
                            </p>
                        </div>

                        <div class="col-md-12">
                            <p class="m-0">
                                <span class="titleoffield">Country : </span>
                                {{ $row->country->country_name }}
                            </p>
                        </div>

                        <div class="col-md-12">
                            <p class="m-0">
                                <span class="titleoffield">Mobile : </span>
                                {{ $row->phone }}
                            </p>
                        </div>

                        <div class="col-md-12">
                            <p class="m-0"><span class="titleoffield">Email : </span>
                                {{ $row->email }}
                            </p>
                        </div>

                        <div class="col-md-12">
                            <p class="m-0"><span class="titleoffield">Website : </span>
                                {{ $row->website }}
                            </p>
                        </div>
                    @endforeach
                @endif

                @if ($OttDirectorDetail && count($OttDirectorDetail) > 0)

                    <h3 class="text-center mt-1">Creator's Details</h3>

                    @foreach ($OttDirectorDetail as $row)
                        <div class="col-md-12">
                            <p class="m-0">
                                <span class="titleoffield">Name : </span>
                                {{ $row->name }}
                            </p>
                        </div>

                        <div class="col-md-12">
                            <p class="m-0">
                                <span class="titleoffield">Country : </span>
                                {{ $row->country->country_name }}
                            </p>
                        </div>

                        <div class="col-md-12">
                            <p class="m-0">
                                <span class="titleoffield">Mobile :</span>
                                {{ $row->phone }}
                            </p>
                        </div>

                        <div class="col-md-12">
                            <p class="m-0">
                                <span class="titleoffield">Email : </span>
                                {{ $row->email }}
                            </p>
                        </div>

                        <div class="col-md-12">
                            <p class="m-0">
                                <span class="titleoffield">Website : </span>
                                {{ $row->website }}
                            </p>
                        </div>
                    @endforeach
                @endif

                <h3 class="text-center mt-1">Other Details</h3>

                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(I) Story Writer : </span>
                        {{ $data_array['story_writer'] }}</p>
                </div>

                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(II) Screenplay Writer
                            :</span>{{ $data_array['screening_writer'] }}</p>
                </div>

                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(III) Director of Photography :
                        </span>{{ $data_array['director_of_photography'] }}</p>
                </div>

                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(IV) Editor :
                        </span>{{ $data_array['editior'] }}</p>
                </div>

                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(V) Art Director :
                        </span>{{ $data_array['art_director'] }}</p>
                </div>

                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(VI) Costume Designer :
                        </span>{{ $data_array['costume_director'] }}</p>
                </div>

                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(VII) Director of Music :
                        </span>{{ $data_array['music_director'] }}</p>
                </div>

                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(VIII) Sound Designer :
                        </span>{{ $data_array['sound_designer'] }}</p>
                </div>

                <div class="col-md-12">
                    <p class="m-0"><span class="titleoffield">(IX) Principal cast :
                        </span>{{ $data_array['principal_cast'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card m-1">
        <div class="card-body">
            <h4>6. Document's</h4>
            <div class="row">

                <div class="col-md-12">
                    <p class="m-0">
                        <span class="titleoffield">(a) Synopsis Of The Web-Series(Precise, Not Exceeding 200
                            words):</span>
                        {{ !empty($OttDoc[1]['name']) ? $OttDoc[1]['name'] : '' }}
                    </p>
                </div>

                <div class="col-md-12">
                    <p class="m-0">
                        <span class="titleoffield">(b) Brief Profile Of Creator's (Precise, Not
                            Exceeding 200 words):</span>
                        {{ !empty($OttDoc[2]['name']) ? $OttDoc[2]['name'] : '' }}
                    </p>
                </div>

                <div class="col-md-12">
                    <p class="m-0">
                        <span class="titleoffield">(c) Brief Profile Of Director's (Precise, Not Exceeding 200
                            words):</span>
                        {{ !empty($OttDoc[3]['name']) ? $OttDoc[3]['name'] : '' }}
                    </p>
                </div>

                <div class="col-md-12">
                    <p class="m-0">
                        <span class="titleoffield">(d) Brief Profile Of Producer's (Precise, Not Exceeding 200
                            words):</span>
                        {{ !empty($OttDoc[4]['name']) ? $OttDoc[4]['name'] : '' }}
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
