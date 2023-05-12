<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use \App\Models\User;
use Modules\Setups\Entities\Role;
use Modules\Setups\Entities\Permission;
use DB, DataTables;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        request()->merge([
            'anyPermissionArray' => makeResourcePermissions('role-management-user'),
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
                    User::with(['roles'])
                )
                ->addIndexColumn()
                ->addColumn('roles', function($user){
                    return $user->roles->pluck('name')->implode(', ');
                })
                ->filterColumn('roles', function($query, $keyword){
                    return $query->whereHas('roles', function($query) use($keyword){
                        return $query->where(function($query) use($keyword){
                            return $query->where('name', 'LIKE', '%'.$keyword.'%');
                        });
                    });
                })
                ->addColumn('actions', function($user){
                    if(auth()->user()->allPermissions(['role-management-user-edit'])){
                        return '<a class="btn btn-sm btn-success" href="'.url('setups/users/'.$user->id.'/edit').'"><i class="fa fa-edit text-white"></i>&nbsp;Edit</a>';
                    }
                })
                ->rawColumns(['actions'])
                ->toJson();
        }
        return view('setups::users.index', [
            'headerColumns' => headerColumns('users')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        if(!auth()->user()->allPermissions(['role-management-user-create'])){
            return redirect()->back();
        }

        $data = [
            'roles' => Role::all(),
            'modules' => Permission::orderBy('module', 'asc')->groupBy('module')->pluck('module')->toArray(),
            'permissions' => Permission::all(),
        ];
        return view('setups::users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->allPermissions(['role-management-user-create'])){
            return redirect()->back();
        }

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'gender' => 'required',
            'password' => 'required|min:6'
        ]);


        DB::beginTransaction();
        try{
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->password = bcrypt($request->password);
            $user->save();

            $user->syncRoles(Role::whereIn('id', (isset($request->roles) ? $request->roles : []))->pluck('name')->toArray());
            $user->syncPermissions(Permission::whereIn('id', (isset($request->permissions) ? $request->permissions : []))->pluck('name')->toArray());

            DB::commit();
            success('User has been Created.');
            return redirect()->back();
        } catch (\Throwable $th){
            whoops($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        if(!auth()->user()->allPermissions(['role-management-user-edit'])){
            return redirect()->back();
        }

        $data = [
            'user' => User::findOrFail($id),
            'roles' => Role::all(),
            'modules' => Permission::orderBy('module', 'asc')->groupBy('module')->pluck('module')->toArray(),
            'permissions' => Permission::all(),
            'existingPermissions' => DB::table('role_has_permissions')->where('role_id', request()->get('role_id'))->pluck('permission_id')->toArray(),
        ];
        return view('setups::users.edit', $data);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username,'.$id,
            'email' => 'required|unique:users,email,'.$id,
            'gender' => 'required',
        ]);

        if(!empty($request->password)){
            $request->validate([
                'password' => 'min:6'
            ]);
        }


        DB::beginTransaction();
        try{
            $user = User::findOrFail($id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->gender = $request->gender;

            if(!empty($request->password)){
                $user->password = bcrypt($request->password);
            }

            $user->save();

            $user->syncRoles(Role::whereIn('id', (isset($request->roles) ? $request->roles : []))->pluck('name')->toArray());
            $user->syncPermissions(Permission::whereIn('id', (isset($request->permissions) ? $request->permissions : []))->pluck('name')->toArray());

            DB::commit();
            success('User has been updated.');
            return redirect()->back();
        } catch (\Throwable $th){
            whoops($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        return redirect()->back();
    }
}
