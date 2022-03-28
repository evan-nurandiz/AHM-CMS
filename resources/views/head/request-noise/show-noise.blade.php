@extends('layouts.head')

@section('style')
<style>
    p {
        margin: 0px !important;
    }

    #request-noise .plant {
        height: 320px;
    }

    @media only screen and (max-width: 800px) {
        #request-noise .plant {
            height: 200px
        }
    }
</style>
@endsection

@section('content')
<main id="request-noise">
    <div class="row">
        <div class="col-12 px-0 py-4 px-4 bg-white">
            <div class="d-flex gap-4 justify-content-between align-items-start mx-0 mb-lg-4">
                <div>
                    <p class="text-secondary">Jumlah Revisi</p>
                    <h4>{{count($data['noise']['revision'])}}</h4>
                </div>
                <form action="{{route('head.request-noise.confirm',[
                        'noise_id' => $data['noise']['id']
                    ])}}" method="POST">
                    @csrf
                    @method('patch')
                    <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#revision-modal">Revisi List</button>
                    @if($data['noise']['confirmed'] == 0)
                    <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#exampleModal">Revisi</button>
                    <button type="submit" class="btn btn-success text-white" onclick="return confirm('Anda Yakin untuk Konfirmasi?')">Confirm</button>
                    @endif
                </form>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <video width="600" src="{{ asset('storage/machine_vidio/'.$data['noise']['vidio']) }}" controls class="vidio-container">
                        Your browser does not support HTML video.
                    </video>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-secondary mb-1">status</p>
                <h4>{{CONFIRM_STATUS[$data['noise']['confirmed']]}}</h4>
            </div>
            <div class="mt-4">
                <p class="text-secondary mb-1">Symton Noise</p>
                <h4>{{$data['noise']['symton_noise']}}</h4>
            </div>
            <div class="mt-4">
                <p class="text-secondary mb-1">Area</p>
                <h4>{{$data['noise']['area']}}</h4>
            </div>
            <div class="mt-4">
                <p class="text-secondary mb-1">Causing Part</p>
                <h4>{{$data['noise']['causing_part']}}</h4>
            </div>
            <div class="mt-4">
                <p class="text-secondary mb-1">Method</p>
                <h4>{{$data['noise']['method']}}</h4>
            </div>
            @if($data['noise']['method'] != 'Idle')
            <div class="mt-4">
                <p class="text-secondary mb-1">At Gear</p>
                <h4>{{$data['noise']['at_gear']}}</h4>
            </div>
            @endif
            <div class="mt-4">
                <p class="text-secondary mb-1">Deskripsi</p>
                <h4>{{$data['noise']['description']}}</h4>
            </div>
        </div>
    </div>
    <main>

        <!-- Revision Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Revisi Noise Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('head.request-noise.revision',[
                'noise_id' => $data['noise']['id']
            ])}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Deskripsi Revisi</label>
                                <textarea name="description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                </div>
                </form>
            </div>
        </div>

        <!--Revision List Modal -->
        <div class="modal fade" id="revision-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content pb-5">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">List Revisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="row justify-content-center mx-0">
                        <div class="col-11 mt-3">
                            @if(count($data['noise']['revision']) > 0)
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                @foreach($data['noise']['revision'] as $revision)
                                <div class="accordion-item mb-3">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-{{$loop->iteration}}" aria-expanded="false" aria-controls="flush-collapseOne-{{$loop->iteration}}">
                                            Revisi {{$loop->iteration}}
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne-{{$loop->iteration}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body shadow-md">{!!$revision['description']!!}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p>Belum Ada Revisi</p>
                            @endif
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
                @endsection

                @section('bottom')
                <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
                <script>
                    CKEDITOR.replace('description');
                </script>
                @endsection