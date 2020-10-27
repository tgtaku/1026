<?php
if(isset($_GET['name'])){
    $name = $_GET['name'];
    $address = $_GET['address'];
    $overview = $_GET['overview'];
    
    //json形式に変更
    /*$json_array_project = json_encode($name);
    $json_array_address = json_encode($address);
    $json_array_overview = json_encode($overview);*/

    require "conn.php";

    //現場IDの取得
    $mysql_qry = "select * from projects_information_1 where projects_name = '$name' AND projects_street_address = '$address' AND overview = '$overview';";
    $result = mysqli_query($conn, $mysql_qry);
    if(mysqli_num_rows($result) > 0){
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            $project_id = $row['projects_id'];
            $i++;
        }
    //print_r($project_id);
    //json形式に変更
    //セッションスタート
    session_start();
    $_SESSION['count'] = $project_id;
    $json_project_id = json_encode($project_id);}

    //図面情報の取得
    $row_array_file = array();
    $mysql_qry = "select * from pdf_information_1 inner join projects_information_1 on pdf_information_1.project_id = projects_information_1.projects_id where projects_name = '$name' AND projects_street_address = '$address' AND overview = '$overview';";
    $result = mysqli_query($conn, $mysql_qry);
    if(mysqli_num_rows($result) > 0){
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            $row_array_file[$i] = $row['pdf_name'];
            $i++;
        }
        //print_r($row_array_file);
    //json形式に変更
    $json_array_file = json_encode($row_array_file);
    }
    //参加者情報の取得
    $row_array_user = array();
    $mysql_qry_user = "select * from assign_company_information_1 inner join users_information_1 on assign_company_information_1.companies_id = users_information_1.companies_id inner join projects_information_1 on assign_company_information_1.projects_id = projects_information_1.projects_id inner join companies_information_1 on assign_company_information_1.companies_id = companies_information_1.companies_id where projects_name = '$name';";
    $result_user = mysqli_query($conn, $mysql_qry_user);
    if(mysqli_num_rows($result_user) > 0){
        $i = 0;
        while($row = mysqli_fetch_assoc($result_user)){
            $row_array_user[$i] = $row['users_name'];
            $row_array_company[$i] = $row['companies_name'];
            $i++;
        }
        }else{
            $row_array_user ="";
            $row_array_company ="";
        print_r($row_array_user);
    
    }
    //json形式に変更
    $json_array_user = json_encode($row_array_user);
    $json_array_company = json_encode($row_array_company);
}

?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>現場情報編集</title>
        <link rel="stylesheet" href = "style.css" type="text/css">
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
                    <li><a href="report.php">-報告書確認</a></li>
                </ul>
            </div>
            <div class="maincol">
                <div class="maincol-container">
    

    <h2>現場情報</h2>
    <p>
    <form id="project_form">
    <table id = "project_info" name = "table_project">
                <tr>
                    <th style="WIDTH: 100px" id="project">現場名</th>
                    <th style="WIDTH: 200px" id="project_edit"><input type = "text" value = "<?php echo $name; ?>"></th>
                </tr>
                <tr>
                    <th style="WIDTH: 100px" id="address">所在値</th>
                    <th style="WIDTH: 200px" id="address_edit"><input type = "text" value = "<?php echo $address; ?>"></th>
                    
                </tr>
                <tr>
                    <th style="WIDTH: 100px" id="overview">概要</th>
                    <th style="WIDTH: 200px" id="overview_edit"><input type = "text" value = "<?php echo $overview; ?>"></th>
                </tr>
            </table>
            <!--<input type = "button" id = "pro_button" name="editpro" value = "現場編集" onclick="editpro()">-->
    </form>
    </p>

    <h2>図面情報</h2>
    <p>
    <form id="pdf_form">
        <table id = "pdf_info" name = "table_pdf">
                <tr>
                    <th style="WIDTH: 50px">No</th>
                    <th style="WIDTH: 200px" id="project">図面名</th>
                    <th style="WIDTH: 200px" id="edit_pdf"></th>
                </tr>            
        </table>
        <input type = "button" id = "pdf_button" name="addpdf" value = "報告箇所編集" onclick="edit_report_point()">
    </form>
    </p>
    
    <h2>参加者情報</h2>
    <p>
    <form id="user_form">
        <table id = "user_info" name = "table_user">
                <tr>
                    <th style="WIDTH: 50px">No</th>
                    <th style="WIDTH: 200px" id="com">企業名</th>
                    <th style="WIDTH: 200px" id="user">ユーザ名</th>
                </tr>            
        </table>
        <input type = "button" id = "edit_user_button" name="edituser" value = "参加者編集" onclick="edit_user()">
    </form>
    </p>
    <input type = "button" id = "edit" name="edit" value = "変更" onclick="edit()">
    </div>
            </div>
        </div>
