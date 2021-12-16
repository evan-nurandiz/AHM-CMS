<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Helpers\ExtractJsonHelpers;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plants = ExtractJsonHelpers::getPlantList();
        return view('admin.plant.index',compact('plants'));
    }

    public function detail($plant_number){
        return view('admin.plant.detail');
    }
}
