<?php
//接受参数
$request = $_REQUEST;
$config = array();
$config['source'] = ''; //填写对应的source
$config['secret'] = ''; //填写对应的secret

//校验推送过来数据的签名
$_temp = $request;
$_temp['body'] = json_decode($_temp['body'],true);

if($request['sign'] != _genSign($_temp,$config)){
    $request['body'] = array('errno'=>-1,'error'=>'check sign failed!'); 
}else{
    if('order.create' == $request['cmd']){    
        //!!!!!!!接收到订单之后对接方需要根据自己的业务进行处理!!!!!!
        //demo为了方便直接随机生成一个source_order_id返回
        $request['body'] = array('errno'=>0,'error'=>'success','data'=>array('source_order_id'=>rand()));
    }else{
        echo "其他接口参考order.create进行处理";exit();
    }
}
$request['cmd']  = 'resp.' . $request['cmd'];
$request['sign'] = _genSign($request,$config);
ksort($request);
$ret = json_encode($request);
echo $ret;
exit();

function _genSign($data,$config)
{
    $arr = array();
    $arr['body'] = json_encode($data['body']);
    $arr['cmd'] = $data['cmd'];
    $arr['encrypt'] = $data['encrypt'];
    $arr['secret'] = $config['secret'];
    $arr['source'] = $data['source'];
    $arr['ticket'] = $data['ticket'];
    $arr['timestamp'] = $data['timestamp'];
    $arr['version'] = $data['version'];
    ksort($arr);
    $tmp = array();
    foreach ($arr as $key => $value) {
        $tmp[] = "$key=$value";
    }
    $strSign = implode('&', $tmp);
    $sign = strtoupper(md5($strSign));
    return $sign;
}

