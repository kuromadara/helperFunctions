/*
 * Controller
 */

 public static function calculateRate($payband_min, $basic ,$grade_pay, $da ){

    $single = 0;
    $holiday = 0;
    $max = 0;

    if($payband_min == 0){
        return [
            'single' => $single,
            'holiday' => $holiday,
        ]; ;
    }
    $single = (($payband_min + $grade_pay) * 1.5 * 2) / 208;
    $single = round($single, 0, PHP_ROUND_HALF_UP);

    $holiday = (($payband_min + $grade_pay) * 2 * 2) / 208;
    $holiday = round($holiday, 0, PHP_ROUND_HALF_UP);

    $max = (($basic + $da + $grade_pay ) * 1.34 * 2) / 208;
    $max = round($max, 0, PHP_ROUND_HALF_UP);

    if($single > $max){
        $single = $max;
    }
    if($holiday > $max){
        $holiday = $max;
    }
    return [
        'single' => $single,
        'holiday' => $holiday,
    ];
}


/*
 * Blade
 */


 @inject('calculate', 'App\Http\Controllers\OvertimeController')

 @php
    $ot_rates = $calculate::calculateRate(
                                $overtime->employee->payband->minimum ?? 0,
                                $overtime->employee->temp_payslip_data[0]->claims,
                                $overtime->employee->temp_payslip_data[1]->claims,
                                $overtime->employee->temp_payslip_data[2]->claims,
                            ) ;

@endphp
