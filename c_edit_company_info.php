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
<title>会社情報編集</title>
</head>
<body>
<h2>会社情報編集</h2>
<form action="c_edit_company_info.php" method="post">
  <p>
  会社名<input type = "text" name = "company_name" value = "<?php echo $name; ?>"><br />
  住所<input type ="text" name="address" value = "<?php echo $add; ?>"><br />
  電話番号<input type = "text" name="tel" value = "<?php echo $tel; ?>"><br />
  </p>
  <p><input type="submit" name="change" value="変更" onclick = change() /></p>
</form>
<script>
  function change(){
    //opener.pro_form.pro_info.1company.value = test;
  }
</script>
</body>
</html>
