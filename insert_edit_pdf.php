<?php
//現場IDの取得
session_start();
$project_id = $_SESSION['count'];
print_r($project_id);

//ファイル名、base64データの取得
if(isset($_POST['file'])){
    $post_file = $_POST["file"];
    $post_file_name = $_POST['file_name'];

    //テキストデータを配列に変更
    $str_file = str_replace('data:application/pdf;base64,','',$_POST["file"]);
    $array_post_file = preg_split("/[\s,]+/", $str_file);
    $array_post_file_name = preg_split("/[\s,]+/", $_POST["file_name"]);
    //print_r($array_post_file);
    //print_r($array_post_file_name);
    $num = count($array_post_file);

    //ファイルアップロード処理
    for($i = 0; $i < $num; $i++){
    file_put_contents("./up/" .$array_post_file_name[$i], base64_decode($array_post_file[$i])); 
    }

    require "conn.php";
    for($i = 0; $i < $num; $i++){
        $sql = "INSERT INTO pdf_information_1 VALUES ('', '$project_id', '$array_post_file_name[$i]', '' );";
        $result  = mysqli_query($conn, $sql);
        if($result){
        echo "Data Inserted";
        exit;
        }
        else{
        echo "Failed";
        }
    }
}

?>