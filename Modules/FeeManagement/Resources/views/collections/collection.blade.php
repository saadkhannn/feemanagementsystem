<form action="{{ route('fee-collections.store') }}" method="post" id="crud-form" enctype="multipart/form-data">
@csrf
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Course</th>
        <th>Deadline</th>
        <th>Fee</th>
        <th>Collections</th>
        <th>Due</th>
        <th>Collecting Amount</th>
      </tr>
    </thead>
    <tbody>
      @if($bills->count() > 0)
      @foreach($bills as $key => $bill)
      @php
        $collection = $bill->billCollections->sum('collection');
      @endphp
      @if($bill->fee-$collection > 0)
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ '['.$bill->userCourse->course->code.'] '.$bill->userCourse->course->name }}</td>
        <td>{{ $bill->deadline }}</td>
        <td class="text-right">{{ $bill->fee }}</td>
        <td class="text-right">{{ $collection }}</td>
        <td class="text-right">{{ $bill->fee-$collection }}</td>
        <td class="text-right">
          <input type="number" name="collections[{{ $bill->id }}]" min="0" max="{{ $bill->fee-$collection }}" value="{{ $bill->fee-$collection }}" class="form-control text-right">
        </td>
      </tr>
      @endif
      @endforeach
      @endif
    </tbody>
  </table>
  <button type="submit" class="btn btn-primary crud-button" style="float: right"><i class="fa fa-save"></i>&nbsp; Receive Collections</button>
</form>
@include('layouts.crudFormJs')