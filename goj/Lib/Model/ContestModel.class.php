<?php
	class ContestModel extends Model {
	    // 定义自动验证
		protected $_validate    =   array(
	        	array('name','require','标题必须'),
			array('start_time','require','开始时间必须'),
			array('end_time','require','结束时间必须'),
        	);
    	// 定义自动完成
    		protected $_auto    =   array(
        		array('type','Public'),
			array('status','Pending'),
		);
	}
?>
