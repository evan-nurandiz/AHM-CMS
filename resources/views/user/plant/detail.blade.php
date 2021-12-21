@extends('layouts.user')

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
                        <div class="position-absolute top-0 w-100 h-100 align-items-center justify-content-center d-flex">
                            <div class="text-center">
                                <h2 class="text-white font-bold">Unit</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 plant mb-5 position-relative">
                        <a href="{{route('user.plant-detail-engine',['plant_number' => $plant_number])}}">
                            <img src="/image/engine-audit.jpg" alt="" class="h-100 w-100 border-16 filter-dark">
                            <div class="position-absolute top-0 w-100 h-100 align-items-center justify-content-center d-flex">
                                <div class="text-center">
                                    <h2 class="text-white font-bold">Engine</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
	<main>
@endsection

@section('bottom')
    
@endsection
