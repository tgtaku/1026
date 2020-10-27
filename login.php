<?php

$err_msg = "";

if(isset($_POST['login'])){
    require "conn.php";
    $id = $_POST["id"];
    $user_name = $_POST["user_name"];
    $user_pass = $_POST["password"];
    
    $pre_mysql_qry = "select * from owner where owner_code like '$id';";
    $pre_result = mysqli_query($conn, $pre_mysql_qry);
    if(mysqli_num_rows($pre_result) > 0){
	    $mysql_qry = "select * from users_information_1 where users_id like '$user_name' and password like '$user_pass';";
	    $result = mysqli_query($conn, $mysql_qry);
	    if(mysqli_num_rows($result) > 0){
            $row_array_file = array();
            $i = 0;
            while ($row = mysqli_fetch_assoc ($result)) {
            $row_array_file[$i] = $row;
            
            //管理者権限ユーザーなら続行
            if($row['flag'] == 1){
            //セッションスタート
            session_start();
            $_SESSION['user_id'] = $row['users_name'];
            $i++;
            //ログイン成功
            print_r ($row_array_file);
	        header('Location: http://10.20.170.52/web/mypage.php');
	        exit;
            }else{
                $err_msg = "管理者権限のユーザーではありません。";
            }
            
            }
            
            
	    //echo "login success!";
	    }
	    else{
	        $err_msg = "企業ID、ユーザ名またはパスワードが間違っています";
	    //echo "login not success";
	    }
	}else{
	$err_msg = "企業ID、ユーザ名またはパスワードが間違っています";
	}
}
?>


<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ログイン画面</title>
    </head>
    <body>

    <h1>現場管理アプリ</h1>
    <h2>会社ID、ユーザ名、パスワードを入力してください。</h2>

        <form action="login.php" method = "post">
        <?php if($err_msg !== null && $err_msg !== ''){
            echo $err_msg;
            echo '<br />';
            } ?>
            会社ID<input type = "text" name = "id" value = ""><br />
            ユーザー名<input type ="text" name="user_name" value = ""><br />
            パスワード<input type = "password" name="password" value = ""><br />
            <input type="submit" name ="login" value = "ログイン">
        </form>
    </body>
</html>