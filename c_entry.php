<?php
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>現場編集</title>
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
    

    <h2>会社名、住所、電話番号を入力してください</h2>
    <p>
    <form id="c_form">
    <table id = "c_info" name = "c_table">
                <tr>
                    <th style="WIDTH: 50px" id="no">No</th>
                    <th style="WIDTH: 200px" id="project">会社名</th>
                    <th style="WIDTH: 200px" id="address">住所</th>
                    <th style="WIDTH: 200px" id="overview">電話番号</th>
                </tr>
                <tr>
                    <th style="WIDTH: 50px">1</th>
                    <th style="WIDTH: 200px"><input type = "text" value = ""></th>
                    <th style="WIDTH: 200px"><input type = "text" value = ""></th>
                    <th style="WIDTH: 200px"><input type = "text" value = ""></th>
                </tr>
                
            </table>
    </form>
    <input type = "button" id = "add_button" name="add_table" value = "追加" onclick="add_table()">
</p>
<input type = "button" id = "c_button" name="add_company" value = "登録" onclick="add_com()">
    </div>
            </div>
        </div>
</main>
<script type="text/javascript">
    var cell1 = [];
    var cell2 = [];
    var cell3 = [];
    var cell4 = [];

function add_com(){
//テーブル取得
var table = document.getElementById("c_info");
var num = 1;
while(table.rows[num].cells[1].getElementsByTagName("input")[0].value != ""){
num++
}
console.log(num);
            /*var s_name;
            var s_page;
            var s_x;
            var s_y;
            for(var i = 1; i<table.rows.length; i++){
            s_name = table.rows[i].cells[1].innerHTML;
            s_page = table.rows[i].cells[2].innerHTML;
            s_x = table.rows[i].cells[3].innerHTML;
            s_y = table.rows[i].cells[4].innerHTML;
            // フォームデータを取得
            //pdfIDの取得
            fd = new FormData();
            var file = document.getElementById('selectedPDF').innerHTML;
            fd.append('id', p_id);
            fd.append('file',file);
            fd.append('s_name', s_name);
            fd.append('s_page', s_page);
            fd.append('s_x',s_x);
            fd.append('s_y', s_y);
            fd.append('to_user', "to_user")
            xhttpreq = new XMLHttpRequest();
            xhttpreq.onreadystatechange = function() {
                if (xhttpreq.readyState == 4 && xhttpreq.status == 200) {
                    alert(xhttpreq.responseText);
                }
            };
            xhttpreq.open("POST", "insert_report_place.php", true);
            xhttpreq.send(fd);
            }*/

}

var n = 0;
function add_table(){
    var table = document.getElementById("c_info");
        var tableLength = table.rows.length;
        

        //会社名
        //for(var j = 0; j < tableLength; j++){
            var row = table.insertRow(-1);
            cell1.push(row.insertCell(-1));
            cell2.push(row.insertCell(-1));
            cell3.push(row.insertCell(-1));
            cell4.push(row.insertCell(-1));
            cell1[n].innerHTML = parseInt(tableLength);
            cell2[n].innerHTML = '<input type = "text" value = ""/>';
            cell3[n].innerHTML = '<input type = "text" value = ""/>';
            cell4[n].innerHTML = '<input type = "text" value = ""/>';
            n++;
    //}
}
    </script>
    </body>
</html>