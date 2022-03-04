/**
 * data
 */

 array:5 [▼
   "_token" => "qkytsiXhQn0FTWry1RJisRXIeTqVFMk5cWeB7jHc"
   "salhead_id" => "19"
   "month" => "7"
   "year" => "2022"
   "datas" => array:2 [▶
     0 => array:2 [▶
       "employee_id" => "2"
       "amounts" => "0.00"
     ]
     2 => array:2 [▶
       "employee_id" => "1"
       "amounts" => "0.00"
     ]
   ]
 ]

 /**
  * VALIDATOR
  */

  $request->validate([
    'salhead_id' => 'required',
    'month'      => 'required',
    'year'       => 'required',
    'datas.*'    => 'required',
    'datas.*.employee_id'  => 'required',
    'datas.*.amount'       => 'required|numeric|min:0',
]);

/**
 *
 * https://laravel.com/docs/5.5/validation#validating-arrays
 */
