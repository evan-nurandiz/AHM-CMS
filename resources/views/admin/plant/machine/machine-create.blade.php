@extends('layouts.admin')

@section('style')
    <style>
        
    </style>
@endsection

@section('content')
	<main id="dashboard">
        <div class="col-12 bg-white p-4">
            <form action="{{route('admin.plant-machine-add.post',['plant_number' => $plant_number])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="d-flex justify-content-between">
                    <h3>Tambah Mesin</h3>
                    <button type="submit" class="btn btn-success text-white">Tambah Mesin</button>
                </div>
                <div class="row mt-5">
                    <div class="col-4 rounded border-doted p-4 d-flex align-items-center justify-content-center" id="input-image-preview">
                        <label type="button" class="btn bg-base text-white rounded w-50 h-25" for="file">Upload Foto Mesin</label>
                        <input type="file" id="file" class="d-none" name="image_temp">
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nomor Plant</label>
                            <input type="text" class="form-control" name="plant_id" value="{{$plant_number}}" disabled>
                            <input type="hidden" class="form-control" name="plant_id" value="{{$plant_number}}" >
                        </div>  
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tipe Mesin</label>
                            <input type="text" class="form-control" name="type" value="{{$machine['type'] ?? '' }}">
                        </div>
                        <label for="exampleFormControlTextarea1">Example textarea</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description">
                        {{$machine['description'] ?? '' }}
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
