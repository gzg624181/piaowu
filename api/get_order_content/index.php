<?php
    /**
	   * 链接地址：get_order_content  获取单个用户的订单详情
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
     * @提供返回参数账号 id
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){
      $r=$dosql->GetOne("SELECT imagesurl FROM pmw_share  where id=3");
      $cfg_default = $r['imagesurl'];
      $r=$dosql->GetOne("SELECT a.*,b.label, b.picarr,b.solds,b.level,b.lowmoney  FROM `#@__order` a inner join `#@__ticket` b  on a.tid=b.id WHERE a.id=$id");

      if(!is_array($r)){
        $State = 0;
        $Descriptor = '暂无订单消息！';
        $result = array (
                    'State' => $State,
                    'Descriptor' => $Descriptor,
                    'Version' => $Version,
                    'Data' => $Data
                     );
        echo phpver($result);
      }else{
      $bid = $r['bid'];  //默认购票人信息
      $s = $dosql->GetOne("SELECT * FROM pmw_buyer where id=$bid");
      if(!is_array($s)){
        $s = array();
      }else{
        $picarr=stripslashes($r['picarr']);
        if($picarr==""){
        $picarrTmp=array("0"=>$cfg_weburl."/".$cfg_default);
        $picarr = json_encode($picarrTmp);
        }else{
        $picarr=GetPic($picarr, $cfg_weburl);
        }
        $r['picarr']=$picarr;
      }

      $Data = array(
        "order" => $r,
        "buyer" => $s
      );
      $State = 1;
      $Descriptor = '数据获取成功！';
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
