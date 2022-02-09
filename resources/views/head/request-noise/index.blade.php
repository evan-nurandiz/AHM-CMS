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
            <div class="row justify-content-center">
                <div class="col-12 col-lg-3 text-center p-2" id="{{$data['status'] == 0 ? 'active-menu' : ''}}">
                    <a href="{{route('head.request-noise',['status' => 0])}}" class="text-decoration-none ">
                        <p class="{{$data['status'] == 0 ? 'text-white' : 'text-black'}}">Pending</p>
                    </a>
                </div>
                <div class="col-12 col-lg-3 text-center p-2" id="{{$data['status'] == 2 ? 'active-menu' : ''}}">
                    <a href="{{route('head.request-noise',['status' => 2])}}" class="text-decoration-none ">
                        <p class="{{$data['status'] == 2 ? 'text-white' : 'text-black'}}">Revisi</p>
                    </a>
                </div>
                <div class="col-12 col-lg-3 text-center p-2" id="{{$data['status'] == 3 ? 'active-menu' : ''}}">
                    <a href="{{route('head.request-noise',['status' => 3])}}" class="text-decoration-none">
                        <p class="{{$data['status'] == 3 ? 'text-white' : 'text-black'}}">Menunggu Publish</p>
                    </a>
                </div>
                <div class="col-12 col-lg-3 text-center p-2" id="{{$data['status'] == 1 ? 'active-menu' : ''}}">
                    <a href="{{route('head.request-noise',['status' => 1])}}" class="text-decoration-none">
                        <p class="{{$data['status'] == 1 ? 'text-white' : 'text-black'}}">Diterima</p>
                    </a>
                </div>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-top-0">No</th>
                                    <th class="border-top-0">Nomer Engine</th>
                                    <th class="border-top-0">Symptoms Noise</th>
                                    <th class="border-top-0">Area</th>
                                    <th class="border-top-0">Part Penyebab</th>
                                    <th class="border-top-0">Method</th>
                                    <th class="border-top-0">Tanggal Input</th>
                                    <th class="border-top-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['noises'] as $noise)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$noise['code']}}</td>
                                    <td>{{$noise['symton_noise']}}</td>
                                    <td>{{$noise['area']}}</td>
                                    <td>{{$noise['causing_part']}}</td>
                                    <td>{{$noise['method']}}</td>
                                    <td>{{ date('d F Y', strtotime($noise['created_at']))}}</td>
                                    <td>
                                        <a href="{{route('head.request-noise.detail',[
                                            'noise_id' => $noise['id']
                                            ])}}" class="text-decoration-none">
                                            <button type="button" class="btn btn-primary">Detail</button>
                                        </a>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex mt-4 justify-content-center">
                        {!! $data['noises']->links() !!}
                    </div>
                </div>
            </div>
        </div>
        <main>
            @endsection

            @section('bottom')

            @endsection