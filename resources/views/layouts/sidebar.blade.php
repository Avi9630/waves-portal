<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box bg-logo">
        <!-- Dark Logo-->
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('public/admin-iffi/images/nfdc-logo.png') }}" alt="" class="img-fluid"
                style=" width:110px">
        </a>
        <!-- Light Logo-->
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav mt-4" id="navbar-nav">
                @if (Route::has('login'))
                    @auth

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/') }}">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">DASHBOARD</span>
                            </a>
                        </li>

                        @can('list-user')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarUser" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarUser">
                                    <i class="ri-user-2-line"></i> <span data-key="">USERS</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarUser">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('users.index') }}" class="nav-link" data-key="">LIST
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('list-role')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarRole" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarRole">
                                    <i class="ri-user-follow-line"></i> <span data-key="">ROLE</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarRole">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('roles.index') }}" class="nav-link" data-key="">LIST
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('list-permission')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#Permission" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="Permission">
                                    <i class="ri-lock-2-line"></i> <span data-key="">PERMISSION</span>
                                </a>
                                <div class="collapse menu-dropdown" id="Permission">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('permissions.index') }}" class="nav-link" data-key="">
                                                LIST </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('list-ip')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#indianPanoroma" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="indianPanoroma">
                                    <i class="ri-flag-2-line"></i> <span data-key="">INDIAN PANORAMA</span>
                                </a>
                                <div class="collapse menu-dropdown" id="indianPanoroma">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('ips.index') }}" class="nav-link" data-key="">LIST</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('list-ott')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#ott" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="ott">
                                    <i class="ri-play-circle-line"></i> <span data-key="">OTT</span>
                                </a>
                                <div class="collapse menu-dropdown" id="ott">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('otts.index') }}" class="nav-link" data-key="">LIST
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('list-cmot')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#CMOT" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="CMOT">
                                    <i class="ri-folder-user-line"></i> <span data-key="">CMOT</span>
                                </a>
                                <div class="collapse menu-dropdown" id="CMOT">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('cmots.index') }}" class="nav-link" data-key="">LIST
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('list-dd')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#DirectDebut" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="DirectDebut">
                                    <i class="ri-direction-line"></i> <span data-key="">DIRECTOR DEBUTE</span>
                                </a>
                                <div class="collapse menu-dropdown" id="DirectDebut">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('dds.index') }}" class="nav-link" data-key="">LIST</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('master-list')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#Alumanis" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="Alumanis">
                                    <i class="ri-lightbulb-flash-line"></i> <span data-key="">ALUMNI</span>
                                </a>
                                <div class="collapse menu-dropdown" id="Alumanis">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('alumnis.index') }}" class="nav-link" data-key=""> MASTER LIST </a>
                                        </li>

                                        @can('recruiter-selected')
                                            <li class="nav-item">
                                                <a href="{{ route('selected-list') }}" class="nav-link" data-key="">MY SELECTION</a>
                                            </li>
                                        @endcan

                                        @can('recruiter-rejected')
                                            <li class="nav-item">
                                                <a href="{{ route('rejected-list') }}" class="nav-link" data-key="">MY REJECTION</a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @can('cmot-participants-2024')
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#CMOTParticipant" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="CMOTParticipant">
                                    <i class="ri-stack-line"></i> <span data-key="">2024 CMOT PARTICIPANTS
                                    </span>
                                </a>
                                <div class="collapse menu-dropdown" id="CMOTParticipant">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('cmot-participants.index') }}" class="nav-link"
                                                data-key=""> MASTER LIST </a>
                                        </li>

                                        @can('recruiter-selected')
                                            <li class="nav-item">
                                                <a href="{{ route('cmot-participant-selected-list') }}" class="nav-link"
                                                    data-key=""> MY SELECTION </a>
                                            </li>
                                        @endcan

                                        @can('recruiter-rejected')
                                            <li class="nav-item">
                                                <a href="{{ route('cmot-participant-rejected-list') }}" class="nav-link"
                                                    data-key="">MY REJECTION </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </li>
                        @endcan
                    @else
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/') }}">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">DASHBOARD</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route('login') }}">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">LOGIN</span>
                            </a>
                        </li>
                    @endauth
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>

<div class="vertical-overlay"></div>
