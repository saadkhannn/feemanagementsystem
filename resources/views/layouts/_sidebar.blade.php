<a href="{{ url('/') }}" class="brand-link">
  <img src="{{ url('system-images/logos/'.session()->get('system-information')->logo) }}" class="brand-image">
  <h5>&nbsp;&nbsp;<strong>{{ session()->get('system-information')->name }}</strong></h5>
</a>

<div class="sidebar">
    <nav class="mt-2">
	  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
	  @php
	  	$user_permissions = auth()->user()->getAllPermissions()->pluck('id')->toArray();
	  	$user_menus = \Modules\Setups\Entities\Menu::whereHas('permissions', function($query) use($user_permissions){
	  		return $query->whereIn('permission_id', $user_permissions);
	  	})->pluck('id')->toArray();
	  	$user_submenus = \Modules\Setups\Entities\Submenu::whereHas('permissions', function($query) use($user_permissions){
	  		return $query->whereIn('permission_id', $user_permissions);
	  	})->pluck('id')->toArray();

    	$modules = \Modules\Setups\Entities\Module::where('status', 1)
      	->with([
      		'menu.submenu'
      	])
      	->where(function($query) use($user_menus, $user_submenus){
      		return $query->whereHas('menu', function($query) use($user_menus){
	      		return $query->whereIn('id', $user_menus);
	      	})
	      	->orWhereHas('menu.submenu', function($query) use($user_submenus){
	      		return $query->whereIn('id', $user_submenus);
	      	});
      	})
		->orderBy('serial','asc')
		->orderBy('name','asc')
		->get();
	  @endphp

	  @if($modules && isset($modules[0]))
	  @foreach ($modules as $key => $module)
	    <li class="nav-item has-treeview modules" data-route="{{ $module->route }}">
	      <a style="cursor: pointer;color: white" class="nav-link">
	        <i class="nav-icon {{(!empty($module->icon) ? $module->icon : 'fas fa-chart-pie')}}"></i>
	        <p>
	          {{$module->name}}
	          <i class="right fas fa-angle-left"></i>
	        </p>
	      </a>
	      @if($module->menu->whereIn('id', $user_menus)->count() > 0)
	      <ul class="nav nav-treeview">
	        @foreach ($module->menu->whereIn('id', $user_menus)->sortBy('serial') as $key => $menu)
	          <li class="nav-item {{(isset($menu->submenu[0])) ? 'has-treeview' : ''}} menus" data-route="{{ $menu->route }}">
	          <a @if($menu->route!='#') data-href="{{url('/'.$module->route.'/'.$menu->route)}}" @endif style="cursor: pointer;" class="nav-link one-pager">
	          	&nbsp;&nbsp;
	            <i class="nav-icon {{(!empty($menu->icon) ? $menu->icon : 'far fa-circle')}}"></i>
	            <p>
	              {{$menu->name}}
	              {!! $menu->submenu->count() > 0 ? '<i class="right fas fa-angle-left"></i>' : '' !!}
	            </p>
	          </a>
	          @if($menu->submenu->whereIn('id', $user_submenus)->count() > 0)
	          <ul class="nav nav-treeview">
	            @foreach ($menu->submenu->whereIn('id', $user_submenus)->sortBy('serial') as $key => $submenu)
	              <li class="nav-item submenus" data-route="{{ $submenu->route }}">
	              <a style="cursor: pointer" data-href="{{url('/'.$module->route.'/'.$submenu->route)}}" class="nav-link one-pager">
	              	&nbsp;&nbsp;&nbsp;&nbsp;
	                <i class="nav-icon {{(!empty($submenu->icon) ? $submenu->icon : 'far fa-dot-circle')}}"></i>
	                <p>{{$submenu->name}}</p>
	              </a>
	            </li>
	            @endforeach
	          </ul>
	          @endif
	        </li>
	        @endforeach
	      </ul>
	      @endif
	    </li>
	  @endforeach
	  @endif
	    
	  </ul>
	</nav>
</div>