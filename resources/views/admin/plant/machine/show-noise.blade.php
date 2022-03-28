@extends('layouts.admin')

@section('style')
<style>
    p {
        margin: 0px;
    }
</style>
@endsection

@section('content')
<main id="machine-problem-show">
    <div class="row justify-content-center mx-0  mb-xs-60">
        <div class="col-12 bg-white p-4">
            <div class="d-flex justify-content-between">
                <h4>{{$data['machine']['type']}}</h4>
                <div class="d-flex justify-content-end gap-3">
                    <form action="{{route('admin.plant-machine-destroy',[
                            'plant_number' => $data['plant_id'],
                            'machine_id' => $data['machine_id'],
                            'noise_id' => $data['noise_id']
                        ])}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn bg-base text-white" onclick="return confirm('Are you sure?')">Hapus Symtom Noise</button>
                    </form>
                </div>
            </div>
            <div class="row justify-content-center align-items-center mt-4">
                <div class="col-12 col-lg-6 mb-3 mb-lg-0 text-center">
                    <video controls src="{{ asset('storage/machine_vidio/'.$data['machineProblem']['vidio']) }}" class="w-100">
                        Your browser does not support HTML video.
                    </video>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-secondary mb-1">Symton Noise</p>
                <h4>{{$data['machineProblem']['symton_noise']}}</h4>
            </div>
            <div class="mt-4">
                <p class="text-secondary mb-1">Area</p>
                <h4>{{$data['machineProblem']['area']}}</h4>
            </div>
            <div class="mt-4">
                <p class="text-secondary mb-1">Causing Part</p>
                <h4>{{$data['machineProblem']['causing_part']}}</h4>
            </div>
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
            <div class="mt-4">
                <p class="text-secondary mb-1">Deskripsi</p>
                <h4>{{$data['machineProblem']['description']}}</h4>
            </div>
        </div>
    </div>
    <main>
        @endsection

        @section('bottom')
        <script>

        </script>
        @endsection