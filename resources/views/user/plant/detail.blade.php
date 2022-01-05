@extends('layouts.user')

@section('style')
    <style>
        #dashboard-plant .wrapper{
            min-height:700px;
        }
        #dashboard-plant .plant{
            max-height:320px;
        }

        @media only screen and (max-width: 800px) {
            #dashboard-plant .plant{
                height:200px
            }

            #dashboard-plant .wrapper{
                min-height:500px;
            }
        }
    </style>
@endsection

@section('content')
	<main id="dashboard-plant">
        <div class="row wrapper">
            <div class="col-12 px-0 py-4 px-4 bg-white">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-6 plant mb-5 position-relative">
                        <img src="/image/unit.jpg" alt="" class="h-100 w-100 border-16 filter-dark">
                    </div>
                    <div class="col-12 col-lg-6 plant mb-5 position-relative">
                        <a href="{{route('user.plant-detail-engine',['plant_number' => $plant_number])}}">
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
