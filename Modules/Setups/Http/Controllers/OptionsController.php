<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB, DataTables;

use Modules\Setups\Entities\Module;
use Modules\Setups\Entities\Menu;
use Modules\Setups\Entities\Submenu;
use Modules\Setups\Entities\Option;

class OptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        request()->merge([
            'anyPermissionArray' => makeResourcePermissions('system-settings-options'),
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
        return $this->show('0&0&0');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data=[
            'modules' => Module::where('status',1)->orderBy('serial','asc')->orderBy('name','asc')->get(),
        ];
        return view('setups::options.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'menu_id' => 'required',
            'submenu_id' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $names = explode(',', $request->name);
            foreach($names as $key => $name){
                $option = Option::create([
                    'name' => trim(strtolower($name)),
                    'menu_id' => $request->menu_id,
                    'submenu_id' => $request->submenu_id,
                ]);
            }
            
            DB::commit();
            return is_save($option, 'Options Has been Added.');
        }catch(\Throwable $th){
            DB::rollback();
            return redirectWithError($th->getMessage());
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

    public function getSubmenu($menu_id){
        return Submenu::where('status',1)
            ->when($menu_id>0,function($query) use($menu_id){
                return $query->where('menu_id',$menu_id);
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
    public function show($data)
    {
        $module_id=explode('&', $data)[0] ? explode('&', $data)[0] : 0;
        $menu_id=explode('&', $data)[1] ? explode('&', $data)[1] : 0;
        $submenu_id=explode('&', $data)[2] ? explode('&', $data)[2] : 0;

        $data=[
            'modules' => Module::where('status',1)->orderBy('serial','asc')->orderBy('name','asc')->get(),
            'options' => Option::when($menu_id>0,function($query) use($menu_id){
                                return$query->where('menu_id',$menu_id);
                            })
                            ->when($submenu_id>0,function($query) use($submenu_id){
                                return$query->where('submenu_id',$submenu_id);
                            })
                            ->get()
        ];
        return view('setups::options.index',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data=[
            'modules' => Module::where('status',1)->orderBy('serial','asc')->orderBy('name','asc')->get(),
            'option' => Option::findOrFail($id)
        ];
        return view('setups::options.edit',$data);
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
            'menu_id' => 'required',
            'submenu_id' => 'required',
            'status' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $option = Option::findOrFail($id);
            $option->fill($request->all());
            $option->save();
            
            DB::commit();
            return is_save($option,'Option Has been updated.');
        }catch(\Throwable $th){
            DB::rollback();
            return redirectWithError($th->getMessage());
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
            if(Option::find($id)->delete()){
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
