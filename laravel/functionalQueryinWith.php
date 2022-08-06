$employee = Employee::with(['transactions' => function ($query) use ($salaryblock) {
      $query->where('sal_head_id', 23)
          ->where('salMonth', $salaryblock->salary_month)
          ->where('salYear', $salaryblock->salary_year);
  }])
  ->active()
  ->get();


  //optimised

  $employee = Employee::select('id', 'code', 'title', 'first_name', 'last_name')
    ->with(['transactions' => function ($query) use ($salaryblock) {
        $query->select('employee_id','deducts')->where('sal_head_id', 23)
            ->where('salMonth', $salaryblock->salary_month)
            ->where('salYear', $salaryblock->salary_year);
    }])
    ->active()
    ->get();

// if when is needed inside then, situation arise when there is a search filter

  $employee = Employee::select('id', 'code', 'title', 'first_name', 'last_name')
    ->with('transactions')
    ->whereHas('transactions', function ($query) use ($salaryblock){
        $query->select('employee_id', 'deducts')->where('sal_head_id', 23)
            ->where('salMonth', $salaryblock->salary_month)
            ->where('salYear', $salaryblock->salary_year);
    })
    ->active()
    ->get()
