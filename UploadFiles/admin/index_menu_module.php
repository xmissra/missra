<?php
/**
 * 快捷发布菜单
 *
 * @version        $Id: file_pic_view.php
 * @package        Mi.Administrator
 * @copyright      Copyright (c)  2010, Missra
 * @link           http://www.missra.com
 */
require(dirname(__FILE__)."/config.php");
if($cuserLogin->adminStyle!='missra') {
    header("location:index_menu.php?openitem=100");
    exit();
}
require(MIADMIN.'/inc/inc_menu_module.php');
require(MIADMIN.'/inc/inc_menu_func.php');
?>
<html>
<head>
	<title>Missra menu</title>
	<link rel="stylesheet" href="css/base.css" type="text/css" />
	<link rel="stylesheet" href="images/menuold.css" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>" />
	<base target="main" />
</head>
<script type="text/javascript">
	function showHide(objname) {
		var obj = document.getElementById(objname);
		if(obj.style.display == 'block' || obj.style.display =='') {
			obj.style.display = 'none';
		} else {
			obj.style.display = 'block';
		}
	}
</script>
<base target="main">
<body leftmargin="0" topmargin="0" target="main">
	<table width='100%' height="100%" border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td style='padding-left:3px;padding-top:8px' valign="top">
				<?php GetMenus($cuserLogin->getUserRank(),'module'); ?>
			</td>
		</tr>
	</table>
	<table width="120" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td height="6"></td>
		</tr>
	</table>
</body>
</html>