@php
	$bills = \Modules\FeeManagement\Entities\UserBill::whereHas('userCourse', function($query) use($user){
		return $query->where('user_id', $user->id);
	})->get();
@endphp
<table class="table table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Course</th>
			<th>Deadline</th>
			<th>Fee</th>
			<th>Collections</th>
			<th>Due</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		@php
			$collections = 0;
		@endphp
		@if($bills->count() > 0)
		@foreach($bills as $key => $bill)
		@php
			$collection = $bill->billCollections->sum('collection');
			$collections += $collection;
		@endphp
		<tr>
			<td>{{ $key+1 }}</td>
			<td>{{ '['.$bill->userCourse->course->code.'] '.$bill->userCourse->course->name }}</td>
			<td>{{ $bill->deadline }}</td>
			<td class="text-right">{{ $bill->fee }}</td>
			<td class="text-right">{{ $collection }}</td>
      		<td class="text-right">{{ $bill->fee-$collection }}</td>
			<td>{{ $bill->description }}</td>
		</tr>
		@endforeach
		@endif

		<tr>
			<td colspan="3"><strong>Total</strong></td>
			<td class="text-right"><strong>{{ $bills->sum('fee') }}<strong></td>
			<td class="text-right"><strong>{{ $collections }}<strong></td>
			<td class="text-right"><strong>{{ $bills->sum('fee')-$collections }}<strong></td>
			<td></td>
		</tr>
	</tbody>
</table>