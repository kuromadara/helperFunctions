function dateDiff($from_date, $to_date, $type)
{
    $new_from_date = $from_date;
    $new_to_date = $to_date;
    if (trim($from_date) == "") {
        $from_date = "2019-01-01";
    }
    $from_date = new \DateTime($from_date);
    $to_date   = new \DateTime($to_date);
    $diff      = $from_date->diff($to_date);
    if ($type == "Month") {
        return (($diff->format('%y') * 12) + $diff->format('%m'));
    } elseif ($type == "Day") {
        // old logic remove due to it s not returning into fractional
        $oneDay = 24 * 60 * 60;
        $datetime1 = strtotime($new_from_date); // smaller date
        $datetime2 = strtotime($new_to_date); // larger date
        $interval = $datetime2 - $datetime1; // seconds
        $days = $interval / $oneDay; // fractions of days
        return (float)$days;
        // return $diff->format('%r%a'); //old logic
    }
    return 0;
}
