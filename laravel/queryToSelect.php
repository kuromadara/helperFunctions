// without helper

$get_emp_details=processShiftallowance::query()
->with('employee')
->where('month', $salarystatus ->salary_month)
->where('year',$salarystatus->salary_year)
->where('status' , 1)
->when($request->department, function($query){
	return $query->whereHas('employee', function($query){
	     return $query->where('department_id', $request->department);
	});
});


// with helper

$get_emp_details=processShiftallowance::query()
->with('employee')
->where('month', $salarystatus ->salary_month)
->where('year',$salarystatus->salary_year)
->where('status' , 1)
->when($request->department, function($query){
	return $query->whereHas('employee', function($query){
	     return employee_global_filter($query);
	});
});

// filter

function employee_global_filter(Builder $query)
{
    //dd(request("grade"));
    return $query->when(request("department"), function ($department_filter) {
        return $department_filter->where("department_id", request("department"));
    })
        ->when(request("grade"), function ($grade_filter) {
            return $grade_filter->where("grade_id", request("grade"));
        })
        ->when(request("code"), function ($query) {
            return $query->where("code", request("code"));
        })
        ->when(request("employee_id"), function ($query) {
            return $query->where("id", request("employee_id"));
        })
        ->when(request("name"), function ($name_filter) {
            $return_query = $name_filter;
            $return_query->where(function ($where_query) {
                $name         = request("name");
                $name_array   = [];
                $name_array[] = $name;
                $name_array[] = str_replace(" ", "  ", $name);
                foreach ($name_array as $name) {
                    $where_query->orWhereRaw(DB::raw("CONCAT(first_name,' ', middle_name,' ', last_name) LIKE  '%" . $name . "%'"));
                }
            });
            return $return_query;
        });
}
