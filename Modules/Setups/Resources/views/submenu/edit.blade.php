<form action="{{ route('submenu.update',$submenu->id) }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group row">
    <div class="col-md-3">
      <label for="serial"><strong>Serial :</strong></label>
      <input type="number" class="form-control" name="serial" id="serial" value="{{$submenu->serial}}">
    </div>
    <div class="col-md-4">
      <label for="edit_module_id"><strong>Module :</strong></label>
      <select name="module_id" class="form-control select2bs4" id="edit_module_id" onchange="getCreateMenu()">
        @if(isset($modules[0]))
        @foreach ($modules as $key => $module)
          <option value="{{$module->id}}" @if($submenu->menu->module_id==$module->id) selected @endif>{{$module->name}}</option>
        @endforeach
        @endif
      </select>
    </div>
    <div class="col-md-5">
      <label for="edit_menu_id"><strong>Menu :</strong></label>
      <select name="menu_id" class="form-control select2bs4" id="edit_menu_id">
        @if(isset($submenu->menu->module->menu[0]))
        @foreach ($submenu->menu->module->menu as $key => $menu)
          <option value="{{$menu->id}}" @if($submenu->menu_id==$menu->id) selected @endif>{{$menu->name}}</option>
        @endforeach
        @endif
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name" value="{{$submenu->name}}">
  </div>
  <div class="form-group row">
    <div class="col-md-6">
      <label for="route"><strong>Route :</strong></label>
      <input type="text" class="form-control" name="route" id="route" value={{$submenu->route}}>
    </div>
    <div class="col-md-6">
      <label for="icon"><strong>Icon :</strong></label>
      <input type="text" class="form-control" name="icon" id="icon" value="{{$submenu->icon}}">
    </div>
  </div>
  <div class="form-group">
    <label for="permissions"><strong>Permissions :</strong></label>
    <select name="permissions[]" id="permissions" class="form-control select2bs4" multiple>
      @if($permissions->count() > 0)
      @foreach($permissions as $key => $permission)
      <option value="{{ $permission->id }}" {{ $submenu->permissions->where('permission_id', $permission->id)->count() > 0 ? 'selected' : '' }}>{{ $permission->name }}</option>
      @endforeach
      @endif
    </select>
  </div>
  <div class="form-group">
    <label for="desc"><strong>Description :</strong></label>
    <textarea name="desc" class="textarea">{{$submenu->desc}}</textarea>
  </div>
  
  @include('layouts.status', ['status' => $submenu->status])

  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Update Submenu</button>
</form>
<script type="text/javascript">
  $('textarea').summernote();
  $(".select2bs4").each(function() {
    $(this).select2({
      theme: "bootstrap4",
      dropdownParent: $(this).parent()
    });
  });
  
  function getCreateMenu(){
    $.ajax({
      url: "{{url('setups/submenu')}}/"+$('#edit_module_id').val()+"/get-menu",
      type: 'GET',
      dataType: 'json',
      data: {},
    })
    .done(function(response) {
      var menu='';
      $.each(response, function(index, val) {
        menu+='<option value="'+val.id+'">'+val.name+'</option>';
      });
      $('#edit_menu_id').html(menu);
    })
    .fail(function() {
      $('#edit_menu_id').html('');
    });
  }
</script>
@include('layouts.crudFormJs')