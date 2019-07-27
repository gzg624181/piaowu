<?php
    /**
	   * 链接地址： 更改购票人信息设置为默认显示
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
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  //备注 ：使用get传输数据

  // 将默认显示的先更改为正常
  $dosql->ExecNoneQuery("UPDATE pmw_buyer SET defaults=0 where mid=$mid and defaults=1");

  //将需要更改的购票人信息设置为默认显示
  $sql =  "UPDATE pmw_buyer SET defaults=1 where id=$id";

  if($dosql->ExecNoneQuery($sql)){
    $State = 1;
    $Descriptor = '默认显示更改成功!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $Data
                 );
    echo phpver($result);
  }else{
    $State = 0;
    $Descriptor = '默认显示更改失败!';
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
