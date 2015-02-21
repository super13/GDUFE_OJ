<?php
	class ConproModel extends Model {
     	// 定义自动验证
     	protected $_validate    =   array(
     	 	array('cid','require','比赛ID号必须'),
                array('pid','require','题目ID号必须'),
		array('name','require','标题必须'),
		array('content','require','内容必须'),
		array('calTimeout','require','算法超时时间必须'),
		array('runTimeout','require','运行超时时间必须'),
		array('input','require','input必须'),
                array('output','require','output必须'),
		array('spInput','require','Simple Input必须'),
                array('spOutput','require','Simple Output必须'),
     	    );
	}
?>
