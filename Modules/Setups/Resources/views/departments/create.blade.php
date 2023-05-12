<form action="{{ route('departments.store') }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <label for="code"><strong>Code :</strong></label>
    <input type="text" class="form-control" name="code" id="code">
  </div>
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name">
  </div>
  <div class="form-group">
    <label for="decription"><strong>Description :</strong></label>
    <textarea name="decription" class="textarea"></textarea>
  </div>
  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Save Department</button>
</form>
<script type="text/javascript">
  $('textarea').summernote();
</script>
@include('layouts.crudFormJs')