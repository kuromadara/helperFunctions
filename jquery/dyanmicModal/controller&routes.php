public function list(Request $request, $id)
{
   $transactions = FileTrans::query()
       ->where('file_id', $id)
       ->get();

   $initiation_date = FileMaster::select('created_at')
       ->where('id', $id)
       ->first();

   return view('imo.list', compact('transactions', 'initiation_date'));
}

public function masterList()
{
   $file_masters = FileMaster::with('employee', 'from_employee.designation', 'to_employee.designation', 'from_employee.department', 'to_employee.department')
       ->get();

   return view('imo.master_list', compact('file_masters'));
}

Routes:

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
