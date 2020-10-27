<?php
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>報告書選択</title>
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
                    <li><a href="c_edit.php" >-施工会社/ユーザ編集</a></li>
                    <li>施工状況確認</li>
                    <li><a href="report.php"　style="background-color:gray">-報告書確認</a></li>
                </ul>
            </div>
            <div class="maincol">
                <div class="maincol-container">
    

    <h2>表示する報告書を選択してください。</h2>

    <p>
        <form action="p_edit.php" method = "post">
        管理者ID<input type = "text" name = "project" value = ""><br />
        現場名<input type ="text" name="address" value = ""><br />
        施工会社<input type ="text" name="overview" value = ""><br />
        施工箇所<input type ="text" name="address" value = ""><br />
        日付<input type ="text" name="overview" value = ""><br />
        <input type = "submit" id = "search_pro" name="search_pro" value = "検索">
        </form>
    </p>
    <form id="pro_form" action="p_edit_company.php" method = "post">
    <table id = "pro_info" name = "table_com">
                <tr>
                <th style="WIDTH: 50px" id="no">No</th>
                    <th style="WIDTH: 200px" id="project">現場名</th>
                    <th style="WIDTH: 200px" id="address">施工会社</th>
                    <th style="WIDTH: 200px" id="overview">施工箇所</th>
                    <th style="WIDTH: 100px" id="editButton">日付</th>
                    <th style="WIDTH: 100px" id="editButton"></th>
                </tr>
                <tr>
                <th style="WIDTH: 50px" id="no">1</th>
                    <th style="WIDTH: 200px" id="project">晴海トリトン</th>
                    <th style="WIDTH: 200px" id="address">大和ハウス</th>
                    <th style="WIDTH: 200px" id="overview">窓</th>
                    <th style="WIDTH: 100px" id="editButton">2020/10/9</th>
                    <th style="WIDTH: 100px" id="editButton"><input type = "button" value = "表示"></th>
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