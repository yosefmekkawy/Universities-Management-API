<?php

namespace App\traits;

trait upload_image
{
    public function uploadImage($file,$folder_name){
        $valid_extensions = array("jpg", "jpeg", "png",'svg','gif');
        if(in_array($file->getClientOriginalExtension(),$valid_extensions)){
            $name = time().rand(0,99999999999).'_image'.$file->getClientOriginalName();
            $file->move(public_path().'/images/'.$folder_name,$name);
            return $folder_name.'/'.$name;
        }else{
            return false;
        }
    }

}
