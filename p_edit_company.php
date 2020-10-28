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
        session_start();
        $_SESSION['count'] = $project_id;
    //print_r($project_id);
    //json形式に変更
    }
}else{
        session_start();
        $project_id = $_SESSION['count'];
        //print_r($project_id);
        //現場名、所在地、概要の取得
        require "conn.php";
        $mysql_qry = "select * from projects_information_1 where projects_id = '$project_id';";
        $result = mysqli_query($conn, $mysql_qry);
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            $name = $row['projects_name'];
            $address = $row['projects_street_address'];
            $overview = $row['overview'];
            $i++;
        }
        
    }
    //セッションスタート
    require "conn.php";
    $json_project_id = json_encode($project_id);
    

    //図面情報の取得
    $row_array_file = array();
    $mysql_qry = "select * from pdf_information_1 inner join projects_information_1 on pdf_information_1.project_id = projects_information_1.projects_id where projects_information_1.projects_id = '$project_id';";
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
    $mysql_qry_user = "select * from assign_company_information_1 inner join users_information_1 on assign_company_information_1.companies_id = users_information_1.companies_id inner join projects_information_1 on assign_company_information_1.projects_id = projects_information_1.projects_id inner join companies_information_1 on assign_company_information_1.companies_id = companies_information_1.companies_id where projects_information_1.projects_id = '$project_id';";
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
                    <li><a href="select_report.php">-報告書確認</a></li>
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
        <label for="image_file">ファイル選択はこちらをクリック</label><br>
            
    </form>
    <input type="file" name="image_file[]" id="image_file" multiple="multiple" onchange=addpdf()><br>
        <input type = "button" id = "pdf_button" name="addpdf" value = "報告箇所編集" onclick="edit_report_point()">
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
    
    //削除するファイル
    var delete_file = [];

    //図面情報をテーブルに挿入
    if(<?php echo $json_array_file; ?>[0] !=""){
        //テーブル表示
        //phpから配列の取得
        var file = <?php echo $json_array_file; ?>;
        //var n=[]; fileで代用
        //追加アップロードしたファイル情報を保存
        var f=[];
        //選択したファイル
        var selected_file = document.getElementById("image_file");
        //テーブル情報
        var table_pdf = document.getElementById("pdf_info");
        var tableLength = file.length;
        var cell1 = [];
        var cell2 = [];
        var cell3 = [];

            //会社名
            for(var j = 0; j < tableLength; j++){
                var row = table_pdf.insertRow(-1);
                cell1.push(row.insertCell(-1));
                cell2.push(row.insertCell(-1));
                cell3.push(row.insertCell(-1));
                cell1[j].innerHTML = j+1;
                cell2[j].innerHTML = file[j];
                cell3[j].innerHTML = '<input type = "button" value = "削除" onclick="delete_pdf_info(this)"/>';
                //cell4[j].innerHTML = '<input type = "submit" id = "p_project" name="p_project" value = "編集">';
                f.push("");
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
        var user_cell1 = [];
        var user_cell2 = [];
        var user_cell3 = [];

            //会社名
            for(var j = 0; j < tableLength; j++){
                var row = table.insertRow(-1);
                user_cell1.push(row.insertCell(-1));
                user_cell2.push(row.insertCell(-1));
                user_cell3.push(row.insertCell(-1));
                user_cell1[j].innerHTML = j+1;
                user_cell2[j].innerHTML = company[j];
                user_cell3[j].innerHTML = user[j];
        }
        }

        function readAsDataURL(blob){
            return new Promise((resolve, reject) => {
                let reader = new FileReader();
                reader.onload = () => {resolve(reader.result); };
                reader.readAsDataURL(blob);
            });
        }

        //報告箇所編集
        function edit_report_point(){
            var post_f = [];
            var post_file_name = [];
            //追加されたPDFのアップロード
            for(var i = 0; i < f.length; i++){
                if(f[i] == ""){

                }else{
                    post_f.push(f[i]);
                    post_file_name.push(file[i]);
                }
            }
            
            //図面削除処理がされているか確認
            if(delete_file[0] == null){

            }else{
                delete_file_info(delete_file);
            }

            if(post_f[0] == null){
                window.location.href = 'p_edit_report_place.php';
            }else{
                fd = new FormData();
                fd.append('file',post_f);
                fd.append('file_name',post_file_name);
                xhttpreq = new XMLHttpRequest();
                xhttpreq.onreadystatechange = function() {
                if (xhttpreq.readyState == 4 && xhttpreq.status == 200) {
                    alert(xhttpreq.responseText);
                }
            };
            xhttpreq.open("POST", "insert_edit_pdf.php", true);
            //アップロード終了後、ページ遷移
            xhttpreq.addEventListener('load', (event) => {
                window.location.href = 'p_edit_report_place.php';
            });
            xhttpreq.send(fd);
            //console.log(post_f);
            //console.log(post_file);
            }
        }

        //PDFファイルの追加
        async function addpdf(){
            //選択したファイル名とbase64データを取得
            for(var i=0; i<selected_file.files.length; i++){
            // readerのresultプロパティに、データURLとしてエンコードされたファイルデータを格納
            file.push(selected_file.files[i].name);
            let dataURL = await readAsDataURL(selected_file.files[i]);
            f.push(dataURL);
            console.log(file);
            console.log(f);
            }
            //テーブルにアップロードしたPDFファイル名を追加
            for(var i = 0; i<selected_file.files.length; i++){
                //var table = document.getElementById("pdf_info");
                var row = table_pdf.insertRow(-1);
                cell1.push(row.insertCell(-1));
                cell2.push(row.insertCell(-1));
                cell3.push(row.insertCell(-1));
                console.log(table_pdf.rows.length-1);
                cell1[table_pdf.rows.length-2].innerHTML = table_pdf.rows.length-1;
                cell2[table_pdf.rows.length-2].innerHTML = file[table_pdf.rows.length-2];
                cell3[table_pdf.rows.length-2].innerHTML = '<input type = "button" value = "削除" onclick="delete_pdf_info(this)"/>';
            }
        }
        
        //ユーザ情報の編集
        function edit_user(){
            //図面削除処理がされているか確認
            if(delete_file[0] == null){
            }else{
                delete_file_info(delete_file);
            }
            //var param = "id="+project_id;
            location.href ="http://10.20.170.52/web/p_edit_user.php";
        }
        //変更処理
        function edit(){
            //図面削除処理がされているか確認
            if(delete_file[0] == null){

            }else{
                delete_file_info(delete_file);
            }

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

        function delete_pdf_info(obj){
            // 削除ボタンを押下された行を取得
        tr = obj.parentNode.parentNode;
        //file_name = tr.cells[1].innerHTML;
        console.log(tr.cells[1].innerHTML);
        console.log(tr.cells[0].innerHTML-1);
        f.splice(tr.cells[0].innerHTML-1,1);
        file.splice(tr.cells[0].innerHTML-1,1);
        console.log(f);
        console.log(file);
        
        //削除するファイル名を格納
        delete_file.push(tr.cells[1].innerHTML);

        // trのインデックスを取得して行を削除する
        tr.parentNode.deleteRow(tr.sectionRowIndex);
        var tableTarget = document.getElementById('pdf_info');
        for(var i = 1; i < tableTarget.rows.length; i++){
            tableTarget.rows[i].cells[0].innerHTML = i;
        }
        
        console.log(delete_file);
        }

        function delete_file_info(del){
            console.log(del);
            
            fd = new FormData();
            fd.append('delete_file',del);
            xhttpreq = new XMLHttpRequest();
            xhttpreq.onreadystatechange = function() {
            if (xhttpreq.readyState == 4 && xhttpreq.status == 200) {
                alert(xhttpreq.responseText);
                }
            };
            xhttpreq.open("POST", "delete_file_info.php", true);
            xhttpreq.send(fd);
        }
    </script>
</html>