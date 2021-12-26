@extends('layouts.admin')

@section('style')
    <style>
        #dashboard-plant .plant{
            max-height:320px;
        }

        @media only screen and (max-width: 800px) {
            #dashboard-plant .plant{
                height:200px
            }
        }
    </style>
@endsection

@section('content')
	<main id="dashboard-plant">
        <div class="row">
            <div class="col-12 px-0 py-4 px-4 bg-white">
                <div class="row justify-content-center">
                    <div class="col-12 plant mb-5 position-relative">
                        <img src="/image/unit.jpg" alt="" class="h-100 w-100 border-16 filter-dark">
                    </div>
                    <div class="col-12 plant mb-5 position-relative">
                        <a href="{{route('admin.plant-engine',['plant_number' => $plant_number])}}">
                            <img src="/image/engine-audit.jpg" alt="" class="h-100 w-100 border-16 filter-dark">
                        </a>
                    </div>
                </div>
            </div>
        </div>
	<main>
@endsection

@section('bottom')
    
@endsection
