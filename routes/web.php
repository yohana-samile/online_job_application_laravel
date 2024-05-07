<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\JobApplication;
    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "web" middleware group. Make something great!
    |
    */

    Route::get('/', function () {
        return view('index');
    });

    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::controller(JobApplication::class)->group(function () {
        // Route::get('crimeTypes/index', 'index');
        Route::get('users/applicant', 'applicant');
        Route::post('store_job', 'store_job')->name('store_job');
        Route::post('complite_registration', 'complite_registration')->name('complite_registration');
        Route::post('send_application', 'send_application')->name('send_application');
        Route::post('apply_for_a_job', 'apply_for_a_job')->name('apply_for_a_job');

        Route::get('jobApplication', 'jobApplication');
        Route::post('deny_this_application/{id}', 'deny_this_application')->name('deny_this_application');
        Route::post('invite_for_interview/{id}', 'invite_for_interview')->name('invite_for_interview');
    })->middleware('auth');
