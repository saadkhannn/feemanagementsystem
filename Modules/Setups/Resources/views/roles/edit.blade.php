<form action="{{ route('roles.update',$role->id) }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="name"><strong>Name :</strong></label>
    <input type="text" class="form-control" name="name" id="name" value="{{$role->name}}">
  </div>
  <button type="submit" class="btn btn-primary crud-button"><i class="fa fa-save"></i>&nbsp; Update Role</button>
</form>
@include('layouts.crudFormJs')