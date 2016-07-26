<?php 
/**
* 图片抓取file_get_contents demo
* @author:yanglijun
* @data:2016-07-26
*
*/
header("Content-type: text/html; charset=utf-8");
class image_grab_demo1
{
	/**
	* 将图片读入字符串中
	* @param:[string] $url:包含图片url地址
	* @return:[string] 包含图片的所有信息的字符串
	*/
	public function getsource($url)
    {
    	$str = @file_get_contents($url);
	    if(empty($str))
	    {
	      exit('抓取失败');
	    }else
	    {
	      return $str;
	    }
    }
    /**
    * 单张图片抓取
    * @param:[string] 图片路径
    * @return:[int] 返回写入到文件内数据的字节数
    */
    public function downloadImg($imgurl)
 	{
	    $imginfo = pathinfo($imgurl);
	    $imgpath = IMG_PATH.$imginfo['basename'];
	    if(file_exists($imgpath))
	    {
	      return false;
	    }
	    $imgdata = $this->getsource($imgurl);
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
 	$imageGrab = new image_grab_demo1();
 	//定义图片保存路径
	define("IMG_PATH","/home/www/test/img/");
	//要抓取的包含图片信息的页面地址
	$url = 'http://www.48tu.cn/st/pic_20686.html';
	//将页面地址写进字符串
	$str = $imageGrab->getsource($url);
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