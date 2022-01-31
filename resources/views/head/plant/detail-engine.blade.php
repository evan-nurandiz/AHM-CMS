@extends('layouts.head')

@section('style')
<style>
    #dashboard-plant .wrapper {
        min-height: 700px;
    }

    #dashboard-plant .plant {
        max-height: 320px;
    }

    @media only screen and (max-width: 800px) {
        #dashboard-plant .plant {
            height: 200px !important;
        }
    }
</style>
@endsection

@section('content')
<main id="dashboard-plant">
    <div class="row wrapper mb-xs-60">
        <div class="col-12 px-0 py-4 px-4 bg-white">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6 plant mb-5 position-relative">
                    <img src="/image/mesin-performa.png" alt="" class="h-100 w-100 border-16 filter-dark">
                    <div class="position-absolute top-0 w-100 h-100 align-items-center justify-content-center d-flex">
                        <div class="text-center">
                            <h2 class="text-white font-bold">Performance</h2>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 plant mb-5 position-relative">
                    <img src="/image/Audit-Kinerja.jpg" alt="" class="h-100 w-100 border-16 filter-dark">
                    <div class="position-absolute top-0 w-100 h-100 align-items-center justify-content-center d-flex">
                        <div class="text-center">
                            <h2 class="text-white font-bold">Audit</h2>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 plant mb-5 position-relative">
                    <a href="{{route('head.plant-machine-list',['plant_number' => $plant_number])}}">
                        <img src="/image/noise.jpg" alt="" class="h-100 w-100 border-16 filter-dark">
                        <div class="position-absolute top-0 w-100 h-100 align-items-center justify-content-center d-flex">
                            <div class="text-center">
                                <h2 class="text-white font-bold">Noise</h2>
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