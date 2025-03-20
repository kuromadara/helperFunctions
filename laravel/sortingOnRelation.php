$summaryReport = CasualWorkerAttendance::query()
   ->with('attendenceTransaction', 'workers', 'requisition')
   ->when($request->department_id != null, function ($query) use ($request) {
       return $query->where('department_id', $request->department_id);
   })
   ->when($fromDate != null, function ($query) use ($fromDate) {
       return $query->where('from_date', '>=', $fromDate);
       })
   ->when($toDate != null, function ($query) use ($toDate) {
       return $query->where('to_date', '<=', $toDate);
       })
   ->where('status', CasualWorkerAttendance::$STATUS_VOUCHER_PRINTED)
   ->get();

$summaryReport = $summaryReport->sortBy(function ($item) {
   return $item->workers->first_name;
});
