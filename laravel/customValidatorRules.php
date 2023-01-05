/*
 * DATA:
   array:3 [▼
        0 => array:6 [▼
         "employee_code" => 1018
         "oth_income_1" => 4400
         "oth_income_2" => null
         "oth_income_3" => null
         "oth_income_4" => null
         "oth_income_5" => null
        ]
        1 => array:6 [▼
         "employee_code" => 1575
         "oth_income_1" => null
         "oth_income_2" => null
         "oth_income_3" => 3000
         "oth_income_4" => null
         "oth_income_5" => null
        ]
        2 => array:6 [▼
         "employee_code" => 1018
         "oth_income_1" => 3000
         "oth_income_2" => null
         "oth_income_3" => null
         "oth_income_4" => null
         "oth_income_5" => null
        ]
      ]
 * ERROR:
    The field employee_code: 1018 has a duplicate value at row: 2
    The field employee_code: 1018 has a duplicate value at row: 4
 */


$distict_check = $collection->toArray();
$message       = [];
foreach ($distict_check as $rowNum => $row) {
    foreach ($row as $field => $value) {
        $actual_row                                   = $rowNum + 2; // 1 for heading row, 1 for 0 index
        $message["{$rowNum}." . $field . ".distinct"] = "The field {$field}: {$value} has a duplicate value at row: {$actual_row}";
    }
}
$validator_distinct = Validator::make($distict_check, [
    '*.employee_code' => 'distinct',
], $message,
    [
        '*.employee_code' => 'Employee Code',
    ],
);

$validator_distinct->validate();

/* Try Catch */

DB::beginTransaction();
try{
    Excel::import($import, $request->file);

} catch(\Maatwebsite\Excel\Validators\ValidationException $e){
    $failures = $e->failures();
    return Redirect::back()->with("error",  $failures);
}
DB::commit();


// another example


$data = $collection->toArray();
$message[] = [
    'row' => $this->row,
    'message' => 'Imported Successfully',
];
foreach ($data as $rowNum => $row) {
    foreach ($row as $field => $value) {
        $actual_row                                   = $rowNum + 1; // 1 for heading row, 1 for 0 index
        $message["{$rowNum}.".$field.".required"] = "The field {$field} at row: {$actual_row} is required";
        if($field == 'name'){
            $message["{$rowNum}.".$field.".string"] = "The field {$field} at row: {$actual_row} must be a string";
        }
        if($field == "email"){
            $message["{$rowNum}.".$field.".email"] = "The field {$field} at row: {$actual_row} must be a valid email address";
        }
        if($field == "mobile"){
            $message["{$rowNum}." . $field.".unique"] = "The field {$field}: {$value} at row: {$actual_row} already exists in database";
        }

    }
}
        // dd($message);
$validator = Validator::make($data,[
    '*.name' => 'required|string|min:1',
    '*.mobile' => 'required|numeric|unique:trainees,mobile|digits:10',
    '*.email' => 'required|email',
    '*.address' => 'required|string|min:1',
], $message,
[
    '*.name' => 'Name',
    '*.mobile' => "Mobile",
    '*.email' => "Email",
    '*.address' => "Address",

]);

$validator->validate();

// https://beyondco.de/blog/writing-and-testing-custom-validators-in-laravel


// the below validation 

$request->validate(
		[
			'username' => 'exists:users',
		]
	);

    $request->validate(
    	[
      	'username' => 'exists:users,status,status,1',
      	'password' => 'required',
      	'captcha' => 'required|captcha',
	],
	[
     		'username' . '.exists' => 'The username is deactivated.',
	]
);
