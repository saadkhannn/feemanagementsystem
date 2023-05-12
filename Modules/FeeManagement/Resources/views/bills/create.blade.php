<form action="{{ route('user-bills.store') }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
  <div class="form-group row">
    <div class="col-md-7">
      <label for="user_id"><strong>Student :</strong></label>
      <select name="user_id" id="user_id" class="form-control select2bs4" onchange="getBills()">
        @if(isset($students[0]))
        @foreach ($students as $key => $student)
          <option value="{{$student->id}}">{{$student->first_name}} {{$student->last_name}}</option>
        @endforeach
        @endif
      </select>
    </div>
    <div class="col-md-5">
      <label for="deadline"><strong>Deadline :</strong></label>
      <input type="date" name="deadline" id="deadline" value="{{ date('Y-m-d') }}" onchange="getBills()" class="form-control">
    </div>
  </div>
  <div class="form-group bills">

  </div>
  <div class="form-group">
    <label for="decription"><strong>Description :</strong></label>
    <textarea name="decription" class="textarea"></textarea>
  </div>
  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Create Student Bill</button>
</form>
<script type="text/javascript">
  $('textarea').summernote();
  $(".select2bs4").each(function() {
    $(this).select2({
      theme: "bootstrap4",
      dropdownParent: $(this).parent()
    });
  });

  getBills();
  function getBills() {
    $('.bills').html('<h5 class="text-center">Please wait...</h5>');
    $.ajax({
      url: "{{ url('fee-management/user-bills/create') }}?user_id="+$('#user_id').val()+"&deadline="+$('#deadline').val(),
      type: 'GET',
      data: {},
    })
    .done(function(response) {
      $('.bills').html(response);
    });
  }
</script>
@include('layouts.crudFormJs')