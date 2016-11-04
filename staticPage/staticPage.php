<?php 
/*
* 生成静态页面方法
*
*/
/**
* 第一种
*/
// $out1 = "<div>
// 		    <p>The page you are looking at is being generated dynamically by CodeIgniter.</p>
// 	    	<p>If you would like to edit this page you'll find it located at:</p>
// 			<code>application/views/welcome_message.php</code>
// 	    </div>";
// $fp = fopen('test.html','w');
// if(!$fp)
// {
// 	echo 'error';
// }else
// {
// 	fwrite($fp, $out1);
// 	fclose($fp);
// 	echo 'success';
// }
// die;

/**
* 第二种
*/
header('content-type:text/html; charset=utf-8');//防止生成的页面乱码
$body = "动态生成静态HTML页面动态生成静态HTML页面动态生成静态HTML页面"; //定义变量
$url = "http://ljbll.loc/";
$temp_file = "temp.html"; //临时文件，也可以是模板文件
$dest_file = "dest_page.html"; //生成的目标页面
$fp = fopen($temp_file, "r"); //只读打开模板
$str = fread($fp, filesize($temp_file));//读取模板中内容
$str = str_replace("123", $body, $str);//替换内容
$str = str_replace("123", $url, $str);//替换内容
fclose($fp);
$handle = fopen($dest_file, "w"); //写入方式打开需要写入的文件
fwrite($handle, $str); //把刚才替换的内容写进生成的HTML文件
fclose($handle);//关闭打开的文件，释放文件指针和相关的缓冲区
echo "<script>alert('生成成功');window.location.href='".$dest_file."';</script>";
die;

?>