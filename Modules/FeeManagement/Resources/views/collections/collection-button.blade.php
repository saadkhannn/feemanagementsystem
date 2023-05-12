@php
	$collections = \Modules\FeeManagement\Entities\BillCollection::whereHas('userBill.userCourse', function($query) use($user){
		return $query->where('user_id', $user->id);
	})->sum('collection');
@endphp
<a class="btn btn-sm btn-info text-white" onclick="Show('Student Collections for #{{ $user->first_name.' '.$user->last_name }}','{{ url('fee-management/fee-collections/'.$user->id.'?page=collections') }}')">{{ $collections }}</a>