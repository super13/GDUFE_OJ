<?php
class UploadAction extends Action {
    	public function index($id=0){
		$this->display();//打开主页面
    	}
       // 文件上传
	public function edit($id=0){
              	$data['id']=$id;
                $this->vo = $data;
                $this->display();//打开主页面	
	}
     	public function upload($id=0) {
		import('ORG.Net.UploadFile');
             	$upload = new UploadFile();// 实例化上传类
              	$upload->maxSize  = 3145728 ;// 设置附件上传大小
               	$upload->allowExts  = array('jpg');// 设置附件上传类型
              	$upload->savePath =  '/var/www/html/goj/Tpl/Public/Uploads/';// 设置附件上传目录
		$name=time().'_'.mt_rand();
              	$upload->saveRule = $name;
              	if(!$upload->upload()) {// 上传错误提示错误信息
       			$this->error($upload->getErrorMsg());
            	}else{// 上传成功
			if($id==0)
                      		$this->success('上传成功！','http://222.202.171.23/Problem/add/img/'.$name);
			else 
				$this->success('上传成功！','http://222.202.171.23/Problem/edit/id/'.$id.'/img/'.$name);
       		}
   	}
}
