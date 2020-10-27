<?php
require "conn.php";
if(isset($_POST["id"])){
    $id = $_POST["id"];
    $company = $_POST["company"];
    $user = $_POST["user"];
    
    $mysql_qry = "select * from users_information_1 inner join companies_information_1 on users_information_1.companies_id = companies_information_1.companies_id where users_name = '$user';";
    $result = mysqli_query($conn, $mysql_qry);
    $j = 0;
    $user_id = "";
    $company_id = "";
    while ($row = mysqli_fetch_assoc ($result)) {
        $user_id = $row['users_id'];
        $company_id = $row['companies_id'];
        $j++;
    }
    //print_r($user_id);
    
    require "conn.php";
    
    $sql = "INSERT INTO assign_company_information_1 VALUES ('', '$id', '$company_id', '$user_id', '' );";
    $result  = mysqli_query($conn, $sql);
    if($result){
    echo "Data Inserted";
    exit;
    }
    else{
    echo "Failed";
    }
}

?>