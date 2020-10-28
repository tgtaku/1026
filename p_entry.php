<?php
//セッションスタート
session_start();

//仮の行を作成する
//require "conn.php";
//$sql = "INSERT INTO projects_information_1 VALUES ('', 'projects_name', 'address', 'overview', '' );";
//$result  = mysqli_query($conn, $sql);

    $link = mysqli_connect('localhost', 'root', '');
    if (!$link) {
    die('Failed connecting'.mysqli_error());
    }

    //DBの選択
    $db_selected = mysqli_select_db($link , 'test_db');
    if (!$db_selected){
    die('Failed Selecting table'.mysql_error());
    }

    //文字列をutf8に設定
    mysqli_set_charset($link , 'utf8');

    //pdfテーブルの取得
    $result_file  = mysqli_query($link ,"SELECT projects_id FROM projects_information_1 ORDER BY projects_id DESC LIMIT 1;");
    if (!$result_file) {
        die('Failed query'.mysql_error());
    }
    $row = mysqli_fetch_assoc($result_file);
    $row_num = (int) $row['projects_id'];
    $_SESSION['count'] = $row_num;
    //print_r($_SESSION['count']);
    // MySQLに対する処理
    $close_flag = mysqli_close($link);
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <title>現場登録画面</title>
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
                    <li><a href="select_report.php">-報告書確認</a></li>
                </ul>
            </div>
            <div class="maincol">
                <div class="maincol-container">
    

    <!--<h1>現場管理アプリ</h1>-->
    <h2>現場情報を入力してください。</h2>
        <form action="p_entry.php" method = "post" enctype="multipart/form-data">
            
            現場名<input type = "text" id = "project_name" name = "project_name" value = ""><br />
            所在地<input type ="text" id = "address" name="address" value = ""><br />
            概要<input type = "text" id = "overview" name="overview" value = ""><br />
        </form>

        <h2>図面情報を登録してください。</h2>
            
        <form id="my_form">
			<label for="image_file">ファイル選択はこちらをクリック</label><br>
            <input type="file" name="image_file[]" id="image_file" multiple="multiple" onchange=checkFile()><br>

            <table id = "pdf_information">
                <tr>
                    <th style="WIDTH: 15px" id="no">No</th>
                    <th style="WIDTH: 150px" id=>ファイル名</th>
                    <th style="WIDTH: 30px"></th>
                </tr>
            </table>
            
            <!--<input type="submit" name ="next" value = "次へ">-->
        </form>
        <button type="button" name="next" value = "次へ" onclick="setPDF()">次へ</button>
        <!--<button type="button" name="next" value = "次へ" onclick="ent()">次へ</button>-->
        
        </div>
            </div>
        </div>
</main>
<script>
            console.log("ID : " + <?php echo $_SESSION['count']; ?>);
