$this->validate($request, [
    'section' => 'required',
    'subsection_of_id' => 'required_if:limit,null',
    'subsection_of' => 'required_with:subsection_of_id',
    'limit' => 'required_if:subsection_of_id,null',
]);

// if limit is null subsection id is required if subsection_of_id is present subsection_of is required.

// for further reference

link: https://laravel.com/docs/8.x/validation#rule-required-unless
