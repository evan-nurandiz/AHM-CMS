@extends('layouts.admin')

@section('style')
<style>
    p {
        margin: 0px;
    }

    #dashboard .description {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        /* number of lines to show */
        line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    #dashboard .card {
        background: rgba(255, 255, 255, 0.4);
        border: 0.5px solid #A9A9A9;
        box-sizing: border-box;
        border-radius: 12px;
    }

    #dashboard .card img {
        border-top-left-radius: 12px !important;
        border-top-right-radius: 12px !important;
        max-height: 260px;
    }

    #dashboard #add-engine-button{
        height: 320px;
        border-radius: 12px;
    }

    @media only screen and (max-width: 800px) {
        #dashboard #input-image-preview,
        #dashboard #sound-priview {
            height: 200px
        }
    }
</style>
@endsection

@section('content')
<main id="dashboard">
    <div class="row  mb-xs-60">
        <div class="col-12 col-lg-12 py-4 bg-white min-100vh">
            <div class="row justify-content-start gap-2 w-100 mx-0 mt-lg-5">
                @foreach($machines as $machine)
                <div class="col-12 col-lg-3 mt-4 mt-lg-0 machine-wrapper h-lg-100 px-0">
                    <a href="{{route('admin.plant-machine-detail',
                        ['plant_number' => $plant_number,'machine_id' => $machine['id'] ]
                        )}}">
                        <div class="card shadow-md w-100">
                            <img class="card-img-top w-100" src="{{$machine['image'] ? asset('storage/machine_image/'.$machine['image']) : '/image/icon/engine-icon.png'}}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title font-bold">{{$machine['type']}}</h5>
                                <p class="card-text font-light description text-secondary">{{$machine['description']}}</p>
                                <p class="mt-2 text-secondary">
                                    {{ date('d F Y', strtotime($machine['created_at']))}}</ </p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
                <div class="col-12 pb-4 col-lg-3 mt-4 mt-lg-0 machine-wrapper h-lg-100 px-0">
                    <a id="add-engine-button" href="{{route('admin.plant-machine-add',['plant_number' => $plant_number])}}" type="button" 
                    class="d-flex justify-content-center align-items-center bg-base btn w-100">
                        <div>
                            <h1 class="text-white">+</h1>
                            <h3 class="text-white">Tambah Engine</h3>
                        </div>
                    </a>
                </div>
                <div class="d-flex mt-4 justify-content-center">
                    {!! $machines->links() !!}
                </div>
            </div>
        </div>
    </div>
    <main>
        @endsection