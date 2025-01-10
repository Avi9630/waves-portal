<style>
    @import url('https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap');

    F .container {
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
        width: 100%;
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

    .col-md-6 {
        width: 49%;
        /* Two columns per row in print */
        float: left;
        flex-wrap: wrap;
    }



    .col-md-12 {
        flex: 0 0 auto;
        width: 100%;
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
        width: 99%;
    }

    .text-center {
        display: flex;
        justify-content: center;
        color: #AD4172;
    }

    .alignment {
        display: flex;
        align-items: end;

        & p {
            padding-right: 1px;
            padding-left: 1px;
        }
    }

    /* @font-face {
        font-family: 'NotoSansDevanagari';
        src: url('http://192.168.1.11/nfdc-admin-dashboard/public/fonts/NotoSansDevanagari-Regular.ttf');
        font-weight: normal;
        font-style: normal;
    }
    body {
            font-family: 'DejaVuSans', sans-serif;
            
        } */
    @font-face {
        font-family: 'Noto Sans Devanagari';
        src: url({{ public_path('fonts/NotoSansDevanagari-Regular.ttf') }}) format('truetype');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }

    body {
        font-family: 'Noto Sans Devanagari', sans-serif;

    }
</style>

<body>

    <div class="container">
        <!-- Panel 1: Film Details -->
        <h5 class="text-center">Best Debut Indian Film Section 2024</h5>

        <div class="card m-1">
            <div class="card-body">
                <!-- Category of the Film -->
                <div class="row">
                    <div class="col-md-6 alignment">
                        <p class="titleoffield-view">1. Whether the film is a Debut film of the Director :</p>
                    </div>
                    <div class="col-md-6 alignment">
                        <p class="titleoffield-view-span">{{ $ipForm->category == 1 ? 'Yes' : 'No' }}
                        </p>
                    </div>
                    <p class="titleoffield-view">2. Title of the Film</p>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 alignment">
                                <p><span class="titleoffield-view">हिंदी(a) Title of the Film in Roman Script :</span>
                                </p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p class="titleoffield-view-span">{{ $ipForm->title_of_film_in_roman }}</p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p><span class="titleoffield-view">(b) Title of the Film in Devanagari:</span></p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p class="titleoffield-view-span">{{ $ipForm->title_of_film_in_devanagari }}</p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p><span class="titleoffield-view">(c) English translation of the Film:</span></p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p class="titleoffield-view-span">{{ $ipForm->english_translation_of_film }}</p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p><span class="titleoffield-view">(d) Title of the Film in the script of the language
                                        of
                                        the Film:</span></p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p class="titleoffield-view-span">{{ $ipForm->title_of_script_langauge }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="titleoffield-view">3. Language of the Film</p>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 alignment">
                            <p><span class="titleoffield-view">(a) Language of the Film:</span></p>
                        </div>
                        <div class="col-md-6 alignment">
                            <p class="titleoffield-view-span">
                                {{ $ipForm->language_id ? $language[$ipForm->language_id] ?? '' : '-' }}</p>
                        </div>
                        @if ($ipForm->language_id == 20)
                            <div class="col-md-6 alignment">
                                <p><span class="titleoffield-view"> Other language name:</span></p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p class="titleoffield-view-span">{{ $ipForm->other_language_name }}</p>
                            </div>
                        @endif
                        <div class="col-md-6 alignment">
                            <p><span class="titleoffield-view">(b) Whether Subtitled in English:</span></p>
                        </div>
                        <div class="col-md-6 alignment">
                            <p class="titleoffield-view-span">{{ $ipForm->whether_subtitle_english ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                </div>
                <!-- Format of the Submitted Film -->
                <div class="row">
                    <p class="titleoffield-view">4. Format of the submitted Film</p>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 alignment">
                                <p><span class="titleoffield-view">Feature Film:</span></p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p class="titleoffield-view-span">
                                    {{ $ipForm->dcp == 1 ? 'DCP' : ($ipForm->dcp == 2 ? 'Blu-ray' : ($ipForm->dcp == 3 ? 'Pendrive' : '')) }}
                                </p>
                            </div>
                            @if ($ipForm->dcp == 1)
                                <div class="col-md-6 alignment">
                                    <p><span class="titleoffield-view">DCI Compliant JPEG2000 (J2K) Interop or SMPTE DCP
                                            (Note: J2K Interop DCP to be only in 24 fps):</span></p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p class="titleoffield-view-span">
                                        {{ $ipForm->dci_compliant_jpeg_2000 == 1 ? 'Yes' : 'No' }}</p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p><span class="titleoffield-view">The subtitles to be burned in the picture or in
                                            TI
                                            CineCanvas™ Format:</span></p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p class="titleoffield-view-span">
                                        {{ $ipForm->subtitle_to_be_burned_in_picture == 1 ? 'Yes' : 'No' }}</p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p><span class="titleoffield-view">The Hard Disk partition format shall be NTFS or
                                            EXT2/EXT3 (with Inode size 128 bytes):</span></p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p class="titleoffield-view-span">
                                        {{ $ipForm->hard_disk_format_ext2_ext3 == 1 ? 'Yes' : 'No' }}</p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p><span class="titleoffield-view">The DCP should be preferably sent in CRU Hard
                                            Disk:</span></p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p class="titleoffield-view-span">
                                        {{ $ipForm->dcp_should_cru_hard_disk == 1 ? 'Yes' : 'No' }}</p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p><span class="titleoffield-view">Is the DCP Unencrypted?</span></p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p class="titleoffield-view-span">
                                        {{ $ipForm->is_dcp_unencrypted == 1 ? 'Yes' : 'No' }}
                                    </p>
                                </div>
                            @elseif($ipForm->dcp == 2)
                                <div class="col-md-6 alignment">
                                    <p><span class="titleoffield-view">Is the Blu-ray region free PAL?</span></p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p class="titleoffield-view-span">
                                        {{ $ipForm->blueray_region_free_pal ? 'Yes' : 'No' }}
                                    </p>
                                </div>
                            @endif
                            <div class="col-md-6 alignment">
                                <p><span
                                        class="titleoffield-view">{{ $ipForm->category == 2 ? 'Value of the DCP/Blu-ray/Pendrive' : 'Value of the DCP/Blu-ray' }}:</span>
                                </p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p class="titleoffield-view-span">{{ $ipForm->value_of_dcp_or_blueray }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel 2: Producer Details -->
        <div class="card m-1">
            <div class="card-body">
                <p class="titleoffield-view-out">5. Producer(s) Details</p>
                <div class="row">
                    <div class="col-md-6 alignment">
                        <p>(a) Whether Producer is :</p>
                    </div>
                    <div class="col-md-6 alignment">
                        <p class="titleoffield-view-span">
                            {{ $ipForm->producer_is == 1 ? 'Individual' : 'Company/Institute/Other Such Entity' }}</p>
                    </div>
                    @if ($ipForm->producer_is == 1)
                        <div class="col-md-6 alignment">
                            <p>(b) Name of the Producer making the entry as per the clause 2(c):</p>
                            {{-- <p>(b) Whether any proprietor firm is owned by the individual making entry :</p> --}}
                        </div>
                        <div class="col-md-6 alignment">
                            <p class="titleoffield-view-span">{{ $ipForm->firm_is_owned_by_individual ? 'Yes' : 'No' }}
                            </p>
                        </div>
                        @if ($ipForm->firm_is_owned_by_individual)
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 alignment">
                                        <p>(i) Name of the firm :</p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p class="titleoffield-view-span">{{ $ipForm->name_of_firm }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        @if (
                            $ipForm->producer_is == 2 &&
                                ($ipForm->firm_is_owned_by_individual == 0 || $ipForm->firm_is_owned_by_individual == 1))
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 alignment">
                                        <p>(i) Name of the producer making the entry :</p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p class="titleoffield-view-span">
                                            {{ $ipForm->name_of_the_producer_making_entry }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 alignment">
                                        <p>(i) Name of the production house :</p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p class="titleoffield-view-span">{{ $ipForm->name_of_production_house }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    <!-- Additional Details -->
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 alignment">
                                <p>(ii) E-mail :</p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p class="titleoffield-view-span">{{ $ipForm->producer_email }}</p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p>(iii) Address :</p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p class="titleoffield-view-span">{{ $ipForm->producer_address }}</p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p>(iv) Landline :</p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p class="titleoffield-view-span">
                                    {{ $ipForm->producer_landline ? $ipForm->producer_landline : '-' }}</p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p>(v) Mobile :</p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p class="titleoffield-view-span">
                                    {{ $ipForm->producer_mobile ? $ipForm->producer_mobile : '-' }}</p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p>(vi) Website :</p>
                            </div>
                            <div class="col-md-6 alignment">
                                <p class="titleoffield-view-span">{{ $ipForm->producer_website }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 alignment">
                        <p>(b) Whether the indivdual/company is registered as an Indian/Indian entity - Public
                            Ltd./Private
                            Ltd./Partnership/Proprietorship :</p>
                        {{-- <p>(b) Whether Company is Registered as an Indian entity - Public Ltd./Private
                        Ltd./Partnership/Proprietorship or Whether Indian national (as per the clause number 2(d)) :</p> --}}
                    </div>
                    <div class="col-md-6 alignment">
                        <p class="titleoffield-view-span">
                            {{ $ipForm->company_is_registered_as_indian_entity ? 'Yes' : 'No' }}
                        </p>
                    </div>
                    <div class="col-md-6 alignment">
                        <p>(c) Attach Photo ID issued by the Govt. of India (for Indian National) :</p>
                    </div>
                    <div class="col-md-6 alignment">
                        @if (!empty($documents->where('type', 1)->first()->file))
                            <p class="inputoffield">
                                <span class="Attach_Photo_ID">
                                    <a target="_blank" download
                                        href="{{ 'https://iffigoa.org/backend/api/downloadfile/dd/' . $ipForm->id . '/' . $documents->where('type', 1)->first()->file }}">
                                        {{ $documents->where('type', 1)->first()->name }}
                                    </a>
                                </span>
                            </p>
                        @endif
                    </div>
                </div>

                <p class="titleoffield-view-out">6. DCP/Blu-ray of the Film to be returned to</p>
                <div class="row">
                    <div class="col-md-6 alignment">
                        <p>(a) Is the address same as Producer :</p>
                    </div>
                    <div class="col-md-6 alignment">
                        <p class="titleoffield-view-span">{{ $ipForm->is_address_same_as_producer ? 'Yes' : 'No' }}
                        </p>
                    </div>
                    @if (!$ipForm->is_address_same_as_producer)
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 alignment">
                                    <p>(i) Name :</p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p class="titleoffield-view-span">{{ $ipForm->return_address_name }}</p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p>(ii) E-mail :</p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p class="titleoffield-view-span">{{ $ipForm->return_address_email }}</p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p>(iii) Landline :</p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p class="titleoffield-view-span">
                                        {{ $ipForm->return_address_landline ? $ipForm->return_address_landline : '-' }}
                                    </p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p>(iv) Mobile Number :</p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p class="titleoffield-view-span">{{ $ipForm->return_address_mobile }}</p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p>(v) Address :</p>
                                </div>
                                <div class="col-md-6 alignment">
                                    <p class="titleoffield-view-span">{{ $ipForm->return_address }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @foreach ($IpCoProducer as $index => $item)
                    <div class="card m-1">
                        <div class="card-body">
                            <p>({{ $index + 1 }}) Co-Producer Details</p>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 alignment">
                                        <p>Whether Co-producer is :</p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p class="titleoffield-view-span">
                                            {{ $item->co_producer_is == 1 ? 'Individual' : 'Company / Institute /Other such entity' }}
                                        </p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p>Name :</p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p class="titleoffield-view-span">{{ $item->name }}</p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p>E-mail :</p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p class="titleoffield-view-span">{{ $item->email }}</p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p>Landline :</p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p class="titleoffield-view-span">
                                            {{ $item->landline ? $item->landline : '-' }}
                                        </p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p>Mobile Number :</p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p class="titleoffield-view-span">{{ $item->mobile }}</p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p>Address :</p>
                                    </div>
                                    <div class="col-md-6 alignment">
                                        <p class="titleoffield-view-span">{{ $item->address }}</p>
                                    </div>

                                    @if ($item->co_producer_is == 1)
                                        <div class="col-md-6">
                                            <p>Whether the Individual is an Indian National</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><span class="">Yes</span></p>
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <p><span class="">Whether the company(s) is registered as an Indian
                                                    Entity, Mention(In accordance with cause 6.2.2) : </span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p>No</p>
                                        </div>
                                    @endif

                                    @if ($item->is_indian_entity == 1)
                                        <div class="col-md-6">
                                            <p>Attach Photo ID issued by the Govt. of India (for Indian National):</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="inputoffield"><span class="Attach_Photo_ID"><a
                                                        href="{{ url('downloadfile/IP/' . $ipForm->id . '/' . $item->file) }}"><span>{{ $item->documents_name }}</span></a></span>
                                            </p>
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <p>Attach copy of Passport:</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="inputoffield"><span class="Attach_Photo_ID">
                                                    <a
                                                        href="{{ url('downloadfile/IP/' . $ipForm->id . '/' . $item->file1) }}"><span>{{ $item->documents_name1 }}</span></a></span>
                                            </p>
                                        </div>
                                    @endif
                                    @if ($item->co_producer_is == 2)
                                        <div class='col-md-6 alignment'>
                                            <p><span class="">Registration Details :</span></p>
                                        </div>
                                        <div class='col-md-6 alignment'>
                                            <p><span class="titleoffield-view-span">
                                                    {{ $item->registration_details }}</span> </p>
                                        </div>

                                        <div class='col-md-6 alignment'>
                                            <p><span class="">The name of the Producer along with
                                                    Co-Producers(s), if
                                                    any, who is to be credited in the Certificate :
                                                </span></p>
                                        </div>
                                        <div class='col-md-6 alignment'>
                                            <p><span
                                                    class="titleoffield-view-span">{{ $item->name_of_producers }}</span>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-md-6 alignment">
                    <p><span class="">(b) Whether the Indian and Foreign right holder is same : </span></p>
                </div>
                <div class="col-md-6 alignment">
                    <p><span class="titleoffield-view-span">
                            {{ $ipForm->whether_indian_foreign_right_holder_same ? 'Yes' : 'No' }}</span> </p>
                </div>

                @if ($ipForm->whether_indian_foreign_right_holder_same == 0)
                    @if ($ipForm->right_holder_name)
                        <div class="col-md-6 alignment">
                            <p><span class="">(i) Name : </span></p>
                        </div>
                        <div class="col-md-6 alignment">
                            <p><span class="titleoffield-view-span"> {{ $ipForm->right_holder_name }}</span> </p>
                        </div>
                    @endif
                    <div class="col-md-6 alignment">
                        <p><span class="">(ii) E-mail : </span></p>
                    </div>
                    <div class="col-md-6 alignment">
                        <p><span class="titleoffield-view-span"> {{ $ipForm->right_holder_email }}</span> </p>
                    </div>
                    @if ($ipForm->right_holder_landline)
                        <div class="col-md-6 alignment">
                            <p><span class="">(iii) Landline : </span></p>
                        </div>
                        <div class="col-md-6 alignment">
                            <p><span
                                    class="titleoffield-view-span">{{ $ipForm->right_holder_landline ? $ipForm->right_holder_landline : '-' }}</span>
                            </p>
                        </div>
                    @endif
                    <div class="col-md-6 alignment">
                        <p><span class="">(iv) Mobile : </span></p>
                    </div>
                    <div class="col-md-6 alignment">
                        <p><span class="titleoffield-view-span"> {{ $ipForm->right_holder_mobile }}</span> </p>
                    </div>
                    <div class="col-md-6 alignment">
                        <p><span class="">(v) Address : </span></p>
                    </div>
                    <div class="col-md-6 alignment">
                        <p><span class="titleoffield-view-span"> {{ $ipForm->right_holder_address }}</span> </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Director(s) Details -->
        <div class="card m-1">
            @foreach ($IpDirector as $index => $item)
                <div class="card-body">
                    <p><span class="titleoffield-view-out">7. Director(s) Details</span></p>
                    <div class="container">
                        <p>({{ $index + 1 }}) Director Details</p>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><span>Name: </span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span class="titleoffield-view-span">{{ $item->name }}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span>E-mail: </span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span class="titleoffield-view-span">{{ $item->email }}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span>Landline: </span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span class="titleoffield-view-span">{{ $item->landline }}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span>Mobile: </span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span class="titleoffield-view-span">{{ $item->mobile }}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span>Website: </span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span class="titleoffield-view-span">{{ $item->website }}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span>Address: </span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span class="titleoffield-view-span">{{ $item->address }}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span>Indian National: </span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span
                                            class="titleoffield-view-spa n">{{ $item->indian_nationality ? 'Yes' : 'No' }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><span>Your uploaded file in PDF format only: </span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span class="titleoffield-view-span">

                                            <a target="_blank" download
                                                href="{{ 'https://iffigoa.org/backend/api/downloadfile/dd/' . $ipForm->id . '/' . $item->documents[0]->file }}">
                                                {{ $item->documents[0]->name }}
                                            </a>
                                        </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Panel 4: Crew Details -->
        <div class="card m-1">
            <div class="card-body">
                <p><span class="titleoffield-view-out">8. Crew Details</span></p>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <p><span>(a) Story Writer/ Author:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">{{ $ipForm->story_write_aurthor }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span>(b) Screenplay/ Script Writer:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">{{ $ipForm->screenplay_script_write }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span>(c) Director of Photography:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">{{ $ipForm->director_of_photography }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span>(d) Editor:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">{{ $ipForm->editor }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span>(e) Art Director:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">{{ $ipForm->art_director }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span>(f) Costume Designer:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">{{ $ipForm->costume_designer }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span>(g) Music Director:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">{{ $ipForm->music_director }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span>(h) Sound Recordist:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">{{ $ipForm->sound_recordist }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span>(i) Sound Re-recordist (Optional):</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">{{ $ipForm->sound_re_recordist }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span>(j) Principal Cast:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">{{ $ipForm->principal_cast }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span>(k) Duration/Running time (in minutes):</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">{{ $ipForm->duration_running_time }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span>(l) No. of DCP/Blu-ray (Optional):</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">{{ $ipForm->no_of_dcp_blueray }}</span></p>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><span>. Colour or B&W:</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span class="titleoffield-view-span">{{ $ipForm->color_b_w }}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span>. Aspect Ratio:</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span class="titleoffield-view-span">{{ $ipForm->aspect_ratio }}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span>. Sound System:</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span class="titleoffield-view-span">{{ $ipForm->sound_system }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel 9: CBFC Certification -->
        <div class=" card m-1">
            <div class="card-body">
                <p class='m-0'><span class="titleoffield-view-out">9. CBFC Certification</span></p>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <p><span>Whether the Film is certified by CBFC or uncensored:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">
                                    {{ $ipForm->film_is_certified_by_cbfc_or_uncensored == 1 ? 'Certified by CBFC' : 'Uncensored' }}
                                </span></p>
                        </div>

                        @if ($ipForm->film_is_certified_by_cbfc_or_uncensored == 1)
                            <!-- Certified by CBFC -->
                            <div class="col-md-6">
                                <p><span>(a) Date of CBFC certificate:</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><span
                                        class="titleoffield-view-span">{{ \Carbon\Carbon::parse($ipForm->date_of_cbfc_certificate)->format('d-m-Y') }}</span>
                                </p>
                            </div>

                            <div class="col-md-6">
                                <p><span>(b) Certification No:</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><span class="titleoffield-view-span">{{ $ipForm->certificate_no }}</span></p>
                            </div>

                            <div class="col-md-6">
                                <p><span>(c) Attach Copy Of CBFC Certificate:</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><span class="titleoffield-view-span">

                                        <a target="_blank" download
                                            href="{{ 'https://iffigoa.org/backend/api/downloadfile/dd/' . $ipForm->id . '/' . $documents->where('type', 4)->first()->file }}">
                                            {{ $documents->where('type', 4)->first()->name }}
                                        </a>
                                    </span></p>
                            </div>
                        @else
                            <!-- Not Certified by CBFC -->
                            <div class="col-md-6">
                                <p><span>(a) Date of Completion of Production:</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><span
                                        class="titleoffield-view-span">{{ \Carbon\Carbon::parse($ipForm->date_of_completion_production)->format('d-m-Y') }}</span>
                                </p>
                            </div>

                            <div class="col-md-12">
                                <p>
                                    <span>(b) Attach Copy Of Declaration As per Clause (7.2(C)):</span>
                                    <span class="titleoffield-view-span">
                                        <a target="_blank" download
                                            href="{{ 'https://iffigoa.org/backend/api/downloadfile/dd/' . $ipForm->id . '/' . $documents->where('type', 3)->first()->file }}">
                                            {{ $documents->where('type', 3)->first()->name }}
                                        </a>
                                    </span>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- Panel 10: Other Details -->
        <div class=" card m-1">
            <div class="card-body">
                <p class='m-0'><span class="titleoffield-view-out">10. Other Details</span></p>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <p><span>A. Whether the Film has been completed during the last 12 months preceding the
                                    festival
                                    i.e 1st August, 2023 to 31st July, 2024:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span
                                    class="titleoffield-view-span">{{ $ipForm->film_comletion_during_12month ? 'Yes' : 'No' }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><span>B. Whether the Film has been screened in any Indian or International Film
                                    Festival:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span class="titleoffield-view-span">{{ $ipForm->film_screened ? 'Yes' : 'No' }}</span>
                            </p>
                        </div>

                        @if ($ipForm->film_screened == 1)
                            @foreach ($IpInternationalFilmFestival as $index => $item)
                                <div class="card m-1">
                                    <div class="card-body">
                                        <p>({{ $index + 1 }}) Festival Details</p>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><span>Name of the festival:</span><span
                                                            class="titleoffield-view-span">
                                                            {{ $item->name_of_festival }}</span></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><span>Address of the Festival:</span><span
                                                            class="titleoffield-view-span">
                                                            {{ $item->address_of_festival }}</span></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><span>Date of the Festival:</span><span
                                                            class="titleoffield-view-span">
                                                            {{ \Carbon\Carbon::parse($item->date_of_festival)->format('d-m-Y') }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div class="col-md-6">
                            <p><span>C. Whether the Film has been shown/broadcasted on the Internet/TV or other
                                    media:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span
                                    class="titleoffield-view-span">{{ $ipForm->film_broadcast_tv ? 'Yes' : 'No' }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><span>D. Whether the Film has been screened commercially inside India:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span
                                    class="titleoffield-view-span">{{ $ipForm->film_screened_inside_india == 1 ? 'Yes' : 'No' }}</span>
                            </p>
                        </div>

                        @if ($ipForm->film_screened_inside_india == 1)
                            <div class="card m-1">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><span>Date Of Release:</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><span
                                                    class="titleoffield-view-span">{{ \Carbon\Carbon::parse($ipForm->date_of_release)->format('d-m-Y') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <p><span>E. Whether Film has been screened commercially outside India:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span
                                    class="titleoffield-view-span">{{ $ipForm->film_screened_outside_india ? 'Yes' : 'No' }}</span>
                            </p>
                        </div>

                        @if ($ipForm->film_screened_outside_india == 1)
                            @foreach ($IpCommerciallyOutsideIndia as $index => $item)
                                <div class="card m-1">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><span>({{ $index + 1 }}) Name of the Country:</span><span
                                                        class="titleoffield-view-span"> {{ $item->country }}</span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><span>Release Date:</span><span class="titleoffield-view-span">
                                                        {{ \Carbon\Carbon::parse($item->release_date)->format('d-m-Y') }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div class="col-md-6">
                            <p><span>F. Whether Film has participated in any International Competition:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span
                                    class="titleoffield-view-span">{{ $ipForm->film_participated_compentitaion ? 'Yes' : 'No' }}</span>
                            </p>
                        </div>

                        @if ($ipForm->film_participated_compentitaion == 1)
                            @foreach ($IpInternationalCompetition as $index => $item)
                                <div class="card m-1">
                                    <div class="card-body">
                                        <div class="col-md-6">
                                            <p><span>({{ $index + 1 }}) Name of the festival:</span><span
                                                    class="titleoffield-view-span"> {{ $item->name }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div class="col-md-6">
                            <p><span>G. Whether, it is Director's Debut Film:</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><span
                                    class="titleoffield-view-span">{{ $ipForm->is_directore_debute_film ? 'Yes' : 'No' }}</span>
                            </p>
                        </div>
                        {{-- <div class="col-md-6">
                        <p><span>H. Whether Film's distribution is limited to India only:</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><span
                                class="titleoffield-view-span">{{ $ipForm->film_distribution_limited_to_india_only ? 'Yes' : 'No' }}</span>
                        </p>
                    </div> --}}

                        @foreach ($IpAward as $index => $item)
                            <div class="card m-1">
                                <div class="card-body">
                                    <div class="col-md-6">
                                        <p><span>({{ $index + 1 }}) Details of the Awards won(if
                                                any):</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><span class="titleoffield-view-span">
                                                {{ $item->details }}</span></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel 11: Documents -->
        <div class="  card m-1">
            <div class="card-body">
                <p class='m-0'><span class="titleoffield-view-out">11. Documents (For Feature Film and Non-Feature
                        Film)</span></p>
                <div class="container">
                    <p>A.<span class="">Upload Documents:</span></p>
                    <div class="container">
                        <div class='row'>
                            <div class='col-md-6'>
                                <p><span class="">(a) Authorisation Letter in Favour Of NFDC (FORM I.P.-11) in
                                        PDF:</span></p>
                            </div>
                            <div class='col-md-6'>
                                <p><span class="titleoffield-view-span">
                                        <a target="_blank" download
                                            href="{{ 'https://iffigoa.org/backend/api/downloadfile/dd/' . $ipForm->id . '/' . $documents->where('type', 5)->first()->file }}">
                                            {{ $documents->where('type', 5)->first()->name }}
                                        </a>
                                    </span></p>
                            </div>

                            <div class='col-md-6'>
                                <p><span class="">(b) Declaration Letter (As Per The Clause No 7.2(C)) in
                                        PDF:</span>
                                </p>
                            </div>
                            <div class='col-md-6'>
                                <p><span class="titleoffield-view-span">
                                        <a target="_blank" download
                                            href="{{ 'https://iffigoa.org/backend/api/downloadfile/dd/' . $ipForm->id . '/' . $documents->where('type', 6)->first()->file }}">
                                            {{ $documents->where('type', 6)->first()->name }}
                                        </a>
                                    </span></p>
                            </div>

                            <div class='col-md-6'>
                                <p><span class="">(c) Synopsis in English (Not Exceeding 200 Words) In
                                        PDF:</span>
                                </p>
                            </div>
                            <div class='col-md-6'>
                                <p><span class="titleoffield-view-span">
                                        <a target="_blank" download
                                            href="{{ 'https://iffigoa.org/backend/api/downloadfile/dd/' . $ipForm->id . '/' . $documents->where('type', 7)->first()->file }}">
                                            {{ $documents->where('type', 7)->first()->name }}
                                        </a>
                                    </span></p>
                            </div>

                            <div class='col-md-6'>
                                <p><span class="">(d) Director's Profile (Not Exceeding 100 words) & Note (Not
                                        Exceeding 30 words) In Doc Format:</span></p>
                            </div>
                            <div class='col-md-6'>
                                <p><span class="titleoffield-view-span">
                                        <a target="_blank" download
                                            href="{{ 'https://iffigoa.org/backend/api/downloadfile/dd/' . $ipForm->id . '/' . $documents->where('type', 8)->first()->file }}">
                                            {{ $documents->where('type', 8)->first()->name }}
                                        </a>
                                    </span></p>
                            </div>

                            <div class='col-md-6'>
                                <p><span class="">(e) Producer's Profile (Not Exceeding 100 words) In Doc
                                        Format:</span></p>
                            </div>
                            <div class='col-md-6'>
                                <p><span class="titleoffield-view-span">
                                        <a target="_blank" download
                                            href="{{ 'https://iffigoa.org/backend/api/downloadfile/dd/' . $ipForm->id . '/' . $documents->where('type', 9)->first()->file }}">
                                            {{ $documents->where('type', 9)->first()->name }}
                                        </a>
                                    </span></p>
                            </div>

                            <div class='col-md-6'>
                                <p><span class="">(f) Details Of Cast & Crew In Doc Format:</span></p>
                            </div>
                            <div class='col-md-6'>
                                <p><span class="titleoffield-view-span">

                                        <a target="_blank" download
                                            href="{{ 'https://iffigoa.org/backend/api/downloadfile/dd/' . $ipForm->id . '/' . $documents->where('type', 10)->first()->file }}">
                                            {{ $documents->where('type', 10)->first()->name }}
                                        </a>
                                    </span></p>
                            </div>
                        </div>
                    </div>

                    <p>B. Following must be mailed to <span
                            style="color: #AD4172; font-weight: 800;">indianpanorama@nfdcindia.com:</span></p>
                    <div class="container">
                        <div class='row'>
                            <div class='col-md-12'>
                                <p>A: Film stills (5 nos.), 200-300 dpi<sup class="text-danger">*</sup></p>
                                <p>B: Director(s) working stills (2 nos.), 200-300 dpi<sup class="text-danger">*</sup>
                                </p>
                                <p>C: Producer(s) still or logo, 200-300 dpi<sup class="text-danger">*</sup></p>
                                <p>D: Posters<sup class="text-danger">*</sup></p>
                            </div>
                            <div class="col-md-12">
                                <p><span class="">Whether the requisite documents -(A) (B) (C) & (D) are sent by
                                        email:</span> Yes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
