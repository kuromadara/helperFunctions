// Common Helper

public static function calculate_age($dob)
{
    return Carbon::parse($dob)->age;
}

// Models

public function getAge()
{
    return CommonHelper::calculate_age($this->dob);
}


// Alternate method using arribute accessor

public function getAgeAttribute()
{
   return Carbon::parse($this->dob)->age;
}
