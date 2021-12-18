@extends('layouts.admin')

@section('style')
    <style>
        p{
            margin:0px;
        }
    </style>
@endsection

@section('content')
	<main id="machine-problem-show">
        <div class="row justify-content-center mx-0">
            <div class="col-12 bg-white p-4">
                <div class="d-flex justify-content-between">
                    <h4>{{$data['machine']['type']}}</h4>
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{route('admin.plant-machine-edit-noise',[
                            'plant_number' => $data['plant_id'],
                            'machine_id' => $data['machine_id'],
                            'noise_id' => $data['noise_id'],
                        ])}}">
                            <button type="button" class="btn btn-info text-white">Edit</button>
                        </a>
                        <form action="{{route('admin.plant-machine-destroy',[
                            'plant_number' => $data['plant_id'],
                            'machine_id' => $data['machine_id'],
                            'noise_id' => $data['noise_id']
                        ])}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn bg-base text-white" onclick="return confirm('Are you sure?')">Hapus Mesin</button>
                        </form>
                    </div>
                </div>
                <div class="row align-items-center mt-4">
                    <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                        <p>Grafik Mesin</p>
                        <img src="{{ asset('storage/machine_diagram/'.$data['machineProblem']['diagram_image']) }}" alt="" class="w-100">
                    </div>
                    <div class="col-12 col-lg-6">
                        <p>Suara Mesin</p>
                        <audio src="{{ asset('storage/machine_sound/'.$data['machineProblem']['sound']) }}" controls></audio>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-secondary mb-1">Symton Noise</p>
                    <h4>{{$data['machineProblem']['symton_noise']}}</h4>
                </div>
                <div class="mt-4">
                    <p class="text-secondary mb-1">Causing Part</p>
                    <h4>{{$data['machineProblem']['causing_part']}}</h4>
                </div>
                @if($data['machineProblem']['causing_part'] == 'Honing CYL Head')
                <div class="mt-4">
                    <p class="text-secondary mb-1">Break Down Part</p>
                    <h4>{{$data['machineProblem']['breakdown_part']}}</h4>
                </div>
                @endif
                <div class="mt-4">
                    <p class="text-secondary mb-1">Method</p>
                    <h4>{{$data['machineProblem']['method']}}</h4>
                </div>
                @if($data['machineProblem']['method'] != 'Idle')
                <div class="mt-4">
                    <p class="text-secondary mb-1">At Gear</p>
                    <h4>{{$data['machineProblem']['at_gear']}}</h4>
                </div>
                @endif
            </div>
        </div>
	<main>
@endsection

@section('bottom')
    <script>
        
    </script>
@endsection
