<?php
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>現場情報編集</title>
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
    

    <h2>削除するユーザを選択、登録するユーザ情報を入力してください。</h2>
    <p>
    <form id="pro_form" action="p_edit_company.php" method = "post">
    <table id = "pro_info" name = "table_com">
                <tr>
                <th style="WIDTH: 200px" id="name">大和ハウス</th>
                </tr>
                <tr>
                <th style="WIDTH: 50px" id="no">No</th>
                    <th style="WIDTH: 200px" id="project">ユーザ名</th>
                    <th style="WIDTH: 200px" id="address">パスワード</th>
                    <th style="WIDTH: 50px" id="editButton"></th>
                </tr>
                <tr>
                <th style="WIDTH: 50px" id="no">1</th>
                    <th style="WIDTH: 200px" id="project">大和一郎</th>
                    <th style="WIDTH: 200px" id="address">password</th>
                    <th style="WIDTH: 50px" id="editButton"><input type = "checkbox" name = "ch" id="user_check" ></th>
                </tr>
            </table>
            <!--<input type = "button" id = "pro_button" name="editpro" value = "現場編集" onclick="editpro()">-->
    </form>
    </p>

<p>
    <h4>ユーザー登録</h4>
    <form action="login.php" method = "post">
            ユーザー名<input type = "text" name = "id" value = ""><br />
            パスワード<input type = "password" name="password" value = ""><br />
            パスワード（再入力）<input type = "password" name="password" value = ""><br />
            <input type="button" name ="add" value = "ユーザ追加">
            
        </form>
        </p>
        <input type="submit" name ="login" value = "登録/削除">
    </div>
            </div>
        </div>
</main>

    </body>
</html>