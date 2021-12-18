@extends('layouts.admin')

@section('style')
    <style>
        
    </style>
@endsection

@section('content')
	<main id="dashboard">
        <div class="col-12 bg-white p-4">
            <div class="row justify-content-end">
                <div class="col-12 col-lg-6 d-flex justify-content-between justify-content-lg-end">
                    <form action="{{route('admin.plant-machine-delete',[
                            'plant_number' => $data['plant_id'],
                            'machine_id' => $data['machine']['id']
                        ])}}" method="post">
                        @csrf
                        @method('delete')
                        <a href="{{route('admin.plant-machine-add-noise',[
                            'plant_number' => $data['plant_id'],
                            'machine_id' => $data['machine']['id']
                        ])}}">
                            <button type="button" class="btn btn-info text-white">Tambah Symton Noise</button>
                        </a>
                        <a href="{{route('admin.plant-machine-edit',[
                            'plant_number' => $data['plant_id'],
                            'machine_id' => $data['machine']['id']
                        ])}}">
                            <button type="button" class="btn btn-info text-white">Edit</button>
                        </a>
                        <button type="submit" class="btn bg-base text-white" onclick="return confirm('Are you sure?')">Hapus Mesin</button>
                    </form>
                </div>
            </div>
            <div class="row justify-content-center justify-content-lg-start my-4">
                <div class="col-6 col-lg-2 mb-2 mb-lg-0">
                    <img src="/image/icon/engine-icon.png" alt="" class="w-100" id="image">
                </div>
                <div class="col-12 col-lg-10">
                    <h3>{{$data['machine']['type']}}</h3>
                    <p class="description">
                       {{$data['machine']['description']}}
                    </p>
                </div>
            </div>
            <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th class="border-top-0">No</th>
                                <th class="border-top-0">Symton Noise</th>
                                <th class="border-top-0">Part Penyebab</th>
                                <th class="border-top-0">Method</th>
                                <th class="border-top-0">Action</th>
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach ($data['machineProblems'] as $machineProblem)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$machineProblem['symton_noise']}}</td>
                                    <td>{{$machineProblem['causing_part']}}</td>
                                    <td>{{$machineProblem['method']}}</td>
                                    <td>
                                        <a href="{{route('admin.plant-machine-show-noise',[
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
