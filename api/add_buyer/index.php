<?php
    /**
	   * 链接地址： 添加购票人信息
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
     * company         公司名称
     * name            用户姓名
     * tel             联系电话
     * mid             会员唯一id
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){

  //备注 ：使用get传输数据

  $posttime=time();  //添加时间

   // 判断添加的购票人信息是否是第一次添加

  $r=$dosql->GetOne("SELECT id FROM pmw_buyer where mid=$mid");

   //如果数据库里面没有这个会员添加的购票人信息，则自动将第一条数据设置为默认显示
  if(!is_array($r)){
   $defaults = 1;   //默认显示
  }else{
   $defaults = 0;
  }
  $sql = "INSERT INTO `#@__buyer`(company,name,tel,mid,defaults,posttime) VALUES ('$company','$name','$tel',$mid,$defaults,$posttime)";
  if($dosql->ExecNoneQuery($sql)){
    $State = 1;
    $Descriptor = '购票信息添加成功!';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $Data
                 );
    echo phpver($result);
  }else{
    $State = 0;
    $Descriptor = '购票信息添加失败!';
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
