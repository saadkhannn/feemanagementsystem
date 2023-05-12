@php
	$collections = \Modules\FeeManagement\Entities\BillCollection::whereHas('userBill.userCourse', function($query) use($user){
		return $query->where('user_id', $user->id);
	})->get();
@endphp
<table class="table table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Course</th>
			<th>Date</th>
			<th>Collection</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		@if($collections->count() > 0)
		@foreach($collections as $key => $collection)
		<tr>
			<td>{{ $key+1 }}</td>
			<td>{{ '['.$collection->userBill->userCourse->course->code.'] '.$collection->userBill->userCourse->course->name }}</td>
			<td>{{ $collection->date }}</td>
			<td class="text-right">{{ $collection->collection }}</td>
			<td>{{ $collection->description }}</td>
		</tr>
		@endforeach
		@endif

		<tr>
			<td colspan="3"><strong>Total</strong></td>
			<td class="text-right"><strong>{{ $collections->sum('collection') }}<strong></td>
			<td></td>
		</tr>
	</tbody>
</table>