<?php
if($_FILES["image_file"]["tmp_name"][0]){

$num = count($_FILES["image_file"]["name"]);
for($i=0; $i<$num; $i++){
    // 一時アップロード先ファイルパス
$file_tmp  = $_FILES["image_file"]["tmp_name"][$i];

// 正式保存先ファイルパス
$file_save = "./up/" . $_FILES["image_file"]["name"][$i];

// ファイル移動
$result = @move_uploaded_file($file_tmp, $file_save);
if ( $result === true ) {
    echo "UPLOAD OK";
} else {
    echo "UPLOAD NG";
}

}
}


/*if(is_uploaded_file($_FILES["image_file[]"]["tmp_name"])){


    $uploaddir = "./up/";
    $uploadfile = $uploaddir . basename($_FILES['image_file']['name'][0]);
    
    echo '<pre>';
    if (move_uploaded_file($_FILES['image_file']['tmp_name'][0], $uploadfile)) {
        echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Possible file upload attack!\n";
        print_r($uploadfile);
    }
    
    echo 'Here is some more debugging info:';
    print_r($_FILES);
    
    print "</pre>";
}
*/    
?>