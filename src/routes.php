<?php
Route::group(
    [
        'prefix'     => 'backend',
        'as'         => 'backend.',
        'namespace'  => 'Minhbang\File',
        'middleware' => config('file.middleware'),
    ],
    function () {
        Route::group(
            ['prefix' => 'file', 'as' => 'file.'],
            function () {
                Route::get('data', ['as' => 'data', 'uses' => 'BackendController@data']);
                Route::get('{file}/preview', ['as' => 'preview', 'uses' => 'BackendController@preview']);
                Route::post('{file}/quick_update', ['as' => 'quick_update', 'uses' => 'BackendController@quickUpdate']);
            }
        );
        Route::resource('file', 'BackendController');
    }
);