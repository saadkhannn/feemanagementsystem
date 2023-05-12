<form action="{{ route('roles.store') }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name">
  </div>
  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Save Role</button>
</form>
@include('layouts.crudFormJs')