<!DOCTYPE html>
<html>
<body>

<?php
   $arr = [
    'list1' => [
        'a',
        'b',
        ],
    'list2' => [
        'c',
        'd',
        ],
     'list3' => [
        'b',
        'a',
        ],
    'list4' => [
        'd',
        'c',
        ],
    ];

	$arr1 = [];
    $arr2 = [];
    $arr3 = [];
    $arr4 = [];
    foreach($arr as $key => $value){
        if($value[0] == 'a' || $value[0] == 'b'){
            $arr1[$key] = $value;
        }else if($value[0] == 'c' || $value[0] == 'd'){
            $arr2[$key] = $value;
        }
    }
    foreach($arr1 as $key => $value){
        if($value[1] == 'a' || $value[1] == 'b'){
            $arr3[$key] = $value;
        }
    }
    foreach($arr2 as $key => $value){
        if($value[1] == 'c' || $value[1] == 'd'){
            $arr4[$key] = $value;
        }
    }
    $arr = array_merge($arr3,$arr1,$arr4,$arr2);
    print_r($arr);

?>

</body>
</html>
