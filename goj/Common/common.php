<?php
        function handleStr($data,$nowstr){
                        $arr=explode("c", $data);
                        $count=count($arr);
                        for($i=0;$i<$count;$i++){
                                if($arr[$i]==$nowstr)
                                        return $arr[$i+1];
                        }
                }
?>
