@extends('frontend::layouts.index')
@section('custom-css')
<style type="text/css">
    @media print {
  .hide-print {
    display: none;
  }
}
</style>
@endsection
@section('main-body')
@php
    $user = \App\Models\User::with([
        'courses.course',
        'departments.department',
    ])->findOrFail(auth()->user()->id);
    $bills = \Modules\FeeManagement\Entities\UserBill::with([
        'userCourse.course',
        'billCollections'
    ])
    ->whereHas('userCourse', function($query){
        return $query->where('user_id', auth()->user()->id);
    })->get();
    $bill_amount = $bills->sum('fee');

    $collections = \Modules\FeeManagement\Entities\BillCollection::with([
        'userBill.userCourse.course'
    ])
    ->whereHas('userBill.userCourse', function($query){
        return $query->where('user_id', auth()->user()->id);
    })->get();
    $collection_amount = $collections->sum('collection');
@endphp
    <div class="container">
        <div class="row pt-3">
            <div class="col-md-6 mb-2">
                <h2 class="my-0 mr-md-auto font-weight-normal">
                    <strong>Edufee</strong>
                </h2>
            </div>
            <div class="col-md-6 mb-2">
                <a class="btn btn-outline-danger hide-print" style="float: right" href="{{ route('student.logout') }}">Sign out</a>

                 <a class="btn btn-outline-info hide-print" id="downloadbtn" onclick="printpage()" style="float: right; margin-right: 5px;">Download Report</a>
            </div>
            <hr>
        </div>

        <div class="row pt-3">
            <h3><strong><i class="fas fa-user-graduate"></i>&nbsp;Student Information</strong></h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><strong>Name</strong></th>
                        <th><strong>Email</strong></th>
                        <th><strong>User ID</strong></th>
                        <th><strong>Gender</strong></th>
                        <th><strong>Department</strong></th>
                        <th style="text-align: center"><strong>Bill</strong></th>
                        <th style="text-align: center"><strong>Paid</strong></th>
                        <th style="text-align: center"><strong>Due</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ auth()->user()->first_name.' '.auth()->user()->last_name }}</td>
                        <td>{{ auth()->user()->email }}</td>
                        <td>{{ auth()->user()->username }}</td>
                        <td>{{ genders()[auth()->user()->gender] }}</td>
                        <td>{{ auth()->user()->departments->pluck('department.name')->implode(', ') }}</td>
                        <td style="text-align: center">{{ $bill_amount }}</td>
                        <td style="text-align: center">{{ $collection_amount }}</td>
                        <td style="text-align: center">{{ $bill_amount-$collection_amount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row pt-3">
            <h3><strong><i class="fas fa-book-open"></i>&nbsp;Courses</strong></h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><strong>#</strong></th>
                        <th><strong>Course Code</strong></th>
                        <th><strong>Course Name</strong></th>
                        <th><strong>Enrolled At</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @if(auth()->user()->courses->count() > 0)
                    @foreach(auth()->user()->courses as $key => $course)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $course->course->code }}</td>
                        <td>{{ $course->course->name }}</td>
                        <td>{{ date('Y-m-d g:i a', strtotime($course->created_at)) }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="row pt-3">
            <h3><strong><i class="fas fa-file-invoice-dollar"></i>&nbsp;Bills</strong></h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><strong>#</strong></th>
                        <th><strong>Course Code</strong></th>
                        <th><strong>Course Name</strong></th>
                        <th><strong>Deadline</strong></th>
                        <th><strong>Description</strong></th>
                        <th style="text-align: right"><strong>Fee</strong></th>
                        <th style="text-align: right"><strong>Collection</strong></th>
                        <th style="text-align: right"><strong>Due</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @if($bills->count() > 0)
                    @foreach($bills as $key => $bill)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $bill->userCourse->course->code }}</td>
                        <td>{{ $bill->userCourse->course->name }}</td>
                        <td>{{ $bill->deadline }}</td>
                        <td>{{ $bill->description }}</td>
                        <td style="text-align: right">{{ $bill->fee }}</td>
                        <td style="text-align: right">{{ $bill->billCollections->sum('collection') }}</td>
                        <td style="text-align: right">{{ $bill->fee-$bill->billCollections->sum('collection') }}</td>
                    </tr>
                    @endforeach
                    @endif

                    <tr>
                        <td colspan="5" style="text-align: right"><strong>Total:</strong></td>
                        <td style="text-align: right">{{ $bill_amount }}</td>
                        <td style="text-align: right">{{ $collection_amount }}</td>
                        <td style="text-align: right">{{ $bill_amount-$collection_amount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row pt-3">
            <h3><strong><i class="fas fa-receipt"></i>&nbsp;Payments</strong></h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><strong>#</strong></th>
                        <th><strong>Course Code</strong></th>
                        <th><strong>Course Name</strong></th>
                        <th><strong>Deadline</strong></th>
                        <th><strong>Pay Date</strong></th>
                        <th><strong>Description</strong></th>
                        <th style="text-align: right"><strong>Payment</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @if($collections->count() > 0)
                    @foreach($collections as $key => $collection)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $collection->userBill->userCourse->course->code }}</td>
                        <td>{{ $collection->userBill->userCourse->course->name }}</td>
                        <td>{{ $collection->userBill->deadline }}</td>
                        <td>{{ $collection->userBill->date }}</td>
                        <td>{{ $collection->description }}</td>
                        <td style="text-align: right">{{ $collection->collection }}</td>
                    </tr>
                    @endforeach
                    @endif

                    <tr>
                        <td colspan="6" style="text-align: right"><strong>Total:</strong></td>
                        <td style="text-align: right">{{ $collection_amount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('custom-js')
<script>
function printpage()
{
  window.print()

}
</script>

@endsection