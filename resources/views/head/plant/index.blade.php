@extends('layouts.head')

@section('style')
<style>
    p {
        margin: 0px !important;
    }

    #request-noise .plant {
        height: 320px;
    }

    @media only screen and (max-width: 800px) {
        #request-noise .plant {
            height: 200px
        }
    }
</style>
@endsection

@section('content')
<main id="request-noise">
    <div class="row mb-xs-60">
        <div class="col-12 px-0 py-4 px-4 bg-white">
            <div class="row justify-content-center mx-0">
                @foreach($plants as $plant)
                <div class="col-12 col-lg-4 plant mb-5 position-relative">
                    <a href="{{route('head.plant-detail',['plant_number' => $plant['id']])}}">
                        <img src="/image/{{$plant['image']}}" alt="" class="h-100 w-100 border-16 filter-dark">
                        <div class="position-absolute top-0 w-100 h-100 align-items-center justify-content-center d-flex">
                            <div class="text-center">
                                <h2 class="text-white font-bold">{{$plant['name']}}</h2>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <main>
        @endsection

        @section('bottom')

        @endsection