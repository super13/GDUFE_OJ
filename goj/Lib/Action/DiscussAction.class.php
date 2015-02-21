<?php
	class DiscussAction extends Action{
		public function post($problem_id=1000){
			$this->problem_id = $problem_id;
			$LNick_name = cookie('nickname');
			if($LNick_name==null){
                                $this->error('请先登录','__APP__/User/Login');
                        }
			$this->display();
		}
		//写入数据库
		public function post_insert($problem_id=1000){
			$LNick_name = cookie('nickname');
			$Discuss = D('Discuss');
			if($Discuss->create()){
				$Discuss->nick_name = $LNick_name;
			        $Discuss->problem_id = $problem_id;	
				$Discuss->rcount=0;
				$Discuss->pid = 0;
				$Discuss->isleaf = 1;
				$result = $Discuss->add();
				if($result){
					$this->success('发表成功!',"__APP__/Discuss/readList/problem_id/$problem_id");
				}else{
					$this->error('发表失败!');	
				}
			}else{
				$this->error($Discuss->getError());
			}
			
		}
		public function reply($problem_id=1000,$id=0){
                        $this->problem_id = $problem_id;
			$this->id = $id;
			$Discuss = D('Discuss');
			$ptitle = $Discuss->where("problem_id=%d AND id=%d",$problem_id,$id)->find();
			$Discuss->where("id=$id")->setField('rcount',rount+1);
			$this->ptitle =$ptitle['title'];
                        $LNick_name = cookie('nickname');
                        if($LNick_name==null){
                                $this->error('请先登录','__APP__/User/Login');
                        }
                        $this->display();
                }
		//回复的写入数据库
		public function reply_insert($problem_id=1000,$id=0){
			$LNick_name = cookie('nickname');
			$Discuss = D('Discuss');
			if($Discuss->create()){
				$Discuss->nick_name = $LNick_name;
                                $Discuss->pid = $id;
				$Discuss->problem_id = $problem_id;
                                $Discuss->rcount=0;
				$Discuss->isleaf = 1;
				$Discuss->where("id='$id'")->setField('isleaf','0');
                                $result = $Discuss->add();
                                if($result){
                                        $this->success('发表成功!',"__APP__/Discuss/read/problem_id/$problem_id/id/$id");
                                }else{
                                        $this->error('发表失败!');
                                }
                        }else{
                                $this->error($Discuss->getError());
			}
		}
                
		//根帖子展示
		public function readList($problem_id=1000){
			$Discuss = M('Discuss');
			$data = $Discuss->where("problem_id=$problem_id AND pid=0")->order('id')->select();
			//if($data){
			//	$this->data = $data;
			//}else{
			//	$this->error('数据错误');
			//}
			$this->count=$count;
			$this->data = $data;
			$this->problem_id = $problem_id;
			$this->display();
		} 
       		public function read($problem_id=1000,$id=0){
			$Discuss = D('Discuss');
                        $reply = $Discuss->where("problem_id=$problem_id AND pid=$id")->order('id')->select();
			$data = $Discuss->where("problem_id=$problem_id AND id=$id")->find();
                        if($data){
                              $this->data = $data;
                        }else{
			      $this->error('数据错误');
                        }
			$this->count = $count;
			$this->reply_data = $reply;
                        $this->problem_id = $problem_id;
                        $this->display();	
		}

	}	
?>
