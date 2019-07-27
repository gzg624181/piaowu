<?php require_once(dirname(__FILE__).'/inc/config.inc.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改音频文件</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="layui/layui.js"></script>
<link href="layui/css/layui.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
//初始化参数
$action  = isset($action)  ? $action  : 'music_save.php';
$tbname='pmw_music';
$r=$dosql->GetOne("SELECT * FROM  $tbname where id=$id");
?>
<div class="formHeader"> <span class="title" style="margin-left: 13px;">修改音频</span> <a href="javascript:location.reload();" class="reload"><i class="fa fa-refresh fa-spin fa-fw"></i></a> </div>
<form name="form" id="form" method="post" action="<?php echo $action;?>">
	<table id="table1"  width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable" >
         <tr>
			<td width="25%" height="40" align="right">音频标题：</td>
			<td width="75%">
             <input type="text" class="input" id="title" name="title" value="<?php echo $r['title'];?>" required="required">
             <span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
             </td>
		</tr>
		<tr>
 <td width="25%" height="40" align="right">分享标题：</td>
 <td width="75%">
				<input type="text" class="input" id="sharename" name="sharename" value="<?php echo $r['sharename'];?>" required="required">
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
				</td>
</tr>
<tr>
			<td height="40" align="right">图片分享上传：</td>
			<td>
            <img style="border-radius:10px; width:80px; padding:5px;" src="<?php echo $cfg_weburl."/".$r['share'];?>"/>
              <input style="margin-top:5px; width:406px;" type="text" name="share" id="share"  value="<?php echo $r['share'];?>" class="input"  required="required"/>
				<span class="cnote"><span class="grayBtn" onclick="GetUploadify('uploadify','缩略图上传','image','image',1,20971520,'share')">上 传</span>
             </td>
		</tr>
                <tr>
			<td height="40" align="right">音频文件上传：</td>
			<td>
              <input style="margin-top:5px;" type="text" name="url" id="url"  value="<?php echo $r['url'];?>" class="input"  required="required"/>
				<span class="cnote"><span class="grayBtn" onclick="GetUploadify('uploadify','音频文件上传','media','media',1,20971520,'url')">上 传</span>
             </td>
		</tr>
		<tr>
			<td height="40" align="right">播放数量：</td>
			<td><input type="text" name="num" id="num" value="<?php echo $r['num'];?>" class="input" required="required" />
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
		<tr>
			<td height="40" align="right">更新时间：</td>
			<td><input type="text" name="addtime" id="addtime" class="input" value="<?php echo GetDateTime(time()); ?>" readonly="readonly" />
				<script type="text/javascript">
				Calendar.setup({
					inputField     :    "addtime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
        <tr>
			<td height="40" align="right">排列顺序：</td>
			<td><input type="text" name="orderid" id="orderid" class="input" value="<?php echo $r['orderid'] ?>" required="required" />
				<span class="maroon">*</span><span class="cnote">带<span class="maroon">*</span>号表示为必填项</span></td>
		</tr>
	</table>
	<div class="formSubBtn">
		<input type="submit" class="submit" value="提交" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" name="id" id="id" value="<?php echo $r['id'];?>" />
  </div>
</form>

</body>
</html>
