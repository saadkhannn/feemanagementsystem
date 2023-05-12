@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Student Bills</strong>

            @if(auth()->user()->allPermissions(['user-bills-create']))
               <a class="btn btn-success btn-sm" style="float: right" onclick="Show('Generate Student Bill','{{ url('fee-management/user-bills/create') }}')"><i class=" fa fa-plus"></i>&nbsp;Generate Student Bill</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        @include('yajra.datatable')
    </div>
</div>
@endsection