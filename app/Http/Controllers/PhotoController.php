<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Action déclenchée par l'API pour avoir la liste des photos disponibles
     * @return array La liste des photos (json)
     */
    function index() {
        $path = self::path();
        $photos = glob("$path/*.*");
        $photos = array_map(function($photo) use ($path) {
            return str_replace($path, "//".$_SERVER['HTTP_HOST']."/photos", $photo);
        }, $photos);
        return $photos;
    }

    /**
     * Action déclenchée par l'API pour ajouter des photos
     * @return array La liste des nouvelles photos (json)
     */
    function store() {
        $resultat = [];
		$keys = array_keys($_FILES['photos']['tmp_name']);
        foreach($keys as $key) {
            $resultat[] = self::traiterPhoto($key, uniqid());
        }
        return $resultat;
    }

    /**
     * Retourne le chemin vers une photo donnée
     * @param  string [$fic] Optionnel. Un nom de fichier.
     * @return string Le chemin vers la photo
     */
    static function path($fic = "") {
        $path = \public_path("photos");
        if ($fic) {
            $path .= "/" . $fic;
        }
        return $path;
    }
    /**
     * Retourne l'url d'une photo donnée
     * @param  string [$fic] Optionnel. Un nom de fichier.
     * @return string L'url de la photo
     */
    static function url($fic = "") {
        $url = "//".$_SERVER['HTTP_HOST']."/photos";
        if ($fic) {
            $url .= "/" . $fic;
        }
        return $url;
    }
    /**
     * Déplace sa photo vers sa destination finale
     * @param  integer $idx L'indice du fichier dans FILES
     * @return string  L'URL final de la photo
     */
    static function traiterPhoto($idx, $nom = "") {
        $tmp_name = $_FILES['photos']['tmp_name'][$idx];
		$name = $_FILES['photos']['name'][$idx];
        if ($nom) {
			$ext = array_slice(explode(".", $name), -1)[0];
			$nomfic = $nom . "." . $ext;
		} else {
			$nomfic = $name;

		}
        if (\is_uploaded_file($tmp_name)) {
            \move_uploaded_file($tmp_name, self::path($nomfic));
        }
        return self::url($nomfic);
    }
}
