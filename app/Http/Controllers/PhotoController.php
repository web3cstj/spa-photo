<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoController extends Controller
{
    static function path($fic = "") {
        $path = \public_path("photos");
        if ($fic) {
            $path .= "/" . $fic;
        }
        return $path;
    }
    static function url($fic = "") {
        $url = "//".$_SERVER['HTTP_HOST']."/photos";
        if ($fic) {
            $url .= "/" . $fic;
        }
        return $url;
    }
    function index() {
        $path = self::path();
        $photos = glob("$path/*.jpg");
        $photos = array_map(function($photo) use ($path) {
            return str_replace($path, "//".$_SERVER['HTTP_HOST']."/photos", $photo);
        }, $photos);
        return $photos;
    }
    function store(Request $request) {
        $fic = $_FILES['file'];
        $nomfic = uniqid().'_'.$fic['name'];
        if (\is_uploaded_file($fic['tmp_name'])) {
            \move_uploaded_file($fic['tmp_name'], self::path($nomfic));
        }
        return self::url($nomfic);
    }
}
