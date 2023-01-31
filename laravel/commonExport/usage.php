$item = DomesticHelp::where('id', 1)->first();

$users_table_columns = array_keys($item->getAttributes());

$exclude_columns = [
   'title',
   'employeed_before',
   'identity_proof_file',
   'passport_size_photo',
   'finger_print',
   'deactivate_date',
   'approve_date',
   'description',
   'created_at',
   'updated_at',
   'status',
   'status_file',
   'sarpanch',
   'sarpanch_file',
];

$selectedColumns = array_diff($users_table_columns, (array) $exclude_columns);

$unsetColumn = "title";

// unsetColumn is sent because title is required for full_name attribute

$headings = [
   "#",
   "Reference No.",
   "Username",
   "Name",
   "Guardian",
   "Place Of Birth",
   "Age",
   "Gender",
   "Nationality  ",
   "Language",
   "Mobile No.",
   "Landline No.",
   "Permanent Address",
   "Present Address",
   "District  ",
   "Permanent District  ",
   "Police Station  ",
   "Permanent Police Station",
   "Identity Proof Type",
   "Identity Proof No.",
   "Other ID Name",
   "Other ID No.",
   "Complexion",
   "Build",
   "Height",
   "Eye Colour",
   "Identification Mark",
   "Employer Name",
   "Employer Contact No.",
   "Employer Mobile No.",
   "Date of Employment",
   "Employer Address",
];

// foreach ($selectedColumns as $column) {
//     $headings[] = ucwords(str_replace(['_', 'id'], ' ', $column));
// }

// $headings[0] = '#';
// $headings[2] = 'Username';
// $headings[4] = 'Guardian';

// dd($headings);

$model = "App\Models\DomesticHelp";

$relations = [
   ['id' => 'user_id', 'relation' => 'user'],
   ['id' => 'district_id', 'relation' => 'district'],
   ['id' => 'perma_district_id', 'relation' => 'perma_district'],
   ['id' => 'police_station_id', 'relation' => 'police_station'],
   ['id' => 'perma_police_station_id', 'relation' => 'perma_police_station'],
   ['id' => 'nationality_id', 'relation' => 'nationality']
];

$attributes = [
   ['id' => 'name', 'attribute' => 'full_name'],
];

return (new CommonExport($selectedColumns, $headings, $model, $relations, $attributes, $unsetColumn))->download('domestic.xlsx');
