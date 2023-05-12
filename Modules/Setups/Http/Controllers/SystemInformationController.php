<?php

namespace Modules\Setups\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB, DataTables;

use Modules\Setups\Entities\SystemInformation;
use Modules\Setups\Entities\UserColumnVisibility;

class SystemInformationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        request()->merge([
            'anyPermissionArray' => makeResourcePermissions('system-information'),
            'allPermissionArray' => []
        ]);
        $this->middleware('check_permission');
    }
    
    public function index()
    {
        $data = [
            'information' => systemInformation()
        ];
        return view('setups::systemInformation.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'motto' => 'required',
            'tagline' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'website' => 'required',
            'twitter' => 'required',
            'facebook' => 'required',
            'instagram' => 'required',
            'skype' => 'required',
            'linked_in' => 'required',
        ]);

        $information = SystemInformation::find(1);
        $information->fill($request->all());
        $information->save();

        if($information){
            if($request->hasFile('logo_file')){
                $fileInfo=fileInfo($request->logo_file);
                $name=$information->id.'-'.date('YmdHis').'-'.rand().'-'.rand().'.'.$fileInfo['extension'];
                $upload=fileUpload($request->logo_file,'system-images/logos',$name);
                if($upload){
                   if(!empty($information->logo)){
                        fileDelete('system-images/logos/'.$information->logo);
                   }
                   $information->logo=$name;
                   $information->save();
                }
            }

            if($request->hasFile('secondary_logo_file')){
                $fileInfo=fileInfo($request->secondary_logo_file);
                $name=$information->id.'-'.date('YmdHis').'-'.rand().'-'.rand().'.'.$fileInfo['extension'];
                $upload=fileUpload($request->secondary_logo_file,'system-images/secondary-logos',$name);
                if($upload){
                   if(!empty($information->secondary_logo)){
                        fileDelete('system-images/secondary-logos/'.$information->secondary_logo);
                   }
                   $information->secondary_logo=$name;
                   $information->save();
                }
            }

            if($request->hasFile('icon_file')){
                $fileInfo=fileInfo($request->icon_file);
                $name=$information->id.'-'.date('YmdHis').'-'.rand().'-'.rand().'.'.$fileInfo['extension'];
                $upload=fileUpload($request->icon_file,'system-images/icons',$name);
                if($upload){
                    if(!empty($information->icon)){
                        fileDelete('system-images/icons/'.$information->icon);
                    }
                   $information->icon=$name;
                   $information->save();
                }
            }

            if($request->hasFile('map_image_file')){
                $fileInfo=fileInfo($request->map_image_file);
                $name=$information->id.'-'.date('YmdHis').'-'.rand().'-'.rand().'.'.$fileInfo['extension'];
                $upload=fileUpload($request->map_image_file,'system-images/maps',$name);
                if($upload){
                    if(!empty($information->map_image)){
                        fileDelete('system-images/maps/'.$information->map_image);
                    }
                   $information->map_image=$name;
                   $information->save();
                }
            }

            if($request->hasFile('offer_image_file')){
                $fileInfo=fileInfo($request->offer_image_file);
                $name=$information->id.'-'.date('YmdHis').'-'.rand().'-'.rand().'.'.$fileInfo['extension'];
                $upload=fileUpload($request->offer_image_file,'system-images/offers',$name);
                if($upload){
                    if(!empty($information->offer_image)){
                        fileDelete('system-images/offers/'.$information->offer_image);
                    }
                   $information->offer_image=$name;
                   $information->save();
                }
            }

            if($request->hasFile('faq_image_file')){
                $fileInfo=fileInfo($request->faq_image_file);
                $name=$information->id.'-'.date('YmdHis').'-'.rand().'-'.rand().'.'.$fileInfo['extension'];
                $upload=fileUpload($request->faq_image_file,'system-images/faq',$name);
                if($upload){
                    if(!empty($information->faq_image)){
                        fileDelete('system-images/faq/'.$information->faq_image);
                    }
                   $information->faq_image=$name;
                   $information->save();
                }
            }
        }

        session()->forget('system-information');
        
        return is_save($information, 'System Information Has been updated.');
    }

    public function updateUserColumnVisibilities(Request $request)
    {
        UserColumnVisibility::updateOrCreate([
            'user_id' => auth()->user()->id,
            'url' => $request->url
        ],[
            'columns' => json_encode($request->columns)
        ]);
    }
}
