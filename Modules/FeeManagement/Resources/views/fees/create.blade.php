<form action="{{ route('course-fees.store') }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <label for="course_id"><strong>Course :</strong></label>
    <select name="course_id" class="form-control select2bs4">
      @if(isset($courses[0]))
      @foreach ($courses as $key => $course)
        <option value="{{$course->id}}">[{{$course->code}}] {{$course->name}}</option>
      @endforeach
      @endif
    </select>
  </div>
  <div class="form-group row">
    <div class="col-md-6">
      <label for="date"><strong>Date :</strong></label>
      <input type="date" class="form-control" name="date" id="date" value="{{ date('Y-m-d') }}">
    </div>
    <div class="col-md-6">
      <label for="fee"><strong>Fee :</strong></label>
      <input type="number" class="form-control text-right" name="fee" id="fee" value="0">
    </div>
  </div>
  <div class="form-group">
    <label for="decription"><strong>Description :</strong></label>
    <textarea name="decription" class="textarea"></textarea>
  </div>
  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Save Course Fee</button>
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