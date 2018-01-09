<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageControllerAPI extends Controller
{
    public function getImages(Request $request)
    {
        return Image::all();
    }

    public function activate(Request $request, $imageId)
    {
        $user = Auth::user();

        if ($user->admin != 1) {
            return response()->json(['message'=>'Erro, você não é um administrador'], 400);
        }

        $image = Image::findOrFail($imageId);
        $image->active = 1;
        $image->save();
        return response()->json(['message'=>'A imagem foi reativada com sucesso'], 200);
    }

    public function checkIfImageCanBeDesactivatesOrDeleted($face){
        if ($face == "tile") {
            $count = Image::where( 'active', '=', '1')->where('face', '=', 'tile')->count();

            if ($count > 40) {
                return true;
            }
        }
        if ($face == "hidden") {
            $count = Image::where( 'active', '=', '1')->where('face', '=', 'hidden')->count();

            if ($count > 1) {
                return true;
            }
        }
        return false;
    }

    public function desactivate(Request $request, $imageId)
    {
        $user = Auth::user();

        if ($user->admin != 1) {
            return response()->json(['message'=>'Erro, você não é um administrador'], 400);
        }

        $image = Image::findOrFail($imageId);
        if ($this->checkIfImageCanBeDesactivatesOrDeleted($image->face)) {
            $image->active = 0;
            $image->save();
            return response()->json(['message'=>'A imagem foi desativada com sucesso'], 200);
        }
        return response()->json(['message'=>'não foi possivel desativar a imagem, verifique o numero de imagens ativas e tente outra vez' ], 400);
    }

    public function uploadImage(Request $request)
    {
        $user = Auth::user();

        if ($user->admin != 1) {
            return response()->json(['message'=>'Erro, você não é um administrador'], 400);
        }

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
        return response()->json(['message'=>'não foi enviada nenhuma imagem' ], 400);
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

    public function delete(Request $request, $imageId)
    {
        $user = Auth::user();

        if ($user->admin != 1) {
            return response()->json(['message'=>'Erro, você não é um administrador'], 400);
        }

        $image = Image::findOrFail($imageId);
        if ($this->checkIfImageCanBeDesactivatesOrDeleted($image->face)) {
            Storage::disk('public_uploads')->delete('img/'.$image->path);
            $image->delete();
            return response()->json(['message'=>'A imagem foi removida com sucesso'], 204);
        }
        return response()->json(['message'=>'não foi possivel apagar a imagem, verifique o numero de imagens ativas e tente outra vez' ], 400);
    }
}
