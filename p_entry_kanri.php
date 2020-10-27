<?php
$row_array_company_search ="";
$row_array_user_search = "";
$row_array_sum_search = array();

session_start();
$user_name = $_SESSION['user_id'];
$project_id = $_SESSION['count'];
$json_project_id = json_encode($project_id);
//$user_name = "kanri1";
//print_r($user_name);
$json_user = json_encode($user_name);

//管理者の取得
//mysqlとの接続
$link = mysqli_connect('localhost', 'root', '');
if (!$link) {
    die('Failed connecting'.mysqli_error($link));
}
//print('<p>Successed connecting</p>');

//DBの選択
$db_selected = mysqli_select_db($link , 'test_db');
if (!$db_selected){
    die('Failed Selecting table'.mysqli_error($db_selected));
}

//文字列をutf8に設定
mysqli_set_charset($link , 'utf8');

//pdfテーブルの取得
$result_file  = mysqli_query($link ,"SELECT * FROM users_information_1;");
if (!$result_file) {
    die('Failed query'.mysqli_error($result_file));
}
//データ格納用配列の取得
$row_array_user = array();
$i = 0;
while ($row = mysqli_fetch_assoc ($result_file)) {
    $row_array_user[$i] = $row['users_name'];
    $i++;
    
}
$json_user_array = json_encode($row_array_user);
//print_r($row_array_user);
//print_r($json_user_array);
// MySQLに対する処理
$close_flag = mysqli_close($link);

if(isset($_POST['search_user'])){

    require "conn.php";
    $id = $_POST["id"];
    $user_name = $_POST["user_name"];

    //①両方なし
    if($id =="" && $user_name == ""){
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where users_information_1.flag = '1';";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
        //print_r($result);
        $row_array_company_search = array();
        $row_array_user_search = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            //1回目は追加、2回目から同じ値かどうかの確認
            //print_r($row);
            if($i == 0){
                $row_array_company_search[$i] = $row['companies_name'];
                $row_array_sum_search[$row['companies_name']]["num"]=0;
                $i++;
            }else{
                $key = in_array($row['companies_name'], $row_array_company_search);
                if($key){
                    
                }else{
                    $row_array_company_search[$i] = $row['companies_name'];
                    $row_array_sum_search[$row['companies_name']]["num"]=0;
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
            $row_array_sum_search[$ro['companies_name']][$row_array_sum_search[$ro['companies_name']]["num"]] = $ro['users_name'];
            $row_array_sum_search[$ro['companies_name']]["num"] += 1;
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
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where companies_name like '%$id%' and users_information_1.flag = '1' ;";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            
            $row_array_company_search = array();
        $row_array_user_search = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            //1回目は追加、2回目から同じ値かどうかの確認
            //print_r($row);
            if($i == 0){
                $row_array_company_search[$i] = $row['companies_name'];
                $row_array_sum_search[$row['companies_name']]["num"]=0;
                $i++;
            }else{
                $key = in_array($row['companies_name'], $row_array_company_search);
                if($key){
                    
                }else{
                    $row_array_company_search[$i] = $row['companies_name'];
                    $row_array_sum_search[$row['companies_name']]["num"]=0;
                    $i++;
                }   
        }
    }
        $resultt = mysqli_query($conn, $mysql_qry);
        while($ro = mysqli_fetch_assoc($resultt)){
            $row_array_sum_search[$ro['companies_name']][$row_array_sum_search[$ro['companies_name']]["num"]] = $ro['users_name'];
            $row_array_sum_search[$ro['companies_name']]["num"] += 1;
        }
            
    }
    }elseif($id =="" && $user_name != ""){
        //③idなし
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where users_name like '%$user_name%' and users_information_1.flag = '1';";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $row_array_company_search = array();
        $row_array_user_search = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            //1回目は追加、2回目から同じ値かどうかの確認
            //print_r($row);
            if($i == 0){
                $row_array_company_search[$i] = $row['companies_name'];
                $row_array_sum_search[$row['companies_name']]["num"]=0;
                $i++;
            }else{
                $key = in_array($row['companies_name'], $row_array_company_search);
                if($key){
                    
                }else{
                    $row_array_company_search[$i] = $row['companies_name'];
                    $row_array_sum_search[$row['companies_name']]["num"]=0;
                    $i++;
                }   
        }
    }
        $resultt = mysqli_query($conn, $mysql_qry);
        while($ro = mysqli_fetch_assoc($resultt)){
            $row_array_sum_search[$ro['companies_name']][$row_array_sum_search[$ro['companies_name']]["num"]] = $ro['users_name'];
            $row_array_sum_search[$ro['companies_name']]["num"] += 1;
        }
    }//print_r($row_array_sum);
}elseif($id !="" && $user_name != ""){
        print_r("テスト");
        $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where companies_name like '%$id%' or users_name like '%$user_name%' and users_information_1.flag = '1';";
        $result = mysqli_query($conn, $mysql_qry);
        if(mysqli_num_rows($result) > 0){
            $row_array_company_search = array();
        $row_array_user_search = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            //1回目は追加、2回目から同じ値かどうかの確認
            //print_r($row);
            if($i == 0){
                $row_array_company_search[$i] = $row['companies_name'];
                $row_array_sum_search[$row['companies_name']]["num"]=0;
                $i++;
            }else{
                //両方記入されている
                $key = in_array($row['companies_name'], $row_array_company_search);
                if($key){
                    
                }else{
                    $row_array_company_search[$i] = $row['companies_name'];
                    $row_array_sum_search[$row['companies_name']]["num"]=0;
                    $i++;
                }   
        }
    }
        $resultt = mysqli_query($conn, $mysql_qry);
        while($ro = mysqli_fetch_assoc($resultt)){
            $row_array_sum_search[$ro['companies_name']][$row_array_sum_search[$ro['companies_name']]["num"]] = $ro['users_name'];
            $row_array_sum_search[$ro['companies_name']]["num"] += 1;
        }
            print_r($row_array_sum);
    }
    }
   
}
$json_array_company_search = json_encode($row_array_company_search);
$json_array_user_search = json_encode($row_array_user_search);
$json_array_sum_search = json_encode($row_array_sum_search);
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>管理者登録画面</title>
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
                    <li><a href="p_entry.php" style="background-color:gray">-現場登録</a></li>
                    <li><a href="p_edit.php">-現場編集</a></li>
                    <li>施工会社管理</li>
                    <li><a href="c_entry.php">-施工会社登録</a></li>
                    <li><a href="c_edit.php">-施工会社/ユーザ編集</a></li>
                    <li>施工状況確認</li>
                    <li><a href="report.php">-報告書確認</a></li>
                </ul>
            </div>
            <div class="maincol">
                <div class="maincol-container">
                    <!--<h1>現場管理アプリ</h1>-->
    <h2>管理者情報を入力してください。</h2>
    <h4>登録管理者</h4>
    <form id="kanri_form">
    <table id = "user_kanri" name = "table_kanri">
                <tr>
                    <th style="WIDTH: 50px" id="user_company">No</th>
                    <th style="WIDTH: 300px" id="user_name">管理者名</th>
                </tr>
            </table>
            
            
    </form>

    <h4>ユーザー追加検索フォーム</h4>
    <p>
        <form action="p_entry_kanri.php" method = "post">
        会社名<input type = "text" name = "id" value = ""><br />
        ユーザー名<input type ="text" name="user_name" value = ""><br />
        <input type = "submit" id = "search_user" name="search_user" value = "検索">
        </form>
    </p>
    <p>
    <form id="user_form">
    <table id = "user_info" name = "table1">
                <tr>
                    <th style="WIDTH: 200px" id="user_company">会社名</th>
                    <th style="WIDTH: 300px" id="user_name">ユーザ名</th>
                    <th> <input type = "checkbox" name = "ch" style="WIDTH: 60px" id="user_check" onclick="selectall(this)"></th>
                </tr>
            </table>
            <input type = "button" id = "user_button" name="gotUser" value = "ユーザ追加" onclick="adduser()">
    </form>     