</main>

    </body>
    <script>
    console.log("ID : " + <?php echo $_SESSION['count']; ?>);
    //phpからIDの取得
    var project_id = <?php echo $json_project_id; ?>;

    //図面情報をテーブルに挿入
    if(<?php echo $json_array_file; ?>[0] !=""){
        //テーブル表示
        //phpから配列の取得
        var file = <?php echo $json_array_file; ?>;
        
        //テーブル情報
        var table = document.getElementById("pdf_info");
        var tableLength = file.length;
        var cell1 = [];
        var cell2 = [];
        var cell3 = [];

            //会社名
            for(var j = 0; j < tableLength; j++){
                var row = table.insertRow(-1);
                cell1.push(row.insertCell(-1));
                cell2.push(row.insertCell(-1));
                cell3.push(row.insertCell(-1));
                cell1[j].innerHTML = j+1;
                cell2[j].innerHTML = file[j];
                cell3[j].innerHTML = '<input type = "button" value = "削除" onclick="delete_pdf_info(this)"/>';
                //cell4[j].innerHTML = '<input type = "submit" id = "p_project" name="p_project" value = "編集">';
        }
        }
    //ユーザ情報をテーブルに挿入
    if(<?php echo $json_array_user; ?>[0] !=""){
        //テーブル表示
        //phpから配列の取得
        var user = <?php echo $json_array_user; ?>;
        var company = <?php echo $json_array_company; ?>;
        //テーブル情報
        var table = document.getElementById("user_info");
        var tableLength = user.length;
        var cell1 = [];
        var cell2 = [];
        var cell3 = [];

            //会社名
            for(var j = 0; j < tableLength; j++){
                var row = table.insertRow(-1);
                cell1.push(row.insertCell(-1));
                cell2.push(row.insertCell(-1));
                cell3.push(row.insertCell(-1));
                cell1[j].innerHTML = j+1;
                cell2[j].innerHTML = company[j];
                cell3[j].innerHTML = user[j];
        }
        }


        //報告箇所編集
        function edit_report_point(){
            location.href ="http://10.20.170.52/web/p_entry_report_place.php";
        }

        //PDFファイルの追加
        function addpdf(){

        }
        
        //ユーザ情報の編集
        function edit_user(){
            //var param = "id="+project_id;
            location.href ="http://10.20.170.52/web/p_edit_user.php";
        }
        //変更処理
        function edit(){
            
            var table = document.getElementById("project_info");
            var project_name = table.rows[0].getElementsByTagName("input")[0].value;
            var address = table.rows[1].getElementsByTagName("input")[0].value;
            var overview = table.rows[2].getElementsByTagName("input")[0].value;
            /*console.log(project_id);
            console.log(project_name);
            console.log(address);
            console.log(overview);*/
            fd = new FormData();
            //現場情報
            fd.append('project_id',project_id);
            fd.append('project_name',project_name);
            fd.append('address',address);
            fd.append('overview',overview);
            xhttpreq = new XMLHttpRequest();
            xhttpreq.onreadystatechange = function() {
                /*if (xhttpreq.readyState == 4 && xhttpreq.status == 200) {
                    alert(xhttpreq.responseText);
                }*/
            };
            xhttpreq.open("POST", "upload_project_info.php", true);
            xhttpreq.addEventListener('load', (event) => {
                window.location.href = "http://10.20.170.52/web/mypage.php";
            });
            xhttpreq.send(fd);
            
        }
    </script>
</html>