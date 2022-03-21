Route::group(['prefix' => 'imo'], function () {
    Route::get('', [
        'as'   => 'imo.add',
        'uses' => 'InterOfficeMemo@add',
    ])
        ->middleware('role_or_permission:User');

    Route::post('store', [
        'as' => 'imo.store',
        'uses' => 'InterOfficeMemo@store',
    ])
        ->middleware('role_or_permission:User');
    Route::get('inbox', [
        'as'   => 'imo.inbox',
        'uses' => 'InterOfficeMemo@inbox',
    ])
        ->middleware('role_or_permission:User');

    Route::post('inbox/{id}',[
        'as'   => 'imo.inboxRead',
        'uses'  => 'InterOfficeMemo@inboxRead',
    ])
        ->middleware('role_or_permission:User');

    Route::get('outbox', [
        'as'   => 'imo.outbox',
        'uses' => 'InterOfficeMemo@outbox',
    ])
        ->middleware('role_or_permission:User');

    Route::post('outbox/{id}',[
        'as'   => 'imo.outboxSend',
        'uses'  => 'InterOfficeMemo@outboxSend'
    ])
        ->middleware('role_or_permission:User');

    Route::get('view/{id}', [
        'as'   => 'imo.view',
        'uses' => 'InterOfficeMemo@view',
    ])
        ->middleware('role_or_permission:User');

    Route::post('close/{id}', [
        'as'   => 'imo.close',
        'uses' => 'InterOfficeMemo@close',
    ])
        ->middleware('role_or_permission:User');
    Route::post('forward/{id}', [
        'as'   => 'imo.forward',
        'uses' => 'InterOfficeMemo@forward'
    ])
        ->middleware('role_or_permission:User');

    Route::get('list/{id}', [
        'as'   => 'imo.list',
        'uses' => 'InterOfficeMemo@list',
    ])
        ->middleware('role_or_permission:User');
    Route::get('master-list', [
         'as'   => 'imo.master-list',
         'uses' => 'InterOfficeMemo@masterList',
     ])
         ->middleware('role_or_permission:User');

});
