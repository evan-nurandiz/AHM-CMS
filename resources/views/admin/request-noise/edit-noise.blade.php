@extends('layouts.admin')

@section('style')
<style>
    .upload-container {
        height: 300px;
    }

    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

        /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
<main id="dashboard">
    <div class="col-12 bg-white p-4  mb-xs-60">
        <h2>Edit Engine Problem</h2>
        <div class="row justify-content-between mx-0">
            <div class="col-6 col-lg-6 px-0">
                <p>Revisi Ke</p>
                <p>{{count($data['noise']['Revision'])}}</p>
            </div>
            @if($data['noise']['confirmed'] == 2)
            <form action="{{route('admin.request-noise.revision',[
                'status' => $data['status'],
                'noise_id' => $data['noise']['id']
            ])}}" class="col-6 text-end px-0" method="POST">
                @csrf
                <button type="submit" class="btn btn-success text-white" onclick="return confirm('Anda Yakin untuk Konfirmasi?')">Ajukan Revisi</button>
            </form>
            @elseif($data['noise']['confirmed'] == 0)
            <div class="col-12 col-lg-6 text-lg-end">
                <p>Revisi Berhasil Dijukan Pada Tanggal</p>
                <p>{{ date('d F Y', strtotime($data['noise']['created_at']))}}</p>
            </div>
            @endif
        </div>
        <div class="row justify-content-center my-4">
            <div class="col-6 col-lg-2">
                <img src="/image/icon/engine-icon.png" alt="" class="w-100" id="image">
            </div>
            <div class="col-12 col-lg-10">
                <h3>{{$data['noise']['MachineDetail']['type']}}</h3>
                <p class="description">
                    {{$data['noise']['MachineDetail']['description']}}
                </p>
            </div>
        </div>
        <form action="{{route('admin.request-noise.update',[
            'status' => $data['status'],
            'noise_id' => $data['noise']['id']
            ])}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="form-group">
                <label for="exampleFormControlInput1">No Engine <span id="required">*</span></label>
                <input type="text" class="form-control" required name="code" value="{{$data['noise']['code']}}">
            </div>
            <div class="form-group mb-4">
                <p>Symptoms Noise<span id="required">*</span></p>
                <select class="form-select" aria-label="Default select example" name="symton_noise">
                    <option>Open this select menu</option>
                    @foreach($data['symton_noises'] as $symton_noise)
                    <option value="{{$symton_noise['symton_name']}}" id="symton-noise-input" for="symton_noise" {{ $data['noise']['symton_noise'] == $symton_noise['symton_name'] ? "selected" : "" }}>{{$symton_noise['symton_name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-4">
                <p>Area<span id="required">*</span></p>
                <select class="form-select" aria-label="Default select example" name="area">
                    <option>Pilih Area</option>
                    @foreach($data['area'] as $area)
                    <option value="{{$area['area']}}" id="causing-part-input" {{ $data['noise']['area'] == $area['area'] ? "selected" : "" }}>{{$area['area']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Causing Part <span id="required">*</span></label>
                <input type="text" class="form-control" required name="causing_part" value="{{$data['noise']['causing_part']}}">
            </div>
            <div class="form-group mb-4">
                <p>Method <span id="required">*</span></p>
                <div class="row justify-content-between">
                    @foreach($data['methods'] as $method)
                    <div class="col-lg-3">
                        @if(in_array($method['method'], json_decode($data['noise']['method'])))
                        <input type="checkbox" id="{{$method['method']}}" name="method[]" value="{{$method['method']}}" checked>
                        @else
                        <input type="checkbox" id="{{$method['method']}}" name="method[]" value="{{$method['method']}}">
                        @endif
                        <label for="{{$method['method']}}">{{$method['method']}}</label><br>
                    </div>
                    @endforeach
                </div>
            </div>
            @if($data['noise']['method'] != 'Idle')
            <div class="form-group mb-4" id="at-gear-wrap">
                <p>At Gear</p>
                <select class="form-select" aria-label="Default select example" name="at_gear">
                    <option selected>Open this select menu</option>
                    @foreach($data['at_gears'] as $at_gear)
                    <option value="{{$at_gear['gear']}}" id="at-gear-input" {{ $data['noise']['at_gear'] == $at_gear['gear'] ? "selected" : "" }}>{{$at_gear['gear']}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="form-group mb-4" id="at-gear-wrap">
                <label for="exampleFormControlTextarea1">Deskripsi <span id="required">*</span></label>
                <textarea class="form-control" required id="exampleFormControlTextarea1" rows="3" name="description">
                    {!!$data['noise']['description']!!}
                </textarea>
            </div>
            <div class="mx-auto my-lg-4">
                <div class="row justify-content-center mx-0">
                    <div class="col-6 text-center">
                        <video width="600" src="{{ asset('storage/machine_vidio/'.$data['noise']['vidio']) }}" controls class="vidio-container">
                            Your browser does not support HTML video.
                        </video>
                    </div>
                    <div class="col-12 text-center">
                        <label type="submit" class="btn bg-base rounded-lg vidio-upload-label text-white" for="vidio">Ubah Vidio</label>
                        <input type="file" class="d-none" name="vidio_temp" id="vidio" prevFile="{{$data['noise']['vidio']}}">
                    </div>
                    <div class="loader d-none"></div>
                    <input type="text" class="d-none" name="vidio">
                </div>
            </div>
            @if($data['noise']['confirmed'] == 2)
            <button type="submit" class="btn btn-primary w-100 rounded-lg">Ubah</button>
            @endif
        </form>
    </div>
    <main>
@endsection

@section('bottom')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const inputVidio = document.querySelector('input[name=vidio_temp]')
    const vidioContainer = document.querySelector('.vidio-container')
    const loader = document.querySelector('.loader')
    const vidioUploadLabel = document.querySelector('label.vidio-upload-label')
    let fileName = ''

    inputVidio.addEventListener('input',(e) => {
        loader.classList.remove('d-none')
        vidioContainer.classList.add('d-none')
        vidioUploadLabel.classList.add('d-none')
        let formData = new FormData()
        formData.append("prev_vidio",inputVidio.getAttribute("prevFile")) 
        formData.append("vidio_temp",e.target.files[0])
        $.ajax({
            type:'POST',
            url: "{{ route('admin.upload-noise-vidio')}}",
            data:formData,
            processData: false,
            contentType: false,
            success: function (response) {
                vidioContainer.classList.remove('d-none')
                vidioContainer.src = "{{env('APP_URL')}}"+"/storage/machine_vidio/"+response
                loader.classList.add('d-none')
                document.querySelector('input[name=vidio]').value = response
                fileName = response
                vidioUploadLabel.classList.remove('d-none')
                vidioUploadLabel.innerHTML = 'Ganti Vidio'
            }
        });

    })

</script>
@endsection