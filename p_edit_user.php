<?php
//画面遷移時の処理→既に登録されているユーザーの検索
//プロジェクトIDの取得
$project_id = "";
session_start();
$project_id = $_SESSION['count'];
$project_id_now = json_encode($project_id);

//既存ユーザーの取得
//検索用
$row_array_user = [];
$row_array_company = [];
$row_array_sum = [];
//事前取得用
$row_array_user_db = [];
$row_array_company_db = [];

require "conn.php";
$mysql_qry_user = "select * from assign_company_information_1 inner join users_information_1 on assign_company_information_1.companies_id = users_information_1.companies_id inner join projects_information_1 on assign_company_information_1.projects_id = projects_information_1.projects_id inner join companies_information_1 on assign_company_information_1.companies_id = companies_information_1.companies_id where assign_company_information_1.projects_id = '$project_id';";
$result_user = mysqli_query($conn, $mysql_qry_user);
if(mysqli_num_rows($result_user) > 0){
    //print_r($result_user);
    $i = 0;
    while($row = mysqli_fetch_assoc($result_user)){
            $row_array_user_db[$i] = $row['users_name'];
            $row_array_company_db[$i] = $row['companies_name'];
            $i++;
        }
    }else{

    }
    //json形式に変更
    $json_array_user_db = json_encode($row_array_user_db);
    $json_array_company_db = json_encode($row_array_company_db);
    //初期情報
    $json_array_user = json_encode($row_array_user);
    $json_array_company = json_encode($row_array_company);
    $json_array_sum = json_encode($row_array_sum);
    
        

/*
//参加者情報の取得
$row_array_user = array();
require "conn.php";
$mysql_qry_user = "select * from assign_company_information_1 inner join users_information_1 on assign_company_information_1.companies_id = users_information_1.companies_id inner join projects_information_1 on assign_company_information_1.projects_id = projects_information_1.projects_id inner join companies_information_1 on assign_company_information_1.companies_id = companies_information_1.companies_id where assign_company_information_1.projects_id = '$project_id';";
$result_user = mysqli_query($conn, $mysql_qry_user);
if(mysqli_num_rows($result_user) > 0){
    //print_r($result_user);
    $i = 0;
    while($row = mysqli_fetch_assoc($result_user)){
        //print_r($row);
        $row_array_user[$i] = $row['users_name'];
        $row_array_company[$i] = $row['companies_name'];
        $i++;
        $row_array_sum = "";
    }
    }else{
        $row_array_user ="";
        $row_array_company ="";
        $row_array_sum = "";
    //print_r($row_array_user);

}
//json形式に変更
$json_array_user = json_encode($row_array_user);
$json_array_company = json_encode($row_array_company);
$json_array_sum = json_encode($row_array_sum);

*/

