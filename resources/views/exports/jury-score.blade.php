@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">Jury Marks</div>
        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Users</h4>
                    </div>
                    <div class="card-body">
                        {{-- @can('create-user')
                            <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">Create User</a><br><br>
                        @endcan --}}
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

                        <table class="table table-bordered">
                            @if (count($users) > 0)
                                <thead>
                                    <tr>
                                        <th scope="col">Sr.Nom</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Roles</th>
                                        <th scope="col" width="280px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $key => $user)
                                        <tr>
                                            <th> {{ $user->id }} </th>

                                            <td> {{ $user['name'] }} </td>

                                            <td> {{ $user['email'] }} </td>

                                            <td> {{ $user['mobile'] }} </td>

                                            <td>
                                                @if ($user->getRoleNames()->isEmpty())
                                                    @can('assign-role')
                                                        <a href="{{ url('assign_role', $user->id) }}"
                                                            class="btn btn-sm btn-success">ASSIGN-ROLE</a>
                                                    @endcan
                                                @else
                                                    {{-- {{ $user->getRoleNames() }} --}}
                                                    {{ $user->getRoleNames()->implode('", "') }}
                                                @endif
                                            </td>
                                            <td>
                                                {{-- @can('view-user')
                                                    <a class="btn btn-sm btn-info"
                                                        href="{{ route('users.show', $user->id) }}">View</a>
                                                @endcan --}}

                                                @can('edit-user')
                                                    <a class="btn btn-sm btn-info"
                                                        href="{{ route('users.edit', $user->id) }}">Edit</a>
                                                @endcan

                                                @can('delete-user')
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="post"
                                                        style="display: inline" onsubmit="return confirmDelete()">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                @endcan
                                            </td>

                                        </tr>

                                    @empty

                                        <td colspan="3">
                                            <span class="text-danger">
                                                <strong>No User Found!</strong>
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
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
