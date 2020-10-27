<?php
//ポスト情報の確認
if(isset($_POST['search_pro'])){
    require "conn.php";
    $project = $_POST["project"];
    $address = $_POST["address"];
    $overview = $_POST["overview"];
    //結果格納用の配列
    $row_array_project_id = "";
    $row_array_project = array();
    $row_array_address = array();
    $row_array_overview = array();

    //全部なし
    if($project =="" && $address == "" && $overview == ""){
        $mysql_qry = "select * from projects_information_1;";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                $row_array_project_id[$i] = $row['projects_id'];
                $row_array_project[$i] = $row['projects_name'];
                $row_array_address[$i] = $row['projects_street_address'];
                $row_array_overview[$i] = $row['overview'];
                $i++;
            }
        }
        //プロジェクト名だけで検索
    }elseif($project !="" && $address == "" && $overview == ""){
        $mysql_qry = "select * from projects_information_1 where projects_name like '%$project%' ;";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                $row_array_project_id[$i] = $row['projects_id'];
                $row_array_project[$i] = $row['projects_name'];
                $row_array_address[$i] = $row['projects_street_address'];
                $row_array_overview[$i] = $row['overview'];
                $i++;
            }
        }
        //住所だけで検索
    }elseif($project =="" && $address != "" && $overview == ""){
        $mysql_qry = "select * from projects_information_1 where projects_street_address like '%$address%' ;";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                $row_array_project_id[$i] = $row['projects_id'];
                $row_array_project[$i] = $row['projects_name'];
                $row_array_address[$i] = $row['projects_street_address'];
                $row_array_overview[$i] = $row['overview'];
                $i++;
            }
        }
        //概要だけで検索
    }elseif($project =="" && $address == "" && $overview != ""){
        $mysql_qry = "select * from projects_information_1 where overview like '%$overview%' ;";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                $row_array_project_id[$i] = $row['projects_id'];
                $row_array_project[$i] = $row['projects_name'];
                $row_array_address[$i] = $row['projects_street_address'];
                $row_array_overview[$i] = $row['overview'];
                $i++;
            }
        }
        //プロジェクト名と住所で検索
    }elseif($project !="" && $address != "" && $overview == ""){
        $mysql_qry = "select * from projects_information_1 where projects_name like '%$project%' or projects_street_address like '%$address%';";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                $row_array_project_id[$i] = $row['projects_id'];
                $row_array_project[$i] = $row['projects_name'];
                $row_array_address[$i] = $row['projects_street_address'];
                $row_array_overview[$i] = $row['overview'];
                $i++;
            }
        }
        //プロジェクト名と概要で検索
    }elseif($project !="" && $address == "" && $overview != ""){
        $mysql_qry = "select * from projects_information_1 where projects_name like '%$project%' or overview like '%$overview%';";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                $row_array_project_id[$i] = $row['projects_id'];
                $row_array_project[$i] = $row['projects_name'];
                $row_array_address[$i] = $row['projects_street_address'];
                $row_array_overview[$i] = $row['overview'];
                $i++;
            }
        }
        //住所と概要で検索
    }elseif($project =="" && $address != "" && $overview != ""){
        $mysql_qry = "select * from projects_information_1 where projects_street_address like '%$address%' or overview like '%$overview%';";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                $row_array_project_id[$i] = $row['projects_id'];
                $row_array_project[$i] = $row['projects_name'];
                $row_array_address[$i] = $row['projects_street_address'];
                $row_array_overview[$i] = $row['overview'];
                $i++;
            }
        }
        //全部で検索
    }else{
        $mysql_qry = "select * from projects_information_1 where projects_name like '%$project%' or projects_street_address like '%$address%' or overview like '%$overview%';";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                $row_array_project_id[$i] = $row['projects_id'];
                $row_array_project[$i] = $row['projects_name'];
                $row_array_address[$i] = $row['projects_street_address'];
                $row_array_overview[$i] = $row['overview'];
                $i++;
            }
        }
        
    }
