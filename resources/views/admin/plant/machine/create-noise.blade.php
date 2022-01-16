@extends('layouts.admin')

@section('style')
<style>
    .upload-container {
        min-height: 300px;
    }

    @media only screen and (max-width: 800px) {

        #dashboard #input-image-preview,
        #dashboard #sound-priview {
            height: 200px
        }
    }
</style>
@endsection

@section('content')
<main id="dashboard">
    <div class="col-12 bg-white p-4  mb-xs-60">
        <h2>Engine problem</h2>
        <div class="row justify-content-center my-4">
            <div class="col-6 col-lg-2 mb-4 mb-lg-0">
                <img src="{{$data['machine']['image'] ? asset('storage/machine_image/'.$data['machine']['image']) : '/image/icon/engine-icon.png'}}" alt="" class="w-100" id="image">
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
            <div class="form-group mb-4">
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
            <div class="form-group mb-4">
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
                <select class="form-select" aria-label="Default select example" name="at_gear">
                    <option selected>Pilih at gear</option>
                    @foreach($data['at_gears'] as $at_gear)
                    <option value="{{$at_gear['gear']}}" id="at-gear-input">{{$at_gear['gear']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-4" id="at-gear-wrap">
                <p>Assign To</p>
                <select class="form-select" aria-label="Default select example" name="assign_to">
                    @foreach($data['head_department_list'] as $head_department)
                    <option value="{{$head_department['id']}}" id="at-gear-input" selected>{{$head_department['name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mx-auto my-lg-4">
                <div class="row justify-content-center mx-0">
                    <div class="col-6 text-center">
                        <video width="600" controls class="d-none vidio-container">
                            Your browser does not support HTML video.
                        </video>
                    </div>
                    <div class="col-12 text-center">
                        <label type="submit" class="btn bg-base rounded-lg text-white" for="vidio">Upload Vidio</label>
                        <input type="file" class="d-none" name="vidio_temp" id="vidio">
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
            //Preview Image
            const vidioInput = document.querySelector('#vidio')

            vidioInput.addEventListener('input', (e) => {
                const [file] = vidioInput.files
                console.log(URL.createObjectURL(file))
                if (file && file.size < 20097152) {
                    document.querySelector('.vidio-container').classList.remove('d-none')
                    let blobURL = URL.createObjectURL(file);
                    document.querySelector('.vidio-container').src = blobURL
                } else {
                    return alert('Maximal File Upload 20MB');
                }
            })

            //Symton Noise Dropdown
            const symtonNoiseInput = document.querySelector('#symton_noise')
            const symtonNoiseOptions = document.querySelectorAll('#symton-noise-input')

            symtonNoiseOptions.forEach((symtonNoiseOption, i) => {
                symtonNoiseOption.addEventListener('click', () => {
                    symtonNoiseInput.value = symtonNoiseOption.value
                })
            })

            //Method
            const methodInput = document.querySelector('#method')
            const methodInputOptions = document.querySelectorAll('#method-input')
            const atGearWrapper = document.querySelector('#at-gear-wrap')

            methodInputOptions.forEach((methodInputOption, i) => {
                methodInputOption.addEventListener('click', () => {
                    methodInput.value = methodInputOption.value
                    if (methodInput.value !== 'Idle') {
                        atGearWrapper.classList.remove("d-none")
                    } else {
                        atGearWrapper.classList.add("d-none")
                        methodInput.value = ''
                    }
                })
            })
        </script>
        @endsection