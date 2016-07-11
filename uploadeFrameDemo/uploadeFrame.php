<?php 
class UploadeFrame extends MY_Controller
{
	public function index()
	{
		$this->load->view('uploadeFrame.html');
	}
	/**
    * 图片上传
    */
    public function uploade()
    {
        $time = time();  
        $dir = IMG_MOBILE_PATH.'mobile/test/';
        $dirs = 'mobile/test/';
        if(!is_dir($dir))
        {
            mkdir($dir,0777,true);   
        }
        //上传图片到图片服务器目录下
        $config['upload_path'] = $dir;//上传图片地址
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2048';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $this->load->library('upload', $config);//初始化文件上传类
        $res = $this->upload->do_upload('img');
        if($res == true)
        {
            $data=$this->upload->data();//返回上传图片的信息 
            $proportion = $data['image_width']/$data['image_height'];//宽和高的比例，
            $round = round($proportion,2);//宽和高的比例，保留两位小数
            $height = $round * 400;//图片的高
            $this->load->library("image_lib");//载入图像处理类库 
            //生成400×300的大缩略图
            $config_thumb = array(  
                'image_library' => 'gd2',//gd2图库  
                'source_image' => $data['full_path'],//原图地址  
                'new_image' => $dir.'detail_'.$time.'.jpg',//缩略图  
                'create_thumb' => true,//是否创建缩略图  
                'maintain_ratio' => true,  
                'width' => 400,//缩略图宽度  
                'height' => $height,//缩略图的高度  
                'thumb_marker'=>""//缩略图名字后加上 "_300_300",可以代表是一个300*300的缩略图  
            );  
            $this->image_lib->initialize($config_thumb);  
            $thumbImage = $this->image_lib->resize();//生成缩略图
            if($thumbImage == true)
            {
            	$this->session->set_userdata('imgInfo',array('source_image'=>$config_thumb['source_image']));
            	$this->delImg();
                //生成地址，给页面iframe返回
                $path = IMG_URL_MOBILE.$dirs.'detail_'.$time.'.jpg'; 
                ?>
                <!DOCTYPE html>
                <html>
                <head>
                <meta name ="viewport" content= "initial-scale=1.0, user-scalable=no" >
                <meta http-equiv ="Content-type" content= "text/html;charset:utf-8" >
                <script type ="text/javascript" src= "/static/js/jquery-1.7.1.min.js"></script>
                </head>
                <body >
                <div id= "pic" style = "diplay:none;" ><?php echo $path; ?></div>
                </body>
                </html>
                <?php
            }
        }    
    }
	/**
	* 删除原图
    */
    private function delImg()
    {
        $imageInfo = $this->session->userdata('imgInfo'); //获取session信息
        if (!empty($imageInfo['source_image']))
        {
            unlink($imageInfo['source_image']);//删除原图地址
        }
    }     
}
?>