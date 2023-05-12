@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Menu</strong>

            @if(auth()->user()->allPermissions(['system-settings-menu-create']))
        	   <a class="btn btn-success btn-sm" style="float: right" onclick="Show('New Menu','{{ url('setups/menu/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Menu</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        @include('yajra.datatable')
    </div>
</div>
@endsection