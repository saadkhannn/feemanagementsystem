@php
	$button = (isset($status) ? $status : true);
	$edit = (isset($permission) && !auth()->user()->allPermissions([$permission.'-edit']) ? false : true);
	$delete = (isset($permission) && !auth()->user()->allPermissions([$permission.'-delete']) ? false : true);
@endphp
<div class="btn-group">
	@if($button)
		@if($object->status=="1")
			<a class="btn btn-sm btn-success"><i class="fa fa-check text-white"></i></a>
		@else
			<a class="btn btn-sm btn-danger"><i class="fa fa-ban text-white"></i></a>
		@endif
	@endif

	@if($edit)
		<a class="btn btn-sm btn-info" onclick="Show('Edit {{$text}}','{{ url($link.'/'.$object->id.'/edit') }}')"><i class="fa fa-edit text-white"></i></a>
	@endif

	@if($delete)
		<a class="btn btn-sm btn-danger" id="crud-delete-button-{{ $object->id }}" onclick="Delete('{{ $object->id }}','{{ url($link) }}')"><i class="fa fa-trash text-white"></i></a>
	@endif
</div>