//検索ボタン押下時の処理
if(isset($_POST['search_user'])){
    //print_r($_POST);
    require "conn.php";
    $id = $_POST["id"];
    $json_id = json_encode($id);
    $user_name = $_POST["user_name"];
    print_r($id);

    //①両方なし
    if($id =="" && $user_name == ""){
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id;";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
        //print_r($result);
        $row_array_company = array();
        $row_array_user = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            //1回目は追加、2回目から同じ値かどうかの確認
            //print_r($row);
            if($i == 0){
                $row_array_company[$i] = $row['companies_name'];
                $row_array_sum[$row['companies_name']]["num"]=0;
                $i++;
            }else{
                $key = in_array($row['companies_name'], $row_array_company);
                if($key){
                    
                }else{
                    $row_array_company[$i] = $row['companies_name'];
                    $row_array_sum[$row['companies_name']]["num"]=0;
                    $i++;
                }   
        }
    }
        //$i = 0;
        //$num = 0;
        //値格納用の配列を作る
        //for($j = 0; $j < count($row_array_company); $j++){
            //$row_array_sum[$row_array_company[$j]] = array();
            //print_r($row_array_company[$j]);
        //}
        //print_r($row_array_sum);
        //$row_array_sum = array($row_array_company ,$row_array_user);
        $resultt = mysqli_query($conn, $mysql_qry);
        while($ro = mysqli_fetch_assoc($resultt)){
            //配列の何番目の会社か調べる
            //$com_num = array_search($ro['companies_name'], $row_array_company);
            //print_r($com_num);
            $row_array_sum[$ro['companies_name']][$row_array_sum[$ro['companies_name']]["num"]] = $ro['users_name'];
            $row_array_sum[$ro['companies_name']]["num"] += 1;
            //array_push($row_array_sum[$com_num], $ro['users_name']);
            //$com_user_num = count($row_array_sum[$com_num]);
            //$row_array_sum[$com_num][$com_user_num] = $ro['user_name'];
        }
        //print_r($row_array_sum["company1"]["num"]);
        //$row_array_sum = array($row_array_company, $row_array_user);
            
            //配列の中にいるユーザ数
            //$com_user_num = count($row_array_sum[$com_num]);
            //$row_array_sum[$com_num][$com_user_num] = $row;
       
        //print_r($row_array_company);
        //print_r($row_array_sum);
}
    }elseif($id !="" && $user_name == ""){
        //②ユーザ名なし
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where companies_name like '%$id%' ;";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            
            $row_array_company = array();
        $row_array_user = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            //1回目は追加、2回目から同じ値かどうかの確認
            //print_r($row);
            if($i == 0){
                $row_array_company[$i] = $row['companies_name'];
                $row_array_sum[$row['companies_name']]["num"]=0;
                $i++;
            }else{
                $key = in_array($row['companies_name'], $row_array_company);
                if($key){
                    
                }else{
                    $row_array_company[$i] = $row['companies_name'];
                    $row_array_sum[$row['companies_name']]["num"]=0;
                    $i++;
                }   
        }
    }
        $resultt = mysqli_query($conn, $mysql_qry);
        while($ro = mysqli_fetch_assoc($resultt)){
            $row_array_sum[$ro['companies_name']][$row_array_sum[$ro['companies_name']]["num"]] = $ro['users_name'];
            $row_array_sum[$ro['companies_name']]["num"] += 1;
        }
            
    }
    }elseif($id =="" && $user_name != ""){
        //③idなし
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where users_name like '%$user_name%';";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $row_array_company = array();
        $row_array_user = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            //1回目は追加、2回目から同じ値かどうかの確認
            //print_r($row);
            if($i == 0){
                $row_array_company[$i] = $row['companies_name'];
                $row_array_sum[$row['companies_name']]["num"]=0;
                $i++;
            }else{
                $key = in_array($row['companies_name'], $row_array_company);
                if($key){
                    
                }else{
                    $row_array_company[$i] = $row['companies_name'];
                    $row_array_sum[$row['companies_name']]["num"]=0;
                    $i++;
                }   
        }
    }
        $resultt = mysqli_query($conn, $mysql_qry);
        while($ro = mysqli_fetch_assoc($resultt)){
            $row_array_sum[$ro['companies_name']][$row_array_sum[$ro['companies_name']]["num"]] = $ro['users_name'];
            $row_array_sum[$ro['companies_name']]["num"] += 1;
        }
    }//print_r($row_array_sum);
}elseif($id !="" && $user_name != ""){
        print_r("テスト");
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where companies_name like '%$id%' or users_name like '%$user_name%';";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $row_array_company = array();
        $row_array_user = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            //1回目は追加、2回目から同じ値かどうかの確認
            //print_r($row);
            if($i == 0){
                $row_array_company[$i] = $row['companies_name'];
                $row_array_sum[$row['companies_name']]["num"]=0;
                $i++;
            }else{
                //両方記入されている
                $key = in_array($row['companies_name'], $row_array_company);
                if($key){
                    
                }else{
                    $row_array_company[$i] = $row['companies_name'];
                    $row_array_sum[$row['companies_name']]["num"]=0;
                    $i++;
                }   
        }
    }
        $resultt = mysqli_query($conn, $mysql_qry);
        while($ro = mysqli_fetch_assoc($resultt)){
            $row_array_sum[$ro['companies_name']][$row_array_sum[$ro['companies_name']]["num"]] = $ro['users_name'];
            $row_array_sum[$ro['companies_name']]["num"] += 1;
        }
            print_r($row_array_sum);
    }
    }
   
    
}else{
    $row_array_company = "";
    $row_array_user = "";
    $row_array_sum = "";
}
$json_array_company = json_encode($row_array_company);
$json_array_user = json_encode($row_array_user);
$json_array_sum = json_encode($row_array_sum);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ユーザ編集画面</title>
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
                    <li><a href="select_report.php">-報告書確認</a></li>
                </ul>
            </div>
            <div class="maincol">
                <div class="maincol-container">
    
    <h2>ユーザを登録してください。</h2>
    <h2>参加者情報</h2>
    <p>
        <table id = "db_user_info" name = "table_user">
                <tr>
                    
                    <th style="WIDTH: 200px" id="com">企業名</th>
                    <th style="WIDTH: 200px" id="user">ユーザ名</th>
                </tr>            
        </table>
