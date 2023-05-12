@extends('layouts.index')

@section('content')
<div class="row">
	<div class="col-md-6 offset-md-3">
		<div class="card card-info">
			<div class="card-header">
				<h5 style="margin-bottom: 0px !important"><strong>Update Image</strong></h5>
			</div>
			<div class="card-body">
				<form action="{{ route('my-image.store') }}" method="post" enctype="multipart/form-data">
				  @csrf
				  <div class="form-group">
				    <label for="file"><strong>Choose Image</strong></label>
				    <input type="file" name="file" id="file" class="form-control">
				  </div>
				  <button class="btn btn-success"><i class="fa fa-upload"></i>&nbsp;Upload Image</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection