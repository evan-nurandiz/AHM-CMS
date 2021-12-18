<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\MachineController;
use App\Http\Controllers\user\IndexController;
use App\Http\Controllers\admin\PlantController;
use App\Http\Controllers\admin\NoiseController;
use App\Http\Controllers\user\PlantController as UserPlantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/profile', function () {
    return view('admin.dashboard');
});

Auth::routes();

Route::group(['prefix' => 'admin','middleware'=>['role:Admin']],function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/dashboard/create-engine',[DashboardController::class, 'createEngine']);
    Route::resource('/dashboard/user',UserController::class,[
        'names' => [
            'index' => 'admin.dashboard-user',
            'create' => 'admin.dashboard-user-create',
            'store' => 'admin.dashboard-user-create.action',
            'edit' => 'admin.dashboard-user-edit',
            'update' => 'admin.dashboard-user-update.action',
            'destroy' => 'admin.dashboard-user-destroy'
        ]
    ]);
    
    Route::prefix('/dashboard/list-plan')->group(function () {
        Route::get('/',[PlantController::class,'index'])->name('admin.plant');
        Route::get('/{plant_number}/detail',[PlantController::class,'detail'])->name('admin.plant-detail');
        Route::prefix('/{plant_number}/list-mesin')->group(function () {
            Route::get('/',[MachineController::class,'index'])->name('admin.plant-machine-list');
            Route::get('/tambah-mesin',[MachineController::class,'create'])->name('admin.plant-machine-add');
            Route::post('/tambah-mesin',[MachineController::class,'store'])->name('admin.plant-machine-add.post');
            Route::get('/{machine_id}/detail',[MachineController::class,'show'])->name('admin.plant-machine-detail');
            Route::get('/{machine_id}/edit',[MachineController::class,'edit'])->name('admin.plant-machine-edit');
            Route::patch('/{machine_id}/edit',[MachineController::class,'update'])->name('admin.plant-machine-update');
            Route::delete('/{machine_id}',[MachineController::class,'destroy'])->name('admin.plant-machine-delete');
            Route::get('/{machine_id}/tambah-noise',[NoiseController::class,'create'])->name('admin.plant-machine-add-noise');
            Route::post('/{machine_id}/tambah-noise',[NoiseController::class,'store'])->name('admin.plant-machine-add-noise.store');
            Route::get('/{machine_id}/noise/{noise_id}',[NoiseController::class,'show'])->name('admin.plant-machine-show-noise');
            Route::get('/{machine_id}/noise/{noise_id}/edit',[NoiseController::class,'edit'])->name('admin.plant-machine-edit-noise');
            Route::patch('/{machine_id}/noise/{noise_id}/edit',[NoiseController::class,'update'])->name('admin.plant-machine-update-noise');
            Route::delete('/{machine_id}/noise/{noise_id}',[NoiseController::class,'destroy'])->name('admin.plant-machine-destroy');
        });
    });

    Route::get('/dashboard/machine-problem/{id}',[MachineController::class,'AddMachineProblem'])->name('admin.machine-add-problem');
    Route::get('/dashboard/machine-problem/detail/{id}',[MachineController::class,'ShowMachineProblem'])->name('admin.machine-problem-detail');
    Route::get('/dashboard/machine-problem/edit/{id}',[MachineController::class,'EditMachineProblem'])->name('admin.machine-problem-edit');
    Route::post('/dashboard/machine-problem/{id}',[MachineController::class,'StoreMachineProblem'])->name('admin.machine-problem-store');
    Route::put('/dashboard/machine-problem/{id}',[MachineController::class,'updateMachineProblem'])->name('admin.machine-problem-update');
});

Route::group(['prefix' => 'user','middleware' => ['role:User']], function () {
    Route::get('/dashboard',[IndexController::class,'index'])->name('user.dashboard');
    Route::prefix('/dashboard/list-plan')->group(function () {
        Route::get('/',[UserPlantController::class,'index'])->name('user.plant');
        Route::get('/{plant_number}/detail',[UserPlantController::class,'detail'])->name('user.plant-detail');
        Route::prefix('/{plant_number}/list-mesin')->group(function () {
            Route::get('/',[UserPlantController::class,'machineList'])->name('user.plant-machine-list');
            Route::get('/{machine_id}/detail',[UserPlantController::class,'machineDetail'])->name('user.plant-machine-detail');
            Route::get('/{machine_id}/detail/{noise_id}',[UserPlantController::class,'machineNoise'])->name('user.plant-machine-noise');
        });
    });
});
