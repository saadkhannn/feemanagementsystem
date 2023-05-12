<form action="{{ route('menu.store') }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
  <div class="form-group row">
    <div class="col-md-3">
      <label for="serial"><strong>Serial :</strong></label>
      <input type="number" class="form-control" name="serial" id="serial">
    </div>
    <div class="col-md-9">
      <label for="module_id"><strong>Module :</strong></label>
      <select name="module_id" class="form-control select2bs4">
        @if(isset($modules[0]))
        @foreach ($modules as $key => $module)
          <option value="{{$module->id}}">{{$module->name}}</option>
        @endforeach
        @endif
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name">
  </div>
  <div class="form-group row">
    <div class="col-md-6">
      <label for="route"><strong>Route :</strong></label>
      <input type="text" class="form-control" name="route" id="route">
    </div>
    <div class="col-md-6">
      <label for="icon"><strong>Icon :</strong></label>
      <input type="text" class="form-control" name="icon" id="icon">
    </div>
  </div>
  <div class="form-group">
    <label for="permissions"><strong>Permissions :</strong></label>
    <select name="permissions[]" id="permissions" class="form-control select2bs4" multiple>
      @if($permissions->count() > 0)
      @foreach($permissions as $key => $permission)
      <option value="{{ $permission->id }}">{{ $permission->name }}</option>
      @endforeach
      @endif
    </select>
  </div>
  <div class="form-group">
    <label for="desc"><strong>Description :</strong></label>
    <textarea name="desc" class="textarea"></textarea>
  </div>
  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Save Menu</button>
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