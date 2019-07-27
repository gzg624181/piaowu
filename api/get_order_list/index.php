<?php
    /**
	   * 链接地址：get_order_list   获取票务订单状态
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
     * @提供返回参数账号    下单人id
     *   全部订单 ：  用户下注支付成功之后的所有未出行订单和已出现订单
     *   待出行订单： 用户下注支付成功之后还未出行的订单（包括退款订单）
     *   已出行订单： 用户支付成功之后，已经到了出现时间 （退款按钮失效，不能在线上进行退款操作）
     *   退款提交中： 用户提交了退款申请，后台还未审核通过的状态
     *   已退款：    用户申请了退款，后台操作审核通过，已经退款成功的订单
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

      $dosql->Execute("SELECT * FROM `#@__order` WHERE did=$id");
      $nums = $dosql->GetTotalRow();
      if($nums==0){  //如果订单里面没有这个用户的支付记录，则显示暂无订单
        $State = 0;
        $Descriptor = '暂无购票订单！';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      #计算已经有支付记录的

      $one=1;
      $two=2;
      $three=3;
      $four=4;
      $five=5;

      #全部支付订单

      $dosql->Execute("SELECT a.*,b.cover_pic FROM `#@__order` a  inner join pmw_ticket b on a.tid=b.id WHERE a.did=$id and a.pay_state=1",$one);
      $num=$dosql->GetTotalRow($one);
      if($num!=0){
      for($i=0;$i<$dosql->GetTotalRow($one);$i++){
      $row1=$dosql->GetArray($one);
      $all[]=$row1;
      $all[$i]['cover_pic']=$cfg_weburl."/".$row1['cover_pic'];
      }
      }else{
      $all=array();
      }

      #待出行

      $now=time();
      $dosql->Execute("SELECT a.*,b.cover_pic FROM `#@__order` a  inner join pmw_ticket b on a.tid=b.id WHERE a.did=$id and a.timestampuse > $now and a.pay_state=1 and a.refund_state=0",$two);
      $num=$dosql->GetTotalRow($two);
      if($num!=0){
      for($i=0;$i<$dosql->GetTotalRow($two);$i++){
      $row2=$dosql->GetArray($two);
      $to_be_travelled[]=$row2;
      $to_be_travelled[$i]['cover_pic']=$cfg_weburl."/".$row2['cover_pic'];
      }
      }else{
        $to_be_travelled=array();
      }

      #已出行
      $now=time();
      $dosql->Execute("SELECT a.*,b.cover_pic FROM `#@__order` a  inner join pmw_ticket b on a.tid=b.id WHERE a.did=$id and a.timestampuse <= $now and a.pay_state=1 and a.refund_state=0",$three);
      $num=$dosql->GetTotalRow($three);
      if($num!=0){
      for($i=0;$i<$dosql->GetTotalRow($three);$i++){
        $row3=$dosql->GetArray($three);
        $travelled[]=$row3;
        $travelled[$i]['cover_pic']=$cfg_weburl."/".$row3['cover_pic'];
      }
      }else{
        $travelled=array();
      }

      #退款提交中
      $dosql->Execute("SELECT a.*,b.cover_pic FROM `#@__order` a  inner join pmw_ticket b on a.tid=b.id WHERE a.did=$id and a.pay_state=1 and a.refund_state=1",$four);
      $num=$dosql->GetTotalRow($four);
      if($num!=0){
      for($i=0;$i<$dosql->GetTotalRow($four);$i++){
      $row4=$dosql->GetArray($four);
      $refunding[]=$row4;
      $refunding[$i]['cover_pic']=$cfg_weburl."/".$row1['cover_pic'];
      }
      }else{
      $refunding=array();
      }

      #已退款
      $dosql->Execute("SELECT a.*,b.cover_pic FROM `#@__order` a  inner join pmw_ticket b on a.tid=b.id WHERE a.did=$id and a.pay_state=1 and a.refund_state=2",$five);
      $num=$dosql->GetTotalRow($five);
      if($num!=0){
      for($i=0;$i<$dosql->GetTotalRow($five);$i++){
      $row5=$dosql->GetArray($five);
      $refundend[]=$row5;
      $refundend[$i]['cover_pic']=$cfg_weburl."/".$row1['cover_pic'];
      }
      }else{
      $refundend=array();
      }

      $Data= array(

           "all"=>$all,
           "to_be_travelled"=>$to_be_travelled,
           "travelled"=>$travelled,
           "refunding"=>$refunding,
           "refundend"=>$refundend
      );

      $State = 1;
      $Descriptor = '票务订单查询成功！';
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
                   'Data' => $Data,
                   );
  echo phpver($result);
}

?>
