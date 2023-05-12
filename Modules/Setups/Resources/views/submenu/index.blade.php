@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Submenu</strong>

            @if(auth()->user()->allPermissions(['system-settings-submenu-create']))
        	   <a class="btn btn-success btn-sm" style="float: right" onclick="Show('New Submenu','{{ url('setups/submenu/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Submenu</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
       @include('yajra.datatable')
    </div>
</div>
@endsection