Route::group(['prefix' => 'upload', "middleware" => "auth"], function () {
    Route::get('/','UploadController@index')->name('upload.index');
    Route::post('/','UploadController@store')->name('upload.store');
});