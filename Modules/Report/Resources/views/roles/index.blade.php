@extends('layouts.index')
@section('content')
@include('dashboard::filter', [
	'url' => 'report/role-report',
    'report' => true,
    'permission' => 'role-report'
])
@endsection