//json形式に変更
$json_array_project_id = json_encode($row_array_project_id);
$json_array_project = json_encode($row_array_project);
$json_array_address = json_encode($row_array_address);
$json_array_overview = json_encode($row_array_overview);
//セッションスタート
//session_start();
//$_SESSION['count'] = $row_array_project_id[0];

    
}
//print_r($json_array_project);
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>現場編集</title>
        <link rel="stylesheet" href = "style.css">
    </head>
    <body>
    <main>
        <div class="main-container">
            <div class="sidebar">
                <h1>menu</h1>
                <ul class="subnav">
                    <!--<li><a href="#" class="current">管理者ページ</a></li>-->
                    <li>現場情報管理</li>
                    <li><a href="p_entry.php" >-現場登録</a></li>
                    <li><a href="p_edit.php" style="background-color:gray">-現場編集</a></li>
                    <li>施工会社管理</li>
                    <li><a href="c_entry.php">-施工会社登録</a></li>
                    <li><a href="c_edit.php">-施工会社/ユーザ編集</a></li>
                    <li>施工状況確認</li>
                    <li><a href="report.php">-報告書確認</a></li>
                </ul>
            </div>
            <div class="maincol">
                <div class="maincol-container">
    

    <h2>編集する現場を選択してください</h2>
    <p>
        <form action="p_edit.php" method = "post">
        現場名<input type = "text" name = "project" value = ""><br />
        所在地<input type ="text" name="address" value = ""><br />
        概要<input type ="text" name="overview" value = ""><br />
        <input type = "submit" id = "search_pro" name="search_pro" value = "検索">
        </form>
    </p>
    <form id="pro_form" action="p_edit_company.php" method = "post">
    <table id = "pro_info" name = "table_com">
                <tr>
                    <th style="WIDTH: 200px" id="project">現場名</th>
                    <th style="WIDTH: 200px" id="address">所在地</th>
                    <th style="WIDTH: 200px" id="overview">概要</th>
                    <th style="WIDTH: 100px" id="editButton"></th>
                </tr>
            </table>
            <!--<input type = "button" id = "pro_button" name="editpro" value = "現場編集" onclick="editpro()">-->
    </form>
    </div>
            </div>
        </div>
</main>
<script type="text/javascript">

if(<?php echo $json_array_project; ?> != ""){
        //テーブル表示
        //phpから配列の取得
        var pro = <?php echo $json_array_project; ?>;
        var add = <?php echo $json_array_address; ?>;
        var ove = <?php echo $json_array_overview; ?>;
        
        //テーブル情報
        var table = document.getElementById("pro_info");
        var tableLength = pro.length;
        var cell1 = [];
        var cell2 = [];
        var cell3 = [];
        var cell4 = [];

            //会社名
            for(var j = 0; j < tableLength; j++){
                var row = table.insertRow(-1);
                cell1.push(row.insertCell(-1));
                cell2.push(row.insertCell(-1));
                cell3.push(row.insertCell(-1));
                cell4.push(row.insertCell(-1));
                cell1[j].innerHTML = pro[j];
                cell1[j].id = "project";
                cell2[j].innerHTML = add[j];
                cell2[j].value = "address";
                cell3[j].innerHTML = ove[j];
                cell3[j].value = "overview";
                cell4[j].innerHTML = '<input type = "button" value = "編集" onclick="change_project_info(this)"/>';
                //cell4[j].innerHTML = '<input type = "submit" id = "p_project" name="p_project" value = "編集">';
        }
        }
    </script>
    <script>
        function change_project_info(point){
        // 編集ボタンを押下された行を取得
        tr = point.parentNode.parentNode;
        var p_name = tr.cells[0].innerHTML;
        
        var p_address = tr.cells[1].innerHTML;
        var p_overview = tr.cells[2].innerHTML;
        var param = "name="+p_name+"&address="+p_address+"&overview="+p_overview;
        //console.log(tr.cells[0].innerHTML);
        //現場情報編集画面にポスト
        // フォームデータを取得
        /*fd = new FormData();
        fd.append('project',p_name);
        fd.append('address',p_address);
        fd.append('overview',p_overview);
        // XMLHttpRequestによるアップロード処理
        xhttpreq = new XMLHttpRequest();
        xhttpreq.onreadystatechange = function() {
            if (xhttpreq.readyState == 4 && xhttpreq.status == 200) {
                alert(xhttpreq.responseText);
            }
            };
            xhttpreq.open("POST", "p_edit_company.php", true);
            xhttpreq.send(fd);*/
            ///document.location.href = "https://www.ipentec.com?"+paramstr;   
            //window.
            location.href ="http://10.20.170.52/web/p_edit_company.php?"+param;
            //header('Location: http://10.20.170.52/web/p_edit_company.php');
        }
    </script>
    </body>
</html>