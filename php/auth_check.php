// in helper

function checkAuthorization($json, $currentPageModuleId) {
       global $webUrl;
       $foundModule = false;
       foreach ($json as $key => $val) {
           if ($val['module_id'] == $currentPageModuleId) {
               $foundModule = true;
               if ($val['edit_permission'] == 0 || $val['add_permission'] == 0 || $val['delete_permission'] == 0 || $val['view_permission'] == 0) {
                   header("Location: " . $webUrl . "access-denied.php");
                   exit();
               }
           }
       }
       if (!$foundModule) {
           header("Location: " . $webUrl . "access-denied.php");
           exit();
       }
   }

// call the function in each page as


<?php

    // Module to check permission
    $json = json_decode($_SESSION['user_level'], true);

    $currentPageModuleId = 3;

    $helper->checkAuthorization($json, $currentPageModuleId);

?>

// in login function

$data = array();
foreach($rowP as $key=>$val){
   $data[$key]['module_id'] = $val['module_id'];
   $data[$key]['role_id'] = $val['role_id'];
   $data[$key]['edit_permission'] = $val['edit_permission'];
   $data[$key]['add_permission'] = $val['add_permission'];
   $data[$key]['delete_permission'] = $val['delete_permission'];
   $data[$key]['view_permission'] = $val['view_permission'];
}
$_SESSION['user_level'] = json_encode($data);
