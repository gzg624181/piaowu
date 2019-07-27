<?php
    /**
	   * 链接地址：get_ticket_typeclass  获取分类景区列表
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
     * @提供返回参数账号 景点的分类id  types
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
$one=1;
if(isset($token) && $token==$cfg_auth_key){

      $one=1;
      $dosql->Execute("SELECT  id,names,cover_pic  FROM `#@__ticket` where types='$types' and checkinfo=1 order by id desc",$one);
      for($i=0;$i<$dosql->GetTotalRow($one);$i++){
       $row1 = $dosql->GetArray($one);
       $Data[$i]=$row1;
       $cover_pic=$cfg_weburl."/".$row1['cover_pic'];
       $Data[$i]['cover_pic']=$cover_pic;
      }
      $State = 1;
      $Descriptor = '内容获取成功！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data
                   );
      echo phpver($result);


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
