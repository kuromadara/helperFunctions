
$item = DomesticHelp::where('id', 1)->first();

$users_table_columns = array_keys($item->getAttributes());

$exclude_columns = [
    'employeed_before',
    'identity_proof_file',
    'finger_print',
    'deactivate_date',
    'approve_date',
    'description',
    'created_at',
    'updated_at',
    'status',
    'status_file',
];

$selectedColumns = array_diff($users_table_columns, (array) $exclude_columns);

$headings = [];

// change the names of headings

foreach ($selectedColumns as $column) {
    $headings[] = ucwords(str_replace(['_', 'id'], ' ', $column));
}

$headings[0] = '#';
$headings[2] = 'Username';

$model = "App\Models\DomesticHelp";

// relations are sent dynamically as parameter.

$relations = [
    ['id' => 'user_id', 'relation' => 'user'],
    ['id' => 'district_id', 'relation' => 'district'],
    ['id' => 'perma_district_id', 'relation' => 'perma_district'],
    ['id' => 'police_station_id', 'relation' => 'police_station'],
    ['id' => 'perma_police_station_id', 'relation' => 'perma_police_station'],
    ['id' => 'nationality_id', 'relation' => 'nationality']
];

return (new CommonExport($selectedColumns, $headings, $model, $relations))->download('domestic.xlsx');
