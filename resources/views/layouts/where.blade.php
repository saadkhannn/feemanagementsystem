@php
	$url = this_url();
	$links = explode('/',$url);
@endphp
@php
	$getModule = getModule($links[0]);
@endphp
@if(isset($links[0]) && $getModule)
	<li class="breadcrumb-item">{{$getModule->name}}</li>
@endif

@if(isset($links[1]))
	@php
		$getMenu = getMenu($links[1]);
		$getSubmenu = getSubmenu($links[1]);
	@endphp
	@if($getMenu)
		<li class="breadcrumb-item active"><a href="{{ url($links[0].'/'.$links[1]) }}">{{$getMenu->name}}</a></li>
	@elseif($getSubmenu)
		<li class="breadcrumb-item">{{$getSubmenu->menu->name}}</li>
		<li class="breadcrumb-item active"><a href="{{ url($links[0].'/'.$links[1]) }}">{{$getSubmenu->name}}</a></li>
	@endif
@endif