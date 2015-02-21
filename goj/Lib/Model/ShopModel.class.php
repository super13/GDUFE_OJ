<?php
class ShopModel extends Model {
    // 自动填充设置
    protected $_auto = array(
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
    );
}