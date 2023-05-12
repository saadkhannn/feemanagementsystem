@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Roles</strong>

            @if(auth()->user()->allPermissions(['role-management-roles-create']))
        	   <a class="btn btn-success btn-sm" style="float: right" onclick="Show('New Role','{{ url('setups/roles/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Role</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        @include('yajra.datatable')
    </div>
</div>
@endsection