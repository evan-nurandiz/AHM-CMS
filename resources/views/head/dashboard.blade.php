@extends('layouts.head')

@section('style')
<style>
    #dashboard-plant .plant {
        height: 320px;
    }

    @media only screen and (max-width: 800px) {
        #dashboard-plant .plant {
            height: 200px
        }
    }
</style>
@endsection

@section('content')
<main id="dashboard-plant ">
    <div class="row">
        <div class="col-12 px-0 py-4 px-4 bg-white min-vh-100">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                    <div class="wrapper p-4 bg-yellow border-16">
                        <h4>Request Noise</h4>
                        <h5>{{$data['pending']}}</h5>
                    </div>
                </div>
                <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                    <div class="wrapper p-4 bg-bluee-green border-16">
                        <h4>Noise In Revision</h4>
                        <h5>{{$data['in_revision']}}</h5>
                    </div>
                </div>
                <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                    <div class="wrapper p-4 bg-green border-16">
                        <h4>Total Noise</h4>
                        <h5>{{$data['approved']}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main>
        @endsection