<?php
	class ProblemAction extends Action{

		public function insert(){
			$Problem   =   D('Problem');
			if($Problem->create()) {
				$result =   $Problem->add();
				if($result) {
					file_put_contents("goj/Common/stdio/tmp.in",$_POST["inputData"]);
					exec("tr -d '\r' </var/www/html/goj/Common/stdio/tmp.in> /var/www/html/goj/Common/stdio/$result.in");
					file_put_contents("goj/Common/stdio/tmp.out",$_POST["outputData"]);
					exec("tr -d '\r' </var/www/html/goj/Common/stdio/tmp.out> /var/www/html/goj/Common/stdio/$result.out");

                            		//超时数据
                                        file_put_contents("goj/Common/stdio/time/tmp.in",$_POST["timeinputData"]);
                                        exec("tr -d '\r' </var/www/html/goj/Common/stdio/time/tmp.in> /var/www/html/goj/Common/stdio/time/$result.in");
                                        file_put_contents("goj/Common/stdio/time/tmp.out",$_POST["timeoutputData"]);
                                        exec("tr -d '\r' </var/www/html/goj/Common/stdio/time/tmp.out> /var/www/html/goj/Common/stdio/time/$result.out");
					$this->success('操作成功！');
             			}else{
                 			$this->error('写入错误！');
             			}
         		}else{
             			$this->error($Problem->getError());
         		}
     		}
		public function add($img=0){
			if($img!=0){
			$data['img']='<img src=../Public/Uploads/'.$img.'.jpg ></img>';
				$this->vo=$data;
			}
			$this->display();	
		}
		public function edit($id=1000,$img=0){
			$Problem   =   M('Problem');
			$in = file_get_contents("goj/Common/stdio/$id.in");
			$out = file_get_contents("goj/Common/stdio/$id.out");
                        $intime = file_get_contents("goj/Common/stdio/time/$id.in");
                        $outtime = file_get_contents("goj/Common/stdio/time/$id.out");
			$data  =  $Problem->find($id);
			$data['inputData']=$in;
			$data['outputData']=$out;
                        $data['timeinputData']=$intime;
                        $data['timeoutputData']=$outtime;
			if($img!=0){
                        	$data['img']='<img src=../Public/Uploads/'.$img.'.jpg ></img>';
                        }
			$this->vo = $data;
			$this->display();
		}


		public function update(){
			$Problem   =   D('Problem');
			if($Problem->create()) {
				$result =   $Problem->save();
				if($result) {
					//标准数据
					file_put_contents("goj/Common/stdio/tmp.in",$_POST["inputData"]);
					exec("tr -d '\r' </var/www/html/goj/Common/stdio/tmp.in> /var/www/html/goj/Common/stdio/".$_POST['problem_id'].".in");
                                        file_put_contents("goj/Common/stdio/tmp.out",$_POST["outputData"]);
					exec("tr -d '\r' </var/www/html/goj/Common/stdio/tmp.out> /var/www/html/goj/Common/stdio/".$_POST['problem_id'].".out");

					//超时数据
                                        file_put_contents("goj/Common/stdio/time/tmp.in",$_POST["timeinputData"]);
                                        exec("tr -d '\r' </var/www/html/goj/Common/stdio/time/tmp.in> /var/www/html/goj/Common/stdio/time/".$_POST['problem_id'].".in");
                                        file_put_contents("goj/Common/stdio/time/tmp.out",$_POST["timeoutputData"]);
                                        exec("tr -d '\r' </var/www/html/goj/Common/stdio/time/tmp.out> /var/www/html/goj/Common/stdio/time/".$_POST['problem_id'].".out");
					$this->success('操作成功！');
         			}else{
             				$this->error('写入错误！');
         			}
			}else{
         			$this->error($Problem->getError());
     			}
		}
		public function read($id=1000){
     			$Problem   =   M('Problem');
     			// 读取数据
     			$data =   $Problem->find($id);
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
		public function readList(){
                        $Problem   =   M('Problem');
                        // 读取数据
			$count=$Problem->count();
                        import('ORG.Util.Page');// 导入分页类
                        $Page       = new Page($count,50);// 实例化分页类 传入总记录数和每页记录数
                        $show       = $Page->show();// 分页显示输出
                        // 进行分页数据查询
                        $list = $Problem->order('problem_id')->limit($Page->firstRow.','.$Page->listRows)->select();
                        if($list) {
                        	$LUser =cookie('account');
                        	$LNick_name=cookie('nickname');
                        	if($LUser!=null&&LNick_name!=null){
                        	        $user =M('user');
                        	        $userinfo = $user->where("account ='$LUser'")->find();
                        	        $strsol=$userinfo['solvedP'];
					$strunsol=$userinfo['unsolvedP'];
					for($i=0;$i<50;$i++){
						if(!(strpos($strunsol,$list[$i]['problem_id'])===false))
                                                        $list[$i]['isSolved']="<img src='../Public/unsolved.gif'> </img>";
						if(!(strpos($strsol,$list[$i]['problem_id'])===false))
							$list[$i]['isSolved']="<img src='../Public/solved.png'> </img>";
						
					}
                        	}
                        }else{
                                $this->error('数据错误');
                        }
                        $this->assign('list',$list);// 赋值数据集
                        $this->assign('page',$show);// 赋值分页输出
                        $this->assign('nowcount',$Page->firstRow);
                        $this->display();
		}
		public function submit($id=1000){
			$data['id']=$id;	
			$this->data=$data;
			$this->display();
		}
		public function submitCode(){
			$LUser =cookie('account');
			$LNick_name=cookie('nickname');
			if($LUser==null||LNick_name==null)
				$this->error('请先登录','__APP__/User/Login');
			$codeL=file_put_contents("goj/Common/u/$LUser/".$_POST["problem_id"].".cpp",$_POST["code"]);
			$Statu = D('Statu');
			$Statu->problem_id =$_POST["problem_id"];
			$Statu->user =$LUser;
			$Statu->nick_name=$LNick_name;
			$Statu->lang =$_POST["lang"];
			$Statu->codeL=$codeL;
			$result =   $Statu->add();
                                if($result) {
                                        $this->success('操作成功！','http://acm.gdufe.edu.cn/Statu/readList');
                                }else{
                                        $this->error('写入错误！'.$LUser." 3".$LNick_name);
                                }
        	}
 	}
?>
