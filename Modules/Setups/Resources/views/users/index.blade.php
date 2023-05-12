@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Users</strong>

            @if(auth()->user()->allPermissions(['role-management-user-delete']))
               <a class="btn btn-success btn-sm" style="float: right" href="{{ url('setups/users/create') }}"><i class=" fa fa-plus"></i>&nbsp;New User</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        @include('yajra.datatable')
    </div>
</div>
@endsection