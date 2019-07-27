<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改游戏详情</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getjcrop.js"></script>
<script type="text/javascript" src="templates/js/getinfosrc.js"></script>
<script type="text/javascript" src="plugin/colorpicker/colorpicker.js"></script>
<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
<script type="text/javascript" src="editor/kindeditor-min.js"></script>
<script type="text/javascript" src="editor/lang/zh_CN.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<script type="text/javascript" src="templates/js/getarea.js"></script>
<script>

layer.ready(function(){ //为了layer.ext.js加载完毕再执行
   layer.photos({
    photos: '#layer-photos-demo',
	//area:['500px','300px'],  //图片的宽度和高度
    shift: 0 ,//0-6的选择，指定弹出图片动画类型，默认随机
	closeBtn:1,
	offset:'100px',  //离上方的距离
	shadeClose:true
  });
});

</script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `pmw_game` WHERE `id`=$id");
?>
<div class="formHeader">游戏介绍<a href="javascript:location.reload();" class="reload">刷新</a> </div>
<form name="form" id="form" method="post" action="product_save.php" onsubmit="return cfm_infolm();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		  <td height="40" align="right">游戏名称：</td>
		  <td colspan="11"><input style="width:370px;" type="text" name="gamename" id="gamename" class="input" value="<?php echo $row['gamename']; ?>" /></td>
    </tr>
		<tr>
			<td width="6%" height="40" align="right">游戏简称：</td>
			<td colspan="11"><input style="width:370px;" type="text" name="game" id="game" class="input" value="<?php echo $row['game']; ?>" /></td>
		</tr>
		<tr>
			<td height="82" align="right">游戏图片：</td>
			<td colspan="11" valign="middle">
      <div id="layer-photos-demo" class="layer-photos-demo">
     <img  width="90" height="90" style="cursor:pointer; padding:5px;border-radius:3px;" layer-src="<?php echo $row['gamepic']; ?>"  src="<?php echo $row['gamepic']; ?>" alt="<?php echo $row['gamename']; ?>" />
       </div>
   <input style="margin-top:5px;" type="text" name="gamepic" id="gamepic" class="input" value="<?php echo $row['gamepic']; ?>" />
				<span class="cnote"><span class="grayBtn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,<?php echo $cfg_max_file_size; ?>,'gamepic')"></span> <span class="rePicTxt">
				<input type="checkbox" name="rempic" id="rempic" value="true" />
				远程</span> <span class="cutPicTxt"><a href="javascript:;" onclick="GetJcrop('jcrop','picurl');return false;">裁剪</a></span> </span></td>
	  </tr>
      <tr>
          <td height="40" align="right">游戏分类名称：</td>
          <td colspan="11" valign="middle"><input type="text" name="gametypes" id="gametypes" class="input"  value="<?php echo $row['gametypes']; ?>"/></td>
    </tr>
    <tr>
        <td height="40" align="right">直属下线提成比例：</td>
        <td colspan="11" valign="middle"><input type="text" name="zsticheng" id="zsticheng" class="input" value="<?php echo $row['zsticheng']; ?>"/></td>
      </tr>
      <tr>
        <td height="40" align="right">二级下线提成比例：</td>
        <td colspan="11" valign="middle"><input type="text" name="ejticheng" id="ejticheng" class="input" value="<?php echo $row['ejticheng']; ?>"/></td>
      </tr>
      <tr>
			<td height="40" align="right">游戏备注：</td>
			<td colspan="11" valign="middle"><input type="text" name="remark" id="remark" class="input" style="width:78%"  value="<?php echo $row['remark']; ?>"/></td>
	  </tr>
      <tr>
	  <td height="40" align="right">是否在线：</td>
		  <td colspan="3"><p>
          <label>
		      <input type="radio" name="gameonline" value="1" <?php if($row['gameonline']==1){echo "checked='checked'";}?> id="gameonline" />
		      在线</label>
          &nbsp;&nbsp;
		    <label>
		      <input name="gameonline" type="radio" id="gameonline" value="0" <?php if($row['gameonline']==0){echo "checked='checked'";}?> />
		      离线</label><br />
	      </p></td>
		  <td width="4%" align="right">&nbsp;</td>
		  <td width="5%">&nbsp;</td>
		  <td width="4%" align="right">&nbsp;</td>
		  <td width="5%" id="hot2">&nbsp;</td>
		  <td width="3%" align="right">&nbsp;</td>
		  <td width="5%" id="leixing2">&nbsp;</td>
		  <td width="3%" align="right">&nbsp;</td>
		  <td width="35%"  id="countrys2">&nbsp;</td>
    </tr>
      <tr>
		  <td height="272" align="right">游戏赔率说明：</td>
		  <td colspan="11"><textarea name="gamedescription" id="gamedescription" class="kindeditor"><?php echo $row['gamedescription']; ?></textarea>
				<script>
				var editor;
				KindEditor.ready(function(K) {
					editor = K.create('textarea[name="gamedescription"]', {
						allowFileManager : true,
						width:'1200px',
						height:'365px',
						extraFileUploadParams : {
							sessionid :  '<?php echo session_id(); ?>'
						}
					});
				});
				</script>			<div id="fenlei" style="font-size:12px; color:#ffa8a8;display:inline;"></div></td>
	  </tr>
      <tr>
        <td height="40" align="right">排列排序：</td>
        <td width="18%"><input type="text" name="orderid" id="orderid" class="inputos" value="<?php echo $row['orderid']; ?>" /></td>
      </tr>
      <tr>
      <td height="40" align="right">&nbsp;</td>
       <td><div class="formSubBtn" style="float:left; margin-top:5px;">
<input type="submit" class="submit" value="保存" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="update" />
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
  </div></td>
    </tr>
	</table>

</form>
</body>
</html>
