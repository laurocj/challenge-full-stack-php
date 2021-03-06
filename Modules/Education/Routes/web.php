<?php

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

use Illuminate\Support\Facades\Route;

Route::prefix('education')->group(function() {
    Route::get('/', 'EducationController@index');
});

Route::middleware('auth')
     ->prefix('cms/education')
     ->group(function() {
        Route::get('/', 'EducationController@index');

        Route::get('students/search', 'StudentController@search')->name('students.search');
        Route::resource('students', 'StudentController');

        Route::get('courses/search', 'CourseController@search')->name('courses.search');
        Route::resource('courses', 'CourseController');

        Route::get('teams/search', 'TeamController@search')->name('teams.search');
        Route::resource('teams', 'TeamController');

        Route::resource('enrollments', 'EnrollmentController');
    });

