@if(auth()->user()->allPermissions(['update-user-courses']))
  <a class="btn btn-sm btn-info text-white" onclick="Show('Update Courses for {{ $user->first_name.' '.$user->last_name  }}','{{ url('fee-management/user-courses/'.$user->id.'/edit') }}')"><i class="fa fa-edit text-white"></i>&nbsp;Update Courses</a>
@endif