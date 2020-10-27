<?php
if(isset($_POST["kanri"])){
    $project_id = $_POST['id'];
    $user = $_POST["kanri"];
    print_r($_POST["kanri"]);

    require "conn.php";
    $mysql_qry = "INSERT INTO projects_kanri_1 VALUES ('', '$project_id', '$user', '' );";
    $result = mysqli_query($conn, $mysql_qry);
}
?>