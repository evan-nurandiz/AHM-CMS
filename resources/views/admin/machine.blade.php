@extends('layouts.admin')

@section('style')
    <style>
        #dashboard .description{
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3; /* number of lines to show */
            line-clamp: 3; 
            -webkit-box-orient: vertical;
        }
    </style>
@endsection

@section('content')
	<main id="dashboard">
        <div class="row">
            <div class="col-12 py-4 bg-white">
                <div class="d-flex justify-content-between">
                    <h3>List Mesin</h4>
                    <a href="{{route('admin.machine-create')}}">
                        <button type="button" class="btn bg-base rounded text-white">Tambah Mesin</button>
                    </a>
                    
                </div>
                <div class="row gap-2 w-100 mx-0">
                    @foreach($machines as $machine)
                    <div class="col-3">
                        <a href="{{route('admin.machine-show', ['list_mesin'=>$machine['id']])}}">
                            <div class="row align-items-center border rounded-md p-2 shadow">
                                <div class="col-4">
                                    <img src="/image/icon/engine-icon.png" alt="" class="w-100">
                                </div>
                                <div class="col-8">
                                    <h4>{{$machine['type']}}</h4>
                                    <p class="description text-secondary">{{$machine['description']}}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
	<main>
@endsection
