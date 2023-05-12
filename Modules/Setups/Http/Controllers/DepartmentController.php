<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Setups\Entities\Department;
use DB, DataTables;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        request()->merge([
            'anyPermissionArray' => makeResourcePermissions('department'),
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
            return DataTables::of(Department::query())
                ->addIndexColumn()
                ->addColumn('actions', function($department){
                    return view('layouts.crudButtons',[
                        'text' => 'Department',
                        'object' => $department,
                        'link' => 'setups/departments',
                        'permission' => 'department',
                    ])->render();
                })
                ->rawColumns(['actions'])
                ->toJson();
        }
        return view('setups::departments.index', [
            'headerColumns' => headerColumns('departments')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('setups::departments.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:departments',
            'name' => 'required|unique:departments',
        ]);

        DB::beginTransaction();
        try {
            $department = new Department();
            $department->fill($request->all());
            $department->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Department Has been Added."
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
        return view('setups::departments.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'department' => Department::findOrFail($id)
        ];
        return view('setups::departments.edit',$data);
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
            $department = Department::findOrFail($id);
            $department->fill($request->all());
            $department->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Department Has been updated."
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
            if(Department::find($id)->delete()){
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
