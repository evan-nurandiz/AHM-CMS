@extends('layouts.admin')

@section('style')
    <style>
        #dashboard .description{
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3; /* number of lines to show */
            -webkit-box-orient: vertical;
        }

        #dashboard .plant, {
            max-height:320px;
        }
    </style>
@endsection

@section('content')
	<main id="dashboard">
        <div class="row">
            <div class="col-12 px-0 py-4 px-4 bg-white">
                <div class="row mx-0">
                    <div class="col-12 plant mb-5 position-relative">
                        <img src="/image/plant.jpg" alt="" class="h-100 w-100 border-16 filter-dark">
                        <div class="position-absolute top-0 w-100 h-100 align-items-center justify-content-center d-flex">
                            <div class="text-center">
                                <h2 class="text-white font-bold">5 Plant</h2>
                                <button class="btn bg-base text-white px-4">Detail Plant</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 plant position-relative">
                        <img src="/image/engine.jpg" alt="" class="h-100 w-100 border-16 filter-dark">
                        <div class="position-absolute top-0 w-100 pr-5 h-100 align-items-center justify-content-center d-flex">
                            <div class="text-center">
                                <h2 class="text-white font-bold">50 Mesin</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 plant position-relative">
                        <img src="/image/employee.jpg" alt="" class="h-100 w-100 border-16 filter-dark">
                        <div class="position-absolute top-0 w-100 pr-5 h-100 align-items-center justify-content-center d-flex">
                            <div class="text-center">
                                <h2 class="text-white font-bold">200 User</h2>
                                <button class="btn bg-base text-white px-4">Detail User</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<main>
@endsection
