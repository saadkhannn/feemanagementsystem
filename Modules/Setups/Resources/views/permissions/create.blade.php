<form action="{{ route('permissions.store') }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <label for="module"><strong>Module :</strong></label>
    <select name="module" id="module" class="form-control select2bs4-tags">
      @if(isset($modules[0]))
      @foreach($modules as $key => $module)
      <option>{{ $module }}</option>
      @endforeach
      @endif
    </select>
  </div>
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name">
  </div>
  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Save Permission</button>
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