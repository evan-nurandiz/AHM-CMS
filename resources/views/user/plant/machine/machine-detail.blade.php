@extends('layouts.user')

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
            <form action="{{route('user.plant-machine-filter',[
                'plant_number' => $data['plant_id'],
                'machine_id' => $data['machine']['id']
            ])}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-start mx-0">
                    <div class="col-12 mb-2 mb-lg-0 col-lg-2 pl-0">
                        <input type="text" class="form-control" placeholder="Kode Mesin" name="code">
                    </div>
                    <div class="col-6 mb-2 mb-lg-0 col-lg-2 pl-0 pl-lg-2">
                        <select class="form-select" aria-label="Default select example"  name="symton_noise"  id="symton_noise">
                            <option selected value="">Open this select menu</option>
                            @foreach($data['symptons_noises'] as $symton_noise)
                                <option value="{{$symton_noise['symton_name']}}" id="symton-noise-input" for="symton_noise">{{$symton_noise['symton_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-2 mb-lg-0 col-lg-2">
                        <select class="form-select" aria-label="Default select example" name="causing_part" id="causing-part">
                            <option selected value="">Part Penyebab</option>
                            @foreach($data['cause_parts'] as $cause_part)
                            <option value="{{$cause_part['causing_part']}}" id="causing-part-input">{{$cause_part['causing_part']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-2 mb-lg-0 col-lg-2 pl-0 pl-lg-2">
                        <select class="form-select" aria-label="Default select example"  name="method" id="method">
                            <option selected value="">Metode</option>
                            @foreach($data['method'] as $method)
                                <option value="{{$method['method']}}" id="method-input">{{$method['method']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-2 mb-lg-0 col-lg-2">
                        <select class="form-select" aria-label="Default select example" name="date" id="date">
                            <option selected value="">Tanggal</option>
                            <option value="desc" id="symton-noise-input" for="date">Terbaru</option>
                            <option value="asc" id="symton-noise-input" for="date">Terlama</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-2 pl-0 pl-lg-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
            <div class="row justify-content-center">
                <div class="col-sm-12 mt-lg-4">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-top-0">No</th>
                                    <th class="border-top-0">Kode Mesin</th>
                                    <th class="border-top-0">Symptoms Noise</th>
                                    <th class="border-top-0">Part Penyebab</th>
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
