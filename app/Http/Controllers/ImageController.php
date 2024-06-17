<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public  function saveOrgImg(Request $request,$folder_name,$imageName)
    {
        $filenamewithextension = $request->file($imageName)->getClientOriginalName();
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $request->file($imageName)->getClientOriginalExtension();

        //filename to store
        $filenametostore = time().'.'.$extension;

        //Upload File
        $image=$request->file($imageName)->move('uploads/'.$folder_name, $filenametostore);
        $img = Image::make($image->getPathname())->orientate();
        $path = sprintf('%s/thumbnail/%s', $image->getPath(), $image->getFilename());
        $directory = sprintf('%s/thumbnail', $image->getPath());
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $img->save($path);
        File::delete(public_path('uploads/'.$folder_name.'/'.$filenametostore));
        return $filenametostore;
    }
    public  function saveAnyImg(Request $request,$folder_name,$imageName,$width,$height)
    {
        $filenamewithextension = $request->file($imageName)->getClientOriginalName();
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $request->file($imageName)->getClientOriginalExtension();

        //filename to store
        $filenametostore = time().'.'.$extension;

        //Upload File
        $image=$request->file($imageName)->move('uploads/'.$folder_name, $filenametostore);
        $img = Image::make($image->getPathname())->orientate();
        $img->fit($width, $height);
        $path = sprintf('%s/thumbnail/%s', $image->getPath(), $image->getFilename());
        $directory = sprintf('%s/thumbnail', $image->getPath());
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $img->save($path);
        File::delete(public_path('uploads/'.$folder_name.'/'.$filenametostore));
        return $filenametostore;
    }
    public  function resizeAnyImg(Request $request,$folder_name,$imageName,$width,$height)
    {
        $filenamewithextension = $request->file($imageName)->getClientOriginalName();
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $request->file($imageName)->getClientOriginalExtension();

        //filename to store
        $filenametostore = time().'.'.$extension;

        //Upload File
        $image=$request->file($imageName)->move('uploads/'.$folder_name, $filenametostore);
        $img = Image::make($image->getPathname())->orientate();
        $img->resize($width, $height);
        $path = sprintf('%s/thumbnail/%s', $image->getPath(), $image->getFilename());
        $directory = sprintf('%s/thumbnail', $image->getPath());
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $img->save($path);
        File::delete(public_path('uploads/'.$folder_name.'/'.$filenametostore));
        return $filenametostore;
    }
    public  function saveAnyFile(Request $request,$folder_name,$imageName)
    {
        $filenamewithextension = $request->file($imageName)->getClientOriginalName();
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        //get file extension
        $extension = $request->file($imageName)->getClientOriginalExtension();
        //filename to store
        $filenametostore = $filename.'.'.$extension;
        //Upload File
        $file=$request->file($imageName)->move('uploads/'.$folder_name, $filenametostore);
        return $filenametostore;
    }
    public function deleteImg($folder_name,$file_name)
    {
        File::delete(public_path('uploads/'.$folder_name.'/thumbnail/'.$file_name));
    }
    public function deleteFile($folder_name,$file_name)
    {
        File::delete(public_path('uploads/'.$folder_name.'/'.$file_name));
    }
}
