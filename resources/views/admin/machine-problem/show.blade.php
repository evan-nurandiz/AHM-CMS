@extends('layouts.admin')

@section('style')
    <style>
        
    </style>
@endsection

@section('content')
	<main id="machine-problem-show">
        <div class="row justify-content-center mx-0">
            <div class="col-12 bg-white p-4">
                <div class="d-flex justify-content-between">
                    <h4>{{$machine['type']}}</h4>
                    <a href="{{route('admin.machine-problem-edit',['id' => $machineProblem['id']])}}">
                        <button type="button" class="btn btn-info text-white">Edit</button>
                    </a>
                </div>
                <div class="row align-items-center mt-4">
                    <div class="col-6">
                        <p>Grafik Mesin</p>
                        <img src="{{ asset('storage/machine_diagram/'.$machineProblem['diagram_image']) }}" alt="" class="w-100">
                    </div>
                    <div class="col-6">
                        <p>Suara Mesin</p>
                        <audio src="{{ asset('storage/machine_sound/'.$machineProblem['sound']) }}" controls></audio>
                    </div>
                </div>
                <div class="mt-4">
                    <h5>Symton Noise</h5>
                    <h4>{{$machineProblem['symton_noise']}}</h4>
                </div>
                <div class="mt-4">
                    <h5>Causing Part</h5>
                    <h4>{{$machineProblem['causing_part']}}</h4>
                </div>
                @if($machineProblem['causing_part'] == 'Honing CYL Head')
                <div class="mt-4">
                    <h5>Break Down Part</h5>
                    <h4>{{$machineProblem['breakdown_part']}}</h4>
                </div>
                @endif
                <div class="mt-4">
                    <h5>Method</h5>
                    <h4>{{$machineProblem['method']}}</h4>
                </div>
                @if($machineProblem['method'] != 'Idle')
                <div class="mt-4">
                    <h5>At Gear</h5>
                    <h4>{{$machineProblem['at_gear']}}</h4>
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
