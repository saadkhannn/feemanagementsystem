@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Course Fees</strong>

            @if(auth()->user()->allPermissions(['course-fees-create']))
               <a class="btn btn-success btn-sm" style="float: right" onclick="Show('New Course Fee','{{ url('fee-management/course-fees/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Course Fee</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        @include('yajra.datatable')
    </div>
</div>
@endsection