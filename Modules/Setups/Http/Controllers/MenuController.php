<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB, DataTables;

use Modules\Setups\Entities\Module;
use Modules\Setups\Entities\Menu;
use Modules\Setups\Entities\MenuPermission;
use Modules\Setups\Entities\Permission;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        request()->merge([
            'anyPermissionArray' => makeResourcePermissions('system-settings-menu'),
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
            return DataTables::of(Menu::with([
                'module', 'submenu', 'permissions.permission'
            ]))
            ->addIndexColumn()
            ->addColumn('module', function($menu){
                return $menu->module->name;
            })
            ->filterColumn('module', function($query, $keyword){
                return $query->whereHas('module', function($query) use($keyword){
                    return $query->where('name', 'LIKE', '%'.$keyword.'%');
                });
            })
            ->orderColumn('module', function ($query, $order) {
                return pleaseSortMe($query, $order, Module::select('modules.name')
                    ->whereColumn('modules.id', 'menu.module_id')
                    ->take(1)
                );
            })
            ->editColumn('icon', function($menu){
                return $menu->icon.'<br><i class="'.$menu->icon.'"></i>';
            })
            ->addColumn('submenu', function($menu){
                return $menu->submenu->count();
            })
            ->addColumn('description', function($menu){
                return $menu->desc;
            })
            ->addColumn('actions', function($menu){
                return view('layouts.crudButtons',[
                    'text' => 'Menu',
                    'object' => $menu,
                    'link' => 'setups/menu',
                    'permission' => 'system-settings-menu',
                ])->render();
            })
            ->rawColumns(['icon', 'description', 'actions'])
            ->toJson();
        }

        return view('setups::menu.index', [
            'headerColumns' => headerColumns('menu')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'modules' => Module::where('status',1)->orderBy('name','asc')->get(),
            'permissions' => Permission::all(),
        ];
        return view('setups::menu.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'serial' => 'required',
            'name' => 'required',
            'module_id' => 'required',
            'route' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $menu = new Menu();
            $menu->fill($request->all());
            $menu->save();

            if(isset($request->permissions[0])){
                foreach($request->permissions as $key => $permission_id){
                    MenuPermission::updateOrCreate([
                        'menu_id' => $menu->id,
                        'permission_id' => $permission_id,
                    ], []);
                }
            }
            
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Menu Has been Added."
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
    public function show($module_id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'modules' => Module::where('status',1)->orderBy('name','asc')->get(),
            'permissions' => Permission::all(),
            'menu' => Menu::with(['permissions'])->findOrFail($id)
        ];
        return view('setups::menu.edit',$data);
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
            'serial' => 'required',
            'name' => 'required',
            'module_id' => 'required',
            'status' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $menu = Menu::findOrFail($id);
            $menu->fill($request->all());
            $menu->save();

            MenuPermission::where('menu_id', $menu->id)->whereNotIn('permission_id', (isset($request->permissions) ? $request->permissions : []))->delete();
            if(isset($request->permissions[0])){
                foreach($request->permissions as $key => $permission_id){
                    MenuPermission::updateOrCreate([
                        'menu_id' => $menu->id,
                        'permission_id' => $permission_id,
                    ], []);
                }
            }
            
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Menu Has been updated."
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
            if(Menu::find($id)->delete()){
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
