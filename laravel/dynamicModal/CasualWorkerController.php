public function attendancePost(Request $request,CasualWorkerAttendanceTran $attendance_trans)
    {
       dd($request->all());

        DB::beginTransaction();
        try {
            $dates = displayDates($request->from_date, $request->to_date);
            //dd($request->worker_name);
            foreach($request->worker_name as $k =>$cw){

            $data=[
                "from_date"=>$request->from_date,
                "to_date"=>$request->to_date,
                "department_id"=>$request->department,
                "casual_worker_id"=>$cw,
            ];

            $attendance=CasualWorkerAttendance::create($data);

            foreach ($dates as $key => $date) {
            $date=dateFormat($date,'Y-m-d');

            $insert_data=[
                "date"=>$date,
                "casual_worker_id"=>$request->worker_name,
                "casual_worker_attendance_id"=> $attendance->id,
            ];
            $attendance_trans=CasualWorkerAttendanceTran::create($insert_data);
            $date=dateFormat($date,'d-M-y');

            if($request->fn!=null){
             foreach($request->fn as $index =>$f){
                //dd($index,$date);
              if($index==$date){

                $fn_val=1;
                $attendance_trans->update(['fn' => $fn_val]);
              }

             }
            }
            if($request->an!=null){

             foreach($request->an as $ind =>$a){
                    if($ind==$date){
                    $an_val=1;
                    $attendance_trans->update(['an' => $an_val]);
                    }
                 }
              }
           }
        }
        } catch (Exception $e) {
            DB::rollback();
            Log::critical($e);
            $request->session()->flash('error', 'Something went wrong');
            return back();
        }
        DB::commit();
        $request->session()->flash('success', 'Successfully submitted');
        return back();
    }
