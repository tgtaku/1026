<?php
//ポスト情報の確認
if(isset($_POST['search_pro'])){
    require "conn.php";
    /*$project = $_POST["project"];
    $address = $_POST["address"];
    $overview = $_POST["overview"];*/
    //結果格納用の配列
    $row_array_project_id = "";
    $row_array_project = array();
    $row_array_address = array();
    $row_array_overview = array();

    //全部なし
    //if($project =="" && $address == "" && $overview == ""){
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
    //}
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>報告書選択</title>
        <link rel="stylesheet" href = "style.css">
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
    

    <h2>表示する報告書を選択してください。</h2>

    <p>
        <form action="p_edit.php" method = "post">
        管理者ID<input type = "text" name = "project" value = ""><br />
        現場名<input type ="text" name="address" value = ""><br />
        施工会社<input type ="text" name="overview" value = ""><br />
        施工箇所<input type ="text" name="address" value = ""><br />
        日付<input type ="text" name="overview" value = ""><br />
        <input type = "submit" id = "search_pro" name="search_pro" value = "検索">
        </form>
    </p>
    <form id="pro_form" action="p_edit_company.php" method = "post">
    <table id = "pro_info" name = "table_com">
                <tr>
                <th style="WIDTH: 50px" id="no">No</th>
                    <th style="WIDTH: 200px" id="project">現場名</th>
                    <th style="WIDTH: 200px" id="address">施工会社</th>
                    <th style="WIDTH: 200px" id="overview">施工箇所</th>
                    <th style="WIDTH: 100px" id="editButton">日付</th>
                    <th style="WIDTH: 100px" id="editButton"></th>
                </tr>
               
            </table>
            <!--<input type = "button" id = "pro_button" name="editpro" value = "現場編集" onclick="editpro()">-->
    </form>
    </div>
            </div>
        </div>
</main>

    </body>
</html>