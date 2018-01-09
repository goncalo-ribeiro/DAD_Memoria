<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class ImageControllerAPI extends Controller
{
    public function getImages(Request $request)
    {
        return Image::all();
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image'))
        {
            $this->validateFile($request);
            
            $image;
            if ($request->get('hidden') == 1) {
                $image = $this->createHidden($request);
            }else{
                $image = $this->createTile($request);
            }
     
            Storage::disk('public_uploads')->putFileAs('img', $request->file('image'), $image->path);
            return response()->json(['message'=>'ficheiro enviado com sucsso'], 200);
        
        }
        return response()->json(['message'=>'não foi enviado nenhuma imagem' ], 400);
    }

    public function validateFile(Request $request)
    {
        $this->validate($request, ['image' => 'mimes:png|dimensions:width=48,height=48']);
    }

    public function createTile($request)
    {
        $image = new Image();
        
        $request->request->add([
            'face'=> 'tile',
            'active'=> 1,
            'path'=> 'temp.png',
        ]);

        $image->fill($request->all());
        $image->save();

        $image->path = $image->id . '.png';

        $image->save();

        return $image;
    }

        public function createHidden($request)
    {
        $image = new Image();
        
        $request->request->add([
            'face'=> 'hidden',
            'active'=> 1,
            'path'=> 'temp.png',
        ]);

        $image->fill($request->all());
        $image->save();

        $image->path = $image->id . '.png';

        $image->save();

        return $image;
    }
}
