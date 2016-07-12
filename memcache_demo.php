<?php 
class memcache_demo extends MY_Controller
{
	public function index()
	{
		//连接memcache
		$mem = new Memcache; 
		$mem->connect("127.0.0.1", 11211); 

		//保存数据 
		$mem->set('key1','this is first value','0',60);
		var_dump($mem->get('key1'));echo "<br />";

		//替换数据 
		$mem->replace('key1','this is replace value',0,60);
		var_dump($mem->get('key1'));echo '<br/>';

		//保存数组 
		$arr = array('aaa', 'bbb', 'ccc', 'ddd'); 
		$mem->set('key2', $arr, 0, 60); 
		var_dump($mem->get('key2'));echo "<br/>";

		//删除数据 
		$mem->delete('key1'); 
		var_dump($mem->get('key1')); echo '<br/>';

		//清除所有数据 
		$mem->flush(); 
		var_dump($mem->get('key2'));echo '<br/>';

		//返回服务器状态，成功返回服务器状态，服务器没有启动会返回0
		var_dump($mem->getServerStatus('127.0.0.1', 11211));echo '<br/>'; 
		
		//返回memcache的版本信息
		var_dump($mem->getVersion());echo '<br/>';

		//关闭连接 
		$mem->close(); 
	}
}
?>