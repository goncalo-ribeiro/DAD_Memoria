<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class ImageControllerAPI extends Controller
{
    public function getImages(Request $request)
    {
        return Image::all();
    }
}
