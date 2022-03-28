@extends('layouts.super-admin')

@section('style')
<style>
    p {
        margin: 0px;
    }
</style>
@endsection

@section('content')
<main id="User">    
    <div class="row">
        <div class="col-12 px-0 py-4 px-4 bg-white">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-3 text-center p-2" id="{{$data['status'] == 3 ? 'active-menu' : ''}}">
                    <a href="{{route('super-admin.noise.index',['status' => 3])}}" class="text-decoration-none ">
                        <p class="{{$data['status'] == 3 ? 'text-white' : 'text-black'}}">Menuggu Publish</p>
                    </a>
                </div>
                <div class="col-12 col-lg-3 text-center p-2" id="{{$data['status'] == 1 ? 'active-menu' : ''}}">
                    <a href="{{route('super-admin.noise.index',['status' => 1])}}" class="text-decoration-none ">
                        <p class="{{$data['status'] == 1 ? 'text-white' : 'text-black'}}">Sudah Di Publish</p>
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
                                        <a href="{{route('super-admin.noise-show',[
                                            'status' => 0,
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