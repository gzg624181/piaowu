<?php
    /**
	   * 链接地址： 提交退款（后台显示退款提交中）
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
     * @添加购票人信息   提供返回参数账号，
     *  购票人信息 id
     *  购票会员   mid
     *  购票人的   openid
     *  购票人的   formid
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  //备注 ：使用get传输数据
  add_formid($openid,$formid);
  // 将退款订单状态修改为正在退款中
  $sql =  "UPDATE pmw_order SET refund_state=1 where did=$did and id=$id";

  if($dosql->ExecNoneQuery($sql)){
    $State = 1;
    $Descriptor = '退款提交成功!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $Data
                 );
    echo phpver($result);
  }else{
    $State = 0;
    $Descriptor = '退款提交失败!';
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
