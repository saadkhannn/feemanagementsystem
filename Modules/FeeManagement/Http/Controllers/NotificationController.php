<?php

namespace Modules\FeeManagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use \App\Models\User;
use \Modules\Setups\Entities\Department;
use \Modules\Setups\Entities\Course;
use \Modules\Setups\Entities\CourseFee;
use \Modules\Setups\Entities\UserCourse;
use \Modules\FeeManagement\Entities\UserBill;
use \Modules\FeeManagement\Entities\BillCollection;
use DB, DataTables;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        request()->merge([
            'anyPermissionArray' => [
                'notifications',
            ],
            'allPermissionArray' => []
        ]);
        $this->middleware('check_permission');
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (request()->ajax() && request()->has('draw')) {
            return DataTables::of(
                    UserBill::with([
                        'userCourse.course',
                        'userCourse.user',
                        'billCollections',
                    ])
                )
                ->addIndexColumn()
                ->addColumn('student', function($bill){
                    return $bill->userCourse->user ? $bill->userCourse->user->first_name.' '.$bill->userCourse->user->last_name : '';
                })
                ->filterColumn('student', function($query, $keyword){
                    return $query->whereHas('userCourse.user', function($query) use($keyword){
                        return $query->where('first_name', 'LIKE', '%'.$keyword.'%')
                                     ->orWhere('last_name', 'LIKE', '%'.$keyword.'%');
                    });
                })
                ->orderColumn('student', function ($query, $order) {
                    return pleaseSortMe($query, $order, Course::select('courses.name')
                        ->whereColumn('courses.id', 'user_courses.course_id')
                        ->take(1)
                    );
                })

                ->addColumn('course', function($bill){
                    return $bill->userCourse->course ? '['.$bill->userCourse->course->code.'] '.$bill->userCourse->course->name : '';
                })
                ->filterColumn('course', function($query, $keyword){
                    return $query->whereHas('userCourse.course', function($query) use($keyword){
                        return $query->where('code', 'LIKE', '%'.$keyword.'%')
                                     ->orWhere('name', 'LIKE', '%'.$keyword.'%');
                    });
                })
                ->orderColumn('course', function ($query, $order) {
                    return pleaseSortMe($query, $order, Course::select('courses.name')
                        ->whereColumn('courses.id', 'user_courses.course_id')
                        ->take(1)
                    );
                })
                ->addColumn('collections', function($bill){
                    return $bill->billCollections->sum('collection');
                })
                ->addColumn('due', function($bill){
                    return $bill->fee-$bill->billCollections->sum('collection');
                })
                ->addColumn('notification', function($bill){
                    if($bill->fee-$bill->billCollections->sum('collection') > 0){
                        return view('feemanagement::notifications.button', [
                            'bill' => $bill
                        ])->render();
                    }
                })
                ->rawColumns(['total_bills', 'total_collections', 'due', 'notification'])
                ->toJson();
        }
        return view('feemanagement::notifications.index', [
            'headerColumns' => headerColumns('notifications')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_bill_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $userBill = UserBill::findOrFail($request->user_bill_id);
            $message = 'Dear '.$userBill->userCourse->user->first_name.' '.$userBill->userCourse->user->last_name.', <br>You have a due of '.($userBill->fee-$userBill->billCollections->sum('collection')).' for the course ['.$userBill->userCourse->course->code.'] '.$userBill->userCourse->course->name.' and the deadline is '.$userBill->deadline.'. <br>Please Pay your bill on time. <br>Thanks.';
            sendEmail($userBill->userCourse->user, 'Course Fee Deadline for '.$userBill->userCourse->course->code, $message);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Notification has been sent successfully"
            ]);
        }catch(\Throwable $th){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
