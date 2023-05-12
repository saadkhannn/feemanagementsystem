<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB, DataTables;

use Modules\Setups\Entities\Module;

class ModulesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        request()->merge([
            'anyPermissionArray' => makeResourcePermissions('system-settings-modules'),
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
        // foreach(Module::whereNotIn('id', [6, 7, 15])->get() as $module){
        //     if($module->menu->count() > 0){
        //         foreach($module->menu as $menu){
        //             if($menu->submenu->count() > 0){
        //                 foreach($menu->submenu as $submenu){
        //                     $submenu->delete();
        //                 }
        //             }

        //             $menu->delete();
        //         }
        //     }
            
        //     $module->delete();
        // }

        if (request()->ajax() && request()->has('draw')) {
            return DataTables::of(Module::with(['menu'])->orderBy('serial', 'asc'))
                ->addIndexColumn()
                ->editColumn('icon', function($module){
                    return $module->icon.'<br><i class="'.$module->icon.'"></i>';
                })
                ->addColumn('menu', function($module){
                    return $module->menu->count();
                })
                ->addColumn('description', function($module){
                    return $module->desc;
                })
                ->addColumn('actions', function($module){
                    return view('layouts.crudButtons',[
                        'text' => 'Module',
                        'object' => $module,
                        'link' => 'setups/modules',
                        'permission' => 'system-settings-modules',
                    ])->render();
                })
                ->rawColumns(['icon', 'description', 'actions'])
                ->toJson();
        }
        
        return view('setups::modules.index', [
            'headerColumns' => headerColumns('modules')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('setups::modules.create');
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
            'name' => 'required|unique:modules',
            'route' => 'required|unique:modules'
        ]);

        DB::beginTransaction();
        try {
            $module = new Module();
            $module->fill($request->all());
            $module->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Module Has been Added."
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
        return view('setups::modules.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = [
            'module' => Module::findOrFail($id)
        ];
        return view('setups::modules.edit', $data);
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
            'route' => 'required',
            'status' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $module = Module::findOrFail($id);
            $module->fill($request->all());
            $module->save();
            
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Module Has been updated."
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
            if(Module::find($id)->delete()){
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
