<form action="{{ route('courses.update', $course->id) }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="code"><strong>Code :</strong></label>
    <input type="text" class="form-control" name="code" id="code" value="{{$course->code}}">
  </div>
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name" value="{{$course->name}}">
  </div>
  <div class="form-group">
    <label for="description"><strong>Description :</strong></label>
    <textarea name="description" class="textarea">{{$course->description}}</textarea>
  </div>

  @include('layouts.status', ['status' => $course->status])
  
  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Update Course</button>
</form>
<script type="text/javascript">
  $('textarea').summernote();
</script>
@include('layouts.crudFormJs')