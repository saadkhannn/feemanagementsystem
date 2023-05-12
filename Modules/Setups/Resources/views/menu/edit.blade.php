<form action="{{ route('menu.update',$menu->id) }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group row">
    <div class="col-md-3">
      <label for="serial"><strong>Serial :</strong></label>
      <input type="number" class="form-control" name="serial" id="serial" value="{{$menu->serial}}">
    </div>
    <div class="col-md-9">
      <label for="module_id"><strong>Module :</strong></label>
      <select name="module_id" class="form-control select2bs4">
        @if(isset($modules[0]))
        @foreach ($modules as $key => $module)
          <option value="{{$module->id}}" @if($module->id==$menu->module_id) selected @endif>{{$module->name}}</option>
        @endforeach
        @endif
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name" value="{{$menu->name}}">
  </div>
  <div class="form-group row">
    <div class="col-md-6">
      <label for="route"><strong>Route :</strong></label>
      <input type="text" class="form-control" name="route" id="route" value={{$menu->route}}>
    </div>
    <div class="col-md-6">
      <label for="icon"><strong>Icon :</strong></label>
      <input type="text" class="form-control" name="icon" id="icon" value="{{$menu->icon}}">
    </div>
  </div>
  <div class="form-group">
    <label for="permissions"><strong>Permissions :</strong></label>
    <select name="permissions[]" id="permissions" class="form-control select2bs4" multiple>
      @if($permissions->count() > 0)
      @foreach($permissions as $key => $permission)
      <option value="{{ $permission->id }}" {{ $menu->permissions->where('permission_id', $permission->id)->count() > 0 ? 'selected' : '' }}>{{ $permission->name }}</option>
      @endforeach
      @endif
    </select>
  </div>
  <div class="form-group">
    <label for="desc"><strong>Description :</strong></label>
    <textarea name="desc" class="textarea">{{$menu->desc}}</textarea>
  </div>
  
  @include('layouts.status', ['status' => $menu->status])

  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Update Menu</button>
</form>
<script type="text/javascript">
  $('textarea').summernote();
  $(".select2bs4").each(function() {
    $(this).select2({
      theme: "bootstrap4",
      dropdownParent: $(this).parent()
    });
  });
</script>
@include('layouts.crudFormJs')