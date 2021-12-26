<?php

namespace App\Helpers;

class ExtractJSONHelpers {
    public static function getMachines()
    {
        $path = public_path('data\machine_list.json');
        return json_decode(file_get_contents($path), true);
    }

    public static function getSymtonNoise()
    {
        $path = public_path('data/symton_noise.json');
        return json_decode(file_get_contents($path), true);
    }

    public static function getBreakdownPart(){
        $path = public_path('data/breakdown_part.json');
        return json_decode(file_get_contents($path), true);
    }

    public static function getCausingPart(){
        $path = public_path('data/causing_part.json');
        return json_decode(file_get_contents($path), true);
    }

    public static function getMethodList(){
        $path = public_path('data/method.json');
        return json_decode(file_get_contents($path), true);
    }

    public static function getAtgearPart(){
        $path = public_path('data/at_gear.json');
        return json_decode(file_get_contents($path), true);
    }

    public static function getPlantList(){
        $path = public_path('data/plant_list.json');
        return json_decode(file_get_contents($path), true);
    }

    public static function getArea(){
        $path = public_path('data/area.json');
        return json_decode(file_get_contents($path), true);
    }
}
