<?php
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>報告書確認</title>
        <link rel="stylesheet" href = "style_report.css">
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
                    <li><a href="select_report.php"　style="background-color:gray">-報告書確認</a></li>
                </ul>
            </div>
            <div class="maincol">
                <div class="maincol-container">
    
    <table id = "report" name = "report">
                <!--現場情報-->
                <tr id = "project_info">
                    <td colspan = "2">現場情報</td>
                </tr>
                <tr>
                    <td id = "th_title">現場名</td>
                    <td>晴海トリトン</td>
                </tr>
                <tr>
                    <td id = "th_title">所在地</td>
                    <td>東京都中央区晴海</td>
                </tr>
                <tr>
                    <td id = "th_title">概要</td>
                    <td>ビル11階</td>
                </tr>
                <tr id = "blank">
                <td colspan = "2"></td>
                </tr>
                <!--施工者情報-->
                <tr id = "project_info">
                    <td colspan = "2">施工者情報</td>
                </tr>
                <tr>
                    <td id = "th_title">会社名</td>
                    <td>清水建設</td>
                </tr>
                <tr>
                    <td id = "th_title">住所</td>
                    <td>静岡県清水</td>
                </tr>
                <tr>
                    <td id = "th_title">電話番号</td>
                    <td>090-1111-2222</td>
                </tr>
                <tr>
                    <td id = "th_title">報告者</td>
                    <td>清水太郎</td>
                </tr>
                <tr id = "blank">
                    <td colspan = "2"></td>
                </tr>

                <!--施工状況-->
                <tr id = "project_info">
                    <td colspan = "2">施工状況</td>
                </tr>
                <tr>
                    <td id = "th_title">施工箇所</td>
                    <td>リビング</td>
                </tr>
                <tr>
                    <td id = "th_title">撮影日時</td>
                    <td>2020/11/04　12:34:56</td>
                </tr>
                <tr class="pic">
                    <td colspan = "2" id = "src"><img src = http://10.20.170.52/sample/images/066.jpg></td>
                </tr>
                <tr>
                    <td id = "th_title">コメント</td>
                    <td></td>
                </tr>
                <tr id = "blank">
                <td colspan = "2"></td>
                </tr>
                <tr>
                    <td id = "th_title">撮影日時</td>
                    <td>2020/11/04　14:25:25</td>
                </tr>
                <tr class="pic">
                    <td colspan = "2" id = "src"><img src = http://10.20.170.52/sample/images/IMG_20200529_164248.jpg></td>
                </tr>
                <tr>
                    <td id = "th_title">コメント</td>
                    <td></td>
                </tr>
                
                
            </table>
            </div>
            </div>
        </div>
</main>
<script>

</script>
    </body>
</html>