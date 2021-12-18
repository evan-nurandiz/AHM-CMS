@extends('layouts.admin')

@section('style')
    <style>
        #dashboard .description{
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3; /* number of lines to show */
            line-clamp: 3; 
            -webkit-box-orient: vertical;
        }

        #dashboard .machine-wrapper{
            height:126px;
            max-height:126px;
        }
    </style>
@endsection

@section('content')
	<main id="dashboard">
        <div class="row">
            <div class="col-12 col-lg-12 py-4 bg-white">
                <div class="d-flex justify-content-between">
                    <h3>List Mesin</h4>
                    <a href="{{route('admin.plant-machine-add',['plant_number' => $plant_number])}}">
                        <button type="button" class="btn bg-base rounded text-white">Tambah Mesin</button>
                    </a>  
                </div>
                <div class="row gap-2 w-100 mx-0">
                    @foreach($machines as $machine)
                    <div class="col-12 col-lg-3 mt-4 mt-lg-0 machine-wrapper h-lg-100">
                        <a href="{{route('admin.plant-machine-detail',
                        ['plant_number' => $plant_number,'machine_id' => $machine['id'] ]
                        )}}">
                            <div class="row align-items-center border rounded-md p-2 shadow h-100">
                                <div class="col-4">
                                    <img src="{{$machine['image'] ? asset('storage/machine_image/'.$machine['image']) : '/image/icon/engine-icon.png'}}" alt="" class="w-100">
                                </div>
                                <div class="col-8">
                                    <h4>{{$machine['type']}}</h4>
                                    <p class="description text-secondary">{{$machine['description']}}
                                    </p>
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
