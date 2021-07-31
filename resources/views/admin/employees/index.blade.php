@extends('admin.layout') @section('title', __('Employees')) @section('titleSup',
__('Employees')) @section('explorer')
<li class="breadcrumb-item active">
    {{ __("Employees") }}
</li>
@endsection @section('content')
<div class="content" style="text-align: center;">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">{{ __("Employees list") }}</h1>
            @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2 ||
            auth()->user()->role_id == 3)
            <div class="float-end">
                <a href="{{ route('employees.create') }}"
                    ><button class="btn btn-dark" type="button">
                        <i class="fas fa-user-plus"></i></button
                ></a>
            </div>
            @endif
        </div>
        <div class="card-body">
            <table
                class="table table-striped"
                style="width:100%"
                id="tableEmployee"
            >
                <thead>
                    <tr>
                        <th>
                            {{ __("ID") }}
                        </th>
                        <th>
                            {{ __("Imagen") }}
                        </th>
                        <th>
                            {{ __("Name") }}
                        </th>
                        <th>
                            {{ __("Status") }}
                        </th>
                        <th>
                            {{ __("Employee Type") }}
                        </th>
                        @if(auth()->user()->role_id == 1 ||
                        auth()->user()->role_id == 2 || auth()->user()->role_id
                        == 3)
                        <th>
                            {{ __("Actions") }}
                        </th>

                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td id="content-id">
                            {{ $user->id }}
                        </td>
                        <td>
                            @if($user->img !== null)
                            <div class="d-flex justify-content-center">
                                <div class="image-product">
                                    <img
                                        src="{{$user->link}}{{$user->img}}"
                                        alt="{{$user->name}}"
                                        class="img-circle elevation-2"
                                        id="imgProduct"
                                    />
                                </div>
                            </div>
                            @else
                            <div class="d-flex justify-content-center">
                                <div class="image-product">
                                    <img
                                        src="/adminlte/img/users/default.png"
                                        alt="{{$user->name}}"
                                        class="img-circle elevation-2"
                                        id="imgProduct"
                                    />
                                </div>
                            </div>
                            @endif
                        </td>
                        <td id="content-name">
                            {{ $user->name }}
                        </td>
                        <td id="content-status">
                            @if($user->employee_state_id == 1)

                            <span class="right badge badge-success"
                                >Activo</span
                            >

                            @else @if($user->employee_state_id == 2)

                            <span class="right badge badge-danger"
                                >Inactivo</span
                            >
                            @endif @endif
                        </td>
                        <td id="content-rol">
                            {{ $user->role->name }}
                        </td>
                        @if(auth()->user()->role_id == 1 ||
                        auth()->user()->role_id == 2 || auth()->user()->role_id
                        == 3)
                        <td id="actions">
                            <a
                                href="{{ route('employees.edit', $user) }}"
                                class="mg-10"
                            >
                                <i id="IconE" class="fas fa-pencil-alt"></i>
                            </a>
                            <a
                                class="mg-10"
                                onclick="DeleteUser('{{$user->id}}', '{{$user->name}}')"
                            >
                                <i id="IconD" class="fas fa-trash-alt"></i>
                            </a>
                            <a
                                onclick="ShowInfoUser('{{$user->id}}')"
                                data-bs-toggle="modal"
                                data-bs-whatever="@fat"
                                class="mg-10-1"
                            >
                                <i id="IconS" class="fas fa-eye"></i>
                            </a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="/adminlte/js/employees/ShowUser.js"></script>
<script src="/adminlte/js/employees/DeleteUser.js"></script>
@include('admin.employees.show') @endsection
