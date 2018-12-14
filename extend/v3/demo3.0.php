<?php
/**
 * @filename : demo.php
 * @author   : zhangjianguo@baidu.com
 * @date     : 2015-08-13 22:45:55
 * $Ids$
 */

require_once dirname(__FILE__) . '/Openapi3.0.php';

//===============================================================================================
//=================================== 准备配置及实例化对象  =====================================
//===============================================================================================
/**
 * 配置项
 */
$config = array();
$config['encrypt'] = ''; //加密方式;普通对接对解放为空
$config['source'] = ''; //填写对应的source
$config['secret'] = ''; //填写对应的secret
$config['url'] = 'https://api-be.ele.me';


//===============================================================================================
//======================================= 上行接口示例  ========================================
//===============================================================================================

/**
 * 商户信息获取DEMO
 */

$cmd = 'shop.get';
$data = array();
$data['shop_id'] = '100009';
$obj = new Openapi($config);
if(false === $obj->send($cmd, $data)){
    $msg = '获取商户信息失败！';
    display($msg, $obj->getLastError(), $obj->getLastErrno());
}else{
    $msg = '获取商户信息成功！';
    display($msg, $obj->getLastError(), $obj->getLastErrno(), $obj->getLastData());
}





function display($msg, $error, $errno = 0, $data = null){
    echo sprintf('%s[%s] %s, errno[%s] error[%s], data[%s]' . PHP_EOL, str_repeat('=', 80) . PHP_EOL, date('Y-m-d H:i:s'), $msg, $errno, $error, var_export($data, true));
}
