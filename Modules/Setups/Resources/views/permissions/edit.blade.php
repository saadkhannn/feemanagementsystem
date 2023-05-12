<form action="{{ route('permissions.update',$permission->id) }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="module"><strong>Module :</strong></label>
    <select name="module" id="module" class="form-control select2bs4-tags">
      @if(isset($modules[0]))
      @foreach($modules as $key => $module)
      <option {{ $permission->module == $module ? 'selected' : '' }}>{{ $module }}</option>
      @endforeach
      @endif
    </select>
  </div>
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name" value="{{$permission->name}}">
  </div>
  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Update Permission</button>
</form>

<script type="text/javascript">
  $(".select2bs4-tags").each(function() {
    $(this).select2({
      tags: true,
      theme: "bootstrap4",
      dropdownParent: $('#modal').parent()
    });
  });
</script>
@include('layouts.crudFormJs')