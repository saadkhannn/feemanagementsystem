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

class FeeCollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        request()->merge([
            'anyPermissionArray' => [
                'fee-collections',
                'collect-fee',
                'view-fee-collections',
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
                    User::role('Student')
                    ->has('courses.userBills')
                )
                ->addIndexColumn()
                ->addColumn('student', function($user){
                    return $user->first_name.' '.$user->last_name;
                })
                ->filterColumn('student', function($query, $keyword){
                    return $query->where(function($query) use($keyword){
                        return $query->where('first_name', 'LIKE', '%'.$keyword.'%')
                                     ->orWhere('last_name', 'LIKE', '%'.$keyword.'%');
                    });
                })
                ->orderColumn('student', function ($query, $order) {
                    return $query->orderBy('first_name', $order);
                })

                ->addColumn('department', function($user){
                    return $user->departments->pluck('department.name')->implode(', ');
                })
                ->filterColumn('department', function($query, $keyword){
                    return $query->whereHas('departments.department', function($query) use($keyword){
                        return $query->where('name', 'LIKE', '%'.$keyword.'%');
                    });
                })
                ->orderColumn('department', function ($query, $order) {
                    return pleaseSortMe($query, $order, UserDepartment::select('departments.name')
                        ->join('departments', 'departments.id', '=', 'user_departments.department_id')
                        ->whereColumn('user_departments.', 'users.id')
                        ->take(1)
                    );
                })

                ->addColumn('courses', function($user){
                    return $user->courses->pluck('course.name')->implode(', ');
                })
                ->filterColumn('courses', function($query, $keyword){
                    return $query->whereHas('courses.course', function($query) use($keyword){
                        return $query->where('code', 'LIKE', '%'.$keyword.'%')
                                     ->orWhere('name', 'LIKE', '%'.$keyword.'%');
                    });
                })
                ->orderColumn('courses', function ($query, $order) {
                    return pleaseSortMe($query, $order, UserCourse::select('courses.name')
                        ->join('courses', 'courses.id', '=', 'user_courses.course_id')
                        ->whereColumn('user_courses.', 'users.id')
                        ->take(1)
                    );
                })

                ->addColumn('total_bills', function($user){
                    return view('feemanagement::collections.bill-button', [
                        'user' => $user
                    ])->render();
                })
                ->addColumn('total_collections', function($user){
                    return view('feemanagement::collections.collection-button', [
                        'user' => $user
                    ])->render();
                })
                ->addColumn('due', function($user){
                    return view('feemanagement::collections.due-button', [
                        'user' => $user
                    ])->render();
                })
                ->addColumn('options', function($user){
                    return view('feemanagement::collections.button', [
                        'user' => $user
                    ])->render();
                })
                ->rawColumns(['total_bills', 'total_collections', 'due', 'options'])
                ->toJson();
        }
        return view('feemanagement::collections.index', [
            'headerColumns' => headerColumns('fee-collections')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'bills' => UserBill::whereHas('userCourse', function($query) use($id){
                return $query->where('user_id', $id);
            })->get(),
        ];

        return view('feemanagement::collections.collection', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'collections' => 'required',
            'collections.*' => 'required',
        ]);

        DB::beginTransaction();
        try {
            foreach($request->collections as $user_bill_id => $collection){
                BillCollection::create([
                    'user_bill_id' => $user_bill_id,
                    'date' => date('Y-m-d'),
                    'collection' => $collection,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Bills Have been Collected."
            ]);
        }catch(\Throwable $th){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        $data = [
            'user' => User::findOrFail($id),
        ];

        return view('feemanagement::collections.'.request()->get('page'), $data);
    }
}