</p>

<h2>検索欄</h2>

<p>
        <form action="p_edit_user.php" method = "post">
        会社名<input type = "text" name = "id" value = ""><br />
        ユーザー名<input type ="text" name="user_name" value = ""><br />
        <input type = "submit" id = "search_user" name="search_user" value = "検索">
        </form>
    </p>     
    
    <form id="user_form">
    <table id = "user_info" name = "table1">
                <tr>
                    <th style="WIDTH: 200px" id="user_company">会社名</th>
                    <th style="WIDTH: 300px" id="user_name">ユーザ名</th>
                    <th> <input type = "checkbox" name = "ch" style="WIDTH: 60px" id="user_check" onclick="selectall(this)"></th>
                </tr>
            </table>
            <input type = "button" id = "user_button" name="gotUser" value = "登録" onclick="gotuser()">
    </form>
    </div>
            </div>
        </div>
</main>
    <script type="text/javascript">

        //既存ユーザーの表示
        var db_user = <?php echo $json_array_user_db; ?>;
        var db_company = <?php echo $json_array_company_db; ?>;
        var db_cell1 = [];
        var db_cell2 = [];

        if(db_company!=""){
            console.log(db_company);
            console.log(db_user.length);
            //テーブルの作成
            var table = document.getElementById("db_user_info");
            //テーブルの大きさ(会社枠)
            var i = 0;
            //会社名
            for(var j = 0; j < db_company.length; j++){
                if(j == 0){
                    var row = table.insertRow(-1);
                    db_cell1.push(row.insertCell(-1));
                    db_cell2.push(row.insertCell(-1));
                    db_cell1[j].innerHTML = db_company[j];
                    db_cell2[j].innerHTML = db_user[j];
                    i++;
                }else{
                    if(db_company[j] == db_company[i-1]){
                        var row = table.insertRow(-1);
                        db_cell1.push(row.insertCell(-1));
                        db_cell2.push(row.insertCell(-1));
                        db_cell2[j].innerHTML = db_user[j];
                    }else{
                        var row = table.insertRow(-1);
                        db_cell1.push(row.insertCell(-1));
                        db_cell2.push(row.insertCell(-1));
                        db_cell1[j].innerHTML = db_company[j];
                        db_cell2[j].innerHTML = db_user[j];
                        i++;
                    }
                }
                
                
            // = company.length + user.length;
            
        }
    }


        //var names =[];
        var sum = <?php echo $json_array_sum; ?>;
        //console.log(sum['company1'][0]);
        var company = "";
        var user ="";
        var tableLength ="";
        var cell1 = [];
        var cell2 = [];
        var cell3 = [];
        if(<?php echo $json_array_company; ?>!=""){
            company = <?php echo $json_array_company; ?>;
            //user = <?php echo $json_array_user; ?>;
            console.log(company);
            console.log(user.length);
            //テーブルの作成
            var table = document.getElementById("user_info");
            //テーブルの大きさ(会社枠)
            var p = 0;
            var i = 0;
            //会社名
            for(var j = 0; j < company.length; j++){
                var row = table.insertRow(-1);
                cell1.push(row.insertCell(-1));
                cell2.push(row.insertCell(-1));
                cell3.push(row.insertCell(-1));
                cell1[i].innerHTML = company[j];
                cell3[i].innerHTML = '<input type = "checkbox" onclick="changeCom(this)"/>';
                i++;
                //ユーザ名
                for(var k = 0; k < sum[company[j]]['num']; k++){
                    var row = table.insertRow(-1);
                    cell1.push(row.insertCell(-1));
                    cell2.push(row.insertCell(-1));
                    cell3.push(row.insertCell(-1));
                    cell2[i].innerHTML = sum[company[j]][k];
                    cell3[i].innerHTML = '<input type = "checkbox" name = "ch"/>';
                    cell3[i].id = i;
                    if(sum[company[j]][k] == db_user[p]){
                        //cell3[i].innerHTML.checked = true;
                        var c_val = table.rows[i+1].cells[2].children[0];
                        c_val.checked = true;
                        p++;
                    }
                    i++;
                }
            }
            tableLength = company.length + user.length;

            
        }
        
    </script>
    <script>
        function selectall(th){
            for(var t = 1; t < table.rows.length; t++){
                if(th.checked == true){
                    var val = table.rows[t].cells[2].children[0];
                    val.checked = true;
                }else{
                    var val = table.rows[t].cells[2].children[0];
                    val.checked = false;
                }
                
            }
        }

        function changeCom(thi){
            var tr = thi.parentNode.parentNode;
            var ind = tr.rowIndex;
            var le = table.rows.length;
            console.log(le);
            //console.log(table.rows[ind+1].cells[0].innerHTML);
            //console.log(table.rows[ind].cells[0].innerHTML);
                if(thi.checked == true){
                    while(table.rows[ind+1].cells[0].innerHTML == ""){
                    var va = table.rows[ind+1].cells[2].children[0];
                    va.checked = true;
                    ind++;
                    if(ind == le-1){
                        break;
                    }
                    }
                    
                }
                else{
                    while(table.rows[ind+1].cells[0].innerHTML == ""){
                    var va = table.rows[ind+1].cells[2].children[0];
                    va.checked = false;
                    ind++;
                    if(ind == le-1){
                        break;
                    }
                }
                } 
            console.log(tr.rowIndex);
            //var com_name = tr.cell[0].innerHTML;

        }

        function gotuser(){
            //プロジェクトIDと会社名、ユーザ名を送信
            //var p_id = <?php echo $project_id_now; ?>;
            var c_name = [];
            var u_name = [];
            var array_cnt_com_user = [];
            var cnt_com_user = 0;
            var le = table.rows.length;
            for(var p = 1; p < le; p++){
                if(table.rows[p].cells[0].innerHTML != ""){
                    c_name.push(table.rows[p].cells[0].innerHTML);
                    if(p != 1){
                        array_cnt_com_user.push(cnt_com_user);
                        var cnt_com_user = 0;
                    }
                }
                else{
                    if(table.rows[p].cells[2].children[0].checked == true){
                        u_name.push(table.rows[p].cells[1].innerHTML);
                        cnt_com_user++;

                        if(p == le-1){
                            array_cnt_com_user.push(cnt_com_user);
                        var cnt_com_user = 0;
                        }
                    }
                }
            }
                        fd = new FormData();
                        fd.append('cnt', array_cnt_com_user);
                        fd.append('company',c_name);
                        fd.append('user', u_name);
                        xhttpreq = new XMLHttpRequest();
                        xhttpreq.onreadystatechange = function() {
                        if (xhttpreq.readyState == 4 && xhttpreq.status == 200) {
                        alert(xhttpreq.responseText);
                        }
                        };
                        xhttpreq.open("POST", "update_assign_com.php", true);
                        xhttpreq.addEventListener('load', (event) => {
                        //window.location.href = 'p_edit_company.php';
                        });
                        xhttpreq.send(fd);
                }
    </script>
    </body>

</html>
