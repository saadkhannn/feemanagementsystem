<form action="{{ route('user-courses.update', $user->id) }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
@method('PUT')

  <div class="form-group">
    <label for="department_id"><strong>Department :</strong></label>
    <select name="department_id" id="department_id" class="form-control select2bs4">
      @if($departments->count() > 0)
      @foreach($departments as $key => $department)
        <option value="{{ $department->id }}" {{ $user->departments->where('department_id', $department->id)->count() > 0 ? 'selected' : '' }}>[{{ $department->code }}] {{ $department->name }}</option>
      @endforeach
      @endif
    </select>
  </div>

  <div class="form-group">
    <label for="courses"><strong>Courses :</strong></label>
    <select name="courses[]" id="courses" class="form-control select2bs4" multiple>
      @if($courses->count() > 0)
      @foreach($courses as $key => $course)
        <option value="{{ $course->id }}" {{ $user->courses->where('course_id', $course->id)->count() > 0 ? 'selected' : '' }}>[{{ $course->code }}] {{ $course->name }}</option>
      @endforeach
      @endif
    </select>
  </div>

  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Update User Courses</button>
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