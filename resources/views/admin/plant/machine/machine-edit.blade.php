@extends('layouts.admin')

@section('style')
    <style>
        @media only screen and (max-width: 800px) {
            #dashboard #input-image-preview{
                height:200px
            }
        }
    </style>
@endsection

@section('content')
	<main id="dashboard">
        <div class="col-12 bg-white p-4">
            <form action="{{route('admin.plant-machine-update',[
                'plant_number' => $data['plant_id'],
                'machine_id' => $data['machine']['id']
            ])}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="d-flex align-items-center justify-content-between">
                    <h3>Edit Mesin</h3>
                    <button type="submit" class="btn btn-success text-white">Edit Mesin</button>
                </div>
                <div class="row mt-5">
                    <div class="col-12 col-lg-4 px-0 px-lg-2 rounded border-doted mb-4 mb-lg-0 p-4 d-flex align-items-center justify-content-center" id="input-image-preview"
                    style="background-image: url({{ asset('storage/machine_image/'.$data['machine']['image']) }}); background-size:cover">
                        <label type="button" class="btn bg-base text-white rounded w-50 h-25" for="file">Upload Foto Mesin</label>
                        <input type="file" id="file" class="d-none" name="image_temp">
                    </div>
                    <div class="col-12 col-lg-8 px-0 px-lg-2">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nomor Plant</label>
                            <input type="text" class="form-control" name="plant_id" value="{{$data['plant_id']}}" disabled>
                            <input type="hidden" class="form-control" name="plant_id" value="{{$data['plant_id']}}" >
                        </div>  
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tipe Mesin <span id="required">*</span></label>
                            <input type="text" class="form-control" name="type" required value="{{$data['machine']['type'] ?? '' }}">
                        </div>
                        <label for="exampleFormControlTextarea1">Example textarea <span id="required">*</span></label>
                        <textarea class="form-control" required id="exampleFormControlTextarea1" rows="3" name="description">
                        {{$data['machine']['description'] ?? '' }}
                        </textarea>
                    </div>
                </div>
            </form>
        </div>
	<main>
@endsection

@section('bottom')
    <script>
        //Uplaod Preview
        const imagePreviewCanvas = document.querySelector('#input-image-preview')
        const imageInput = document.querySelector('#file')

        imageInput.addEventListener('input', (e) => {
            const [file] = imageInput.files
            if (file) {
                imagePreviewCanvas.style.backgroundImage = 'url('+URL.createObjectURL(file)+')'; 
                imagePreviewCanvas.style.backgroundSize = 'cover'
            }
        })
    </script>
@endsection
