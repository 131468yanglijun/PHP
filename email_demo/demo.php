<?php
/*
* php发送email邮件demo
* author:18610825625@163.com
* date: 2016-07-14
 */
header("Content-Type:text/html; charset=utf-8");
//设置发送文件
include 'email.class.php';//导入邮件发送类库
$smtpserver = "smtp.163.com";//SMTP服务器 
$smtpserverport = 25;//SMTP服务器端口 
$smtpusermail = "18610825625@163.com";//SMTP服务器的用户邮箱 
$smtpemailto = "903714303@qq.com";//发送给谁 
$smtpuser = "18610825625";//SMTP服务器的用户帐号 
$smtppass = "131468ylj";//SMTP服务器的用户密码，这里是邮箱客户端授权码，不是邮箱密码
$mailsubject = "测试邮件系统";//邮件主题 
$mailbody = "<h1> 这是一个测试程序 </h1>";//邮件内容 
$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件 
########################################## 
$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证. 
$smtp->debug = false;//是否显示发送的调试信息 
//发送邮件
$smtp_status = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype); 

if($smtp_status === true)
{
    echo '发送成功';
}else
{
    echo '发送失败';
} 
?>