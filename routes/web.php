<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\MachineController;
use App\Http\Controllers\admin\RequestNoiseController;
use App\Http\Controllers\user\IndexController;
use App\Http\Controllers\admin\PlantController;
use App\Http\Controllers\admin\NoiseController;
use App\Http\Controllers\user\PlantController as UserPlantController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\head\DashboardController as DivisonHeadDashboardController;
use App\Http\Controllers\head\NoiseController as DivisionHeadNoiseController;
use App\Http\Controllers\head\PlantController as DivisionHeadPlantController;
use App\Http\Controllers\superAdmin\UserController as SuperAdminUserController;

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

Route::get('/', [HomeController::class, 'welcome'])->name('landing');

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['role:Admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/dashboard/create-engine', [DashboardController::class, 'createEngine']);

    Route::prefix('/dashboard/list-plan')->group(function () {
        Route::get('/', [PlantController::class, 'index'])->name('admin.plant');
        Route::get('/{plant_number}/detail', [PlantController::class, 'detail'])->name('admin.plant-detail');
        Route::get('/{plant_number}/engine', [PlantController::class, 'engineDetail'])->name('admin.plant-engine');
        Route::prefix('/{plant_number}/list-Engine')->group(function () {
            Route::get('/', [MachineController::class, 'index'])->name('admin.plant-machine-list');
            Route::get('/tambah-Engine', [MachineController::class, 'create'])->name('admin.plant-machine-add');
            Route::post('/tambah-Engine', [MachineController::class, 'store'])->name('admin.plant-machine-add.post');
            Route::get('/{machine_id}/detail', [MachineController::class, 'show'])->name('admin.plant-machine-detail');
            Route::post('/{machine_id}/noise/filter', [MachineController::class, 'filter'])->name('admin.plant-machine-filter-noise');
            Route::get('/{machine_id}/edit', [MachineController::class, 'edit'])->name('admin.plant-machine-edit');
            Route::patch('/{machine_id}/edit', [MachineController::class, 'update'])->name('admin.plant-machine-update');
            Route::delete('/{machine_id}', [MachineController::class, 'destroy'])->name('admin.plant-machine-delete');
            Route::get('/{machine_id}/tambah-noise', [NoiseController::class, 'create'])->name('admin.plant-machine-add-noise');
            Route::post('/{machine_id}/tambah-noise', [NoiseController::class, 'store'])->name('admin.plant-machine-add-noise.store');
            Route::get('/{machine_id}/noise/{noise_id}', [NoiseController::class, 'show'])->name('admin.plant-machine-show-noise');
            Route::get('/{machine_id}/noise/{noise_id}/edit', [NoiseController::class, 'edit'])->name('admin.plant-machine-edit-noise');
            Route::patch('/{machine_id}/noise/{noise_id}/edit', [NoiseController::class, 'update'])->name('admin.plant-machine-update-noise');
            Route::delete('/{machine_id}/noise/{noise_id}', [NoiseController::class, 'destroy'])->name('admin.plant-machine-destroy');
        });
    });

    Route::prefix('/dashboard/request-noie')->group(function () {
        Route::get('/{status}', [RequestNoiseController::class, 'index'])->name('admin.request-noise');
        Route::get('/{status}/{noise_id}/detail', [RequestNoiseController::class, 'show'])->name('admin.request-noise.show');
        Route::get('/{status}/{noise_id}/edit', [RequestNoiseController::class, 'edit'])->name('admin.request-noise.edit');
        Route::patch('/{status}/{noise_id}/update', [RequestNoiseController::class, 'update'])->name('admin.request-noise.update');
        Route::post('/{status}/{noise_id}/request-revision', [RequestNoiseController::class, 'revisionRequest'])->name('admin.request-noise.revision');
    });

    Route::get('/dashboard/machine-problem/{id}', [MachineController::class, 'AddMachineProblem'])->name('admin.machine-add-problem');
    Route::get('/dashboard/machine-problem/detail/{id}', [MachineController::class, 'ShowMachineProblem'])->name('admin.machine-problem-detail');
    Route::get('/dashboard/machine-problem/edit/{id}', [MachineController::class, 'EditMachineProblem'])->name('admin.machine-problem-edit');
    Route::post('/dashboard/machine-problem/{id}', [MachineController::class, 'StoreMachineProblem'])->name('admin.machine-problem-store');
    Route::put('/dashboard/machine-problem/{id}', [MachineController::class, 'updateMachineProblem'])->name('admin.machine-problem-update');
});

