<table class="table table-bordered">
  <thead>
    <tr>
      <th style="width: 5%;">#</th>
      <th style="width: 40%;">Course</th>
      <th style="width: 25%;">Fee</th>
      <th style="width: 30%;">Notes</th>
    </tr>
  </thead>
  <tbody>
    @if($user->courses->count() > 0)
    @foreach($user->courses as $key => $course)
    @php
      $fee = \Modules\Setups\Entities\CourseFee::where('course_id', $course->course_id)->where('date', '<=', $deadline)->orderBy('date', 'desc')->first();
      $fee = isset($fee->fee) ? $fee->fee : 0;
    @endphp
    <tr>
      <td>{{ $key+1 }}</td>
      <td>{{ '['.$course->course->code.'] '.$course->course->name }}</td>
      <td>
        <input type="number" name="fees[{{ $course->id }}]" value="{{ $fee }}" class="form-control text-right">
      </td>
      <td>
        <input type="text" name="descriptions[{{ $course->id }}]" value="" class="form-control">
      </td>
    </tr>
    @endforeach
    @endif
  </tbody>
</table>