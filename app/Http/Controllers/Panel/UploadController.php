<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Api\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    public function upload(Request $request){
        // $file = $request->file('file');
        // $fileName = time() . '_' . $file->getClientOriginalName();
        // $file->move(public_path('store'), $fileName);
       
         
        // $fileUrl = asset('store/' . $fileName);


        // return response()->json(['success' => $fileName , 'message' => 'File uploaded successfully', 'thumbnail' => $fileUrl]);

        try {
            
            $creatorId = $request->user()->id; 

            // Create the directory if it doesn't exist
            $directory = public_path('store/' . $creatorId);
            File::makeDirectory($directory, 0755, true, true);

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($directory, $fileName);

            $fileUrl = asset('store/' . $creatorId . '/' . $fileName);

            return response()->json(['success' => $fileName, 'message' => 'File uploaded successfully', 'thumbnail' => $fileUrl]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
  
}
