<?php
        class UserAction extends Action{

                public function insert(){
			if(md5($_POST['verify'])!=$_SESSION['verify']){  
				$this->error('验证码错误！');  
			}
                        $User   =   D('User');
                        if($User->create()) {
                                $result =   $User->add();
                                if($result) {
					mkdir   ('/var/www/html/goj/Common/u/'.$_POST['account'],0777);
                                        $this->success('注册成功！',"__APP__/");
                                }else{
                                        $this->error('写入错误！');
                                }
                        }else{
                                $this->error($User->getError());
                        }
                }
		
		public function checkLogin(){
			$username = $_POST['account'];
			$passwd = $_POST['password'];
			$user = D("user");
			$userinfo = $user->where("account ='$username'")->find();
			if(!empty($userinfo)){
				if($userinfo['password'] == md5($passwd)){
					cookie('account',$userinfo['account'],3600*24); // 指定cookie保存时间
					cookie('nickname',$userinfo['nick_name'],3600*24);
					$this->assign("jumpUrl","__APP__/");
					$this->success('登陆成功！');

				}else{
					$this->assign("jumpUrl","__APP__/User/Login");
					$this->error("密码错误！登录失败！");
				}

			}else{
				$this->assign("jumpUrl","__APP__/User/Login");
				$this->error('用户名不存在！');
			}

		}


		public function logout(){
			if(cookie('account')!=null){
				cookie('account',null);
				cookie('nickname',null);
				$this->assign("jumpUrl","__APP__/");
				$this->success('您已经成功退出，欢迎您的下次登录！');
			}
			else{
				$this->error("请先登录！");
			}
		}

                public function readList(){
                        $User = M('User'); // 实例化Data数据对象
                        import('ORG.Util.Page');// 导入分页类
                        $count      = $User->count();// 查询满足要求的总记录数
                        $Page       = new Page($count,20);// 实例化分页类 传入总记录数和每页记录数
                        $show       = $Page->show();// 分页显示输出
                        // 进行分页数据查询
                        $list = $User->order('solvedC desc,submitedC')->limit($Page->firstRow.','.$Page->listRows)->select();
                        $this->assign('list',$list);// 赋值数据集
                        $this->assign('page',$show);// 赋值分页输出
			$this->assign('nowcount',$Page->firstRow);
                        $this->display(); // 输出模板
                }
		public function readStatu($name){
			$User =M('User');
			$user1=$User->where("nick_name='%s'",$name)->find();
			$arr=explode("|", $user1['solvedP']);
                        $count=count($arr);
			$str="";
                        for($i=0;$i<$count;$i++){
				$t=$arr[$i];
				$str=$str." "."<a href='http://acm.gdufe.edu.cn/Problem/read/id/".$t."'>".$t."</a>";
                        }
			$data['solvedP']=$str;
			$data['nick_name']=$user1['nick_name'];
			$data['solvedC']=$user1['solvedC'];
			$data['unsolvedP']=$user1['unsolvedP'];
			$data['submitedC']=$user1['submitedC'];
			$this->data=$data;		
			$this->display();
		}
                public function readMeSub(){
                        $User =M('User');
                        $LUser =cookie('account');
                        $LNick_name=cookie('nickname');
                        if($LUser==null||LNick_name==null)
                                $this->error('请先登录','__APP__/User/Login');
                        $user1=$User->where("account='%s'",$LUser)->find();
                        $arr=explode("|", $user1['solvedP']);
                        $count=count($arr);
                        $str="";
                        for($i=0;$i<$count;$i++){
                                $t=$arr[$i];
                                $str=$str." "."<a href='http://acm.gdufe.edu.cn/User/readCode/id/".$t."'>".$t."</a>";
                        }
                        $data['solvedP']=$str;
                        $data['nick_name']=$user1['nick_name'];
                        $data['solvedC']=$user1['solvedC'];
                        $data['unsolvedP']=$user1['unsolvedP'];
                        $data['submitedC']=$user1['submitedC'];

			$Contest   =   M('Contest');
                        // 读取数据
                        $count=$Contest->count();
                        $ct =   $Contest->order('contest_id')->select();
			$ctstr="";
			for($i=0;$i<$count;$i++){
				$ctstr=$ctstr."<a href='http://acm.gdufe.edu.cn/User/readCtList/cid/".$ct[$i]['contest_id']."'>".$ct[$i]['name']."</a></br>";
			}
			$data['contest']=$ctstr;
                        $this->data=$data;
                        $this->display();
                }
		public function readCtList($cid){
                       	$LUser =cookie('account');
                        $LNick_name=cookie('nickname');
                        if($LUser==null||LNick_name==null)
                                $this->error('请先登录','__APP__/User/Login');
			$Crank = M('Crank');
			$user1= $Crank->where("cid=%d and user='%s'",$cid,$LUser)->find();
			if($user1){
                      		$arr=explode("c", $user1['solvedP']);
                        	$count=count($arr);
                        	$str="";
                        	for($i=0;$i<$count;$i=$i+2){
                        	        $t=$arr[$i];
                        	        $str=$str." "."<a href='http://acm.gdufe.edu.cn/User/readCtCode/cid/$cid/pid/$t'>".$t."</a>";
                        	}
                        	$data['solvedP']=$str;
                        	$data['nick_name']=$user1['team'];
                        	$data['solvedC']=$user1['solvedC'];
                        	$data['unsolvedP']=$user1['unsolvedP'];
			}else{
				$this->error('貌似您没参赛！');
			}
			$this->data=$data;
			$this->display();
		}
		public function readCtCode($cid,$pid){
                        $LUser =cookie('account');
                        $LNick_name=cookie('nickname');
                        if($LUser==null||LNick_name==null)
                                $this->error('请先登录','__APP__/User/Login');
                        $code = file_get_contents("goj/Common/contest/$cid/u/$LUser/$pid.cpp");
                        $data['code']=htmlspecialchars($code);
                        $this->data=$data;
                        $this->display();
		}

		public function readCode($id){
                        $LUser =cookie('account');
                        $LNick_name=cookie('nickname');
                        if($LUser==null||LNick_name==null)
                                $this->error('请先登录','__APP__/User/Login');
			$code = file_get_contents("goj/Common/u/$LUser/$id.cpp");
			$data['code']=htmlspecialchars($code);
			$this->data=$data;
			$this->display();
		}
		public function Me(){
			$this->display();
		}

                public function update(){
                        $User   =   D('User');
                        $LUser =cookie('account');
                        $LNick_name=cookie('nickname');
                        if($LUser==null||LNick_name==null)
                                $this->error('请先登录','__APP__/User/Login');
                        if($User->create()) {
				$data['nick_name']=$_POST['nick_name'];
				$data['school']=$_POST['school'];
				$data['qq']=$_POST['qq'];
                                $result =   $User->where("account='%s'",$LUser)->save($data);
                                if($result) {
					cookie('nickname',$_POST['nick_name'],3600*24);	
                                        $this->success('操作成功！');
                                }else{
                                        $this->error('写入错误！');
                                }
                        }else{
                                $this->error($User->getError());
                        }
                }
		public function resetpass(){
                        $User   =   M('User');
      			$userinfo = $User->where("account ='%s' and qq ='%s'",array($_POST['account'],$_POST['qq']))->find();
                        if(!empty($userinfo)){
				$data['password']=md5($_POST['password']);
                                $result =   $User->where("account='%s'",$_POST['account'])->save($data);
                                $this->assign("jumpUrl","__APP__/");
				if($result) {
                                        $this->success('操作成功！');
                                }else{
                                        $this->error('写入错误！');
                                }

                        }else{
                               	$this->error("提供信息错误，修改失败！");
                        }
                }
                public function edit(){
                        $LUser =cookie('account');
                        $LNick_name=cookie('nickname');
                        if($LUser==null||LNick_name==null)
                                $this->error('请先登录','__APP__/User/Login');
                        $User   =   M('User');
                        // 读取数据
                        $data =   $User->where("account='%s'",$LUser)->find();
                         if($data) {
                                $this->data =   $data;// 模板变量赋值
                        }else{
                                $this->error('数据错误');
                        }
                                $this->display();
                }
	}
?>
