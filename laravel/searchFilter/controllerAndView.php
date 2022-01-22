// controller function

public function process(Request $request)
    {   

        // dd($request->all());
        $lte_transaction = LteTransaction::get();
        // dd($lte_transaction);
        
        // $emp          = employee_global_filter($emp)->get();
        $salarystatus = EmployeeSalYearBlock::where('status', 1)->first();
        

        $departments = Department::pluck("name", "id")->toArray();
        $lte         = Lte::pluck("name", "id")->toArray();
        $employees   = Employee::select('id', 'first_name', 'last_name', 'code')->get();
        
        $emp          = Employee::with('Lte')->whereNotNull('lte_id')->active()
                        ->when(request("department"), function ($query) {
                            return $query->where("department_id", request("department"));
                        })
                        ->when(request("lte"), function ($query) {
                            return $query->where("lte_id", request("lte"));
                        })
                        ->get();
        
        if(!$salarystatus){
            dieWithDesign("No active slaray year block found");
        }
        return view('lte_manage.lte_process', compact('emp', 'lte', 'salarystatus', 'departments', 'employees', 'lte_transaction'));

    }
	
// view

<form method="get" action="{{route("process_lte.process")}}">

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">Department</label>
                       
                        {!! Form::select('department', $departments, null , ['class' => 'form-control select2',  "placeholder" => "--All--" , "required" => true]) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">Employee</label>
                        <select name="employee_id" id="categories" class="form-control select2">
                            <option value="">--All--</option>
                            @foreach ($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->full_name_with_code}}</option>
                            @endforeach
                        </select>
                        

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">LTE Type</label>
                        
                        {!! Form::select('name', $lte, null, ['class' => 'form-control select2',  "placeholder" => "--All--", "required" => true]) !!}

                    </div>
                </div>
            </div>

        <button type="submit" class='btn btn-primary text-white'>Search </button>

        </form>
		
		

		
		