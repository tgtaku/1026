<?php
if(isset($_POST["project_name"])){

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

    //pdfテーブルの取得
    $result_file  = mysqli_query($link ,"SELECT projects_id FROM projects_information_1 ORDER BY projects_id DESC LIMIT 1;");
    if (!$result_file) {
        die('Failed query'.mysql_error());
    }
    $row = mysqli_fetch_assoc($result_file);
    $row_num = (int) $row['projects_id'];
    session_start();
    $_SESSION['count'] = $row_num + 1;

    $project_name = $_POST["project_name"];
    $address = $_POST["address"];
    $overview = $_POST["overview"];
    $str_file = str_replace('data:application/pdf;base64,','',$_POST["file"]);
    $array_file = preg_split("/[\s,]+/", $str_file);
    $file_name = preg_split("/[\s,]+/", $_POST["file_name"]);
    //print_r($array_file);
    $num = count($file_name);
    
    
    $project_id = $_SESSION['count'];
    echo $project_id;
    //ファイルアップロード処理
    for($i = 0; $i < $num; $i++){
        file_put_contents("./up/" .$file_name[$i], base64_decode($array_file[$i])); 
    }
    


    require "conn.php";
    $sql = "INSERT INTO projects_information_1 VALUES ('', '$project_name', '$address', '$overview', '' );";
        $result  = mysqli_query($conn, $sql);
        if($result){
        echo "Data Inserted";
        }
        else{
        echo "Failed";
        }
    
    //PDFファイル名の登録
    for($i = 0; $i < $num; $i++){
        $sql = "INSERT INTO pdf_information_1 VALUES ('', '$project_id', '$file_name[$i]', '' );";
        $result  = mysqli_query($conn, $sql);
        if($result){
        echo "Data Inserted";
        }
        else{
        echo "Failed";
        }
    }
    
}?>