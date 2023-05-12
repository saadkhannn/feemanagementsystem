<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB, DataTables;

use Modules\Setups\Entities\Role;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        request()->merge([
            'anyPermissionArray' => makeResourcePermissions('role-management-roles'),
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
            return DataTables::of(Role::query())
            ->addIndexColumn()
            ->addColumn('actions', function($role){
                return '<a class="btn btn-sm btn-success" href="'.url('setups/role-permissions?role_id='.$role->id).'"><i class="fas fa-question-circle"></i>&nbsp;Permissions</a>&nbsp;'.view('layouts.crudButtons',[
                    'text' => 'Role',
                    'object' => $role,
                    'link' => 'setups/roles',
                    'status' => false,
                    'permission' => 'role-management-roles',
                ])->render();
            })
            ->rawColumns(['actions'])
            ->toJson();
        }

        return view('setups::roles.index', [
            'headerColumns' => headerColumns('roles')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('setups::roles.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles'
        ]);

        DB::beginTransaction();
        try {
            $role = new Role();
            $role->fill($request->all());
            $role->guard_name = 'web';
            $role->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Role Has been Added."
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
        return view('setups::roles.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'role' => Role::findOrFail($id)
        ];
        return view('setups::roles.edit',$data);
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
            'name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $role = Role::findOrFail($id);
            $role->fill($request->all());
            $role->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Role Has been updated."
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
            if(Role::find($id)->delete()){
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
