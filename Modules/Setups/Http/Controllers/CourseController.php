<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Setups\Entities\Course;
use DB, DataTables;

class courseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        request()->merge([
            'anyPermissionArray' => makeResourcePermissions('course'),
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
            return DataTables::of(Course::query())
                ->addIndexColumn()
                ->addColumn('actions', function($course){
                    return view('layouts.crudButtons',[
                        'text' => 'course',
                        'object' => $course,
                        'link' => 'setups/courses',
                        'permission' => 'course',
                    ])->render();
                })
                ->rawColumns(['actions'])
                ->toJson();
        }
        return view('setups::courses.index', [
            'headerColumns' => headerColumns('courses')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('setups::courses.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:courses',
            'name' => 'required|unique:courses',
        ]);

        DB::beginTransaction();
        try {
            $course = new Course();
            $course->fill($request->all());
            $course->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Course Has been Added."
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
        return view('setups::courses.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'course' => Course::findOrFail($id)
        ];
        return view('setups::courses.edit',$data);
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
            'code' => 'required|unique:courses,code,'.$id,
            'name' => 'required|unique:courses,name,'.$id,
            'status' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $course = Course::findOrFail($id);
            $course->fill($request->all());
            $course->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Course Has been updated."
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
            if(Course::find($id)->delete()){
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
