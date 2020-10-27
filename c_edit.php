<?php
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>編集現場選択</title>
        <link rel="stylesheet" href = "style.css">
    </head>
    <body>
    <main>
        <div class="main-container">
            <div class="sidebar">
                <h1>menu</h1>
                <ul class="subnav">
                    <li>現場情報管理</li>
                    <li><a href="p_entry.php" >-現場登録</a></li>
                    <li><a href="p_edit.php" >-現場編集</a></li>
                    <li>施工会社管理</li>
                    <li><a href="c_entry.php">-施工会社登録</a></li>
                    <li><a href="c_edit.php" style="background-color:gray">-施工会社/ユーザ編集</a></li>
                    <li>施工状況確認</li>
                    <li><a href="report.php">-報告書確認</a></li>
                </ul>
            </div>
            <div class="maincol">
                <div class="maincol-container">
    

    <h2>会社情報を変更する会社を選択してください。</h2>
    <p>
        <form action="p_edit.php" method = "post">
        会社名<input type = "text" name = "project" value = ""><br />
        住所<input type ="text" name="address" value = ""><br />
        電話番号<input type ="text" name="overview" value = ""><br />
        <input type = "submit" id = "search_pro" name="search_pro" value = "検索">
        </form>
    </p>
    <form id="pro_form" action="p_edit_company.php" method = "post">
    <table id = "pro_info" name = "table_com">
                <tr>
                <th style="WIDTH: 50px" id="no">No</th>
                    <th style="WIDTH: 200px" id="project">会社名</th>
                    <th style="WIDTH: 200px" id="address">住所</th>
                    <th style="WIDTH: 200px" id="overview">電話番号</th>
                    <th style="WIDTH: 100px" id="editButton"></th>
                    <th style="WIDTH: 100px" id="editButton"></th>
                </tr>
                <tr>
                <th style="WIDTH: 50px" id="no">1</th>
                    <th style="WIDTH: 200px" id="project">大和ハウス</th>
                    <th style="WIDTH: 200px" id="address">飯田橋三丁目</th>
                    <th style="WIDTH: 200px" id="overview">01234567890</th>
                    <th style="WIDTH: 100px" id="editButton"><input type = "button" value = "会社情報編集"></th>
                    <th style="WIDTH: 100px" id="editButton"><input type = "button" value = "ユーザ情報編集"></th>
                </tr>
            </table>
            <!--<input type = "button" id = "pro_button" name="editpro" value = "現場編集" onclick="editpro()">-->
    </form>
    </div>
            </div>
        </div>
</main>

    </body>
</html>