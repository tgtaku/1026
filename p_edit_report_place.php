<?php
//追加処理の変更情報登録

//プロジェクトIDの取得
$project_id = "";
session_start();
$project_id = $_SESSION['count'];
$project_id_now = json_encode($project_id);

//mysqlとの接続
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
$result_file  = mysqli_query($link ,"SELECT * FROM pdf_information_1 where project_id = '$project_id';");
if (!$result_file) {
    die('Failed query'.mysql_error());
}
//print_r($result_file);
//データ格納用配列の取得
$row_array_file = array();
$row_array_glob = array();
$j = 0;
$selectedPD = "";
while ($row = mysqli_fetch_assoc ($result_file)) {
    //print_r($row);
    $row_array_file[$j] = $row['pdf_name'];
    $j++;
}
//print_r($row_array_file);
//print_r(count($row_array_file));
for($i = 0; $i < count($row_array_file); $i++ ){
    //ディレクトリ作成
    //①ディレクトリの名称
    $moji = substr($row_array_file[$i], 0, strlen($row_array_file[$i]) - 4);
    //
    $d = '.\up\d';
    $di = substr($d, 0, strlen($d) - 1);
    //ディレクトリ名（./up/ファイル）
    $dir = $di.$moji;

    //ディレクトリが存在した場合、中のpngファイル数をカウントする
    if(file_exists($dir)){
        $dir_num = $dir."/*";
    //print_r($dir_num);
    $glob = glob($dir_num);
    $row_array_glob[$i] = count($glob);
    }//ディレクトリが存在してなかった場合、ディレクトリを作成する
    else{
        mkdir($dir, 0777);
        //参照するPDFのパス
        $pa = 'D:\Bitnami\htdocs\web\up\d';
        $pat = substr($pa, 0, strlen($pa) - 1);
        //D:\Bitnami\htdocs\web\up\ファイル名
        $path = $pat.$row_array_file[$i];
        
        //pngのパス
        $png = substr($path, 0, strlen($path) - 4)."\d";
        $pg = substr($png, 0, strlen($png) - 1);
        $out = $pg.$moji.".png";
        //D:\Bitnami\htdocs\web\up\ファイルディレクトリ

        //print_r($out);
        $cmd = 'D:\ImageMagick-7.0.10-Q16\convert.exe'.' '.$path.' '.$out;
        //echo $cmd;
        exec($cmd);
        
        $dir_num = $dir."/*";
        //print_r($dir_num);
        $glob = glob($dir_num);
        $row_array_glob[$i] = count($glob);
        //print_r(count($glob));
        //print_r($row_array_file[$i]);
        }//PDF情報が何もない場合何もしない
    if($i == 0){
        //$m = $moji."\d";
        //$mm = substr($m, 0, strlen($m) - 1);
        //$selectedPD = $mm.$moji."-0.png";
        $selectedPD = $moji;
        //print_r($selectedPD);
    }
}

//既存報告箇所の取得
//取得用配列
$edit_array = [];
require "conn.php";
$mysql_qry = "select * from report_places_infomation_1 inner join pdf_information_1 on report_places_infomation_1.pdf_id = pdf_information_1.pdf_id where pdf_information_1.project_id = '$project_id';";
    $result = mysqli_query($conn, $mysql_qry);
    if(mysqli_num_rows($result) > 0){
        $i = 0;
        while($row = mysqli_fetch_assoc($result)){
            array_push($edit_array, $row);
            $i++;
        }
    }
    //print_r($edit_array);
$json_array_edit_point = json_encode($edit_array);

