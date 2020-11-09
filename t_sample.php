<?php
$row_array_company = array();
$row_array_address = array();
$row_array_TEL = array();
//ポスト情報の確認
if(isset($_POST['search_pro'])){
    require "conn.php";
    $company = $_POST["company"];
    $address = $_POST["address"];
    $TEL = $_POST["TEL"];

    //全部なし
    if($company =="" && $address == "" && $TEL == ""){
        $mysql_qry = "select * from companies_information_1;";

    }else if($company !="" && $address == "" && $TEL == ""){
        $str_sql = "where companies_name like "."'%$company%';";
        $mysql_qry = "select * from companies_information_1 ".$str_sql;

    }else if($company =="" && $address != "" && $TEL == ""){
        $str_sql = "where street_address like "."'%$address%';";
        $mysql_qry = "select * from companies_information_1 ".$str_sql;

    }else if($company =="" && $address == "" && $TEL != ""){
        $str_sql = "where tel like "."'%$TEL%';";
        $mysql_qry = "select * from companies_information_1 ".$str_sql;

    }else if($company !="" && $address != "" && $TEL == ""){
        $str_sql = "where companies_name like "."'%$company%' or street_address like "."'%$address%';";
        $mysql_qry = "select * from companies_information_1 ".$str_sql;

    }else if($company =="" && $address != "" && $TEL != ""){
        $str_sql = "where street_address like "."'%$address%' or tel like "."'%$TEL%';";
        $mysql_qry = "select * from companies_information_1 ".$str_sql;
        
    }else if($company !="" && $address == "" && $TEL != ""){
        $str_sql = "where companies_name like "."'%$company%' or tel like "."'%$TEL%';";
        $mysql_qry = "select * from companies_information_1 ".$str_sql;
        
    }else if($company !="" && $address != "" && $TEL != ""){
        $str_sql = "where companies_name like "."'%$company%'or street_address like "."'%$address%' or tel like "."'%$TEL%';";
        $mysql_qry = "select * from companies_information_1 ".$str_sql;
        //print_r($mysql_qry);
    }
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $i = 0;
            while($row = mysqli_fetch_assoc($result)){
                //$row_array_project_id[$i] = $row['projects_id'];
                $row_array_company[$i] = $row['companies_name'];
                $row_array_address[$i] = $row['street_address'];
                $row_array_TEL[$i] = $row['tel'];
                //print_r($row_array_company[$i]);
                $i++;
            }
        }
    }

$json_array_company = json_encode($row_array_company);
$json_array_address = json_encode($row_array_address);
$json_array_TEL = json_encode($row_array_TEL);

?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>編集現場選択</title>
        <link rel="stylesheet" href = "style.css">
    </head>
    <body>
初期表示

・ログインしたユーザーに対応する現場名を現場選択リストに格納する
①ログインしたユーザーのIDをpublic変数から取得
②取得したユーザー名に該当する現場名をDBから取得し、配列に格納する
③配列の一番初めに登録されている現場名を現場選択リストの初期値に格納する

・選択された現場名に対応する図面名を図面選択リストに格納する
①現場選択リストで選択された現場名を取得
②取得した現場名に対応する図面名をDBから取得し、配列に格納する
③配列の一番初めに登録されている図面名を図面選択リストの初期値に格納する


現場選択リストから現場名選択時
・選択された現場名に対応する図面名を図面選択リストに格納する
①現場選択リストで選択された現場名を取得
②取得した現場名に対応する図面名をDBから取得し、配列に格納する
③配列の一番初めに登録されている図面名を図面選択リストの初期値に格納する


