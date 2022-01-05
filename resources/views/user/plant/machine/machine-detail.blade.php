@extends('layouts.user')

@section('style')
    <style>
        
    </style>
@endsection

@section('content')
	<main id="dashboard">
        <div class="col-12 bg-white p-4">
            <div class="row justify-content-center justify-content-lg-start my-4">
                <div class="col-6 col-lg-2 mb-2 mb-lg-0">
                    <img src="{{$data['machine']['image'] ? asset('storage/machine_image/'.$data['machine']['image']) : '/image/icon/engine-icon.png'}}" alt="" class="w-100" id="image">
                </div>
                <div class="col-12 col-lg-10">
                    <h3 class="font-bold">{{$data['machine']['type']}}</h3>
                    <p class="description font-light text-secondary">
                       {{$data['machine']['description']}}
                    </p>
                </div>
            </div>
            <div class="accordion accordion-flush mb-2" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Filter Noise
                    </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body py-2 px-0 p-lg-2">
                            <form action="{{route('user.plant-machine-filter',[
                                'plant_number' => $data['plant_id'],
                                'machine_id' => $data['machine']['id']
                            ])}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row justify-content-start mx-0">
                                    <div class="col-12 mb-2 mb-lg-3 col-lg-6 pl-0">
                                        <input type="text" class="form-control" placeholder="Kode Engine" name="code">
                                    </div>
                                    <div class="col-12 mb-2 mb-lg-3 col-lg-6 pl-0">
                                        <input type="text" class="form-control" placeholder="Causing Part" name="causing_part">
                                    </div>
                                    <div class="col-12 mb-3 px-lg-0">
                                        <p>Symptoms Noise</p>
                                        <div class="row mx-0">
                                            @foreach($data['symptons_noises'] as $symton_noise)
                                            <div class="col-6 col-lg pl-0">
                                                <input class="form-check-input" type="checkbox" id="{{$symton_noise['symton_name']}}" value="{{$symton_noise['symton_name']}}" name="symton_noise[]">
                                                <label class="form-check-label" for="{{$symton_noise['symton_name']}}">
                                                    {{$symton_noise['symton_name']}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mb-3 pl-lg-0">
                                        <p>Method</p>
                                        <div class="row mx-0">
                                            @foreach($data['method'] as $method)
                                            <div class="col-6 col-lg pl-0">
                                                <input class="form-check-input" type="checkbox" value="{{$method['method']}}" id="{{$method['method']}}" name="method[]">
                                                <label class="form-check-label" for="{{$method['method']}}">
                                                    {{$method['method']}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3 px-lg-0">
                                        <p>Area</p>
                                        <div class="row mx-0">
                                            @foreach($data['area'] as $area)
                                            <div class="col-12 col-lg pl-lg-0 px-0">
                                                <input class="form-check-input" type="checkbox" id="{{$area['area']}}" value="{{$area['area']}}" name="area[]">
                                                <label class="form-check-label" for="{{$area['area']}}">
                                                    {{$area['area']}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4 px-lg-0">
                                        <p>Tanggal</p>
                                        <div class="row mx-0">
                                            <div class="col pl-0">
                                                <input class="form-check-input" type="radio" value="desc" name="date" id="asc">
                                                <label class="form-check-label" for="asc">
                                                    Terbaru
                                                </label>
                                            </div>
                                            <div class="col pl-0">
                                                <input class="form-check-input" type="radio" value="asc" name="date" id="desc">
                                                <label class="form-check-label" for="desc">
                                                    Terlama
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 pl-0 px-0 pl-lg-2">
                                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
            <div class="col-sm-12 mt-lg-4">
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th class="border-top-0">No</th>
                                <th class="border-top-0">Kode Engine</th>
                                <th class="border-top-0">Symptoms Noise</th>
                                <th class="border-top-0">Part Penyebab</th>
                                <th class="border-top-0">Area</th>
                                <th class="border-top-0">Method</th>
                                <th class="border-top-0">Tanggal Input</th>
                                <th class="border-top-0">Action</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach ($data['machineProblems'] as $machineProblem)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$machineProblem['code']}}</td>
                                    <td>{{$machineProblem['symton_noise']}}</td>
                                    <td>{{$machineProblem['causing_part']}}</td>
                                    <td>{{$machineProblem['area']}}</td>
                                    <td>{{$machineProblem['method']}}</td>
                                    <td>{{ date('d F Y', strtotime($machineProblem['created_at']))}}</td>
                                    <td>
                                        <a href="{{route('user.plant-machine-noise',[
                                            'plant_number' => $data['plant_id'],
                                            'machine_id' => $data['machine']['id'],
                                            'noise_id' => $machineProblem->id
                                            ])}}">
                                            <button type="button" class="btn btn-primary">Detail</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex mt-4 justify-content-center">
                    {!! $data['machineProblems']->links() !!}
                </div>
            </div>
        </div>
        </div>
	<main>
@endsection

@section('bottom')
    
@endsection
