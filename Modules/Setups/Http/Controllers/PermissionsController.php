<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB, DataTables;

use Modules\Setups\Entities\Permission;
use Modules\Setups\Entities\MenuPermission;
use Modules\Setups\Entities\SubmenuPermission;
use Modules\Setups\Entities\Module;
use Modules\Setups\Entities\Menu;
use Modules\Setups\Entities\Submenu;
use Modules\Setups\Entities\Option;

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        request()->merge([
            'anyPermissionArray' => makeResourcePermissions('role-management-permissions'),
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
        /*
        DB::beginTransaction();
        Permission::where('id', '!=', '')->delete();
        $permissions = [];
        $menu = Menu::with([
            'module',
        ])
        ->where('route', '!=', '#')
        ->get();
        $menus = [];
        if($menu->count() > 0){
            foreach($menu as $key => $m){
                if(!array_key_exists(\Str::slug($m->name.'-index'), $permissions)){
                    $permissions[\Str::slug($m->name.'-index')] = [
                        'module' => $m->module->name,
                        'name' => \Str::slug($m->name.'-index'),
                        'guard_name' => 'web'
                    ];
                }

                if(!array_key_exists(\Str::slug($m->name.'-create'), $permissions)){
                    $permissions[\Str::slug($m->name.'-create')] = [
                        'module' => $m->module->name,
                        'name' => \Str::slug($m->name.'-create'),
                        'guard_name' => 'web'
                    ];
                }

                if(!array_key_exists(\Str::slug($m->name.'-edit'), $permissions)){
                    $permissions[\Str::slug($m->name.'-edit')] = [
                        'module' => $m->module->name,
                        'name' => \Str::slug($m->name.'-edit'),
                        'guard_name' => 'web'
                    ];
                }

                if(!array_key_exists(\Str::slug($m->name.'-delete'), $permissions)){
                    $permissions[\Str::slug($m->name.'-delete')] = [
                        'module' => $m->module->name,
                        'name' => \Str::slug($m->name.'-delete'),
                        'guard_name' => 'web'
                    ];
                }

                $menus[$m->id] = [
                    \Str::slug($m->name.'-index'),
                    \Str::slug($m->name.'-create'),
                    \Str::slug($m->name.'-edit'),
                    \Str::slug($m->name.'-delete'),
                ];
            }
        }

        $submenu = Submenu::with([
            'menu.module',
        ])
        ->get();
        $submenus = [];
        if($submenu->count() > 0){
            foreach($submenu as $key => $sm){
                if(!array_key_exists(\Str::slug($sm->menu->name.'-'.$sm->name.'-index'), $permissions)){
                    $permissions[\Str::slug($sm->menu->name.'-'.$sm->name.'-index')] = [
                        'module' => $sm->menu->module->name,
                        'name' => \Str::slug($sm->menu->name.'-'.$sm->name.'-index'),
                        'guard_name' => 'web'
                    ];
                }

                if(!array_key_exists(\Str::slug($sm->menu->name.'-'.$sm->name.'-create'), $permissions)){
                    $permissions[\Str::slug($sm->menu->name.'-'.$sm->name.'-create')] = [
                        'module' => $sm->menu->module->name,
                        'name' => \Str::slug($sm->menu->name.'-'.$sm->name.'-create'),
                        'guard_name' => 'web'
                    ];
                }

                if(!array_key_exists(\Str::slug($sm->menu->name.'-'.$sm->name.'-edit'), $permissions)){
                    $permissions[\Str::slug($sm->menu->name.'-'.$sm->name.'-edit')] = [
                        'module' => $sm->menu->module->name,
                        'name' => \Str::slug($sm->menu->name.'-'.$sm->name.'-edit'),
                        'guard_name' => 'web'
                    ];
                }

                if(!array_key_exists(\Str::slug($sm->menu->name.'-'.$sm->name.'-delete'), $permissions)){
                    $permissions[\Str::slug($sm->menu->name.'-'.$sm->name.'-delete')] = [
                        'module' => $sm->menu->module->name,
                        'name' => \Str::slug($sm->menu->name.'-'.$sm->name.'-delete'),
                        'guard_name' => 'web'
                    ];
                }

                $submenus[$sm->id] = [
                    \Str::slug($sm->menu->name.'-'.$sm->name.'-index'),
                    \Str::slug($sm->menu->name.'-'.$sm->name.'-create'),
                    \Str::slug($sm->menu->name.'-'.$sm->name.'-edit'),
                    \Str::slug($sm->menu->name.'-'.$sm->name.'-delete'),
                ];  
            }
        }

        Permission::insert($permissions);

        $permissions = Permission::all();
        if(count($menus) > 0){
            $menu_permissions = [];
            foreach ($menus as $key => $slugs) {
                if($permissions->whereIn('name', $slugs)->count() > 0){
                    foreach($permissions->whereIn('name', $slugs) as $permission){
                        array_push($menu_permissions, [
                            'menu_id' => $key,
                            'permission_id' => $permission->id
                        ]);
                    }
                }
            }
        }

        if(count($menu_permissions) > 0){
            MenuPermission::insert($menu_permissions);
        }

        if(count($submenus) > 0){
            $submenu_permissions = [];
            foreach ($submenus as $key => $slugs) {
                if($permissions->whereIn('name', $slugs)->count() > 0){
                    foreach($permissions->whereIn('name', $slugs) as $permission){
                        array_push($submenu_permissions, [
                            'submenu_id' => $key,
                            'permission_id' => $permission->id
                        ]);
                    }
                }
            }
        }

        if(count($submenu_permissions) > 0){
            SubmenuPermission::insert($submenu_permissions);
        }

        DB::commit();
        */

        /*
        DB::beginTransaction();
        $menus = Menu::has('submenu')->with(['permissions', 'submenu.permissions'])->get();
        $new_permissions = [];
        if($menus->count() > 0){
            foreach($menus as $key => $menu){
                $permissions = [];
                if($menu->submenu->count() > 0){
                    foreach($menu->submenu as $key => $submenu){
                        array_push($permissions, $submenu->permissions->pluck('permission_id')->toArray());
                    }
                }
                $permissions = call_user_func_array('array_merge', $permissions);
                $menu_permissions = $menu->permissions->pluck('permission_id')->toArray();
                if(count($permissions) > 0){
                    foreach($permissions as $key => $permission_id){
                        if(!in_array($permission_id, $menu_permissions)){
                            array_push($new_permissions, [
                                'menu_id' => $menu->id,
                                'permission_id' => $permission_id,
                            ]);
                        }
                    }
                }
            }
        }

        if(count($new_permissions)){
            MenuPermission::insert($new_permissions);
        }
        
        DB::commit();
        */

        if (request()->ajax() && request()->has('draw')) {
            return DataTables::of(Permission::orderBy('id', 'desc'))
                ->addIndexColumn()
                ->addColumn('actions', function($Permission){
                    return view('layouts.crudButtons',[
                        'text' => 'Permission',
                        'object' => $Permission,
                        'link' => 'setups/permissions',
                        'status' => false,
                        'permission' => 'role-management-permissions',
                    ])->render();
                })
                ->rawColumns(['actions'])
                ->toJson();
        }

        return view('setups::permissions.index', [
            'headerColumns' => headerColumns('permissions')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'modules' => Permission::groupBy('module')->pluck('module')->toArray(),
        ];
        return view('setups::permissions.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'module' => 'required',
            'name' => 'required'
        ]);

        DB::beginTransaction();
        try {
            foreach(explode(',', $request->name) as $key => $name){
                if(!empty(trim($name))){
                    Permission::updateOrCreate([
                        'module' => trim($request->module),
                        'name' => trim($name),
                        'guard_name' => 'web',
                    ], []);
                }
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Permissions Has been Added."
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
        return view('setups::permissions.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'modules' => Permission::groupBy('module')->pluck('module')->toArray(),
            'permission' => Permission::findOrFail($id)
        ];
        return view('setups::permissions.edit',$data);
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
            'module' => 'required',
            'name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $permission = Permission::findOrFail($id);
            $permission->fill($request->all());
            $permission->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Permission Has been updated."
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
            if(Permission::find($id)->delete()){
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
