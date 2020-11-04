<?php
$report_name = $_GET['report'];
//出力用
$project_name = "";//現場名
$project_address = "";//現場所在地
$project_overview = "";//現場概要
$company_name = "";//施工会社名
$company_address = "";//施工会社住所
$company_tel = "";//施工会社電話番号
$reporter = "";//施工会社報告者名
$report_place = "";//施工ヶ所
$pic_date = [];//撮影日時
$pic_path = [];//画像パス
$comment = [];//コメント

//現場情報の取得
//会社情報の取得
require "conn.php";
$mysql_qry = "select * from reports_name_1 inner join projects_information_1 on reports_name_1.projects_id = projects_information_1.projects_id inner join companies_information_1 on reports_name_1.company_id = companies_information_1.companies_id where reports_name = '$report_name';";
        //$mysql_qry = "select * from reports_name_1 inner join projects_information_1 on reports_name_1.projects_id = projects_information_1.projects_id inner join companies_information_1 on reports_name_1.company_id = companies_information_1.companies_id;";
        $result = mysqli_query($conn, $mysql_qry);
        //print_r($result);
        if(mysqli_num_rows($result) > 0){
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                //print_r('<pre>');
                //print_r($row);
                $project_name = $row['projects_name'];//現場名
                $project_address = $row['projects_street_address'];//現場所在地
                $project_overview = $row['overview'];//現場概要
                $company_name = $row['companies_name'];//施工会社名
                $company_address = $row['street_address'];//施工会社住所
                $company_tel = $row['tel'];//施工会社電話番号
                $reporter = $row['reporter'];//施工会社報告者名
                $report_place = $row['reports_place'];//施工ヶ所
                $i++;
            }
        }
    //}

//写真情報の取得
$mysql_qry = "select * from repors_information_1 inner join pictures_information_1 on repors_information_1.pictures_id = pictures_information_1.pictures_name where repors_name = '$report_name';";
        //$mysql_qry = "select * from reports_name_1 inner join projects_information_1 on reports_name_1.projects_id = projects_information_1.projects_id inner join companies_information_1 on reports_name_1.company_id = companies_information_1.companies_id;";
        $result = mysqli_query($conn, $mysql_qry);
        //print_r($result);
        if(mysqli_num_rows($result) > 0){
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                //print_r('<pre>');
                //print_r($row);
                array_push($pic_date, $row['date']);//撮影日時
                array_push($pic_path, $row['path']);//画像パス
                array_push($comment, $row['comment']);//コメント
                $i++;
            }
        }

//配列のエンコード
$json_array_pic_date = json_encode($pic_date);
$json_array_pic_path = json_encode($pic_path);
$json_array_comment = json_encode($comment);

?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>報告書確認</title>
        <link rel="stylesheet" href = "style_report.css">
    </head>
    <body>
    <main>
        <div class="main-container">
            <div class="sidebar">
                <h1>menu</h1>
                <ul class="subnav">
                    <li>現場情報管理</li>
                    <li><a href="p_entry.php" >-現場登録</a></li>
                    <li><a href="p_edit.php" >-現場編集</a></li>
                    <li>施工会社管理</li>
                    <li><a href="c_entry.php">-施工会社登録</a></li>
                    <li><a href="c_edit.php" >-施工会社/ユーザ編集</a></li>
                    <li>施工状況確認</li>
                    <li><a href="select_report.php"　style="background-color:gray">-報告書確認</a></li>
                </ul>
            </div>
            <div class="maincol">
                <div class="maincol-container">
                
    <table id = "report" name = "report">
                <!--現場情報-->
                <tr id = "project_info">
                    <td colspan = "2">現場情報</td>
                </tr>
                <tr>
                    <td id = "th_title">現場名</td>
                    <td><?php echo $project_name; ?></td>
                </tr>
                <tr>
                    <td id = "th_title">所在地</td>
                    <td><?php echo $project_address; ?></td>
                </tr>
                <tr>
                    <td id = "th_title">概要</td>
                    <td><?php echo $project_overview; ?></td>
                </tr>
                <tr id = "blank">
                <td colspan = "2"></td>
                </tr>
                <!--施工者情報-->
                <tr id = "project_info">
                    <td colspan = "2">施工者情報</td>
                </tr>
                <tr>
                    <td id = "th_title">会社名</td>
                    <td><?php echo $company_name; ?></td>
                </tr>
                <tr>
                    <td id = "th_title">住所</td>
                    <td><?php echo $company_address; ?></td>
                </tr>
                <tr>
                    <td id = "th_title">電話番号</td>
                    <td><?php echo $company_tel; ?></td>
                </tr>
                <tr>
                    <td id = "th_title">報告者</td>
                    <td><?php echo $reporter; ?></td>
                </tr>
                <tr id = "blank">
                    <td colspan = "2"></td>
                </tr>

                <!--施工状況-->
                <tr id = "project_info">
                    <td colspan = "2">施工状況</td>
                </tr>
                <tr>
                    <td id = "th_title">施工箇所</td>
                    <td><?php echo $report_place; ?></td>
                </tr>
                <!--<tr>
                    <td id = "th_title">撮影日時</td>
                    <td>2020/11/04　12:34:56</td>
                </tr>
                <tr class="pic">
                    <td colspan = "2" id = "src"><img src = http://10.20.170.52/sample/images/066.jpg></td>
                </tr>
                <tr>
                    <td id = "th_title">コメント</td>
                    <td></td>
                </tr>
                <tr id = "blank">
                <td colspan = "2"></td>
                </tr>
                <tr>
                    <td id = "th_title">撮影日時</td>
                    <td>2020/11/04　14:25:25</td>
                </tr>
                <tr class="pic">
                    <td colspan = "2" id = "src"><img src = http://10.20.170.52/sample/images/IMG_20200529_164248.jpg></td>
                </tr>
                <tr>
                    <td id = "th_title">コメント</td>
                    <td></td>
                </tr>-->
                
                
            </table>
            </div>
            </div>
        </div>
</main>
<script>
    var array_pic_date = <?php echo $json_array_pic_date; ?>;
    var array_pic_path = <?php echo $json_array_pic_path; ?>;
    var array_pic_comment = <?php echo $json_array_comment; ?>;

    
</script>
    </body>
</html>
