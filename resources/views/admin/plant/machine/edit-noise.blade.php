@extends('layouts.admin')

@section('style')
    <style>
        .upload-container{
            height: 300px;
        }
    </style>
@endsection

@section('content')
	<main id="dashboard">
        <div class="col-12 bg-white p-4">
            <h2>Edit Engine Problem</h2>
            <div class="row justify-content-center my-4">
                <div class="col-6 col-lg-2">
                    <img src="/image/icon/engine-icon.png" alt="" class="w-100" id="image">
                </div>
                <div class="col-12 col-lg-10">
                    <h3>{{$data['machine']['type']}}</h3>
                    <p class="description">
                        {{$data['machine']['description']}}
                    </p>
                </div>
            </div>
            <form action="{{route('admin.plant-machine-update-noise',[
                'plant_number' => $data['plant_id'],
                'machine_id' => $data['machine_id'],
                'noise_id' => $data['noise_id'],
            ])}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="exampleFormControlInput1">No Engine <span id="required">*</span></label>
                    <input type="text" class="form-control" required name="code" value="{{$data['machineProblem']['code']}}">
                </div>
                <div class="form-group mb-4">
                    <p>Symptoms Noise<span id="required">*</span></p>
                    <select class="form-select" aria-label="Default select example">
                        <option>Open this select menu</option>
                        @foreach($data['symton_noises'] as $symton_noise)
                            <option value="{{$symton_noise['symton_name']}}" id="symton-noise-input" for="symton_noise" 
                            {{ $data['machineProblem']['symton_noise'] == $symton_noise['symton_name'] ? "selected" : "" }} >{{$symton_noise['symton_name']}}</option>
                        @endforeach
                        <input type="hidden" name="symton_noise" required id="symton_noise" value="{{$data['machineProblem']['symton_noise']}}">
                    </select>
                </div>
                <div class="form-group mb-4" >
                    <p>Area<span id="required">*</span></p>
                    <select class="form-select" aria-label="Default select example" name="area" required value="{{$data['machineProblem']['area']}}">
                        <option>Pilih Area</option>
                        @foreach($data['area'] as $area)
                        <option value="{{$area['area']}}" id="causing-part-input"
                        {{ $data['machineProblem']['area'] == $area['area'] ? "selected" : "" }} >{{$area['area']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Causing Part <span id="required">*</span></label>
                    <input type="text" class="form-control" required name="causing_part" value="{{$data['machineProblem']['causing_part']}}">
                </div>
                <div class="form-group mb-4" >
                    <p>Method <span id="required">*</span></p>
                    <div class="row justify-content-between">
                        @foreach($data['methods'] as $method)
                            <div class="col-lg-3">
                                @if(in_array($method['method'], json_decode($data['machineProblem']['method'])))
                                    <input type="checkbox" id="{{$method['method']}}" name="method[]" value="{{$method['method']}}" checked>
                                @else
                                    <input type="checkbox" id="{{$method['method']}}" name="method[]" value="{{$method['method']}}" >
                                @endif
                                <label for="{{$method['method']}}">{{$method['method']}}</label><br>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group mb-4" >
                    <p>Method <span id="required">*</span></p>
                    <select class="form-select" aria-label="Default select example">
                        <option>Open this select menu</option>
                        @foreach($data['methods'] as $method)
                            <option value="{{$method['method']}}" id="method-input" 
                            {{ $data['machineProblem']['method'] == $method['method'] ? "selected" : "" }} >{{$method['method']}}</option>
                        @endforeach
                        <input type="hidden" name="method" id="method" required value="{{$data['machineProblem']['method']}}">
                    </select>
                </div>
                @if($data['machineProblem']['method'] != 'Idle')
                <div class="form-group mb-4 {{$data['machineProblem']['method'] != 'Idle' ? 'd-block' : 'd-none'}}" id="at-gear-wrap">
                    <p>At Gear</p>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        @foreach($data['at_gears'] as $at_gear)
                            <option value="{{$at_gear['gear']}}" id="at-gear-input" 
                            {{ $data['machineProblem']['at_gear'] == $at_gear['gear'] ? "selected" : "" }} >{{$at_gear['gear']}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="at_gear" id="at-gear" value="{{$data['machineProblem']['at_gear']}}">
                </div>
                @endif
                <div class="justify-content-between align-items-center row mx-0 mb-5">
                    <div class="col-12 px-0 px-lg-2 text-center col-lg-5 rounded p-4 align-items-center justify-content-center" >
                        <img src="{{ asset('storage/machine_diagram/'.$data['machineProblem']['diagram_image']) }}" id="input-image-preview" alt="" class="w-100">
                        <label type="button" class="my-4 btn bg-base text-white rounded w-50 h-25" for="file" accept="image/*">Upload Foto Mesin</label>
                        <input type="file" id="file" class="d-none" name="image_temp"> 
                    </div>
                    <div class="col-12 col-lg-5 text-center mb-2 p-4 ">
                        <audio id="sound" controls src="{{ asset('storage/machine_sound/'.$data['machineProblem']['sound']) }}" ></audio>
                        <label type="button" class="btn bg-base text-white rounded w-50 h-25" for="sound-input" >Upload Suara Mesin</label>
                        <input type="file" id="sound-input" class="d-none"  name="sound_temp">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded-lg">Ubah</button>
            </form>
        </div>
	<main>
@endsection

@section('bottom')
    <script>
        //Symton Noise Dropdown
        const symtonNoiseInput = document.querySelector('#symton_noise')
        const symtonNoiseOptions = document.querySelectorAll('#symton-noise-input')

        symtonNoiseOptions.forEach((symtonNoiseOption,i) => {
            symtonNoiseOption.addEventListener('click',() => {
                symtonNoiseInput.value = symtonNoiseOption.value
            })
        })

        //Causing Parts
        const causingPartInput = document.querySelector('#causing-part')
        const causingPartOptions = document.querySelectorAll('#causing-part-input')
        const BreakDownWrap = document.querySelector('#breakdownpart')
        

        causingPartOptions.forEach((causingPartOption,i) => {
            causingPartOption.addEventListener('click',() => {
                causingPartInput.value = causingPartOption.value
                if(causingPartInput.value == 'Honing CYL Head'){
                    BreakDownWrap.classList.remove("d-none")
                }else{
                    BreakDownWrap.classList.add("d-none")
                    breakDownPartInput.value = ''
                }
            })
        })

        //Breakdown Part
        const breakDownPartInput = document.querySelector('#breakdown-part')
        const breakDownPartOptions = document.querySelectorAll('#breakdown-part-input')

        breakDownPartOptions.forEach((breakDownPartOption, i) => {
            breakDownPartOption.addEventListener('click',() => {
                breakDownPartInput.value = breakDownPartOption.value
            })
        })

        //Method
        const methodInput = document.querySelector('#method')
        const methodInputOptions = document.querySelectorAll('#method-input')
        const atGearWrapper = document.querySelector('#at-gear-wrap')

        methodInputOptions.forEach((methodInputOption, i) => {
            methodInputOption.addEventListener('click',() => {
                methodInput.value = methodInputOption.value
                if(methodInput.value !== 'Idle'){
                    atGearWrapper.classList.remove("d-none")
                }else{
                    atGearWrapper.classList.add("d-none")
                    methodInput.value = ''
                }
            })
        })

        //At Gear
        const gearInput = document.querySelector('#at-gear')
        const gearInputOptions = document.querySelectorAll('#at-gear-input')

        gearInputOptions.forEach((gearInputOption, i) => {
            gearInputOption.addEventListener('click',() => {
                gearInput.value = gearInputOption.value
            })
        })

        //Preview Image
        const imagePreviewCanvas = document.querySelector('#input-image-preview')
        const imageInput = document.querySelector('#file')

        imageInput.addEventListener('input', (e) => {
            const [file] = imageInput.files
            if (file) {
                imagePreviewCanvas.src = URL.createObjectURL(file)
            }
        })

        //Preview Sound
        const SoundCanvas = document.querySelector('#sound')
        const soundInput = document.querySelector('#sound-input')

        soundInput.addEventListener('input',(e) => {
            const [sound] = soundInput.files
            if (sound) {
                SoundCanvas.src = URL.createObjectURL(sound)
            }
        })
    </script>
@endsection
