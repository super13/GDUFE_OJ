<?php
	class ConproAction extends Action{
		
		public function insert(){
                        $LUser =cookie('account');
                        $LNick_name=cookie('nickname');
                        if($LUser==null||LNick_name==null)
                                $this->error('请先登录','__APP__/User/Login');
                        else if($LUser!='TestA')
                                $this->error('非管理员,无权限访问！','__APP__');
			$Conpro   =   D('Conpro');
			if($Conpro->create()) {
				$result =   $Conpro->add();
				if($result) {
                                        file_put_contents("goj/Common/contest/".$_POST['cid']."/stdio/tmp.in",$_POST["inputData"]);
                                        exec("tr -d '\r' </var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/tmp.in> /var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/".$_POST['pid'].".in");
                                        file_put_contents("goj/Common/contest/".$_POST['cid']."/stdio/tmp.out",$_POST["outputData"]);
                                        exec("tr -d '\r' </var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/tmp.out> /var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/".$_POST['pid'].".out");
                                      	//测试超时数据
					file_put_contents("goj/Common/contest/".$_POST['cid']."/stdio/time/tmp.in",$_POST["timeinputData"]);
                                        exec("tr -d '\r' </var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/time/tmp.in> /var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/time/".$_POST['pid'].".in");
                                        file_put_contents("goj/Common/contest/".$_POST['cid']."/stdio/time/tmp.out",$_POST["timeoutputData"]);
                                        exec("tr -d '\r' </var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/time/tmp.out> /var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/time/".$_POST['pid'].".out");
					$this->success('操作成功！');
             			}else{
                 			$this->error('写入错误！');
             			}
         		}else{
             			$this->error($Conpro->getError());
         		}
     		}
                public function add($img=0){
                        $LUser =cookie('account');
                        $LNick_name=cookie('nickname');
                        if($LUser==null||LNick_name==null)
                                $this->error('请先登录','__APP__/User/Login');
                        else if($LUser!='TestA')
                                $this->error('非管理员,无权限访问！','__APP__');
                        if($img!=0){
                        $data['img']='<img src=../Public/Uploads/'.$img.'.jpg ></img>';
                                $this->vo=$data;
                        }
                        $this->display();
                }
		public function edit($cid=100000,$pid=1000,$img=0){
			$LUser =cookie('account');
                        $LNick_name=cookie('nickname');
                        if($LUser==null||LNick_name==null)
                                $this->error('请先登录','__APP__/User/Login');
			else if($LUser!='TestA')
				$this->error('非管理员,无权限访问！','__APP__');
			$Conpro   =   M('Conpro');
			$data  =  $Conpro->where("cid=%d and pid=%d",$cid,$pid)->find();
			$in = file_get_contents("goj/Common/contest/$cid/stdio/$pid.in");
			$out = file_get_contents("goj/Common/contest/$cid/stdio/$pid.out");
                        $timein = file_get_contents("goj/Common/contest/$cid/stdio/time/$pid.in");
                        $timeout = file_get_contents("goj/Common/contest/$cid/stdio/time/$pid.out");
			$data['inputData']=$in;
			$data['outputData']=$out;
                  	$data['timeinputData']=$timein;
                        $data['timeoutputData']=$timeout;
			if($img!=0){
                        	$data['img']='<img src=../Public/Uploads/'.$img.'.jpg ></img>';
                        }
			$this->vo = $data;
			$this->display();
		}
                public function CopyToPro($cid=100000,$pid=1000){
                        $Conpro   =   M('Conpro');
                        $data  =  $Conpro->where("cid=%d and pid=%d",$cid,$pid)->find();
                        $in = file_get_contents("goj/Common/contest/$cid/stdio/$pid.in");
                        $out = file_get_contents("goj/Common/contest/$cid/stdio/$pid.out");
                        $tin = file_get_contents("goj/Common/contest/$cid/stdio/time/$pid.in");
                        $tout = file_get_contents("goj/Common/contest/$cid/stdio/time/$pid.out");

			
			$Problem =D('Problem');
                        $result =   $Problem->add($data);
                        if($result) {
                       		file_put_contents("goj/Common/stdio/tmp.in",$in);
                               	exec("tr -d '\r' </var/www/html/goj/Common/stdio/tmp.in> /var/www/html/goj/Common/stdio/$result.in");
                              	file_put_contents("goj/Common/stdio/tmp.out",$out);
                      		exec("tr -d '\r' </var/www/html/goj/Common/stdio/tmp.out> /var/www/html/goj/Common/stdio/$result.out");
                               
				//测试超时数据
				file_put_contents("goj/Common/stdio/time/tmp.in",$tin);
                                exec("tr -d '\r' </var/www/html/goj/Common/stdio/time/tmp.in> /var/www/html/goj/Common/stdio/time/$result.in");
                                file_put_contents("goj/Common/stdio/time/tmp.out",$tout);
                                exec("tr -d '\r' </var/www/html/goj/Common/stdio/time/tmp.out> /var/www/html/goj/Common/stdio/time/$result.out");
                     		$this->assign("jumpUrl","__APP__/Contest/Admin");
				$this->success('操作成功！');
                      	}else{
				$this->assign("jumpUrl","__APP__/Contest/Admin");
                            	$this->error('写入错误！');
                    	}
                }


		public function update(){
			$Conpro   =   D('Conpro');
			if($Conpro->create()) {
				$result =   $Conpro->save();
				if($result) {
					file_put_contents("goj/Common/contest/".$_POST['cid']."/stdio/tmp.in",$_POST["inputData"]);
					exec("tr -d '\r' </var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/tmp.in> /var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/".$_POST['pid'].".in");
                                        file_put_contents("goj/Common/contest/".$_POST['cid']."/stdio/tmp.out",$_POST["outputData"]);
					exec("tr -d '\r' </var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/tmp.out> /var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/".$_POST['pid'].".out");

					//测试超时数据
                                        file_put_contents("goj/Common/contest/".$_POST['cid']."/stdio/time/tmp.in",$_POST["timeinputData"]);
                                        exec("tr -d '\r' </var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/time/tmp.in> /var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/time/".$_POST['pid'].".in");
                                        file_put_contents("goj/Common/contest/".$_POST['cid']."/stdio/time/tmp.out",$_POST["timeoutputData"]);
                                        exec("tr -d '\r' </var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/time/tmp.out> /var/www/html/goj/Common/contest/".$_POST['cid']."/stdio/time/".$_POST['pid'].".out");
					$this->success('操作成功！');
         			}else{
             				$this->error('写入错误！');
         			}
			}else{
         			$this->error($Problem->getError());
     			}
		}
		public function read($pid=1000,$cid=100004){
                        $Contest = M('Contest');
                        $contest =$Contest->find($cid);
                        $time1=$contest['start_time'];
                        $now=date("y-m-d h:i:s a",time());
                        if(strtotime($now)<strtotime($time1))
                                $this->error('比赛时间未到，请耐心等候！');
     			$Conpro   =   M('Conpro');
     			// 读取数据
			$data = $Conpro->where("pid=%d and cid=%d",array($pid,$cid))->find();
    			 if($data) {
				$data['input']=htmlspecialchars($data['input']);
				$data['output']=htmlspecialchars($data['output']);
				$data['spInput']=htmlspecialchars($data['spInput']);
				$data['spOutput']=htmlspecialchars($data['spOutput']);
        			$this->data =   $data;// 模板变量赋值
     			}else{
         			$this->error('数据错误');
     			}
     				$this->display();
 		}
		public function readList($cid=100000){
			$Contest = M('Contest');
			$contest =$Contest->find($cid);
			$time1=$contest['start_time'];
			$time2=$contest['end_time'];
			$now=date("y-m-d h:i:s a",time());
			//echo $now;
			if(strtotime($now)<strtotime($time1))
				$this->error("比赛时间未到，请耐心等候！");
			else
				if(strtotime($now)>strtotime($time1)&&strtotime($now)<strtotime($time2)){
					if($contest['status']!="Running"){
						$contest['status']="Running";
						$Contest->save($contest);
					}
				}else{
					if(strtotime($now)>strtotime($time2)){
                                		if($contest['status']!="Ended"){
                                        		$contest['status']="Ended";
                                        		$Contest->save($contest);
                                	}
                        	}
				}


			
                        $LUser =cookie('account');
                        $LNick_name=cookie('nickname');
                        if($LUser==null||LNick_name==null)
                                $this->error('请先登录','__APP__/User/Login');
			else{
				$Crank   =   D('Crank');
				$data = $Crank->where("user='%s' and cid=%d",array($LUser,$cid))->find();
				if(!$data){
					$Crank->cid=$cid;
					$Crank->user=$LUser;
					$Crank->team=$LNick_name;
					$Crank->solved=0;
					$Crank->penatly=0;
					$Crank->problems="";
					$Crank->add();
				}else{
					if($data['team']!=$LNick_name){
						$data['team']=$LNick_name;
						$Crank->where("user='%s' and cid=%d",array($LUser,$cid))->save($data);
					}
				}
				
			}
                        $Conpro   =   M('Conpro');
			$count=$Conpro->where("cid=%d",$cid)->count();
                        // 读取数据
                        $data =   $Conpro->where("cid=%d",$cid)->order('pid')->select();
			$this->assign('cid',$cid);
                        if($data) {
                                        $crank =M('Crank');
                                        $userinfo = $crank->where("user ='$LUser' and cid=$cid")->find();
                                        $strsol=$userinfo['solvedP'];
                                        $strunsol=$userinfo['unsolvedP'];
                                        for($i=0;$i<$count;$i++){
                                                if(!(strpos($strunsol,$data[$i]['pid'])===false))
                                                        $data[$i]['isSolved']="<img src='../Public/unsolved.png'> </img>";
                                                if(!(strpos($strsol,$data[$i]['pid'])===false))
                                                        $data[$i]['isSolved']="<img src='../Public/solved.png'> </img>";

                                        }
                                $this->data =   $data;// 模板变量赋值
                        }else{
                                $this->error('数据错误');
                        }
                                $this->display();
		}

                public function statistics($cid=100000){
                        $Conpro   =   M('Conpro');
                        // 读取数据
                        $data =   $Conpro->where("cid=%d",$cid)->order('pid')->select();
                        $this->assign('cid',$cid);
                        if($data) {
                                $this->data =   $data;// 模板变量赋值
                        }else{
                                $this->error('数据错误');
                        }
                                $this->display();
                }
		public function submit($pid=1000,$cid=100000){
			$data['pid']=$pid;	
			$data['cid']=$cid;
			$this->data=$data;
			$this->display();
		}
		public function submitCode(){
                        $Contest = M('Contest');
                        $contest =$Contest->find($_POST['cid']);
                        $time1=$contest['start_time'];
			$time2=$contest['end_time'];
                        $now=date("y-m-d h:i:s a",time());
                        if(strtotime($now)<strtotime($time1)||strtotime($now)>strtotime($time2))
                                $this->error('不在比赛时间段，无法提交代码！');
			$LUser =cookie('account');
			$LNick_name=cookie('nickname');
			if($LUser==null||LNick_name==null)
				$this->error('请先登录','__APP__/User/Login');
			mkdir   ("/var/www/html/goj/Common/contest/".$_POST['cid']."/u/$LUser",0777);
			$codeL=file_put_contents("goj/Common/contest/".$_POST['cid']."/u/$LUser/".$_POST["pid"].".cpp",$_POST["code"]);
			$Cstatu = D('Cstatu');
			$Cstatu->problem_id =$_POST["pid"];
			$Cstatu->cid=$_POST['cid'];
			$Cstatu->user =$LUser;
			$Cstatu->nick_name=$LNick_name;
			$Cstatu->lang =$_POST["lang"];
			$Cstatu->codeL=$codeL;
			$result =   $Cstatu->add();
                                if($result) {
                                        $this->success('操作成功！','http://222.202.171.23/Cstatu/readList/cid/'.$_POST{'cid'});
                                }else{
                                        $this->error('写入错误！');
                                }
        	}
 	}
?>
