<?php
    /**
	   * 链接地址： 判断这个关联用户是否有默认显示的购票用户
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
     *
     * mid             会员唯一id
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  //备注 ：使用get传输数据

  $r=$dosql->GetOne("SELECT id FROM pmw_buyer where mid=$mid and defaults=1");

  if(!is_array($r)){  //没有默认的用户信息
    $State = 0;
    $Descriptor = '没有默认的购票用户信息!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $Data
                 );
    echo phpver($result);
  }else{
    $Data['id']=$r['id'];
    $State = 1;
    $Descriptor = '有默认的购票用户信息!';
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
