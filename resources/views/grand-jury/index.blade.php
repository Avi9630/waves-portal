@extends('layouts.app')
@section('content')
    <div class="container-fluid page-body-wrapper">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 stretch-card">
                    <div class="card">

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

                        <div class="card-header">
                            <h4 class="card-title">Assigned CMOT</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                @if (count($cmots) > 0)
                                    <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Film Craft</th>
                                            <th>Link to your Submission</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($cmots as $key => $cmot)
                                            <tr>
                                                <th> {{ $key + 1 }} </th>
                                                <td> {{ $cmot->name }} </td>
                                                <td> {{ $cmot->age($cmot->dob) ?? 'None' }} </td>
                                                <td> {{ $cmot->category->name ?? 'None' }} </td>
                                                <td> {{ $cmot->link_of_film }} </td>
                                                <td>
                                                    @foreach ($cmot->juryAssignments as $value)
                                                        @if ($value['active'] != 0)
                                                            <a href="{{ url('review_by_jury', $cmot->id) }}"
                                                                class="btn btn-sm btn-primary">Review</a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>

                                        @empty
                                            <td colspan="3">
                                                <span class="text-danger">
                                                    <strong>No Ip Application form submitted.!</strong>
                                                </span>
                                            </td>
                                        @endforelse
                                    </tbody>
                                @else
                                    <p>No record found...!!</p>
                                @endif
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">

                            {{-- {{ $ips->links() }} --}}
                            {{ $cmots->withQueryString()->links() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
