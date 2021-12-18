<?php
namespace App\Models;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function uploadContent($name_to_db, $input_name, $main_folder = '' , $table, $column)
    {
        $image = request()->file($input_name);
        $name_in_db = time() . '-' . request()->file($input_name)->getClientOriginalName();

        $find_image_name = DB::table($table)->select($column)->where($column, $name_in_db)->get();

        if(empty($find_image_name[0])) {
            $image->storeAs($main_folder,$name_in_db,'public');    
            return request()->merge([$name_to_db => $name_in_db]);
        }

        $name_in_db2 = time() . '-' . request()->file($input_name)->getClientOriginalName();
        $image->storeAs($main_folder,$name_in_db,'public');    
        return request()->merge([$name_to_db => $name_in_db]);
    }
}