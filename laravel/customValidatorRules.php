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
