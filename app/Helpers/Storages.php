<?php
function fileInfo($file){
    if(isset($file)){
        return $image = array(
            'name' => $file->getClientOriginalName(), 
            'type' => $file->getClientMimeType(), 
            'size' => $file->getSize(), 
            'width' => isset(getimagesize($file)[0]) ? getimagesize($file)[0] : 0, 
            'height' => isset(getimagesize($file)[1]) ? getimagesize($file)[1] : 0, 
            'extension' => $file->getClientOriginalExtension(), 
        );
    }else{
        return $image = array(
            'name' => '0', 
            'type' => '0', 
            'size' => '0', 
            'width' => '0', 
            'height' => '0', 
            'extension' => '0', 
        );
    }
    
}

function fileUpload($file,$destination,$name){
    return $file->move(public_path('/'.$destination), $name);
}

function fileMove($oldPath,$newPath){
    return File::move($oldPath, $newPath);
}

function fileDelete($path){
    if(!empty($path) && file_exists(public_path('/'.$path))){
        return unlink(public_path('/'.$path));
    }
    return false;
}

function userImage(){
    if(!empty(auth()->user()->image) && file_exists(public_path('user-images/'.auth()->user()->image))){
        return asset('user-images/'.auth()->user()->image);
    }else{
        $gender = (isset(auth()->user()->gender) ? auth()->user()->gender : 0);
        if($gender == 0){
            return asset('img/female.png');
        }else{
            return asset('img/male.png');
        }
    }
}