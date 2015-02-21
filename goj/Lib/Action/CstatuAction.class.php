<?php
        class CstatuAction extends Action{
		public function readList($cid=100000){
			$Statu = M('Cstatu'); // 实例化Data数据对象
     			import('ORG.Util.Page');// 导入分页类
 		    	$count      = $Statu->where("cid=$cid")->count();// 查询满足要求的总记录数
     			$Page       = new Page($count,20);// 实例化分页类 传入总记录数
     			$show       = $Page->show();// 分页显示输出
     			// 进行分页数据查询
     			$list = $Statu->where("cid=$cid")->order('cstatu_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			for($i=0;$i<20;$i++){
				if($list[$i]['result']=='Accepted!')
					$list[$i]['result']='<font color="#65a603">'.$list[$i]['result'].'</font>';
				else if($list[$i]['result']=='Wrong Answer!')
					$list[$i]['result']='<font color="#FF0000">'.$list[$i]['result'].'</font>';
				else if ($list[$i]['result']=='Time Limit Exceeded!')
                                        $list[$i]['result']='<font color="purple">'.$list[$i]['result'].'</font>';
				else if ($list[$i]['result']=='Presentation Error!')
                                        $list[$i]['result']='<font color="#ffb400">'.$list[$i]['result'].'</font>';
				else if ($list[$i]['result']=='Compilation Error')
                                        $list[$i]['result']="<a href=__APP__/Cstatu/readError/id/".$list[$i]['cstatu_id']."><font color='blue'>".$list[$i]['result'].'</font></a>';
			}
			$this->assign('cid',$cid);
     			$this->assign('list',$list);// 赋值数据集
     			$this->assign('page',$show);// 赋值分页输出
     			$this->display(); // 输出模板
		}
		public function readError($id=10000000){
			$errorLog = file_get_contents("goj/Common/contest/errorLog/$id.log");
			$this->assign('errorLog',$errorLog);
			$this->display();
	
		}
	}
?>
