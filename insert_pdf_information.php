<?php
session_start();

$project_id = $_SESSION['count'];
//if(isset($_POST['next'])){
    $pdf = $_POST["pdf"];
    require "conn.php";

$sql = "INSERT INTO pdf_information_1 VALUES ('', '$project_id', '$pdf', '' );";
$result  = mysqli_query($conn, $sql);
if($result){
echo "Data Inserted";
exit;
}
else{
echo "Failed";
}

//}
?>