<?php
// header("Content-Type: text/html; charset=utf-8");
// require_once("../../include/config.inc.php");
include 'WeixinPay.php';
$Data = array();
$Version=date("Y-m-d H:i:s");
$appid= $cfg_appid;       //小程序端传递过来的 appid
$openid= $openid;
$mch_id= $cfg_mchid;     //微信支付商户支付号
$key= $cfg_key;          //Api 密钥

$out_trade_no = $orderid;
$total_fee = $totalamount;  //小程序端传递过来的金额
$body = "购票金额";
$total_fee = floatval($total_fee * 100);

$weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee);
$return=$weixinpay->pay();


?>