/*functon ent(){
    setPDF().then(()=>{
        page();
    });
}*/
            var n=[];
            var f=[];
            var file_name = document.getElementById("image_file");

        function readAsDataURL(blob){
            return new Promise((resolve, reject) => {
                let reader = new FileReader();
                reader.onload = () => {resolve(reader.result); };
                reader.readAsDataURL(blob);
            });
        }

        async function checkFile(){
            
            //選択したファイル情報の取得

            // フォームデータを取得
            //var formdata = new FormData(document.getElementById("my_form"));
            // XMLHttpRequestによるアップロード処理
            /*var xhttpreq = new XMLHttpRequest();
            xhttpreq.onreadystatechange = function() {
                if (xhttpreq.readyState == 4 && xhttpreq.status == 200) {
                    alert(xhttpreq.responseText);
                }
            };
            xhttpreq.open("POST", "upload_file.php", true);
            xhttpreq.send(formdata);*/
            //var reader = new FileReader();
            
            
                for(var i=0; i<file_name.files.length; i++){


                // readerのresultプロパティに、データURLとしてエンコードされたファイルデータを格納
                //var reader = new FileReader();
                n.push(file_name.files[i].name);
                let dataURL = await readAsDataURL(file_name.files[i]);
                //reader.readAsDataURL(file_name.files[i]);
                //reader.onload = function(){
                    //f.push(reader.result);
                    f.push(dataURL);
                    console.log(f);
                    console.log(n);
                }
                
                //result = reader_onload(reader);
                //}
                /*
                reader.onload = function() {
                $('#thumbnail').attr('src', reader.result );
                //console.log(reader.result);
                f.push(reader.result);
                console.log(f);
                }*/

            
    
            
            console.log(f.length);

            //テーブル取得
            var table = document.getElementById("pdf_information");
            var num = file_name.files.length;
            //var num = n.length;
            var cell1 = [];
            var cell2 = [];
            var cell3 = [];
            for(var i = 0; i < num; i++){
            //行を行末に追加
            var row = table.insertRow(-1);
            //セルの挿入
            cell1.push(row.insertCell(-1));
            cell2.push(row.insertCell(-1));
            cell3.push(row.insertCell(-1));
            
            //削除ボタン
            var button = '<input type = "button" value = "削除" onClick= "deleteRow(this)" />';
            //行数取得
            var row_len = table.rows.length;
            //セルの内容入力
            cell1[i].innerHTML = row_len -1;
            cell2[i].innerHTML = n[row_len-2];
            cell3[i].innerHTML = button;
        }
    }

    function deleteRow(obj) {
        // 削除ボタンを押下された行を取得
        tr = obj.parentNode.parentNode;
        //file_name = tr.cells[1].innerHTML;
        console.log(tr.cells[1].innerHTML);
        console.log(tr.cells[0].innerHTML-1);
        f.splice(tr.cells[0].innerHTML-1,1);
        n.splice(tr.cells[0].innerHTML-1,1);
        console.log(f);
        console.log(n);
        
        //tr.cells[1]
        // フォームデータを取得
        //var formdata = new FormData(document.getElementById("my_form"));
        /*var formdata = new FormData();
        formdata.append('deleteFile',file_name);
        // XMLHttpRequestによるアップロード処理
        var xhttpreq = new XMLHttpRequest();
        xhttpreq.onreadystatechange = function() {
            if (xhttpreq.readyState == 4 && xhttpreq.status == 200) {
                alert(xhttpreq.responseText);
            }
        };
        xhttpreq.open("POST", "delete.php", true);
        xhttpreq.send(formdata);*/
            
        // trのインデックスを取得して行を削除する
        tr.parentNode.deleteRow(tr.sectionRowIndex);
        var tableTarget = document.getElementById('pdf_information');
        for(var i = 1; i < tableTarget.rows.length; i++){
            tableTarget.rows[i].cells[0].innerHTML = i;
        }
        }

        function setPDF(){
            //現場情報の取得
            var project_name = document.getElementById("project_name").value;
            var address = document.getElementById("address").value;
            var overview = document.getElementById("overview").value;
            //現場情報の空文字確認
            if(project_name =="" || address =="" || overview ==""){
                var err_msg = "現場情報を入力してください。";
                alert(err_msg);
            }else{
            //テーブル取得
            var table = document.getElementById("pdf_information");
            var pdf_name = [];
            var fd;
            var xhttpreq;
            var num = table.rows.length-1;
            
            for(var i = 1; i<table.rows.length; i++){
            pdf_name[i-1] = table.rows[i].cells[1].innerHTML;
            }
            
            /*// フォームデータを取得
            fd = new FormData();
            fd.append('pdf',pdf_name);
            // XMLHttpRequestによるアップロード処理
            xhttpreq = new XMLHttpRequest();
            xhttpreq.onreadystatechange = function() {
                if (xhttpreq.readyState == 4 && xhttpreq.status == 200) {
                    alert(xhttpreq.responseText);
                }
            };
            xhttpreq.open("POST", "insert_pdf_information.php", true);
            xhttpreq.send(fd);
            }*/


            fd = new FormData();
            //現場情報
            fd.append('project_name',project_name);
            fd.append('address',address);
            fd.append('overview',overview);
            //図面情報
            
            fd.append('file',f);
            fd.append('file_name',n);
            fd.append('file_num', num);
            //fd.append('');
            xhttpreq = new XMLHttpRequest();
            xhttpreq.onreadystatechange = function() {
                if (xhttpreq.readyState == 4 && xhttpreq.status == 200) {
                    alert(xhttpreq.responseText);
                }
            };
            xhttpreq.open("POST", "insert_project_pdf.php", true);
            //xhttpreq.open("POST", "upload_project_info.php", true);
            xhttpreq.addEventListener('load', (event) => {
                window.location.href = 'p_entry_report_place.php';
            });
            xhttpreq.send(fd);

            }
            //アップロードするファイル情報の取得
            //console.log(document.getElementById("image_file").value[0]);
            //console.log(document.getElementById("image_file").files[0]);
            //console.log(document.getElementById("image_file").files[1].name);
            
            
            }
            
            /*function page(){
                window.location.href = 'p_entry_user.php';
            }*/

            
        </script>
    </body>
</html>