Route::group(['prefix' => 'user', 'middleware' => ['role:User']], function () {
    Route::get('/dashboard', [IndexController::class, 'index'])->name('user.dashboard');
    Route::prefix('/dashboard/plant')->group(function () {
        Route::get('/{plant_number}', [UserPlantController::class, 'detail'])->name('user.plant-detail');
        Route::get('/{plant_number}/detail', [UserPlantController::class, 'detailEngine'])->name('user.plant-detail-engine');
        Route::prefix('/{plant_number}/engine/noise')->group(function () {
            Route::get('/', [UserPlantController::class, 'machineList'])->name('user.plant-machine-list');
            Route::get('/{machine_id}/detail', [UserPlantController::class, 'machineDetail'])->name('user.plant-machine-detail');
            Route::post('/{machine_id}/detail/filter', [UserPlantController::class, 'filterNoise'])->name('user.plant-machine-filter');
            Route::get('/{machine_id}/detail/{noise_id}', [UserPlantController::class, 'machineNoise'])->name('user.plant-machine-noise');
        });
    });
});

Route::group(['prefix' => 'departement-head', 'middleware' => ['role:Division Head']], function () {
    Route::get('/dashboard', [DivisonHeadDashboardController::class, 'index'])->name('head.dashboard');
    Route::prefix('/request-noise')->group(function () {
        Route::get('/{status}', [DivisionHeadNoiseController::class, 'index'])->name('head.request-noise');
        Route::get('/{noise_id}/detail', [DivisionHeadNoiseController::class, 'detail'])->name('head.request-noise.detail');
        Route::post('/{noise_id}/revision', [DivisionHeadNoiseController::class, 'postRevision'])->name('head.request-noise.revision');
        Route::patch('/{noise_id}/confirm', [DivisionHeadNoiseController::class, 'confirmRevision'])->name('head.request-noise.confirm');
    });

    Route::prefix('/list-plan')->group(function () {
        Route::get('/', [DivisionHeadPlantController::class, 'index'])->name('head.plant-index');
        Route::get('/{plant_number}/detail', [DivisionHeadPlantController::class, 'detail'])->name('head.plant-detail');
        Route::get('/{plant_number}/engine', [DivisionHeadPlantController::class, 'engineDetail'])->name('head.plant-engine');
        Route::prefix('/{plant_number}/list-Engine')->group(function () {
            Route::get('/', [DivisionHeadPlantController::class, 'engineNoise'])->name('head.plant-machine-list');
            Route::get('/{machine_id}/detail', [DivisionHeadPlantController::class, 'engineShow'])->name('head.plant-machine-engine-show');
            Route::get('/{machine_id}/{noise_id}/detail',[DivisionHeadPlantController::class,'engineNoiseDetail'])->name('head.plant-machine-noise');
            Route::post('/{machine_id}/noise/filter', [DivisionHeadPlantController::class, 'filter'])->name('head.plant-machine-filter-noise');
        });
    });
});

Route::group(['prefix' => 'Super-Admin', 'middleware' => ['role:Super Admin']], function () {
    Route::prefix('/dashboard/user')->group(function () {
        Route::get('/role/{role}', [SuperAdminUserController::class, 'index'])->name('super-admin.user.index');
        Route::get('/create', [SuperAdminUserController::class, 'create'])->name('super-admin.user.create');
        Route::post('/store', [SuperAdminUserController::class, 'store'])->name('super-admin.user.store');
        Route::get('/{user_id}/edit', [SuperAdminUserController::class, 'edit'])->name('super-admin.user.edit');
        Route::patch('/{user_id}/update', [SuperAdminUserController::class, 'update'])->name('super-admin.user.update');
    });
});

Route::get('/signout', [DivisonHeadDashboardController::class, 'logout']);