</p>
    <input type = "button" id = "kanri_button" name="gotKanri" value = "登録" onclick="gotkanri()">

    <script type="text/javascript">
        //var names =[];
        var kanri ="";
        var tableLength ="";
        var cell1 = [];
        var cell2 = [];
            
            //テーブルの作成
            var table = document.getElementById("user_kanri");
            //管理者一覧
            var all_kanri = <?php echo$json_user_array; ?>;
            //会社名
                var row = table.insertRow(-1);
                cell1.push(row.insertCell(-1));
                cell2.push(row.insertCell(-1));
                cell1[0].innerHTML = "1";
                cell2[0].innerHTML = <?php echo $json_user; ?>;
                //リスト
                /*var row = table.insertRow(-1);
                cell1.push(row.insertCell(-1));
                cell2.push(row.insertCell(-1));
                cell1[1].innerHTML = "2";
                cell2[1].innerHTML = '<select name = "kan" name = "k" id = "kanri"/>';   
                var sel = table.rows[2].cells[1].children[0];
                var ele = document.createElement('option');
                ele.text = "";
                sel.append(ele);
                for(var a = 0; a<all_kanri.length; a++){
                    var ele2 = document.createElement('option');
                    ele2.text = all_kanri[a];
                    sel.append(ele2);
                }*/

                
    </script>
    
                </div>
            </div>
        </div>
</main>

