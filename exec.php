<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<?php
$dir= '.\up\dir';
mkdir($dir, 0777);
$file = '\lowcarbon05.pdf';
$path = 'D:\Bitnami\htdocs\web\up';
$out = 'D:\Bitnami\htdocs\web\hoge.png';
$pdf = $path.$file;
//$out .= 'hoge.png';
echo $pdf;
echo $out;
//$cmd = 'D:\ImageMagick-7.0.10-Q16\convert.exe D:\Bitnami\htdocs\web\lowcarbon05.pdf D:\Bitnami\htdocs\web\hoge.jpg';
$cmd = 'D:\ImageMagick-7.0.10-Q16\convert.exe'.' '.$pdf.' '.$out;
//echo $cmd;
//exec($cmd);
//$outfile = 'out.png';*/
?>