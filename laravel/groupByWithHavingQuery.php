public function list(Request $request)
{
    $salheads = SalHead::whereNotIn("id", [])->pluck("name", "id")->toArray();
    $salarystatus = EmployeeSalYearBlock::where('status', 1)->first();
    $departments = Department::pluck("name", "id")->toArray();

    $attendences = Attendence::with('employee.department', 'employee.designation')
    ->groupBy('employee_id')
        ->whereBetween('date', [$salarystatus->from_date, $salarystatus->to_date])
        ->when(!is_null(request("is_verified")), function ($query) {
            return $query->havingRaw('min(is_verified) = '.request("is_verified"));
        })
        ->when(request("department"), function ($query) {
            return $query->whereHas('employee', function ($query) {
                return $query->where('department_id', request("department"));
            });
        })
        
        ->selectRaw('count(*) as total, employee_id, min(is_verified) as status')
        ->orderBy('employee_code')
        ->get();

    //dd($request->all());
    

    return view("new-attendances.list", compact('salheads', 'salarystatus', 'departments', 'attendences'));
}

/**
* check $attendences query having is used to check is verefied the = here is concatinated with the request.
* !is_null is used because when request("is_verified") is null it doesnot run the query.
*/