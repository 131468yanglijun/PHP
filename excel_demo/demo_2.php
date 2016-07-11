<?php
header("content-type:text/html;charset=utf-8");
/** Error reporting */
error_reporting(E_ALL);
/** PHPExcel */
include_once '/home/www/3732/Classes/PHPExcel.php';
 
/** PHPExcel_Writer_Excel2003用于创建xls文件 */
include_once '/home/www/3732/Classes/PHPExcel/Writer/Excel5.php';
 
// 创建新的excel对象
$objPHPExcel = new PHPExcel();
// 设置属性
$objPHPExcel->getProperties()->setCreator("李汉团");
$objPHPExcel->getProperties()->setLastModifiedBy("李汉团");
$objPHPExcel->getProperties()->setTitle("aaaaaaa");
$objPHPExcel->getProperties()->setSubject("bbbbbbbb");
$objPHPExcel->getProperties()->setDescription("ccccccccccccc");
 
// Add some data
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
$sqlCard =  "SELECT * FROM member_info_base limit 10";
$result = mysql_query($sqlCard);
$row = mysql_fetch_assoc($result);
$n = 1;
while($row = mysql_fetch_assoc($result)) 
{
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', '序号');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', '姓名');
	$objPHPExcel->getActiveSheet()->SetCellValue('C1', '电话');
	$objPHPExcel->getActiveSheet()->SetCellValue('D1', '生日');
	$objPHPExcel->getActiveSheet()->SetCellValue('E1', '地址');
	$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'qq');
	$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'email');

	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$n, $n);
	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$n, $row['real_name']);
	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$n, $row['photo_mob']);
	$objPHPExcel->getActiveSheet()->SetCellValue('D'.$n, $row['birthday']);
	$objPHPExcel->getActiveSheet()->SetCellValue('E'.$n, $row['address']);
	$objPHPExcel->getActiveSheet()->SetCellValue('F'.$n, $row['im_qq']);
	$objPHPExcel->getActiveSheet()->SetCellValue('G'.$n, $row['email']);
	$n++;
}
$objPHPExcel->getActiveSheet()->setTitle('Csat');
  
// Save Excel 2007 file
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
$objWriter->save(str_replace('.php', '.xls', __FILE__));
header("Pragma: public");
header("Expires: 0");
header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
header("Content-Type:application/force-download");
header("Content-Type:application/vnd.ms-execl");
header("Content-Type:application/octet-stream");
header("Content-Type:application/download");
header("Content-Disposition:attachment;filename=csat.xls");
header("Content-Transfer-Encoding:binary");
$objWriter->save("php://output");

?>