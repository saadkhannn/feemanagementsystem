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

class CourseFeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        request()->merge([
            'anyPermissionArray' => makeResourcePermissions('course-fees'),
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
            return DataTables::of(CourseFee::with(['course']))
                ->addIndexColumn()
                ->addColumn('course', function($fee){
                    return $fee->course ? '['.$fee->course->code.'] '.$fee->course->name : '';
                })
                ->filterColumn('course', function($query, $keyword){
                    return $query->whereHas('course', function($query) use($keyword){
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
                ->addColumn('actions', function($fee){
                    return view('layouts.crudButtons',[
                        'text' => 'Course Fee',
                        'object' => $fee,
                        'link' => 'fee-management/course-fees',
                        'permission' => 'course-fees',
                        'status' => false
                    ])->render();
                })
                ->rawColumns(['actions'])
                ->toJson();
        }
        return view('feemanagement::fees.index', [
            'headerColumns' => headerColumns('course-fees')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'courses' => Course::orderBy('code', 'asc')->get()
        ];

        return view('feemanagement::fees.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'date' => 'required',
            'fee' => 'required',
        ]);

        DB::beginTransaction();
        try {
            CourseFee::updateOrCreate([
                'course_id' => $request->course_id,
                'date' => $request->date,
            ], [
                'fee' => $request->fee,
                'description' => $request->description,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Course Fee Has been Added."
            ]);
        }catch(\Throwable $th){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('feemanagement::fees.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'fee' => CourseFee::findOrFail($id)
        ];
        return view('feemanagement::fees.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required',
            'fee' => 'required',
        ]);

        DB::beginTransaction();
        try {
            CourseFee::updateOrCreate([
                'id' => $id,
            ], [
                'fee' => $request->fee,
                'description' => $request->description,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Course Fee Has been Updated."
            ]);
        }catch(\Throwable $th){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            if(CourseFee::find($id)->delete()){
                DB::commit();
                return response()->json([
                    'success' => true
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!'
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
