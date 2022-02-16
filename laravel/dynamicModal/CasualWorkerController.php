public function newAttendancePost(Request $request, $requision_id)
 {
     DB::beginTransaction();
     try {
             foreach($request->data as $workerId => $datalist) {
                 // dd($datalist['total_amount']);
                 $data = [
                     'casual_worker_id' => $workerId,
                     'casual_worker_no' => $datalist['casual_worker_no'],
                     'department_id'    => $request->department_id,
                     'from_date'        => $request->from_date,
                     'to_date'          => $request->to_date,
                     'total_days'       => $datalist['total_days'],
                     'rate'             => $datalist['rate'],
                     'gross_amount'     => $datalist['gross_amount'],
                     'net_amount'       => $datalist['net_amount'],
                     'ot_hour'         => $datalist['ot_hour'],
                     'ot_rate'          => $datalist['ot_rate'],
                     'ot_total'        => $datalist['ot_amount'],
                     'total_amount'     => $datalist['total_amount'],
                     'acknowledgement'  => $datalist['ack'],

                 ];
                 CasualWorkerAttendance::create($data);

                 foreach($datalist['wid_fns'] as $key => $date) {

                     $data_fns = [
                         'casual_worker_id' => $workerId,
                         'date' => $date,
                         'fn'   => 1,
                         'an'   => 0,
                         'casual_worker_requision_id' => $requision_id,
                     ];
                     CasualWorkerAttendanceTran::create($data_fns);
                     //dump($data_fns);
                 }

                 foreach($datalist['wid_ans'] as $key => $date) {

                     $data_ans = [
                         'casual_worker_id' => $workerId,
                         'date' => $date,
                         'fn'   => 0,
                         'an'   => 1,
                         'casual_worker_requision_id' => $requision_id,
                     ];
                     CasualWorkerAttendanceTran::create($data_ans);
                     //dump($data_ans);
                 }
             }

         } catch (Exception $e) {
             DB::rollback();
             Log::critical($e);
             dd($e);
             $request->session()->flash('error', 'Something went wrong');
             return back();
         }
         DB::commit();
         $request->session()->flash('success', 'Successfully submitted');
         return back();
     // dd($request->all());
     // return  "test";
 }
