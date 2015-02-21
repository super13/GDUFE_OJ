<?php
class FeedbackAction extends Action {
    	public function index(){
		$this->display();//打开主页面
    	}
        public function insert(){
     	   $Feedback   =   D('Feedback');
       	 if($Feedback->create()) {
        	    $result =   $Feedback->add();
           	 if($result) {
          	      $this->success('操作成功！');
         	   }else{
        	        $this->error('写入错误！');
      	 	     }
      	  }else{
     	       $this->error($Feedback->getError());
       	 }
        }
	public function readlist(){
		$Feedback = M('Feedback');
		//读取数据
		$data = $Feedback->select();
		//赋值给模板数值data
		if($data){
			$this->data = $data;	
		}
		else{
			$this->error('数据出错');
		}
		$this->display();
	}	
	public function read($id){
		$Feedback = M('Feedback');
		$data = $Feedback->where("feedback_id = $id")->select();
		//赋值给模板参数
		if($data){
			$this->data = $data;
		}
		else{
			$this->error('数据出错');
		}
		$this->display();
	}
}
?>

