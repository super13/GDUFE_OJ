<?php
        class ContestAction extends Action{
                public function insert(){
                        $Contest   =   D('Contest');
                        if($Contest->create()) {
                                $result =   $Contest->add();
                                if($result) {
					mkdir   ('/var/www/html/goj/Common/contest/'.$result,0777);
					mkdir   ('/var/www/html/goj/Common/contest/'.$result.'/stdio',0777);
					mkdir   ('/var/www/html/goj/Common/contest/'.$result.'/stdio/time',0777);
					mkdir   ('/var/www/html/goj/Common/contest/'.$result.'/u',0777);
					$this->assign("jumpUrl","__APP__/Conpro/add/");
                                        $this->success('操作成功！');
                                }else{
                                        $this->error('写入错误！');
                                }
                        }else{
                                $this->error($Contest->getError());
                        }
                }
                public function readList(){
			$Contest   =   M('Contest');
                        // 读取数据
                        $count=$Contest->count();
                        $data =   $Contest->order('contest_id desc')->select();
                        if($data) {
                                $this->data =   $data;// 模板变量赋值
                        }else{
                                $this->error('数据错误');
                        }
                                $this->display();
                }
		public function Admin(){
                        $LUser =cookie('account');
                        $LNick_name=cookie('nickname');
                        if($LUser==null||LNick_name==null)
                                $this->error('请先登录','__APP__/User/Login');
                        else if($LUser!='TestA')
                                $this->error('非管理员,无权限访问！','__APP__');
			$Contest   =   M('Contest');
                        // 读取数据
                        $count=$Contest->count();
                        $data =   $Contest->order('contest_id')->select();
                        if($data) {
                                $this->data =   $data;// 模板变量赋值
                        }else{
                                $this->error('数据错误');
                        }
			$this->display();
		}
        }
?>
