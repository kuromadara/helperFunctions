Route::post('/get-dao-inbox-status', function (Request $request) {
    $latest_status = Helper::getLatestWholesalerStatus(
        $request->request_rack_id,
        $request->district_tracking_id,
        $request->retailer_tracking_id);
    if($latest_status == null)
        return response()->json(
            [
                'status' => 'error',
                'message' => 'No data found'
            ], 404);

    return response()->json(
        [
            'status' => 'success',
            'message' => 'Data found',
            'data' => $latest_status
        ], 200);
});
