<?php
/*
* desc:导出excel-demo-1
* author: yanglijun
* Create time:2016-05-12
*/
$host = 'localhost';//要链接的服务器
$username = 'common';//数据库用户名
$password = 'common';//数据库密码
$dbname = 'ljlj_members';//数据库
$charset = 'set names utf8';//设置字符集
//链接数据库
$con = mysql_connect($host,$username,$password) or die ('database connect failed');
//链接数据库
mysql_select_db($dbname,$con);
//设置字符集
mysql_query($charset);
$sqlCard =  "SELECT * FROM member_info_base limit 80";
$result = mysql_query($sqlCard);
$row = mysql_fetch_assoc($result);
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=excel测试.xls"); 
//输出内容如下：   
echo iconv("utf-8", "GB2312", "序号")."\t";
echo iconv("utf-8", "GB2312", "姓名")."\t";
echo iconv("utf-8", "GB2312", "电话")."\t"; 
echo iconv("utf-8", "GB2312", "生日")."\t";
echo iconv("utf-8", "GB2312", "地址")."\t";
echo iconv("utf-8", "GB2312", "qq")."\t";   
echo iconv("utf-8", "GB2312", "email")."\t";
echo iconv("utf-8", "GB2312", "wechat")."\t";
echo iconv("utf-8", "GB2312", "身份证号")."\t";
echo iconv("utf-8", "GB2312", "添加时间")."\t";
echo "\n"; 
$n = 1;

while($row = mysql_fetch_assoc($result)) 
{
    //输出表格内容
    echo $n."\t";
    echo iconv("utf-8", "GB2312", addslashes($row['real_name']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($row['photo_mob']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($row['birthday']))."\t"; 
    echo iconv("utf-8", "GB2312", addslashes($row['address']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($row['im_qq']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($row['email']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($row['wechat']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($row['idcard']))."\t";
    echo iconv("utf-8", "GB2312", addslashes($row['add_time']))."\t";
    echo "\n"; 
    $n++;
}

