<?php

namespace App\Helpers;
use Image;

class Helpers {

    public static function uploadFile($request, $field, $path, $thumbPath = "",$width="", $height="",$defaultName="") {

        if (!empty($request->file($field))) {

             $icon = $request->file($field);         

            if($defaultName){
                $field = pathinfo($icon->getClientOriginalName(), PATHINFO_FILENAME);
                $imagename = $field .'.' . $icon->getClientOriginalExtension();
            } else {
                $imagename = $field . '_' . time() . '.' . $icon->getClientOriginalExtension();
            }

            if ($thumbPath != "" && $icon->getClientOriginalExtension() != 'pdf') {

                if($width !='' && $height !=''){
                    $thumb_img = Image::make($icon->getRealPath())->resize($width, $height);
                }else{
                    $thumb_img = Image::make($icon->getRealPath())->resize(100, 100);
                }
                $thumb_img->save($thumbPath . '/' . $imagename, 100);
            }

            $icon->move($path, $imagename);

            return $imagename;
        } else {
            return FALSE;
        }
    }

    public static function uploadMultipleFile($request, $field, $path, $thumbPath = "", $attachHidden="") {
        if(!empty($attachHidden)){
            $userHiddenUploads = explode(",",$request->attachHidden[0]);
        }
        $imageArray = array();
        $allowAdd = true;
       // dd($request->file($field));
        for ($i = 0; $i <= count($request->file($field)); $i++) {
            if(!empty($attachHidden)){
                if(isset($request->file($field)[$i]) && in_array($request->file($field)[$i]->getClientOriginalName(), $userHiddenUploads ) )
                {
                    $allowAdd = true;
                }
                else{
                    $allowAdd = false;
                }
            }

            if ($allowAdd && isset($request->file($field)[$i])) {

                $icon = $request->file($field)[$i];
                $imagename = $field .$i. '_' . time() . '.' . $icon->getClientOriginalExtension();

                if ($thumbPath != "") {
                    $thumb_img = Image::make($icon->getRealPath())->resize(100, 100);
                    $thumb_img->save($thumbPath . '/' . $imagename, 100);
                }

                $icon->move($path, $imagename);

                $imageArray[] =  $imagename;
            }
        }
        return $imageArray;
    }


}

?>