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
            <h2>Add Machine Problem</h2>
            <div class="row justify-content-center my-4">
                <div class="col-6 col-lg-2 mb-4 mb-lg-0">
                    <img src="/image/icon/engine-icon.png" alt="" class="w-100" id="image">
                </div>
                <div class="col-12 col-lg-10">
                    <h3>K45 Engine</h3>
                    <p class="description">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nihil hic cumque consequatur fugiat. Delectus enim a 
                        perspiciatis excepturi ea asperiores iure voluptas cupiditate nemo et nesciunt, consequuntur sit 
                        laboriosam blanditiis eos velit ullam quis optio illum vel. At reiciendis ullam dolor error corporis, voluptas corrupti?
                    </p>
                </div>
            </div>
            <form action="{{route('admin.plant-machine-add-noise.store',[
                'machine_id' => $data['machine_id'],
                'plant_number' => $data['plant_id']
            ])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-4">
                    <p>Symton Noise <span id="required">*</span></p>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        @foreach($data['symton_noises'] as $symton_noise)
                            <option value="{{$symton_noise['symton_name']}}" id="symton-noise-input" for="symton_noise">{{$symton_noise['symton_name']}}</option>
                        @endforeach
                        <input type="hidden" name="symton_noise" required id="symton_noise">
                    </select>
                </div>
                <div class="form-group mb-4" >
                    <p>Part Penyebab <span id="required">*</span></p>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        @foreach($data['cause_parts'] as $cause_part)
                        <option value="{{$cause_part['causing_part']}}" id="causing-part-input">{{$cause_part['causing_part']}}</option>
                        @endforeach
                        <input type="hidden" name="causing_part" required id="causing-part">
                    </select>
                </div>
                <div class="form-group mb-4 d-none" id="breakdownpart">
                    <p>Breakdown Part</p>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        @foreach($data['breakdown_parts'] as $breakdown_part)
                        <option value="{{$breakdown_part['part']}}" id="breakdown-part-input">{{$breakdown_part['part']}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="breakdown_part" id="breakdown-part">
                </div>
                <div class="form-group mb-4" >
                    <p>Method <span id="required">*</span></p>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        @foreach($data['methods'] as $method)
                            <option value="{{$method['method']}}" id="method-input">{{$method['method']}}</option>
                        @endforeach
                        <input type="hidden" name="method" required id="method">
                    </select>
                </div>
                <div class="form-group mb-4 d-none" id="at-gear-wrap">
                    <p>At Gear</p>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        @foreach($data['at_gears'] as $at_gear)
                            <option value="{{$at_gear['gear']}}" id="at-gear-input">{{$at_gear['gear']}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="at_gear" id="at-gear">
                </div>
                <div class="upload-container justify-content-between row mx-0 mb-5">
                    <div class="col-12 mb-4 mb-lg-0 col-lg-5 rounded border-doted p-4 d-flex align-items-center justify-content-center" id="input-image-preview">
                        <label type="button" class="btn bg-base text-white rounded w-50 h-25" for="file" accept="image/*">Upload Foto Mesin </label>
                        <input type="file" id="file" class="d-none" required name="image_temp">
                    </div>
                    <div class="col-12 col-lg-5 rounded border-doted p-4 " id="sound-priview">
                        <audio id="sound" controls class="d-none"></audio>
                        <div class="d-flex align-items-center justify-content-center h-100" >
                            <label type="button" class="btn bg-base text-white rounded w-50 h-25" for="sound-input" >Upload Suara Mesin</label>
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
