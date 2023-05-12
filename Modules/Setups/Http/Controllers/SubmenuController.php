<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB, DataTables;

use Modules\Setups\Entities\Module;
use Modules\Setups\Entities\Menu;
use Modules\Setups\Entities\Submenu;
use Modules\Setups\Entities\SubmenuPermission;
use Modules\Setups\Entities\Permission;

class SubmenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        request()->merge([
            'anyPermissionArray' => makeResourcePermissions('system-settings-submenu'),
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
            return DataTables::of(Submenu::with([
                'menu.module', 'permissions'
            ]))
            ->addIndexColumn()
            ->addColumn('module', function($submenu){
                return $submenu->menu->module->name;
            })
            ->filterColumn('module', function($query, $keyword){
                return $query->whereHas('menu.module', function($query) use($keyword){
                    return $query->where('name', 'LIKE', '%'.$keyword.'%');
                });
            })
            ->orderColumn('module', function ($query, $order) {
                return pleaseSortMe($query, $order, Menu::select('modules.name')
                    ->join('modules', 'modules.id', '=', 'menu.module_id')
                    ->whereColumn('menu.id', 'submenu.menu_id')
                    ->take(1)
                );
            })
            ->addColumn('menu', function($submenu){
                return $submenu->menu->name;
            })
            ->filterColumn('menu', function($query, $keyword){
                return $query->whereHas('menu', function($query) use($keyword){
                    return $query->where('name', 'LIKE', '%'.$keyword.'%');
                });
            })
            ->orderColumn('menu', function ($query, $order) {
                return pleaseSortMe($query, $order, Menu::select('menu.name')
                    ->whereColumn('menu.id', 'submenu.menu_id')
                    ->take(1)
                );
            })
            ->editColumn('icon', function($submenu){
                return $submenu->icon.'<br><i class="'.$submenu->icon.'"></i>';
            })
            ->addColumn('description', function($submenu){
                return $submenu->desc;
            })
            ->addColumn('actions', function($submenu){
                return view('layouts.crudButtons',[
                    'text' => 'Submenu',
                    'object' => $submenu,
                    'link' => 'setups/submenu',
                    'permission' => 'system-settings-submenu',
                ])->render();
            })
            ->rawColumns(['icon', 'description', 'actions'])
            ->toJson();
        }
        return view('setups::submenu.index', [
            'headerColumns' => headerColumns('submenu')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data = [
            'modules' => Module::where('status',1)->orderBy('serial','asc')->orderBy('name','asc')->get(),
            'permissions' => Permission::all(),
        ];
        return view('setups::submenu.create',$data);
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
            'menu_id' => 'required',
            'name' => 'required',
            'route' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $submenu = new Submenu();
            $submenu->fill($request->all());
            $submenu->save();

            if(isset($request->permissions[0])){
                foreach($request->permissions as $key => $permission_id){
                    SubmenuPermission::updateOrCreate([
                        'submenu_id' => $submenu->id,
                        'permission_id' => $permission_id,
                    ], []);
                }
            }
            
            DB::commit();
            success('Submenu Has been Added.');
            return response()->json([
                'success' => true,
                'message' => "Submenu Has been Added."
            ]);
        }catch(\Throwable $th){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getMenu($module_id){
        return Menu::where('status',1)
            ->when($module_id>0,function($query) use($module_id){
                return $query->where('module_id',$module_id);
            })
            ->orderBy('serial','asc')
            ->orderBy('name','asc')
            ->get();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($menu_id)
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
            'modules' => Module::where('status',1)->orderBy('serial','asc')->orderBy('name','asc')->get(),
            'permissions' => Permission::all(),
            'submenu' => Submenu::findOrFail($id)
        ];
        return view('setups::submenu.edit',$data);
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
            'menu_id' => 'required',
            'name' => 'required',
            'route' => 'required',
            'status' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $submenu = Submenu::findOrFail($id);
            $submenu->fill($request->all());
            $submenu->save();

            SubmenuPermission::where('submenu_id', $submenu->id)->whereNotIn('permission_id', (isset($request->permissions) ? $request->permissions : []))->delete();
            if(isset($request->permissions[0])){
                foreach($request->permissions as $key => $permission_id){
                    SubmenuPermission::updateOrCreate([
                        'submenu_id' => $submenu->id,
                        'permission_id' => $permission_id,
                    ], []);
                }
            }
            
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Submenu Has been updated."
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
            if(Submenu::find($id)->delete()){
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
