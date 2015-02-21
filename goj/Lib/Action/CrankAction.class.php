<?php
        class CrankAction extends Action{
			
                public function readList($cid=100001){
			$Conpro =M('Conpro');
			
			$proCount =$Conpro->where("cid=%d",$cid)->count();
			
			
                        $Crank = M('Crank'); // 实例化Data数据对象
                        import('ORG.Util.Page');// 导入分页类
                        $count      = $Crank->where("cid=%d",$cid)->count();// 查询满足要求的总记录数
                        $Page       = new Page($count,50);// 实例化分页类 传入总记录数和每页记录数
                        $show       = $Page->show();// 分页显示输出
                        // 进行分页数据查询
                        $list = $Crank->where("cid=$cid and user!='testA'")->order('solvedC desc,lastS+penatly')->limit($Page->firstRow.','.$Page->listRows)->select();
                      	for($i=0;$i<50;$i++){
				$strsol=$list[$i]['solvedP'];
                        	$strunsol=$list[$i]['unsolvedP'];
				$tds="";
				$t=1000;
				for($j=0;$j<$proCount;$j++){
					$flag=1;
					$temptd="";
                  			if(!(strpos($strunsol,strval($t))===false)){
                         			$temptd="<td style=' background-color:red;'>-".handleStr($strunsol,strval($t))."</td>";
						$flag=2;
					}
                         	      	if(!(strpos($strsol,strval($t))===false)){
                               			if($flag==2)
							$temptd="<td style='background-color:green;'>".handleStr($strsol,strval($t))."min\n(-".handleStr($strunsol,strval($t)).")</td>";
						else
							$temptd="<td style='background-color:green;'>".handleStr($strsol,strval($t))."min</td>";
						$flag=3;
						
					}
					$tds=$tds.$temptd;
					$t++;
					if($flag==1)
						$tds=$tds."<td></td>";
				}
				$list[$i]['tds']=$tds;
                        }
			$t=1000;
			$ths="";
			for($i=0;$i<$proCount;$i++){
				$ths=$ths."<th width=50>$t</th>";
				$t++;	
			}
			$this->assign('ths',$ths);
                        $this->assign('list',$list);// 赋值数据集
                        $this->assign('page',$show);// 赋值分页输出
			$this->assign('nowcount',$Page->firstRow);
			$this->assign('cid',$cid);
                        $this->display(); // 输出模板
                }
	}
?>