<script>
    var p_id = <?php echo $json_project_id; ?>;

       function addkanri(){
        var table = document.getElementById("user_kanri");
            //ar row = table.insertRow(-1);
            var row = table.insertRow(-1);
            cell1.push(row.insertCell(-1));
            cell2.push(row.insertCell(-1));
            var len = table.rows.length;
            
            cell1[len-2].innerHTML = len -1;
            cell2[len-2].innerHTML = '<select name = "kan" name = "k" id = "kanri"/>';
            var sel = table.rows[len-1].cells[1].children[0];
                var ele = document.createElement('option');
                ele.text = "";
                sel.append(ele);
                for(var a = 0; a<all_kanri.length; a++){
                    var ele2 = document.createElement('option');
                    ele2.text = all_kanri[a];
                    sel.append(ele2);
                }
        }

        function gotkanri(){
            var k = [];
            var kanri = document.getElementById("user_kanri");
            for(var g = 1; g < kanri.rows.length; g++){
                k.push(kanri.rows[g].cells[1].innerHTML);
        }
        console.log(k);
        //httpPOST
        var le = k.length;
        console.log(le);
            for(var p = 0; p < le; p++){
                fd = new FormData();
                fd.append('kanri', k[p]);
                fd.append('id', p_id);
                xhttpreq = new XMLHttpRequest();
                xhttpreq.onreadystatechange = function() {
                if (xhttpreq.readyState == 4 && xhttpreq.status == 200) {
                alert(xhttpreq.responseText);
                }
                };
                xhttpreq.open("POST", "insert_kanri.php", true);
                xhttpreq.send(fd);
                }
                window.location.href = 'mypage.php';
        }
       </script>



<script type="text/javascript">
        //var names =[];
        var sum = <?php echo $json_array_sum_search; ?>;
        //console.log(sum['company1'][0]);
        var company = "";
        var user ="";
        var tableLength ="";
        var cell1_search = [];
        var cell2_search = [];
        var cell3_search = [];
        if(<?php echo $json_array_company_search; ?>!=""){
            company = <?php echo $json_array_company_search; ?>;
            //user = <?php echo $json_array_user_search; ?>;
            console.log(company);
            console.log(user.length);
            //テーブルの作成
            var table = document.getElementById("user_info");
            //テーブルの大きさ(会社枠)
            var i = 0;
            //会社名
            for(var j = 0; j < company.length; j++){
                var row = table.insertRow(-1);
                cell1_search.push(row.insertCell(-1));
                cell2_search.push(row.insertCell(-1));
                cell3_search.push(row.insertCell(-1));
                cell1_search[i].innerHTML = company[j];
                cell3_search[i].innerHTML = '<input type = "checkbox" onclick="changeCom(this)"/>';
                i++;
                //ユーザ名
                for(var k = 0; k < sum[company[j]]['num']; k++){
                    var row = table.insertRow(-1);
                    cell1_search.push(row.insertCell(-1));
                    cell2_search.push(row.insertCell(-1));
                    cell3_search.push(row.insertCell(-1));
                    cell2_search[i].innerHTML = sum[company[j]][k];
                    cell3_search[i].innerHTML = '<input type = "checkbox" name = "ch"/>';
                    cell3_search[i].id = i;
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
                    var val = table.rows[t].cells_search[2].children[0];
                    val.checked = true;
                }else{
                    var val = table.rows[t].cells_search[2].children[0];
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
                    while(table.rows[ind+1].cells_search[0].innerHTML == ""){
                    var va = table.rows[ind+1].cells_search[2].children[0];
                    va.checked = true;
                    ind++;
                    if(ind == le-1){
                        break;
                    }
                    }
                    
                }
                else{
                    while(table.rows[ind+1].cells_search[0].innerHTML == ""){
                    var va = table.rows[ind+1].cells_search[2].children[0];
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

        function adduser(){
           //登録管理者テーブルにチェックのついたユーザを登録する
           //チェックがついているユーザを取得する
           var table = document.getElementById("user_info");
           var table_kanri = document.getElementById("user_kanri");
           var le = table.rows.length;
           var c_name = [];
            var u_name = [];
            for(var p = 1; p < le; p++){
                if(table.rows[p].cells[0].innerHTML != ""){
                    c_name.push(table.rows[p].cells[0].innerHTML);
                }
                else{
                    if(table.rows[p].cells[2].children[0].checked == true){
                        u_name.push(table.rows[p].cells[1].innerHTML);    
                    }
                    else{
                    } 
                }
            }
            //同じユーザをチェックして同じなら配列から外す
            var array_user_out = [];
            var flag = 0;
            for(var i = 0; i < u_name.length; i++){
                for(var j = 1; j < table_kanri.rows.length; j++){
                    if(table_kanri.rows[j].cells[1].innerHTML == u_name[i]){
                        flag = 1;
                    }else{
                        flag = 0;
                    }
                }
                if(flag == 0){
                    array_user_out.push(u_name[i]);
                }
            }
            console.log(c_name);
            console.log(u_name);
            console.log(array_user_out);
            var array_user_out_num = array_user_out.length;
            console.log(array_user_out_num);
            for(var k = 0; k < array_user_out_num; k++){
                var row_kanri = table_kanri.insertRow(-1);
                //行数取得
                var row_len = table_kanri.rows.length;
                console.log(row_len);
                cell1.push(row_kanri.insertCell(-1));
                cell2.push(row_kanri.insertCell(-1));
                cell1[row_len-2].innerHTML = row_len-1;
                cell2[row_len-2].innerHTML = array_user_out[k];
                console.log(cell1);
                console.log(cell2);
            }
            
            
        }
        
    </script>

    </body>
    
</html>


