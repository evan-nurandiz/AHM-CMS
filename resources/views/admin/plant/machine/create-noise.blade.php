@extends('layouts.admin')

@section('style')
    <style>
        .upload-container{
            min-height: 300px;
        }

        @media only screen and (max-width: 800px) {
            #dashboard #input-image-preview, #dashboard #sound-priview{
                height:200px
            }
        }
    </style>
@endsection

@section('content')
	<main id="dashboard">
        <div class="col-12 bg-white p-4">
            <h2>engine problem</h2>
            <div class="row justify-content-center my-4">
                <div class="col-6 col-lg-2 mb-4 mb-lg-0">
                    <img src="/image/icon/engine-icon.png" alt="" class="w-100" id="image">
                </div>
                <div class="col-12 col-lg-10">
                    <h3>{{$data['machine']['type']}}</h3>
                    <p class="description">
                        {{$data['machine']['description']}}
                    </p>
                </div>
            </div>
            <form action="{{route('admin.plant-machine-add-noise.store',[
                'machine_id' => $data['machine_id'],
                'plant_number' => $data['plant_id']
            ])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput1">No Engine <span id="required">*</span></label>
                    <input type="text" class="form-control" required name="code">
                </div>
                <div class="form-group mb-4">
                    <p>Symptoms Noise <span id="required">*</span></p>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        @foreach($data['symton_noises'] as $symton_noise)
                            <option value="{{$symton_noise['symton_name']}}" id="symton-noise-input" for="symton_noise">{{$symton_noise['symton_name']}}</option>
                        @endforeach
                        <input type="hidden" name="symton_noise" required id="symton_noise">
                    </select>
                </div>
                <div class="form-group mb-4" >
                    <p>Area <span id="required">*</span></p>
                    <select class="form-select" aria-label="Default select example" name="area">
                        <option selected>Pilih Area</option>
                        @foreach($data['area'] as $area)
                        <option value="{{$area['area']}}" id="causing-part-input">{{$area['area']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Causing Part <span id="required">*</span></label>
                    <input type="text" class="form-control" required name="causing_part">
                </div>
                <div class="form-group mb-4" >
                    <p>Method <span id="required">*</span></p>
                    <div class="row justify-content-between">
                        @foreach($data['methods'] as $method)
                            <div class="col-lg-3">
                                <input type="checkbox" id="{{$method['method']}}" name="method[]" value="{{$method['method']}}">
                                <label for="{{$method['method']}}">{{$method['method']}}</label><br>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group mb-4" id="at-gear-wrap">
                    <p>At Gear</p>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Pilih at gear</option>
                        @foreach($data['at_gears'] as $at_gear)
                            <option value="{{$at_gear['gear']}}" id="at-gear-input">{{$at_gear['gear']}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="at_gear" id="at-gear">
                </div>
                <div class="upload-container justify-content-between row mx-0 mb-5">
                    <div class="col-12 mb-4 mb-lg-0 col-lg-5 rounded border-doted p-4 d-flex align-items-center justify-content-center" id="input-image-preview">
                        <label type="button" class="btn bg-base text-white rounded w-50 h-25" for="file" accept="image/*">Upload Foto</label>
                        <input type="file" id="file" class="d-none" required name="image_temp">
                    </div>
                    <div class="col-12 col-lg-5 rounded border-doted p-4 " id="sound-priview">
                        <audio id="sound" controls class="d-none"></audio>
                        <div class="d-flex align-items-center justify-content-center h-100" >
                            <label type="button" class="btn bg-base text-white rounded w-50 h-25" for="sound-input" >Suara</label>
                            <input type="file" id="sound-input" class="d-none" required name="sound_temp">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded-lg">Simpan</button>
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
                imagePreviewCanvas.style.backgroundImage = 'url('+URL.createObjectURL(file)+')'; 
                imagePreviewCanvas.style.backgroundSize = 'cover'
            }
        })

        //Preview Sound
        const SoundCanvas = document.querySelector('#sound')
        const soundInput = document.querySelector('#sound-input')

        soundInput.addEventListener('input',(e) => {
            const [sound] = soundInput.files
            if (sound) {
                SoundCanvas.src = URL.createObjectURL(sound)
                SoundCanvas.classList.remove("d-none")
            }
        })
    </script>
@endsection
