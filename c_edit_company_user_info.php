<?php
if(isset($_GET['com'])){
  $name = $_GET['com'];
  $add = $_GET['add'];
  $tel = $_GET['tel'];
//会社IDを取得
require "conn.php";
$mysql_qry = "select * from companies_information_1 where companies_name = '$name' AND street_address = '$add' AND tel = '$tel';";
$result = mysqli_query($conn, $mysql_qry);
  if(mysqli_num_rows($result) > 0){
      $i = 0;
      while($row = mysqli_fetch_assoc($result)){
          $companies_id = $row['companies_id'];
          $i++;
      }
      session_start();
      $_SESSION['company_id'] = $companies_id;
  }

//会社IDからユーザ情報を取得
$users_name = [];
$user_pass = [];
$company_id = $_SESSION['company_id'];
require "conn.php";
$mysql_qry = "select * from users_information_1 where companies_id = '$company_id';";
$result = mysqli_query($conn, $mysql_qry);
  if(mysqli_num_rows($result) > 0){
      $i = 0;
      while($row = mysqli_fetch_assoc($result)){
          array_push($users_name,$row['users_id']);
          array_push($user_pass,$row['password']);
          $i++;
      }
  }
    $json_array_users_name = json_encode($users_name);
    $json_array_user_pass = json_encode($user_pass);
  //print_r($users_name);
}
if(isset($_POST['change'])){
  session_start();
  $companies_id = $_SESSION['company_id'];
  $p_com = $_POST["company_name"];
  $p_add = $_POST["address"];
  $p_tel = $_POST["tel"];
  //print_r($p_com);
  //print_r($p_add);
  //print_r($p_tel);
  require "conn.php";
  $mysql_qry = "UPDATE companies_information_1 SET companies_name='$p_com', street_address='$p_add', tel='$p_tel' WHERE companies_id = '$companies_id' ;";
  $result = mysqli_query($conn, $mysql_qry);
  echo "<script type='text/javascript'>window.close();</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>ユーザー情報編集</title>
</head>
<body>
<h2>削除するユーザを選択、登録するユーザ情報を入力してください。</h2>

<h4><?php echo $name; ?></h4>
<form id="user_form" method = "post">
    <table id = "user_info" name = "table_com">
                <tr>
                    <th style="WIDTH: 50px" id="project">No</th>
                    <th style="WIDTH: 200px" id="user_name">ユーザ名</th>
                    <th style="WIDTH: 200px" id="password">パスワード</th>
                    <th style="WIDTH: 20px" id="check"></th>
                    <th style="WIDTH: 100px" id="edit"></th>
                </tr>
            </table>
            <!--<input type = "button" id = "pro_button" name="editpro" value = "現場編集" onclick="editpro()">-->
    </form>

<form method="post" id = "new">
    <h4>ユーザ登録欄</h4>
    <h6>No.1</h6>
  ユーザ名<input type = "text" name = "company_name" value = ""><br />
  パスワード<input type ="password" name="address" value = ""><br />
  パスワード（再入力）<input type = "password" name="tel" value = ""><br />
  </form>
  <p><input type="button" name="change" value="ユーザ追加" onclick = add() /></p>
  <p><input type="button" name="change" value="追加/削除" onclick = change() /></p>

<script>
var i = 2;
    if(<?php echo $json_array_users_name; ?> != ""){
        //テーブル表示
        //phpから配列の取得
        var array_user = <?php echo $json_array_users_name; ?>;
        var array_pass = <?php echo $json_array_user_pass; ?>;
        
        //テーブル情報
        var table = document.getElementById("user_info");
        var tableLength = array_user.length;
        var cell1 = [];
        var cell2 = [];
        var cell3 = [];
        var cell4 = [];
        var cell5 = [];

            //会社名
            for(var j = 0; j < tableLength; j++){
                var row = table.insertRow(-1);
                cell1.push(row.insertCell(-1));
                cell2.push(row.insertCell(-1));
                cell3.push(row.insertCell(-1));
                cell4.push(row.insertCell(-1));
                cell5.push(row.insertCell(-1));
                cell1[j].innerHTML = table.rows.length-1;
                cell2[j].innerHTML = array_user[j];
                cell2[j].id = "user";
                cell3[j].innerHTML = array_pass[j];
                cell3[j].value = "pass";
                cell4[j].innerHTML = '<input type = "checkbox" name = "ch"/>';;
                cell4[j].value = "check";
                cell5[j].innerHTML = '<input type = "button" value = "ユーザー情報編集" onclick="edit_user_info(this)"/>';
                
        }
        }
</script>
<script>
    function change(){

    }

    var parent = document.getElementById("new");
    //var br = document.createElement("br");
    function add(){
        var no = document.createElement("h6");
        var no_text = document.createTextNode("No." + i);
        no.appendChild(no_text);
        parent.appendChild(no);
        var text1 = document.createTextNode("ユーザ名");
        var input1 = document.createElement("input");
        input1.setAttribute('type', 'text');
        parent.appendChild(text1);
        parent.appendChild(input1);
        parent.appendChild(document.createElement("br"));
        
    var text2 = document.createTextNode("パスワード");
        var input2 = document.createElement("input");
        input2.setAttribute('type', 'text');
        parent.appendChild(text2);
        parent.appendChild(input2);
        parent.appendChild(document.createElement("br"));

    var text3 = document.createTextNode("パスワード（再入力）");
        var input3 = document.createElement("input");
        input3.setAttribute('type', 'text');
        parent.appendChild(text3);
        parent.appendChild(input3);
        parent.appendChild(document.createElement("br"));

        i = i + 1;
}
        
        
        
        
        
        
        
    
</script>
</body>
</html>