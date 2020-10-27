<?php
//session_start();
//$projects_id = $_SESSION['count'];
if(isset($_POST['project_name'])){
    //require "conn.php";
    $projects_id = $_POST["project_id"];
    $project_name = $_POST["project_name"];
    $address = $_POST["address"];
    $overview = $_POST["overview"];
    require "conn.php";
$sql = "UPDATE projects_information_1 SET projects_name='$project_name', projects_street_address='$address', overview='$overview' WHERE projects_id='$projects_id';";
//$sql = "INSERT INTO projects_information_1 VALUES ('', '$project_name', '$address', '$overview', '' );";
$result  = mysqli_query($conn, $sql);
/*if($result){
    echo "Data Inserted";
    }
    else{
    echo "Failed";
    }*/
}     
exit;
?>