表示ボタン押下時
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
                    <li><a href="c_edit.php" style="background-color:gray">-施工会社/ユーザ編集</a></li>
                    <li>施工状況確認</li>
                    <li><a href="select_report.php">-報告書確認</a></li>
                </ul>
            </div>
            <div class="maincol">
                <div class="maincol-container">
    

    <h2>会社情報を変更する会社を選択してください。</h2>
    <p>
        <form action="c_edit.php" method = "post">
        会社名<input type = "text" name = "company" value = ""><br />
        住所<input type ="text" name="address" value = ""><br />
        電話番号<input type ="text" name="TEL" value = ""><br />
        <input type = "submit" id = "search_pro" name="search_pro" value = "検索">
        </form>
    </p>
    <form id="pro_form" action="p_edit_company.php" method = "post">
    <table id = "pro_info" name = "table_com">
                <tr>
                <th style="WIDTH: 50px" id="no">No</th>
                    <th style="WIDTH: 200px" id="company_table">会社名</th>
                    <th style="WIDTH: 200px" id="address_table">住所</th>
                    <th style="WIDTH: 200px" id="TEL_table">電話番号</th>
                    <th style="WIDTH: 100px" id="editButton1"></th>
                    <th style="WIDTH: 100px" id="editButton2"></th>
                </tr>
                
            </table>
            <!--<input type = "button" id = "pro_button" name="editpro" value = "現場編集" onclick="editpro()">-->
    </form>
    </div>
            </div>
        </div>
</main>
<script type="text/javascript">

if(<?php echo $json_array_company; ?> != ""){
        //テーブル表示
        //phpから配列の取得
        var array_company = <?php echo $json_array_company; ?>;
        var array_address = <?php echo $json_array_address; ?>;
        var array_TEL = <?php echo $json_array_TEL; ?>;
        
        //テーブル情報
        var table = document.getElementById("pro_info");
        var tableLength = array_company.length;
        var cell1 = [];
        var cell2 = [];
        var cell3 = [];
        var cell4 = [];
        var cell5 = [];
        var cell6 = [];

            //会社名
            for(var j = 0; j < tableLength; j++){
                var row = table.insertRow(-1);
                cell1.push(row.insertCell(-1));
                cell2.push(row.insertCell(-1));
                cell3.push(row.insertCell(-1));
                cell4.push(row.insertCell(-1));
                cell5.push(row.insertCell(-1));
                cell6.push(row.insertCell(-1));
                cell1[j].innerHTML = table.rows.length-1;
                cell2[j].innerHTML = array_company[j];
                cell2[j].id = j + 1 +"company";
                cell3[j].innerHTML = array_address[j];
                cell3[j].value = "address";
                cell4[j].innerHTML = array_TEL[j];
                cell4[j].value = "TEL";
                cell5[j].innerHTML = '<input type = "button" value = "会社情報編集" onclick="change_company_info(this)"/>';
                cell6[j].innerHTML = '<input type = "button" value = "ユーザー情報編集" onclick="change_user_info(this)"/>';
                //cell4[j].innerHTML = '<input type = "submit" id = "p_project" name="p_project" value = "編集">';
        }
        }
    </script>

    <script>
    function change_company_info(tr){
        var row = tr.parentNode.parentNode;
        var com = row.cells[1].innerHTML;
        var add = row.cells[2].innerHTML;
        var tel = row.cells[3].innerHTML;
        //"name="+p_name+"&address="+p_address+"&overview="+p_overview;
        var param = "com="+com+"&add="+add+"&tel="+tel;
        console.log(row.cells[1].id);
        window.open("c_edit_company_info.php?" + param, "",'width=400, height=300');
    }

    function change_user_info(tr){
        var row = tr.parentNode.parentNode;
        var com = row.cells[1].innerHTML;
        var add = row.cells[2].innerHTML;
        var tel = row.cells[3].innerHTML;
        //"name="+p_name+"&address="+p_address+"&overview="+p_overview;
        var param = "com="+com+"&add="+add+"&tel="+tel;
        console.log(row.cells[1].id);
        window.open("c_edit_company_user_info.php?" + param, "",'width=600, height=400');
    }
    </script>
    </body>
</html>

