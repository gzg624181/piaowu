<?php
    /**
	   * 链接地址：add_order  添加订单
	   *
     * 下面直接来连接操作数据库进而得到json串
     *
     * 按json方式输出通信数据
     *
     * @param unknown $State 状态码
     *
     * @param string $Descriptor  提示信息
     *
	   * @param string $Version  操作时间
     *
     * @param array $Data 数据
     *
     * @return string
     *
     * @购票订单   提供返回参数账号，
     * tid               票务id
     * jingquname        景区名称
     * contactname       联系人姓名
     * contacttel        联系人电话
     * usetime           使用日期（varchar）
     * price             单张票的价格
     * typename          票务类型（成人票，儿童票，优惠票）
     * nums              票务数量
     * totalamount       支付总金额
     * paytype           支付类型（线下支付，微信支付）
     * orderid           支付订单号
     * states            后台票务处理状态（默认未处理0，已处理1）
     * posttime          添加时间
     * openid            下单用户的openid
     * formid            下单用户的formid
     * bid                默认购票人的信息id（buyer表id）
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  //备注 ：添加行程的时候content 内容以json字符串的形式保存在数据库中去

  $posttime=time();  //添加时间

  $orderid =date('YmdHis').rand(111111,999999);

  $ymd=date("Y-m-d");

  $timestampuse= strtotime($usetime);

  $sql = "INSERT INTO `#@__order` (tid,jingquname,did,contactname,contacttel,usetime,price,typename,nums, totalamount,paytype,orderid,posttime,timestampuse,ymd,bid) VALUES ($tid,'$jingquname',$did,'$contactname','$contacttel','$usetime','$price','$typename',$nums,'$totalamount','$paytype','$orderid',$posttime,$timestampuse,'$ymd',$bid)";
  if($dosql->ExecNoneQuery($sql)){
  //拉取微信支付

  include("../weixinpay/index.php");

  $State = 1;
  $Descriptor = '订单下注成功！!';
  $result = array (
              'State' => $State,
              'Descriptor' => $Descriptor,
              'Version' => $Version,
              'Data' => $return
               );
  echo phpver($result);
  }else{
    $State = 0;
    $Descriptor = '订单下注失败！!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $Data
                 );
    echo phpver($result);
  }
}else{
  $State = 520;
  $Descriptor = 'token验证失败！';
  $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
  				         'Version' => $Version,
                   'Data' => $Data
                   );
  echo phpver($result);
}

?>
