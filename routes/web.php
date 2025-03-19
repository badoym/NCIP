<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return redirect('/home');
    });

    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index']);

    Route::get('/regions', [\App\Http\Controllers\RegionController::class, 'index']);
    Route::get('/regions/show', [\App\Http\Controllers\RegionController::class, 'show']);
    Route::post('/regions/filterData', [App\Http\Controllers\RegionController::class, 'filterData']);
    Route::post('/regions/store', [\App\Http\Controllers\RegionController::class, 'store']);
    Route::get('/regions/edit', [\App\Http\Controllers\RegionController::class, 'edit']);
    Route::put('/regions/update/{id}', [\App\Http\Controllers\RegionController::class, 'update']);
    Route::get('/regions/destroy/{id}', [\App\Http\Controllers\RegionController::class, 'destroy']);

    Route::get('/provinces', [\App\Http\Controllers\ProvinceController::class, 'index']);
    Route::get('/provinces/show', [\App\Http\Controllers\ProvinceController::class, 'show']);
    Route::post('/provinces/filterData', [App\Http\Controllers\ProvinceController::class, 'filterData']);
    Route::post('/provinces/onChangeProvinces/{id}', [App\Http\Controllers\ProvinceController::class, 'onChangeProvinces']);
    Route::post('/provinces/store', [\App\Http\Controllers\ProvinceController::class, 'store']);
    Route::get('/provinces/edit', [\App\Http\Controllers\ProvinceController::class, 'edit']);
    Route::put('/provinces/update/{id}', [\App\Http\Controllers\ProvinceController::class, 'update']);
    Route::get('/provinces/destroy/{id}', [\App\Http\Controllers\ProvinceController::class, 'destroy']);

    Route::get('/cities', [\App\Http\Controllers\CityController::class, 'index']);
    Route::get('/cities/show', [\App\Http\Controllers\CityController::class, 'show']);
    Route::post('/cities/filterData', [App\Http\Controllers\CityController::class, 'filterData']);
    Route::post('/cities/store', [\App\Http\Controllers\CityController::class, 'store']);
    Route::get('/cities/edit/{id}', [\App\Http\Controllers\CityController::class, 'edit']);
    Route::put('/cities/update/{id}', [\App\Http\Controllers\CityController::class, 'update']);
    Route::get('/cities/destroy/{id}', [\App\Http\Controllers\CityController::class, 'destroy']);
    Route::get('/cities/getProvincesByRegion/{id}', [\App\Http\Controllers\CityController::class, 'getProvincesByRegion']);

    Route::get('/barangays', [\App\Http\Controllers\BarangayController::class, 'index']);
    Route::get('/barangays/show', [\App\Http\Controllers\BarangayController::class, 'show']);
    Route::post('/barangays/filterData', [App\Http\Controllers\BarangayController::class, 'filterData']);
    Route::post('/barangays/store', [\App\Http\Controllers\BarangayController::class, 'store']);
    Route::get('/barangays/edit/{id}', [\App\Http\Controllers\BarangayController::class, 'edit']);
    Route::put('/barangays/update/{id}', [\App\Http\Controllers\BarangayController::class, 'update']);
    Route::get('/barangays/destroy/{id}', [\App\Http\Controllers\BarangayController::class, 'destroy']);
    Route::get('/barangays/getProvincesByRegion/{id}', [\App\Http\Controllers\BarangayController::class, 'getProvincesByRegion']);
    Route::get('/barangays/getCitiesByProvince/{id}', [\App\Http\Controllers\BarangayController::class, 'getCitiesByProvince']);
    Route::get('/barangays/getBarangayByCities/{id}', [\App\Http\Controllers\BarangayController::class, 'getBarangayByCities']);

    Route::get('/governmentprograms', [\App\Http\Controllers\GovernmentProgramController::class, 'index']);
    Route::get('/governmentprograms/show', [\App\Http\Controllers\GovernmentProgramController::class, 'show']);
    Route::post('/governmentprograms/filterData', [App\Http\Controllers\GovernmentProgramController::class, 'filterData']);
    Route::post('/governmentprograms/store', [\App\Http\Controllers\GovernmentProgramController::class, 'store']);
    Route::put('/governmentprograms/update/{id}', [\App\Http\Controllers\GovernmentProgramController::class, 'update']);
    Route::get('/governmentprograms/destroy/{id}', [\App\Http\Controllers\GovernmentProgramController::class, 'destroy']);

    Route::get('/services', [\App\Http\Controllers\ServicesController::class, 'index']);
    Route::get('/services/show', [\App\Http\Controllers\ServicesController::class, 'show']);
    Route::post('/services/filterData', [App\Http\Controllers\ServicesController::class, 'filterData']);
    Route::post('/services/store', [\App\Http\Controllers\ServicesController::class, 'store']);
    Route::put('/services/update/{id}', [\App\Http\Controllers\ServicesController::class, 'update']);
    Route::get('/services/destroy/{id}', [\App\Http\Controllers\ServicesController::class, 'destroy']);


    Route::get('/indigenousgroups', [\App\Http\Controllers\IndigenousGroupController::class, 'index']);
    Route::get('/indigenousgroups/show', [\App\Http\Controllers\IndigenousGroupController::class, 'show']);
    Route::post('/indigenousgroups/filterData', [App\Http\Controllers\IndigenousGroupController::class, 'filterData']);
    Route::post('/indigenousgroups/store', [\App\Http\Controllers\IndigenousGroupController::class, 'store']);
    Route::get('/indigenousgroups/edit', [\App\Http\Controllers\IndigenousGroupController::class, 'edit']);
    Route::put('/indigenousgroups/update/{id}', [\App\Http\Controllers\IndigenousGroupController::class, 'update']);
    Route::get('/indigenousgroups/destroy/{id}', [\App\Http\Controllers\IndigenousGroupController::class, 'destroy']);

    Route::get('/programandserviceopenings', [\App\Http\Controllers\ProgramAndServiceOpeningController::class, 'index']);
    Route::get('/programandserviceopenings/show', [\App\Http\Controllers\ProgramAndServiceOpeningController::class, 'show']);
    Route::post('/programandserviceopenings/filter', [\App\Http\Controllers\ProgramAndServiceOpeningController::class, 'filter']);
    Route::get('/programandserviceopenings/onchangeopening/{id}', [\App\Http\Controllers\ProgramAndServiceOpeningController::class, 'onchangeOpening']);
    Route::post('/programandserviceopenings/store', [\App\Http\Controllers\ProgramAndServiceOpeningController::class, 'store']);
    Route::get('/programandserviceopenings/applicants/{id}', [\App\Http\Controllers\ProgramAndServiceOpeningController::class, 'applicants']);
    Route::get('/programandserviceopenings/cancelprogram/{id}', [\App\Http\Controllers\ProgramAndServiceOpeningController::class, 'cancelProgram']);

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::post('/users/store', [\App\Http\Controllers\UserController::class, 'store']);
    Route::post('/users/filterData', [\App\Http\Controllers\UserController::class, 'filter']);
    Route::get('/users/show', [App\Http\Controllers\UserController::class, 'show']);
    Route::post('/users/update', [App\Http\Controllers\UserController::class, 'store']);
    Route::get('/users/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroy']);
    Route::post('/users/changepassword', [App\Http\Controllers\UserController::class, 'changePassword']);

    Route::get('/web_services', [\App\Http\Controllers\WebUserServiceController::class, 'index']);
    Route::get('/web_services/show', [\App\Http\Controllers\WebUserServiceController::class, 'show']);
    Route::post('/web_services/filterData', [App\Http\Controllers\WebUserServiceController::class, 'filterData']);
    Route::post('/web_services/store', [\App\Http\Controllers\WebUserServiceController::class, 'store']);
    Route::put('/web_services/update/{id}', [\App\Http\Controllers\WebUserServiceController::class, 'update']);
    Route::get('/web_services/destroy/{id}', [\App\Http\Controllers\WebUserServiceController::class, 'destroy']);
    Route::get('/web_services/apply/{id}', [\App\Http\Controllers\WebUserServiceController::class, 'apply']);
    Route::get('/web_services/servicesapplied', [\App\Http\Controllers\WebUserServiceController::class, 'servicesApplied']);
    Route::get('/web_services/cancelappliedservice/{id}', [\App\Http\Controllers\WebUserServiceController::class, 'cancelServicesApplied']);


    Route::get('/web_profile', [\App\Http\Controllers\UserInformationController::class, 'index']);
    Route::get('/web_profile/show', [\App\Http\Controllers\UserInformationController::class, 'show']);
    Route::post('/web_profile/filterData', [App\Http\Controllers\UserInformationController::class, 'filterData']);
    Route::post('/web_profile/store', [\App\Http\Controllers\UserInformationController::class, 'store']);
    Route::put('/web_profile/update/{id}', [\App\Http\Controllers\UserInformationController::class, 'update']);
    Route::get('/web_profile/destroy/{id}', [\App\Http\Controllers\UserInformationController::class, 'destroy']);
    Route::get('/web_profile/destroy/{id}', [\App\Http\Controllers\UserInformationController::class, 'destroy']);

    Route::get('/web_government_prog', [\App\Http\Controllers\WebUserGovernmentProgramController::class, 'index']);
    Route::get('/web_government_prog/show', [\App\Http\Controllers\WebUserGovernmentProgramController::class, 'show']);
    Route::post('/web_government_prog/filterData', [App\Http\Controllers\WebUserGovernmentProgramController::class, 'filterData']);
    Route::post('/web_government_prog/store', [\App\Http\Controllers\WebUserGovernmentProgramController::class, 'store']);
    Route::put('/web_government_prog/update/{id}', [\App\Http\Controllers\WebUserGovernmentProgramController::class, 'update']);
    Route::get('/web_government_prog/destroy/{id}', [\App\Http\Controllers\WebUserGovernmentProgramController::class, 'destroy']);
    Route::get('/web_government_prog/apply/{id}', [\App\Http\Controllers\WebUserGovernmentProgramController::class, 'apply']);
    Route::get('/web_government_prog/programapplied', [\App\Http\Controllers\WebUserGovernmentProgramController::class, 'programApplied']);
    Route::get('/web_government_prog/cancelappliedprogram/{id}', [\App\Http\Controllers\WebUserGovernmentProgramController::class, 'cancelProgramApplied']);

    Route::get('/web_messages', [\App\Http\Controllers\WebUserChatController::class, 'index']);
    Route::post('/web_messsage/send', [\App\Http\Controllers\WebUserChatController::class, 'send']);
    Route::get('/web_messsage/fetch', [\App\Http\Controllers\WebUserChatController::class, 'fetchMessage']);



    Route::get('/ipmasterlist', [\App\Http\Controllers\IndigenousPeopleMasterlistController::class, 'index']);
    Route::post('/ipmasterlist/filterData', [\App\Http\Controllers\IndigenousPeopleMasterlistController::class, 'filter']);
    Route::get('/ipmasterlist/show', [App\Http\Controllers\IndigenousPeopleMasterlistController::class, 'show']);
    Route::get('/ipmasterlist/view/{id}', [App\Http\Controllers\IndigenousPeopleMasterlistController::class, 'view']);
    Route::get('/ipmasterlist/action/{id}/{value}', [App\Http\Controllers\IndigenousPeopleMasterlistController::class, 'action']);
});
