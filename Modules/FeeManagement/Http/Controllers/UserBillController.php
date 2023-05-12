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
use DB, DataTables;

class UserBillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        request()->merge([
            'anyPermissionArray' => makeResourcePermissions('user-bills'),
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
            return DataTables::of(UserBill::with([
                    'userCourse.course',
                    'userCourse.user',
                    'billCollections'
                ]))
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
                ->toJson();
        }
        return view('feemanagement::bills.index', [
            'headerColumns' => headerColumns('user-bills')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        if(request()->get('deadline')){
            $data = [
                'deadline' => request()->get('deadline'),
                'user' => User::findOrFail(request()->get('user_id')),
            ];

            return view('feemanagement::bills.bills', $data);
        }

        $data = [
            'students' => User::role('Student')->get(),
        ];

        return view('feemanagement::bills.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'deadline' => 'required',
            'fees' => 'required',
            'fees.*' => 'required',
        ]);

        DB::beginTransaction();
        try {
            foreach($request->fees as $user_course_id => $fee){
                UserBill::updateOrCreate([
                    'user_course_id' => $user_course_id,
                    'deadline' => $request->deadline,
                ], [
                    'fee' => $fee,
                    'description' => $request->descriptions[$user_course_id],
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Student Bill Has been Added."
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
