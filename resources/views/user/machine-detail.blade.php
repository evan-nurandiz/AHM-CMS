@extends('layouts.user')

@section('style')
<style>

</style>
@endsection

@section('content')
<main id="dashboard">
    <div class="col-12 bg-white p-4 mb-xs-60">
        <div class="row my-4">
            <div class="col-2">
                <img src="/image/icon/engine-icon.png" alt="" class="w-100" id="image">
            </div>
            <div class="col-10">
                <h3>K45 Engine</h3>
                <p class="description">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nihil hic cumque consequatur fugiat. Delectus enim a
                    perspiciatis excepturi ea asperiores iure voluptas cupiditate nemo et nesciunt, consequuntur sit
                    laboriosam blanditiis eos velit ullam quis optio illum vel. At reiciendis ullam dolor error corporis, voluptas corrupti?
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-top-0">No</th>
                                    <th class="border-top-0">Symton Noise</th>
                                    <th class="border-top-0">Part Penyebab</th>
                                    <th class="border-top-0">Method</th>
                                    <th class="border-top-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($machineProblems as $machineProblem)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$machineProblem['symton_noise']}}</td>
                                    <td>{{$machineProblem['causing_part']}}</td>
                                    <td>{{$machineProblem['method']}}</td>
                                    <td>
                                        <a href="{{route('user.machine-problem-detail',
                                            ['id' => $machine['id'] , 'machine_id' => $machineProblem['id']]
                                            )}}">
                                            <button type="button" class="btn btn-primary">Detail</button>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <p>No users</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main>
        @endsection

        @section('bottom')

        @endsection