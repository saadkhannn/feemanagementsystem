<form action="{{ route('course-fees.update', $fee->id) }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group row">
    <div class="col-md-6">
      <label for="date"><strong>Date :</strong></label>
      <input type="date" class="form-control" name="date" id="date" value="{{ $fee->date }}">
    </div>
    <div class="col-md-6">
      <label for="fee"><strong>Fee :</strong></label>
      <input type="number" class="form-control text-right" name="fee" id="fee" value="{{ $fee->fee }}">
    </div>
  </div>
  <div class="form-group">
    <label for="decription"><strong>Description :</strong></label>
    <textarea name="decription" class="textarea">{{ $fee->decription }}</textarea>
  </div>
  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Update Course Fee</button>
</form>
<script type="text/javascript">
  $('textarea').summernote();
</script>
@include('layouts.crudFormJs')