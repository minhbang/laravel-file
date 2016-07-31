<?php
Route::group(
    ['prefix' => 'backend', 'namespace' => 'Minhbang\File'],
    function () {
        Route::group(
            ['prefix' => 'file', 'as' => 'backend.file.'],
            function () {
                Route::get('/', ['as' => 'index', 'uses' => 'BackendController@index']);
                Route::get('data', ['as' => 'data', 'uses' => 'BackendController@data']);
                Route::post('/', ['as' => 'store', 'uses' => 'BackendController@store']);
                Route::get('{file}', ['as' => 'show', 'uses' => 'BackendController@show']);
                Route::get('{file}/preview', ['as' => 'preview', 'uses' => 'BackendController@preview']);
                Route::post('{file}', ['as' => 'update', 'uses' => 'BackendController@update']);
                Route::delete('{file}', ['as' => 'destroy', 'uses' => 'BackendController@destroy']);
                Route::post('{file}/quick_update',
                    ['as' => 'quick_update', 'uses' => 'BackendController@quickUpdate']);
            });
    }
);