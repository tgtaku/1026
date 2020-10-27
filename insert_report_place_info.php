<?php
if(isset($_POST["names"])){

    //post情報の取得
    $pdf_name = $_POST["names"];
    $point_name = $_POST['array_point_name'];
    $page = $_POST["page"];
    $pointx = $_POST["pointx"];
    $pointy = $_POST["pointy"];
    $num = $_POST['num'];
    $count_pdf = $_POST['count_pdf'];
    //post情報の配列化
    $array_pdf_name = preg_split("/[\s,]+/", $pdf_name);
    $array_point_name = preg_split("/[\s,]+/", $point_name);
    $array_page = preg_split("/[\s,]+/", $page);
    $array_pointx =  preg_split("/[\s,]+/", $pointx);
    $array_pointy = preg_split("/[\s,]+/", $pointy);
    $array_num = preg_split("/[\s,]+/", $num);
    //$array_count_pdf = preg_split("/[\s,]+/", $point_name);

    //$array_pdf_name = preg_split("/[\s,]+/", $str_file);
    //$array_page = preg_split("/[\s,]+/", $_POST["file_name"]);

    //プロジェクトIDの取得
    session_start();
    $project_id = $_SESSION['count'];
    }

    //PDFIDの取得
    //データ格納用配列の取得
    $pdf_id = [];
    $link = mysqli_connect('localhost', 'root', '');
    if (!$link) {
        die('Failed connecting'.mysqli_error());
    }
    //print('<p>Successed connecting</p>');
    
    //DBの選択
    $db_selected = mysqli_select_db($link , 'test_db');
    if (!$db_selected){
        die('Failed Selecting table'.mysql_error());
    }
    
    //文字列をutf8に設定
    mysqli_set_charset($link , 'utf8');

    for ($j = 0; $j < $count_pdf; $j++){
        $pdf_file_name = $array_pdf_name[$j];
        print_r($pdf_file_name);
        $result_pdf_file  = mysqli_query($link ,"SELECT * FROM pdf_information_1 where project_id = '$project_id' AND pdf_name = '$pdf_file_name';");
        if (!$result_pdf_file) {
            die('Failed query'.mysqli_error($result_pdf_file));
        }
    
        $i = 0;
        while ($row_pdf = mysqli_fetch_assoc ($result_pdf_file)) {
            //$pdf_id[$i] = $row_pdf['pdf_id'];
            print_r($row_pdf['pdf_id']);
            array_push($pdf_id, $row_pdf['pdf_id']);
            $i++;
        }
        //print_r($pdf_id);
       
    }
    $close_flag = mysqli_close($link);
    print_r($pdf_id);

    print_r($array_pdf_name);
    print_r($point_name);
    print_r($page);
    print_r($pointx);
    print_r($pointy);
    print_r($array_num);
    print_r($count_pdf);
    //$num = count($file_name);
    
    $k = 0;
    for($i = 0; $i < $count_pdf; $i++){
        for($j = 0; $j < $array_num[$i]; $j++){
            $sql = "INSERT INTO report_places_infomation_1 VALUES ('', '$pdf_id[$i]', '$array_point_name[$k]', '$array_page[$k]', '$array_pointx[$k]','$array_pointy[$k]','');";
            $k++;
            //print_r($sql);
            require "conn.php";
            $result  = mysqli_query($conn, $sql);
            if($result){
            echo "Data Inserted";
            }
            else{
            echo "Failed";
        }
        }
    }
    
?>