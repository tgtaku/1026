<?php
//現場IDの取得
session_start();
$project_id = $_SESSION['count'];
print_r($project_id);
if(isset($_POST['delete_file'])){
    $str_del_file = $_POST['delete_file'];
    $array_del_file = preg_split("/[\s,]+/", $str_del_file);

    require "conn.php";
    for($i = 0; $i < count($array_del_file); $i++){
        $sql = "delete from pdf_information_1 where project_id = '$project_id' and pdf_name = '$array_del_file[$i]';";
        $result  = mysqli_query($conn, $sql);
        if($result){
        echo "Data Delete";
        exit;
        }
        else{
        echo "Failed";
        }
    }
}
print_r($array_del_file);

?>