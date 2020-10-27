<?php
if(isset($_POST['deleteFile'])){
$file_name = $_POST['deleteFile'];
// ディレクトリへのパス
$path = './up/';

// 変数の初期化
$result = false;

if( is_writable($path) ) {
	$result = unlink( $path.$file_name);
	
	if( $result ) {
		echo 'ファイルを削除しました。';
	} else {
		echo 'ファイルの削除に失敗しました。';
	}
}
}
return;