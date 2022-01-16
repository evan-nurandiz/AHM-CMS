@extends('layouts.user')

@section('style')
<style>
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
</style>
@endsection

@section('content')
<main id="dashboard">
    <div class="row">
        <div class="col-12 col-lg-12 py-4 bg-white min-100vh mb-xs-60">
            <div class="d-flex justify-content-between">
                <h3>List Engine</h4>
            </div>
            <div class="row gap-2 w-100 mx-0">
                @foreach($machines as $machine)
                <div class="col-12 col-lg-3 mt-4 mt-lg-5 machine-wrapper h-lg-100 px-0">
                    <a href="{{route('user.plant-machine-detail',
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
                <div class="d-flex mt-4 justify-content-center">
                    {!! $machines->links() !!}
                </div>
            </div>
        </div>
    </div>
    <main>
        @endsection