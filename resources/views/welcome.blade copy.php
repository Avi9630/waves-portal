@extends('layouts.app')
@section('content')
<h1>Welcome To Waves Poartal</h1>
    {{-- @livewire('counter') --}}
    {{-- <div class="container-fluid">
        <div class="row">
            @if (Auth::user()->hasAnyRole(['SUPERADMIN', 'ADMIN'])) --}}
                {{-- Indian Panorama --}}
                {{-- <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">INDIAN PANORAMA (IP)</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-success text-success fs-17 rounded">
                                    <i class="ri-flag-2-line"></i>
                                </div>
                            </div>
                            <ul class="list-group border-none mb-1">

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total forms submitted</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">
                                                {{ isset($totalIpForms) && !empty($totalIpForms) ? $totalIpForms : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total featured</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">
                                                {{ isset($featuredIp) && !empty($featuredIp) ? $featuredIp : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total non-featured</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($nonFeaturedIp) && !empty($nonFeaturedIp) ? $nonFeaturedIp : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total paid </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($paidIpForms) && !empty($paidIpForms) ? $paidIpForms : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total featured paid </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($featureCount) && !empty($featureCount) ? $featureCount : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total non-featured paid </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">
                                                {{ isset($nonFeaturedCount) && !empty($nonFeaturedCount) ? $nonFeaturedCount : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div> --}}

                {{-- Best web series (OTT) Award etntries --}}
                {{-- <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">BEST WEB SERIES (OTT)</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-danger text-danger fs-17 rounded">
                                    <i class="ri-play-circle-line"></i>
                                </div>
                            </div>
                            <ul class="list-group border-none mb-1">
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total forms submitted</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">{{ $totalOttForms }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total paid forms</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">{{ $paidOttForms }}</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">DIRECTOR DEBUT (DD)</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-info text-info fs-17 rounded">
                                    <i class="ri-direction-line"></i>
                                </div>
                            </div>
                            <ul class="list-group border-none mb-1">
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total forms submitted</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">{{ $totalDdForms }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total paid forms</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">{{ $paidDdForms }}</span>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">CREATIVE MINDS OF TOMORROW (CMOT)</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-warning text-warning fs-17 rounded">
                                    <i class="ri-folder-user-line"></i>
                                </div>
                            </div>
                            <ul class="list-group border-none mb-1">
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total entries</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">{{ $totalEntries }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total completed</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">{{ $cmotCompleteForm }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total assigned to level-1</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">{{ $assignedToLevel1 }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Yet to assign</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">{{ $yetToAssign }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total pending by level-1</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">{{ $feedbackByLevel1 }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total assigned to level-2</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">{{ $assignedToLevel2 }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Feedback by level-2</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">{{ $feedbackByLevel2 }}</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->hasRole('CMOT-ADMIN'))
                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">CREATIVE MINDS OF TOMORROW (CMOT)</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-warning text-warning fs-17 rounded">
                                    <i class="ri-folder-user-line"></i>
                                </div>
                            </div>
                            <ul class="list-group border-none mb-1">
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total entries</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">{{ $totalEntries }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total completed</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="badge text-bg-primary">{{ $cmotCompleteForm }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total assigned to level-1</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">{{ $assignedToLevel1 }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Yet to assign</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">{{ $yetToAssign }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total pending by level-1</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">{{ $feedbackByLevel1 }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total assigned to level-2</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">{{ $assignedToLevel2 }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Feedback by level-2</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ">
                                            <span class="badge text-bg-primary">{{ $feedbackByLevel2 }}</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Level-1</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-info text-info fs-17 rounded">
                                    <i class="ri-direction-line"></i>
                                </div>
                            </div>
                            <ul class="list-group border-none mb-1">
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total assigned to level-1</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span
                                                class="badge text-bg-primary">{{ isset($assignedToLevel1) ? $assignedToLevel1 : '' }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Yet to assign</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span
                                                class="badge text-bg-primary">{{ isset($yetToAssign) ? $yetToAssign : '' }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Marks given by level-1</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span
                                                class="badge text-bg-primary">{{ isset($feedbackByLevel1) ? $feedbackByLevel1 : '' }}</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Level-2</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-warning text-warning fs-17 rounded">
                                    <i class="ri-folder-user-line"></i>
                                </div>
                            </div>
                            <ul class="list-group border-none mb-1">
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Total assigned to level-2</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span
                                                class="badge text-bg-primary">{{ isset($assignedToLevel2) ? $assignedToLevel2 : '' }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 ">
                                                    <h6 class="fs-14 mb-0">Marks given by level-2</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span
                                                class="badge text-bg-primary">{{ isset($feedbackByLevel2) ? $feedbackByLevel2 : '' }}</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Records by category</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                @foreach ($categoryCounts as $key => $value)
                                    <tbody>
                                        <tr>
                                            <td>
                                                {{ $key }} ---- {{ $value }}
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->hasAnyRole(['JURY', 'GRANDJURY']))
                <div class="text-center">
                    <h3>Welcome to the Portal of Creative Minds of Tomorrow's (CMOT) 4th Edition </h3>
                    <br><br>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="heding-content">
                                <p>An integral part of IFFI, Cmot is one of a kind talent development program that now
                                    serves as a
                                    platform to 100 creative minds from all across the country in 13 filmmaking
                                    disciplines.</p>
                                <p> Incase of any queries, feel free to reach out to <b>Mr.Neelabh <a
                                            href="tel:+91 8527668458">8527668458</a></b> </p>

                                <p>Alternatively, <br>you can reach out to <b>Ms. Ishika <a
                                            href="tel:+91 7982158039">7982158039</a></b>
                                    We are delighted to have you on board!</p>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 d-flex">
                    <div class="card card-animate w-100 ">
                        <div class="card-header">
                            <h4 class="card-title mb-0">CMOT</h4>
                        </div>
                        <div class="card-body">
                            <div class="avatar-sm mb-1">
                                <div class="avatar-title bg-soft-warning text-warning fs-17 rounded">
                                    <i class="ri-folder-user-line"></i>
                                </div>
                            </div>
                            <ul class="list-group border-none mb-1">
                                @if (Auth::user()->hasRole('JURY'))
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 ">
                                                        <h6 class="fs-14 mb-0">Total assigned entries</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <span
                                                    class="badge text-bg-primary">{{ count($totalAssignedToLevel1) }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 ">
                                                        <h6 class="fs-14 mb-0">Marks given</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <span
                                                    class="badge text-bg-primary">{{ count($marksGivenByLevel1) }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                                @if (Auth::user()->hasRole('GRANDJURY'))
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 ">
                                                        <h6 class="fs-14 mb-0">Total assigned entries</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <span
                                                    class="badge text-bg-primary">{{ count($totalAssignedToLevel2) }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 ">
                                                        <h6 class="fs-14 mb-0">Marks given</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <span
                                                    class="badge text-bg-primary">{{ count($marksGivenByLevel2) }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->hasAnyRole(['RECRUITER']))
                @include('pages.recruiter-profile')
            @else
                <h1>You don't have access to see this dashboard....</h1>
            @endif
        </div>
    </div> --}}
@endsection
