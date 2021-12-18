@extends('layouts.user')

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
