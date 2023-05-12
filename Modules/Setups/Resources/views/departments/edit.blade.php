<form action="{{ route('departments.update', $department->id) }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="code"><strong>Code :</strong></label>
    <input type="text" class="form-control" name="code" id="code" value="{{$department->code}}">
  </div>
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name" value="{{$department->name}}">
  </div>
  <div class="form-group">
    <label for="description"><strong>Description :</strong></label>
    <textarea name="description" class="textarea">{{$department->description}}</textarea>
  </div>

  @include('layouts.status', ['status' => $department->status])
  
  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Update Department</button>
</form>
<script type="text/javascript">
  $('textarea').summernote();
</script>
@include('layouts.crudFormJs')