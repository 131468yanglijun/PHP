<?php 
/**
* 图片抓取curl demo
* @author:yanglijun
* @data:2016-07-26
*
*/
header("Content-type: text/html; charset=utf-8");
class image_grab_demo2
{
	/**
	* 将图片读入字符串中
	* @param:[string] $url:包含图片url地址
	* @return:[string] 包含图片的所有信息的字符串
	*/
 	public function curlResouce($url)
 	{
 		$ch = curl_init();//开启会话
		curl_setopt($ch, CURLOPT_URL, $url);//请求路径
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//禁止服务器进行证书认证
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);//不检查证书
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//显示输出结果
		curl_setopt($ch, CURLOPT_POST, FALSE);//post传输数据
		curl_setopt($ch, CURLOPT_POSTFIELDS, '');//传递参数
		$response = curl_exec($ch);//执行并返回结果
		curl_close($ch);
		if(empty($response))
		{
			exit('抓取失败');
		}else
		{
			return $response;
		}
 	}
 	/**
    * 单张图片抓取
    * @param:[string] 图片路径
    * @return:[int] 返回写入到文件内数据的字节数
    */
    public function downloadImg($imgurl)
 	{
 		//函数以数组的形式返回文件路径的信息
	    $imginfo = pathinfo($imgurl);
	    $imgpath = IMG_PATH.$imginfo['basename'];
	    //验证图片是否存在
	    if(file_exists($imgpath))
	    {
	      return false;
	    }
	    //将图片读入字符串中
	    $imgdata = $this->curlResouce($imgurl);
	    //把字符串写入文件中
	    $imgres = file_put_contents($imgpath, $imgdata);
	    if(empty($imgres))
	    {
	      exit('生成失败');
	    }else
	    {
	      return true;
	    }
 	}

}
//要抓取的包含图片信息的页面地址
$url="http://www.48tu.cn/st/pic_20686.html"; 
$imageGrab = new image_grab_demo2();
//定义图片保存路径
define("IMG_PATH","/home/www/test/img/");	
//将页面地址写进字符串
$str = $imageGrab->curlResouce($url);
//正则匹配图片路径，将匹配到的信息放入数组array中
$pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/"; 
preg_match_all($pattern,$str,$array,PREG_PATTERN_ORDER); 
//正则匹配图片路径，如果该页面使用了延时加载机制，这里换成data-original属性
//preg_match_all("|<img[^>]+data-original=['\" ]?([^ '\"?]+)['\" >]|U",$str,$array,PREG_SET_ORDER);	
$k = 0;
//遍历图片路径，$value[1]为我们所要下载图片的路径
foreach ($array[1] as $key => $value)
{
	//单张图片抓取
	$res = $imageGrab->downloadImg($value);
	if($res == true)
	{
		$k++;
	}	
}
echo "成功抓取的图片张数为: $k";
?>