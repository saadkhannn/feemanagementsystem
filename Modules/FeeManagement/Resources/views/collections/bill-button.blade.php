@php
	$bills = \Modules\FeeManagement\Entities\UserBill::whereHas('userCourse', function($query) use($user){
		return $query->where('user_id', $user->id);
	})->sum('fee');
@endphp
<a class="btn btn-sm btn-info text-white" onclick="Show('Student Bills for #{{ $user->first_name.' '.$user->last_name }}','{{ url('fee-management/fee-collections/'.$user->id.'?page=bills') }}')">{{ $bills }}</a>