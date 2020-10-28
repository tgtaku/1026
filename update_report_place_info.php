<?php
session_start();
$project_id = $_SESSION['count'];
//print_r($project_id);
if(isset($_POST['file_name'])){

$selected_pdf_id ="";
//各要素を配列に変更
$array_file_name = $_POST['file_name'];
//print_r($array_file_name);
//$array_file_name = preg_split("/[\s,]+/", $_POST['file_name']);
$array_no = preg_split("/[\s,]+/", $_POST['no']); 
$array_point_name = preg_split("/[\s,]+/", $_POST['array_point_name']); 
$array_pointx = preg_split("/[\s,]+/", $_POST['pointx']); 
$array_pointy = preg_split("/[\s,]+/", $_POST['pointy']); 
$array_page = preg_split("/[\s,]+/", $_POST['page']); 

//配列に残っている既存データ数を確認
//print_r($_POST['no']);
$past_data = 0;
for($i = 0; $i < count($array_no); $i++){
    if($array_no[$i] == "0"){
        $past_data++;
    }
}
//print_r($past_data);

//既存データを取得
//mysqlとの接続
$link = mysqli_connect('localhost', 'root', '');
if (!$link) {
    die('Failed connecting'.mysqli_error());
}
//DBの選択
$db_selected = mysqli_select_db($link , 'test_db');
if (!$db_selected){
    die('Failed Selecting table'.mysql_error());
}
//文字列をutf8に設定
mysqli_set_charset($link , 'utf8');
//報告箇所テーブルの取得

//$result_pdf_report_point  = mysqli_query($link ,"select * from report_places_infomation_1 inner join pdf_information_1 on pdf_information_1.pdf_id = report_places_infomation_1.pdf_id where pdf_information_1.project_id = '$project_id' and pdf_information_1.pdf_name like 'test.pdf';");
$result_pdf_report_point  = mysqli_query($link ,"select * from report_places_infomation_1 inner join pdf_information_1 on report_places_infomation_1.pdf_id = pdf_information_1.pdf_id where pdf_information_1.project_id = '$project_id' and pdf_information_1.pdf_name ='$array_file_name';");
if (!$result_pdf_report_point) {
    die('Failed query'.mysql_error());
}
//データ格納用配列の取得
$pdf_id = array();
$i = 0;
while ($row_pdf = mysqli_fetch_assoc ($result_pdf_report_point)) {
    //$pdf_id[$i] = $row_pdf['pdf_id'];
    $selected_pdf_id = $row_pdf['pdf_id'];
    $pdf_id[$i] = $row_pdf;
    $i++;
}
//print_r($pdf_id);
//$close_flag = mysqli_close($link);
if($pdf_id == null){
    //PDF名からpdf_idを取得
    $result_pdf_report_point  = mysqli_query($link ,"select * from pdf_information_1 where project_id = '$project_id' and pdf_name ='$array_file_name';");
    if (!$result_pdf_report_point) {
    die('Failed query'.mysql_error());
}
$i = 0;
while ($row_pdf = mysqli_fetch_assoc ($result_pdf_report_point)) {
    //$pdf_id[$i] = $row_pdf['pdf_id'];
    $selected_pdf_id = $row_pdf['pdf_id'];
}
    //print_r("null");
    for($from = 0; $from < count($array_no); $from++){
        require "conn.php";
        $sql = "INSERT INTO report_places_infomation_1 VALUES ('', '$selected_pdf_id', '$array_point_name[$from]', '$array_page[$from]', '$array_pointx[$from]','$array_pointy[$from]','');";
        $result  = mysqli_query($conn, $sql);
        //($array_point_name[$from]);
    }

}else{
    //print_r($selected_pdf_id);
//既存の施工箇所名更新、削除の判定
for($i = 0; $i < count($pdf_id); $i++){
    $count = 0;
    for($j = 0; $j < count($array_no); $j++){
        //既に登録されているかの確認
        if($pdf_id[$i]['pdf_name'] == $array_file_name && $pdf_id[$i]['page'] == $array_page[$j] && $pdf_id[$i]['X'] == $array_pointx[$j] && $pdf_id[$i]['Y'] == $array_pointy[$j]){
            if($pdf_id[$i]['report_place_name'] == $array_point_name[$j]){
                //print_r("何もしない");
                //print_r($pdf_id[$i]['report_places_id']);
            }else{
                require "conn.php";
                //$sql = "UPDATE projects_information_1 SET projects_name='$project_name', projects_street_address='$address', overview='$overview' WHERE projects_id='$projects_id';";
                $change_name = $pdf_id[$i]['report_place_name'];
                $change_id = $pdf_id[$i]['report_places_id'];
                $sql = "UPDATE report_places_infomation_1 SET report_place_name = '$change_name' where report_places_id = '$change_id';";
                $result  = mysqli_query($conn, $sql);
                //print_r("変更");
                //print_r($pdf_id[$i]['report_places_id']);    
        }
    }else{
        $count++;
        if($count == count($array_point_name)){
            require "conn.php";
            //$sql = "delete from pdf_information_1 where project_id = '$project_id' and pdf_name = '$array_del_file[$i]';";
            $del_id = $pdf_id[$i]['report_places_id'];
            $sql = "delete from report_places_infomation_1 where report_places_id = '$del_id';";
            $result  = mysqli_query($conn, $sql);
            //print_r("削除");
            //print_r($pdf_id[$i]['report_places_id']);
        }
    }
    }
    
}
//報告箇所新規登録処理
$from = $past_data;
for($from; $from < count($array_no); $from++){
    require "conn.php";
    $sql = "INSERT INTO report_places_infomation_1 VALUES ('', '$selected_pdf_id', '$array_point_name[$from]', '$array_page[$from]', '$array_pointx[$from]','$array_pointy[$from]','');";
    $result  = mysqli_query($conn, $sql);
   // print_r($array_point_name[$from]);
}
/*require "conn.php";

$p_id = $pdf_id[0];
//print_r($p_id);
$report_place_name = $_POST["s_name"];
$page = $_POST["s_page"];
$x = $_POST["s_x"];
$y = $_POST["s_y"];
$sql = "INSERT INTO report_places_infomation_1 VALUES ('', '$p_id', '$report_place_name', '$page', '$x','$y','');";
$result  = mysqli_query($conn, $sql);

exit;*/

/*
print_r($array_file_name);
print_r($array_point_name);
print_r($array_pointx);
print_r($array_pointy);
print_r($array_page);*/
}


}
?>