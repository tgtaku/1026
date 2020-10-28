<?php
//プロジェクトIDの取得
session_start();
$project_id = $_SESSION['count'];
$project_id_now = json_encode($project_id);

//POST情報の取得
$array_cnt = preg_split("/[\s,]+/", $_POST['cnt']); 
$array_company = preg_split("/[\s,]+/", $_POST['company']); 
$array_user = preg_split("/[\s,]+/", $_POST['user']); 
print_r($array_cnt);
print_r($array_company);
print_r($array_user);

//POSt情報から割り振り

?>