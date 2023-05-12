@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Permissions</strong>

            @if(auth()->user()->allPermissions(['role-management-permissions-create']))
        	   <a class="btn btn-success btn-sm" style="float: right" onclick="Show('New Permission','{{ url('setups/permissions/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Permission</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        @include('yajra.datatable')
    </div>
</div>
@endsection