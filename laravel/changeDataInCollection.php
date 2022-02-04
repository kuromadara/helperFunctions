$claims       = $salary_heads->where("sal_head.type", SalHead::$claim_status);
$deductions   = $salary_heads->where("sal_head.type", SalHead::$deduction_status);
$this->total_pay = 0.00;
//dd($claims->toArray());
$atten_data = EmployeeProcessedAttendence::select('total_working_days', 'total_present_days')
	->whereEmployeeId($this->employee_id)->first();

/**
 * if total days are less than or equal to 30 then basic pay and da is calculated based on total days.
 * 
 *  Basic * (Total Days Present / Total Days in Month)
 *  DA * (Total Days Present / Total Days in Month)
 */

if($atten_data->total_working_days != $atten_data->total_present_days){
   $basic = $claims->where("sal_head_id", SalHead::$BASIC_HEAD_ID)->first();
   $da    = $claims->where("sal_head_id", SalHead::$DA_HEAD_ID)->first();

   $working_by_total = $atten_data->total_present_days / $atten_data->total_working_days;
   
   $basic = round($basic->claims * $working_by_total, 2);
   $da    = round($da->claims * $working_by_total, 2);

// dump($basic);
//    dd($da);

   
   $claims = $claims->transform(function($item) use ($basic, $da) {
	   if($item->sal_head_id == SalHead::$BASIC_HEAD_ID){
		   $item->claims = $basic;
	   }
	   if($item->sal_head_id == SalHead::$DA_HEAD_ID){
		   $item->claims = $da;
	   }
	   return $item;
   });

   //dd($claims);
}

/**
*
* see how I fetch claims and then change basic and da value using transform function.
* 
* reference link: https://www.f1coder.com/articles/1gbdm6ig/how-to-use-laravel-collection-transform-method#:~:text=The%20transform%20method%20applies%20a,return%20value%20of%20the%20callback.
*/