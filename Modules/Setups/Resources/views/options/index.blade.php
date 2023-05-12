@extends('layouts.index')

@section('content')
<div class="card" style="margin-bottom: 25px;">
    <div class="card-header bg-info text-white" style="cursor: pointer;">
        <h4>
        	<strong>Options</strong>

            @if(auth()->user()->allPermissions(['system-settings-options-create']))
        	   <a class="btn btn-success btn-sm" style="float: right" onclick="Show('New Option','{{ url('setups/options/create') }}')"><i class=" fa fa-plus"></i>&nbsp;New Option</a>
            @endif
        </h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>ID</th>
                    <th>Module</th>
                    <th>Menu</th>
                    <th>Submenu</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(isset($options[0]))
            @foreach($options as $key => $option)
                <tr id="tr-{{ $option->id }}">
                    <td style="width: 2%">{{ $key+1 }}</td>
                    <td>{{$option->id}}</td>
                    <td>{{$option->menu->module->name}}</td>
                    <td>{{$option->menu->name}}</td>
                    <td>{{$option->submenu ? $option->submenu->name : ''}}</td>
                    <td>{{$option->name}}</td>
                    <td>{!! $option->desc !!}</td>
                    <td class="text-center" style="width: 15%">
                        @include('layouts.crudButtons',[
                            'text' => 'Option',
                            'object' => $option,
                            'link' => 'setups/options'
                        ])
                    </td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
@endsection