$selectedPDF = json_encode($selectedPD);
$array_length = count($row_array_file);
$json_array = json_encode($row_array_file);
$json_array_glob = json_encode($row_array_glob);
//print_r($project_id_now);
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>報告箇所登録画面</title>
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
                    <li><a href="p_entry.php">-現場登録</a></li>
                    <li><a href="p_edit.php"  style="background-color:gray">-現場編集</a></li>
                    <li>施工会社管理</li>
                    <li><a href="c_entry.php">-施工会社登録</a></li>
                    <li><a href="c_edit.php">-施工会社/ユーザ編集</a></li>
                    <li>施工状況確認</li>
                    <li><a href="report.php">-報告書確認</a></li>
                </ul>
            </div>
            <div class="maincol">
                <div class="maincol-container">
    <h2>報告箇所を登録してください。</h2>
    <ul id="pdfName">
    </ul>
    <h2 id ="selectedPDF">図面名</h2>
    <h4 id ="pagenum"></h4>
    <h4 id = "pagesum"></h4>
    <div id ="div">
    <img alt = "図面を選択してください" title = "test" id ="im" >

    </div>
    <div>
    <img src="left.png" title = "left" id ="left" >
    <img src="right.png" title = "right" id ="right" >
</div>
    <form id="place_form">
    <table id = "place_info">
                <tr>
                    <th style="WIDTH: 15px" id="no">No</th>
                    <th style="WIDTH: 300px" id="place">施工箇所</th>
                    <th style="WIDTH: 60px" id="page">ページ</th>
                    <th style="WIDTH: 60px" id="x">X</th>
                    <th style="WIDTH: 60px" id="y">Y</th>
                </tr>
            </table>
            <input type = "button" id = "place_button" name="gotPlace" value = "登録" onclick = "ent()">
            
</form>
</div>
            </div>
        </div>
