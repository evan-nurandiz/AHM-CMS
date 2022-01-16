@extends('layouts.admin')

@section('style')
<style>
    @media only screen and (max-width: 800px) {
        #dashboard #input-image-preview {
            height: 200px
        }
    }
</style>
@endsection

@section('content')
<main id="dashboard">
    <div class="col-12 col-lg-12 bg-white p-4  mb-xs-60">
        <form action="{{route('admin.plant-machine-add.post',['plant_number' => $plant_number])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-center justify-content-between">
                <h3>Tambah Engine</h3>
                <button type="submit" class="btn btn-success text-white">Tambah Engine</button>
            </div>
            <div class="row gap-lg-5 justify-content-lg-center mt-5">
                <div class="col-12 mb-3 mb-lg-0 col-md-12 col-lg-4 rounded border-doted p-4 d-flex align-items-center justify-content-center" id="input-image-preview">
                    <label type="button" class="btn bg-base text-white rounded w-50 h-25" for="file">Upload Foto</label>
                    <input type="file" id="file" class="d-none" name="image_temp">
                </div>
                <div class="col-12 col-lg-7 px-0">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nomor Plant</label>
                        <input type="text" class="form-control" name="plant_id" value="{{$plant_number}}" disabled>
                        <input type="hidden" class="form-control" name="plant_id" value="{{$plant_number}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tipe Engine <span id="required">*</span></label>
                        <input type="text" class="form-control" required name="type">
                    </div>
                    <label for="exampleFormControlTextarea1">Deskripisi Engine <span id="required">*</span></label>
                    <textarea class="form-control" required id="exampleFormControlTextarea1" rows="3" name="description">
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
                    imagePreviewCanvas.style.backgroundImage = 'url(' + URL.createObjectURL(file) + ')';
                    imagePreviewCanvas.style.backgroundSize = 'cover'
                }
            })
        </script>
        @endsection