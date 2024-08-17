Route::get('/camera', 'CameraController@index')->name('camera.index');
Route::post('/camera', 'CameraController@store')->name('camera.store');