</main>
    <script>
        //初期処理
        //表示PDF番号
        var pdf_num = 0;

        //phpから受け取り
        var id = <?php echo $_SESSION['count']; ?>; //id
        var array_edit = <?php echo $json_array_edit_point; ?>; //DBに登録されている報告箇所の配列
        var array_file_name = <?php echo $json_array; ?>; //ファイル名

        console.log("ID : " + <?php echo $_SESSION['count']; ?>);
        console.log("array : " + <?php echo $json_array; ?>);

        //図面変更用のボタン作成
        //ボタン用配列
        var li = [];
        for (var i = 0; i < array_file_name.length; i++){
            li[i] = document.createElement('button');
            li[i].id = i;
            li[i].value = array_file_name[i];
            li[i].textContent = array_file_name[i];
            li[i].onclick = function(){getPic(this)};
            //parent.appendChild(li[i]);
            document.getElementById('pdfName').appendChild(li[i]);
            document.getElementById('selectedPDF').innerHTML = array_file_name[0];
        }

        //図面情報の表示
        //ディレクトリにあるファイル数
        var globNum = <?php echo $json_array_glob; ?>;
        var pageNum = 0;
        //配列の何番目にあるか保持する
        var gn = 0;
        var globPage = globNum[gn];
        var globPageNum = globPage + "ページ";
        var page = pageNum+1 + "ページ / ";
        var p = document.getElementById('pagenum');
        p.innerHTML = page;
        var ps = document.getElementById('pagesum');
        ps.innerHTML = globPageNum;

        //報告箇所配列の作成
        var array_no = []; //no
        var array_point_name = []; //報告箇所
        var array_point_x = []; //x
        var array_point_y = []; //y
        var array_page = []; //page番号
        for (var h = 0; h < li.length; h++){
            array_no[h] = [];
            array_point_name[h] = [];
            array_point_x[h] = [];
            array_point_y[h] = [];
            array_page[h] = [];
        }

        //テーブル記述用の配列の初期化
        cell1 = [];
        cell2 = [];
        cell3 = [];
        cell4 = [];
        cell5 = [];
        cell6 = [];

        //既存の報告箇所を配列化する
        var edit_array = <?php echo $json_array_edit_point; ?>;
        for(var m = 0; m < edit_array.length; m++){
            //PDF名がnamesのどれと一致するか確認し、一致した番号の配列にそれぞれの値を格納
            for(var n = 0; n < array_file_name.length; n++){
                if(edit_array[m]['pdf_name'] == array_file_name[n]){
                    array_no[n].push("");
                    array_point_name[n].push(edit_array[m]['report_place_name']);
                    array_point_x[n].push(edit_array[m]['X']);
                    array_point_y[n].push(edit_array[m]['Y']);
                    array_page[n].push(edit_array[m]['page']);
                    break;
                }else{
                }
            }
        }

        //配列に持っている情報を取得→持っていた場合テーブルに記入
            //配列にある要素の数を取得
            var table_array_num = array_point_name[0].length;
            console.log(table_array_num);
            //要素の数だけテーブルを追加
            var table = document.getElementById('place_info');
            for(var l = 0; l < table_array_num; l++){
                var row = table.insertRow(-1);
                cell1.push(row.insertCell(-1));
                cell2.push(row.insertCell(-1));
                cell3.push(row.insertCell(-1));
                cell4.push(row.insertCell(-1));
                cell5.push(row.insertCell(-1));
                cell6.push(row.insertCell(-1));
                cell1[l].innerHTML = l + 1;
                cell2[l].innerHTML = array_point_name[0][l];
                cell3[l].innerHTML = array_page[0][l];
                cell4[l].innerHTML = array_point_x[0][l];
                cell5[l].innerHTML = array_point_y[0][l];
                cell6[l].innerHTML = '<input type = "button" value = "削除" onClick= "deleteRow(this)" />'; 
            }


        //図面画像の表示
        var img = document.getElementById('im');
        var selected_img = <?php echo $selectedPDF; ?>;
        var selected_img_name = "./up/" + selected_img + "/" + selected_img +"-0.png";
        img.src = selected_img_name;
        img.onload = function(){
            
            //1ページ目のマークを表示
            //テーブルの値を確認→ページに該当するものが存在した場合、表示
            var checktable = document.getElementById('place_info');
            var checkLength = checktable.rows.length;
            for(var c = 1; c < checkLength; c++){
                if(checktable.rows[c].cells[2].innerHTML == pageNum + 1){
                    //console.log(checktable.rows[c].cells[3].innerHTML)
                    var cBall = document.createElement('d'); 
                    cBall.id = "pic";
                    cBall.style.position = "absolute";
                    //マーク位置の計算
                    //画像表示位置の取得
                    var elem = document.getElementById('im');
                    var rect = elem.getBoundingClientRect();
                    var elemtop = rect.top + window.pageYOffset;
                    var elemleft = rect.left + window.pageXOffset;
                    var eTop = parseInt(elemtop);
                    var eLeft = parseInt(elemleft);
            
                    //画像サイズ
                    var w = elem.width;
                    var w1 = parseInt(w);
                    var h = elem.height;
                    var h1 = parseInt(h);

                    //画面サイズから表示位置を取得
                    var pointx = parseFloat(checktable.rows[c].cells[3].innerHTML);
                    var pointy = parseFloat(checktable.rows[c].cells[4].innerHTML);

                    //画像上のクリック地点
                    var drop_pointx = parseInt(pointx*w1) + eLeft;
                    var drop_pointy = parseInt(pointy*h1) + eTop;

                    var RandLeft = drop_pointx + "px";
                    var RandTop = drop_pointy + "px";
                    cBall.style.left = RandLeft;
                    cBall.style.top = RandTop;
                    var mark = document.createElement('img');
                    //mark.id = tabLength;
                    mark.value = checktable.rows[c].cells[1].innerHTML;
                    mark.src = "http://10.20.170.52/web/local_pic.png";
                    mark.addEventListener('click', function(event2){
                    var bef_change = this.value;
                    var placeValue = window.prompt("施工箇所名変更", this.value);
                    if(placeValue == bef_change){

                    }else if(placeValue == null){

                    }
                    else{
                        var checktable = document.getElementById('place_info');
                        var checkLength = checktable.rows.length;
                        for(var c = 1; c < checkLength; c++){
                        if(checktable.rows[c].cells[1].innerHTML == bef_change){
                        checktable.rows[c].cells[1].innerHTML = placeValue;
                        array_point_name[pdf_num][c-1] = placeValue;
                        console.log("1" + array_point_name[pdf_num][c-1]);
                        //console.log(placeValue);
                    }
                }
                }
            });
                    //Divにイメージを組み込む
                    cBall.appendChild(mark);
                    //画面にDivを組み込む
                    div.appendChild(cBall);
                }
            }
            var dldiv = document.getElementById('div').children;
            console.log(dldiv);
        console.log(array_point_name);
        console.log(edit_array.length);
        }

        
        //矢印ボタンの処理
        var right = document.getElementById('right');
        var left = document.getElementById('left');

        right.addEventListener('click', function(nextPage){
            if(pageNum < globPage -1){
                console.log("next");
            pageNum += 1;
            var img = document.getElementById('im');
            //img.src = "./up/lowcarbon05/hoge-" + pageNum + ".png";
            img.src = "./up/" + selected_img + "/" + selected_img + "-" + pageNum +".png";
            p.innerHTML = pageNum+1 + "ページ / ";
            }
            //マーク削除
            var dldiv = document.getElementById('div').children;
            console.log(dldiv);
            var dllength = dldiv.length;
            //console.log(dldiv);
            //console.log(dllength);
            for(var m = 0; m < dllength; m++){
                //console.log(m);
                //console.log(dldiv.item(m));
                console.log(dldiv.item(m).id);
                if(dldiv.item(m).id =="pic"){
                    console.log("del");
                    var dl = dldiv.item(m);
                    //dl.parentNode.removeChild(dl);
                    dl.parentNode.removeChild(dl);
                    m--;
                    dllength--;
                }
            }

            //テーブルの値を確認→ページに該当するものが存在した場合、表示
            var checktable = document.getElementById('place_info');
            var checkLength = checktable.rows.length;
            for(var c = 1; c < checkLength; c++){
                console.log(pageNum);
                if(checktable.rows[c].cells[2].innerHTML == pageNum+1){
                    //console.log(checktable.rows[c].cells[3].innerHTML)
                    var cBall = document.createElement('d'); 
                    cBall.id = "pic";
                    cBall.style.position = "absolute";
                    //マーク位置の計算
                    //画像表示位置の取得
                    var elem = document.getElementById('im');
                    var rect = elem.getBoundingClientRect();
                    var elemtop = rect.top + window.pageYOffset;
                    var elemleft = rect.left + window.pageXOffset;
                    var eTop = parseInt(elemtop);
                    var eLeft = parseInt(elemleft);
            
                    //画像サイズ
                    var w = elem.width;
                    var w1 = parseInt(w);
                    var h = elem.height;
                    var h1 = parseInt(h);
                    
                    //画面サイズから表示位置を取得
                    var pointx = parseFloat(checktable.rows[c].cells[3].innerHTML);
                    var pointy = parseFloat(checktable.rows[c].cells[4].innerHTML);

                    //画像上のクリック地点
                    var drop_pointx = parseInt(pointx*w1) + eLeft;
                    var drop_pointy = parseInt(pointy*h1) + eTop;

                    var RandLeft = drop_pointx + "px";
                    var RandTop = drop_pointy + "px";
                    cBall.style.left = RandLeft;
                    cBall.style.top = RandTop;
                    var mark = document.createElement('img');
                    //mark.id = tabLength;
                    mark.value = checktable.rows[c].cells[1].innerHTML;
                    mark.src = "http://10.20.170.52/web/local_pic.png";
                    mark.addEventListener('click', function(event2){
                        var bef_change = this.value;
                    var placeValue = window.prompt("施工箇所名変更", this.value);
                    if(placeValue == bef_change){

                    }else if(placeValue == null){

                    }
                    else{
                        var checktable = document.getElementById('place_info');
                        var checkLength = checktable.rows.length;
                        for(var c = 1; c < checkLength; c++){
                        if(checktable.rows[c].cells[1].innerHTML == bef_change){
                        checktable.rows[c].cells[1].innerHTML = placeValue;
                        array_point_name[pdf_num][c-1] = placeValue;
                        console.log(array_point_name[pdf_num][c-1]);
                        //console.log(placeValue);
                    }
                }
                }
                });
                    //Divにイメージを組み込む
                    cBall.appendChild(mark);
                    //画面にDivを組み込む
                    div.appendChild(cBall);
                }
            }
            

        }, false);

        left.addEventListener('click', function(backPage){
            if(0 < pageNum ){
            console.log("back");
            pageNum -= 1;
            var img = document.getElementById('im');
            //img.src = "./up/lowcarbon05/hoge-" + pageNum + ".png";
            img.src = "./up/" + selected_img + "/" + selected_img + "-" + pageNum +".png";
            p.innerHTML = pageNum+1 + "ページ / ";
            }
            //マーク削除
            var dldiv = document.getElementById('div').children;
            var dllength = dldiv.length;
            //console.log(dldiv);
            //console.log(dllength);
            for(var m = 0; m < dllength; m++){
                //console.log(m);
                //console.log(dldiv.item(m));
                if(dldiv.item(m).id =="pic"){
                    //var iL = dldiv.item(m).length:
                    //console.log(iL);
                    
                    //console.log("del");
                    var dl = dldiv.item(m);
                    dl.parentNode.removeChild(dl);
                    m--;
                    dllength--;
                }
            }
            //テーブルの値を確認
            var checktable = document.getElementById('place_info');
            var checkLength = checktable.rows.length;
            for(var c = 1; c < checkLength; c++){
                if(checktable.rows[c].cells[2].innerHTML == pageNum+1){
                    //console.log(checktable.rows[c].cells[3].innerHTML)
                    var cBall = document.createElement('d'); 
                    cBall.id = "pic";
                    cBall.style.position = "absolute";
                    //マーク位置の計算
                    //画像表示位置の取得
                    var elem = document.getElementById('im');
                    var rect = elem.getBoundingClientRect();
                    var elemtop = rect.top + window.pageYOffset;
                    var elemleft = rect.left + window.pageXOffset;
                    var eTop = parseInt(elemtop);
                    var eLeft = parseInt(elemleft);
            
                    //画像サイズ
                    var w = elem.width;
                    var w1 = parseInt(w);
                    var h = elem.height;
                    var h1 = parseInt(h);
                    
                    //画面サイズから表示位置を取得
                    var pointx = parseFloat(checktable.rows[c].cells[3].innerHTML);
                    var pointy = parseFloat(checktable.rows[c].cells[4].innerHTML);

                    //画像上のクリック地点
                    var drop_pointx = parseInt(pointx*w1) + eLeft;
                    var drop_pointy = parseInt(pointy*h1) + eTop;

                    var RandLeft = drop_pointx + "px";
                    var RandTop = drop_pointy + "px";
                    cBall.style.left = RandLeft;
                    cBall.style.top = RandTop;
                    var mark = document.createElement('img');
                    //mark.id = tabLength;
                    mark.value = checktable.rows[c].cells[1].innerHTML;
                    mark.src = "http://10.20.170.52/web/local_pic.png";
                    mark.addEventListener('click', function(event2){
                        var bef_change = this.value;
                    var placeValue = window.prompt("施工箇所名変更", this.value);
                    if(placeValue == bef_change){

                    }else if(placeValue == null){

                    }
                    else{
                        var checktable = document.getElementById('place_info');
                        var checkLength = checktable.rows.length;
                        for(var c = 1; c < checkLength; c++){
                        if(checktable.rows[c].cells[1].innerHTML == bef_change){
                        checktable.rows[c].cells[1].innerHTML = placeValue;
                        array_point_name[pdf_num][c-1] = placeValue;
                        console.log(array_point_name[pdf_num][c-1]);
                        //console.log(placeValue);
                    }
                }
                }
                });
                    //Divにイメージを組み込む
                    cBall.appendChild(mark);
                    //画面にDivを組み込む
                    div.appendChild(cBall);
                }
            }

        }, false);

        img.addEventListener('click', function(event){
            
            var pValue = window.prompt("施工箇所名を入力してください", "");
            console.log(pValue);
            if(pValue == null){
                console.log("null入っている");
            }
            if(pValue != null){

            //}
            //要素の数を探す
            var div = document.getElementById('div');
            var table = document.getElementById('place_info');
            var tabLength = table.rows.length;
            //var dltabLength = table.rows.length;
            var num = tabLength-1;
            console.log(num);
            console.log(tabLength);
            
            //画像表示位置の取得
            var elem = document.getElementById('im');
            var rect = elem.getBoundingClientRect();
            var elemtop = rect.top + window.pageYOffset;
            var elemleft = rect.left + window.pageXOffset;
            var eTop = parseInt(elemtop);
            var eLeft = parseInt(elemleft);
            //var elembotom = rect.bottom + window.pageYOffset;
            //var elemright = rect.right + window.pageXOffset;

            //画像サイズ
            var w = elem.width;
            var w1 = parseInt(w);
            var h = elem.height;
            var h1 = parseInt(h);
            
            //画像上のクリック地点
            var x = event.pageX;
            var x1 = parseInt(x);
            var x2 = x1 - eLeft;
            var y = event.pageY;
            var y1 = parseInt(y);
            var y2 = y1 - eTop;

            //座標上の比率を計算
            var pointX = x2/w1;
            var pointY = y2/h1;
            
            //動的にdivを作成する
            var cBall = document.createElement('d'); 
            cBall.id = "pic";
		    cBall.style.position = "absolute";
            var RandLeft = x1 + "px";
		    var RandTop = y1 + "px";
            cBall.style.left = RandLeft;
		    cBall.style.top = RandTop;
            var mark = document.createElement('img');
            mark.id = tabLength;
            mark.value = pValue;
            mark.src = "http://10.20.170.52/web/local_pic.png";
            mark.addEventListener('click', function(event2){
                var bef_change = this.value;
                    var placeValue = window.prompt("施工箇所名変更", this.value);
                    if(placeValue == bef_change){

                    }else if(placeValue == null){

                    }
                    else{
                        var checktable = document.getElementById('place_info');
                        var checkLength = checktable.rows.length;
                        for(var c = 1; c < checkLength; c++){
                        if(checktable.rows[c].cells[1].innerHTML == bef_change){
                        checktable.rows[c].cells[1].innerHTML = placeValue;
                        array_point_name[pdf_num][c-1] = placeValue;
                        console.log(array_point_name[pdf_num][c-1]);
                        //console.log(placeValue);
                    }
                }
                }
            });
            //Divにイメージを組み込む
		    cBall.appendChild(mark);
		    //画面にDivを組み込む
		    div.appendChild(cBall);

            //テーブルの追加
            //console.log(table);
            var row = table.insertRow(-1);
            array_no[pdf_num][num] = tabLength;
            array_point_name[pdf_num][num] = pValue;
            array_page[pdf_num][num] = pageNum + 1;
            array_point_x[pdf_num][num] = pointX.toFixed(2);
            array_point_y[pdf_num][num] = pointY.toFixed(2);
            console.log(array_no[pdf_num][num]);
            console.log(array_no[pdf_num]);
            console.log(array_point_name[pdf_num][num]);
            console.log(array_point_name[pdf_num]);
            console.log(array_page[pdf_num][num]);
            console.log(array_point_x[pdf_num][num]);
            console.log(array_point_y[pdf_num][num]);
            console.log(cell1);
            

            cell1.push(row.insertCell(-1));
            cell2.push(row.insertCell(-1));
            cell3.push(row.insertCell(-1));
            cell4.push(row.insertCell(-1));
            cell5.push(row.insertCell(-1));
            cell6.push(row.insertCell(-1));
            cell1[tabLength-1].innerHTML = array_no[pdf_num][tabLength-1];
            cell2[tabLength-1].innerHTML = array_point_name[pdf_num][num];
            cell3[tabLength-1].innerHTML = array_page[pdf_num][num];
            cell4[tabLength-1].innerHTML = array_point_x[pdf_num][num];
            cell5[tabLength-1].innerHTML = array_point_y[pdf_num][num];
            cell6[tabLength-1].innerHTML = '<input type = "button" value = "削除" onClick= "deleteRow(this)" />';            
        }else{

        }
            //console.log(table);
        }, false);
    </script>

    <script>

        function deleteRow(obj) {
        // 削除ボタンを押下された行を取得
        tr = obj.parentNode.parentNode;
        console.log(tr.cells[0].innerHTML);
        // trのインデックスを取得して行を削除する
        tr.parentNode.deleteRow(tr.sectionRowIndex);
        //Noの変更
        var tableTarget = document.getElementById('place_info');
        for(var i = 1; i < tableTarget.rows.length; i++){
            tableTarget.rows[i].cells[0].innerHTML = i;
        }
        
        //配列から施工箇所、ページ、X座標、Y座標を削除
        array_point_name[pdf_num].splice(tr.cells[0].innerHTML-1,1);
        array_point_x[pdf_num].splice(tr.cells[0].innerHTML-1,1);
        array_point_y[pdf_num].splice(tr.cells[0].innerHTML-1,1);
        array_page[pdf_num].splice(tr.cells[0].innerHTML-1,1);
        //cell情報を整形する
        cell1.splice(tr.cells[0].innerHTML-1,1);
        cell2.splice(tr.cells[0].innerHTML-1,1);
        cell3.splice(tr.cells[0].innerHTML-1,1);
        cell4.splice(tr.cells[0].innerHTML-1,1);
        cell5.splice(tr.cells[0].innerHTML-1,1);
        cell6.splice(tr.cells[0].innerHTML-1,1);

        //マークを削除
        //var dldiv = document.getElementById('div').children;
        var dldiv = document.getElementById('div').children;
        var dl = dldiv.item(parseInt(tr.cells[0].innerHTML));
        dl.parentNode.removeChild(dl);
        
        }

        function ent(){
            for(var i = 0; i < array_point_name.length; i++){
                if(array_point_name[i][0] == null){

                }else{
                    
            fd = new FormData();
            fd.append('file_name', array_file_name[i]);
            fd.append('array_point_name', array_point_name[i]);
            fd.append('pointx',array_point_x[i]);
            fd.append('pointy', array_point_y[i]);
            fd.append('page', array_page[i]);
            console.log(fd);
            xhttpreq = new XMLHttpRequest();
            xhttpreq.onreadystatechange = function() {
                if (xhttpreq.readyState == 4 && xhttpreq.status == 200) {
                    alert(xhttpreq.responseText);
                }
            };
            xhttpreq.open("POST", "update_report_place_info.php", true);
            xhttpreq.addEventListener('load', (event) => {
                //window.location.href = 'mypage.php';
            });
            xhttpreq.send(fd);
                    console.log(array_no[i]);
            
                    console.log(array_point_name[i]);
            
                    console.log(array_point_x[i]);
            
                    console.log(array_point_y[i]);
            
                    console.log(array_page[i]);
                }
                
            }
            
            }

            function getPic(obj){
            //PDF変更時の処理
            pdf_num = obj.id;
            console.log(pdf_num);
            
            //テーブル削除
            var deltable = document.getElementById('place_info');
            var deltabLength = deltable.rows.length;
            dltabLength = deltabLength-1;
            //console.log(deltabLength);
            for(var n = deltabLength-1; n > 0; n--){
                deltable.deleteRow(n);
                //tableTarget.rows[i].cells[0].innerHTML = i;
            }
            //配列の初期化
            cell1 = [];
            cell2 = [];
            cell3 = [];
            cell4 = [];
            cell5 = [];
            cell6 = [];

            //マーク削除
            var dldiv = document.getElementById('div').children;
            var dllength = dldiv.length;
            //console.log(dldiv);
            //console.log(dllength);
            for(var m = 0; m < dllength; m++){
                //console.log(m);
                //console.log(dldiv.item(m));
                if(dldiv.item(m).id =="pic"){
                    //var iL = dldiv.item(m).length:
                    //console.log(iL);
                    
                    //console.log("del");
                    var dl = dldiv.item(m);
                    dl.parentNode.removeChild(dl);
                    m--;
                    dllength--;
                }
            }
            
            var target_name = obj.value;
            document.getElementById('selectedPDF').innerHTML = target_name;
            var index = array_file_name.indexOf(target_name);
            //console.log(index);
            pageNum = 0;
            p.innerHTML = pageNum + 1 + "ページ / ";
            //ページ数に挿入
            ps.innerHTML = globNum[index] + "ページ";
            //画像を表示
            selected_img = target_name.substr(0, target_name.length -4);
            //selected_img_name = "./up/" + change + "/" + change + "-0.png";
            //var first_img = "./up/sample/sample-0.png";
            selected_img_name = "./up/" + selected_img + "/" + selected_img +"-0.png";
            img.src = selected_img_name;

            //配列に持っている情報を取得→持っていた場合テーブルに記入
            //配列にある要素の数を取得
            var table_array_num = array_no[pdf_num].length;
            //console.log(table_array_num);
            //要素の数だけテーブルを追加
            var table = document.getElementById('place_info');
            for(var l = 0; l < table_array_num; l++){
                var row = table.insertRow(-1);
                cell1.push(row.insertCell(-1));
            cell2.push(row.insertCell(-1));
            cell3.push(row.insertCell(-1));
            cell4.push(row.insertCell(-1));
            cell5.push(row.insertCell(-1));
            cell6.push(row.insertCell(-1));
            cell1[l].innerHTML = l + 1;
            cell2[l].innerHTML = array_point_name[pdf_num][l];
            cell3[l].innerHTML = array_page[pdf_num][l];
            cell4[l].innerHTML = array_point_x[pdf_num][l];
            cell5[l].innerHTML = array_point_y[pdf_num][l];
            cell6[l].innerHTML = '<input type = "button" value = "削除" onClick= "deleteRow(this)" />'; 
            }
            
            /*
            //1ページ目のマークを表示
            //テーブルの値を確認→ページに該当するものが存在した場合、表示
            var checktable = document.getElementById('place_info');
            var checkLength = checktable.rows.length;
            for(var c = 1; c < checkLength; c++){
                if(checktable.rows[c].cells[2].innerHTML == pageNum+1){
                    //console.log(checktable.rows[c].cells[3].innerHTML)
                    var cBall = document.createElement('d'); 
                    cBall.id = "pic";
                    cBall.style.position = "absolute";
                    //マーク位置の計算
                    //画像表示位置の取得
                    var elem = document.getElementById('im');
                    var rect = elem.getBoundingClientRect();
                    var elemtop = rect.top + window.pageYOffset;
                    var elemleft = rect.left + window.pageXOffset;
                    var eTop = parseInt(elemtop);
                    var eLeft = parseInt(elemleft);
            
                    //画像サイズ
                    var w = elem.width;
                    var w1 = parseInt(w);
                    var h = elem.height;
                    var h1 = parseInt(h);
                    
                    //画面サイズから表示位置を取得
                    var pointx = parseFloat(checktable.rows[c].cells[3].innerHTML);
                    var pointy = parseFloat(checktable.rows[c].cells[4].innerHTML);

                    //画像上のクリック地点
                    var drop_pointx = parseInt(pointx*w1) + eLeft;
                    var drop_pointy = parseInt(pointy*h1) + eTop;

                    var RandLeft = drop_pointx + "px";
                    var RandTop = drop_pointy + "px";
                    cBall.style.left = RandLeft;
                    cBall.style.top = RandTop;
                    var mark = document.createElement('img');
                    //mark.id = tabLength;
                    mark.value = checktable.rows[c].cells[1].innerHTML;
                    mark.src = "http://10.20.170.52/web/local_pic.png";
                    mark.addEventListener('click', function(event2){
                    var bef_change = this.value;
                    var placeValue = window.prompt("施工箇所名変更", this.value);
                    if(placeValue == bef_change){

                    }else if(placeValue == null){

                    }
                    else{
                        var checktable = document.getElementById('place_info');
                        var checkLength = checktable.rows.length;
                        for(var c = 1; c < checkLength; c++){
                        if(checktable.rows[c].cells[1].innerHTML == bef_change){
                        checktable.rows[c].cells[1].innerHTML = placeValue;
                        array_point_name[pdf_num][c-1] = placeValue;
                        //console.log(array_point_name[pdf_num][c-1]);
                        //console.log(placeValue);
                    }
                }
                }
            });
                    //Divにイメージを組み込む
                    cBall.appendChild(mark);
                    //画面にDivを組み込む
                    div.appendChild(cBall);
                }
            }*/
            
        }
    </script>
    </body>

</html>