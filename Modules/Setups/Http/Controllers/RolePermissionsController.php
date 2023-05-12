<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB, DataTables;

use Modules\Setups\Entities\Module;
use Modules\Setups\Entities\Role;
use Modules\Setups\Entities\Permission;

class RolePermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        request()->merge([
            'anyPermissionArray' => makeResourcePermissions('role-management-role-permissions'),
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
        $data = [
            'roles' => Role::all(),
            'modules' => Permission::orderBy('module', 'asc')->groupBy('module')->pluck('module')->toArray(),
            'permissions' => Permission::all(),
            'existingPermissions' => DB::table('role_has_permissions')->where('role_id', request()->get('role_id'))->pluck('permission_id')->toArray(),
        ];

        return view('setups::rolePermissions.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            DB::table('role_has_permissions')->where('role_id', $request->role_id)->delete();
            
            $permissions = [];
            if(isset($request->permissions[0])){
                foreach($request->permissions as $key => $permission_id){
                    array_push($permissions, [
                        'role_id' => $request->role_id,
                        'permission_id' => $permission_id,
                    ]);
                }

                DB::table('role_has_permissions')->insert($permissions);
            }

            DB::commit();
            success('Permissions Has been Updated.');
            return redirect()->back();
        }catch(\Throwable $th){
            DB::rollback();
            return redirectWithError($th->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($role_id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        
    }
}
