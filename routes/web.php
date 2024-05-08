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
        Route::get('interview_invitation/{id}', 'interview_invitation');
        Route::post('store_interview_date', 'store_interview_date')->name('store_interview_date');

        // jobPosted
        Route::get('jobPosted', 'jobPosted');
        Route::get('extend_job_application/{id}', 'extend_job_application');
        Route::post('store_extended_job_application', 'store_extended_job_application')->name('store_extended_job_application');
        Route::post('close_job_application/{id}', 'close_job_application')->name('close_job_application');

        // my_application
        Route::get('my_application', 'my_application');
    })->middleware('auth');
