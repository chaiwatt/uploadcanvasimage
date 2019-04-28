<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
class UploadContontroller extends Controller
{
    public function Upload(Request $request){
        $base64 =  $request->img;   
        $newname = time().'.'.explode('/',explode(':',substr($base64,0,strpos($base64,';')))[1])[1];
        Image::make($request->img)->save(public_path('storage/uploads/treatment/').$newname);
        return $base64;
    }
}
