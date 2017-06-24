<?php
/**
 * 后台管理菜单项
 *
 * @version        $Id: inc_menu.php
 * @package        Missra.Administrator
 * @copyright      Copyright (c)  2010, Missra, Inc.
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/../config.php");

//载入可发布频道
$addset = '';

//检测可用的内容模型
if($cfg_admin_channel = 'array' && count($admin_catalogs) > 0) {
    $admin_catalog = join(',', $admin_catalogs);
    $dsql->SetQuery(" SELECT channeltype FROM `#@__arctype` WHERE id IN({$admin_catalog}) GROUP BY channeltype ");
} else {
    $dsql->SetQuery(" SELECT channeltype FROM `#@__arctype` GROUP BY channeltype ");
}
$dsql->Execute();
$candoChannel = '';
while($row = $dsql->GetObject()) {
    $candoChannel .= ($candoChannel=='' ? $row->channeltype : ','.$row->channeltype);
}

if(empty($candoChannel)) $candoChannel = 1;
$dsql->SetQuery("SELECT id,typename,addcon,mancon FROM `#@__channeltype` WHERE id IN({$candoChannel}) AND id<>-1 AND id<>-8 AND isshow=1 ORDER BY id ASC");
$dsql->Execute();
while ( $row = $dsql->GetObject() ) {
    $addset .= "<m:item name='{$row->typename}管理' ischannel='1' link='{$row->mancon}?channelid={$row->id}' linkadd='{$row->addcon}?channelid={$row->id}' channelid='{$row->id}' rank='' target='main' />\r\n";
}

$adminMenu1 = '';
if($cuserLogin->getUserType() >= 10) {
	
	$adminMenu1 = 
	"<m:top item='7_' name='模板管理' display='none' rank='temp_One,temp_Other,temp_MyTag,temp_test,temp_All'>
	  <m:item name='默认模板管理' link='templets_main.php' rank='temp_All' target='main'/>
	  <m:item name='标签源码管理' link='templets_tagsource.php' rank='temp_All' target='main'/>
	  <m:item name='自定义宏标记' link='mytag_main.php' rank='temp_MyTag' target='main'/>
	  <m:item name='智能标记向导' link='mytag_tag_guide.php' rank='temp_Other' target='main'/>
	  <m:item name='全局标记测试' link='tag_test.php' rank='temp_Test' target='main'/>
	</m:top>

	<m:top item='10_' name='系统设置' display='none' rank='sys_User,sys_Group,sys_Edit,sys_Log,sys_Data'>
	  <m:item name='系统基本参数' link='sys_info.php' rank='sys_Edit' target='main' />
	  <m:item name='系统用户管理' link='sys_admin_user.php' rank='sys_User' target='main' />
	  <m:item name='用户组设定' link='sys_group.php' rank='sys_Group' target='main' />
	  <m:item name='服务器分布/远程' link='sys_multiserv.php' rank='sys_Group' target='main' />
	  <m:item name='系统日志管理' link='log_list.php' rank='sys_Log' target='main' />
	  <m:item name='验证安全设置' link='sys_safe.php' rank='sys_verify' target='main' />
	  <m:item name='图片水印设置' link='sys_info_mark.php' rank='sys_Edit' target='main' />
	  <m:item name='自定义文档属性' link='content_att.php' rank='sys_Att' target='main' />
	  <m:item name='软件频道设置' link='soft_config.php' rank='sys_SoftConfig' target='main' />
	  <m:item name='防采集串混淆' link='article_string_mix.php' rank='sys_StringMix' target='main' />
	  <m:item name='随机模板设置' link='article_template_rand.php' rank='sys_StringMix' target='main' />
	  <m:item name='计划任务管理' link='sys_task.php' rank='sys_Task' target='main' />
	  <m:item name='数据库备份/还原' link='sys_data.php' rank='sys_Data' target='main' />
	  <m:item name='SQL命令行工具' link='sys_sql_query.php' rank='sys_Data' target='main' />
	  <m:item name='文件校验[S]' link='sys_verifies.php' rank='sys_verify' target='main' />
	  <m:item name='病毒扫描[S]' link='sys_safetest.php' rank='sys_verify' target='main' />
	  <m:item name='系统错误修复[S]' link='sys_repair.php' rank='sys_verify' target='main' />
	</m:top>";
}

$remoteMenu = ($cfg_remote_site=='Y')? "<m:item name='远程服务器同步' link='makeremote_all.php' rank='sys_ArcBatch' target='main' />" : "";

$menusMain = "
	<m:top item='1_' name='常用操作' display='block'>
	  <m:item name='网站栏目管理' link='catalog_main.php' ischannel='1' addalt='创建栏目' linkadd='catalog_add.php?listtype=all' rank='t_List,t_AccList' target='main' />
	  <m:item name='所有档案列表' link='content_list.php' rank='a_List,a_AccList' target='main' />
	  <m:item name='等审核的档案' link='content_list.php?arcrank=-1' rank='a_Check,a_AccCheck' target='main' />
	  <m:item name='我发布的文档' link='content_list.php?mid=".$cuserLogin->getUserID()."' rank='a_List,a_AccList,a_MyList' target='main' />
	  <m:item name='评论管理' link='feedback_main.php' rank='sys_Feedback' target='main' />
	  <m:item name='内容回收站' link='recycling.php' ischannel='1' addalt='清空回收站' addico='images/gtk-del.png' linkadd='archives_do.php?dopost=clear&aid=no&recycle=1' rank='a_List,a_AccList,a_MyList' target='main' />
	</m:top>

	<m:top item='1_' name='内容管理' display='block'>
	  <m:item name='文章管理' ischannel='1' link='content_list.php?channelid=1' linkadd='article_add.php?channelid=1' channelid='1' rank='' target='main' />
	  <m:item name='图集管理' ischannel='1' link='content_i_list.php?channelid=2' linkadd='album_add.php?channelid=2' channelid='2' rank='' target='main' />
	  <m:item name='软件管理' ischannel='1' link='content_i_list.php?channelid=3' linkadd='soft_add.php?channelid=3' channelid='3' rank='' target='main' />
	  <m:item name='商品管理' ischannel='1' link='content_list.php?channelid=6' linkadd='archives_add.php?channelid=6' channelid='6' rank='' target='main' />
	  <m:item name='分类信息' ischannel='1' link='content_list.php?channelid=-8' linkadd='article_add.php?channelid=-8' channelid='-8' rank='' target='main' />
	  <m:item name='专题管理' ischannel='1' link='content_s_list.php' linkadd='spec_add.php' channelid='-1' rank='spec_New' target='main' />
	</m:top>

	<m:top item='1_3_3' name='批量维护' display='block'>
	  <m:item name='更新系统缓存' link='sys_cache_up.php' rank='sys_ArcBatch' target='main' />
	  <m:item name='文档批量维护' link='content_batch_up.php' rank='sys_ArcBatch' target='main' />
	  <m:item name='搜索关键词维护' link='search_keywords_main.php' rank='sys_Keyword' target='main' />
	  <m:item name='文档关键词维护' link='article_keywords_main.php' rank='sys_Keyword' target='main' />
	  <m:item name='重复文档检测' link='article_test_same.php' rank='sys_ArcBatch' target='main' />
	  <m:item name='自动摘要|分页' link='article_description_main.php' rank='sys_Keyword' target='main' />
	  <m:item name='TAG标签管理' link='tags_main.php' rank='sys_Keyword' target='main' />
	  <m:item name='数据库内容替换' link='sys_data_replace.php' rank='sys_ArcBatch' target='main' />
	</m:top>

	<m:top item='5_' name='HTML更新' notshowall='1' display='none' rank='sys_MakeHtml'>
	  <m:item name='一键更新网站' link='makehtml_all.php' rank='sys_MakeHtml' target='main' />
	  <m:item name='更新系统缓存' link='sys_cache_up.php' rank='sys_ArcBatch' target='main' />
	  <m:item name='更新主页HTML' link='makehtml_homepage.php' rank='sys_MakeHtml' target='main' />
	  <m:item name='更新栏目HTML' link='makehtml_list.php' rank='sys_MakeHtml' target='main' />
	  <m:item name='更新文档HTML' link='makehtml_archives.php' rank='sys_MakeHtml' target='main' />
	  <m:item name='更新专题HTML' link='makehtml_spec.php' rank='sys_MakeHtml' target='main' />
	  <m:item name='更新网站地图' link='makehtml_map_guide.php' rank='sys_MakeHtml' target='main' />
	  <m:item name='更新RSS文件' link='makehtml_rss.php' rank='sys_MakeHtml' target='main' />
	  {$remoteMenu}
	</m:top>

	<m:top item='6_' name='会员管理' display='none' rank='member_List,member_Type'>
	  <m:item name='注册会员列表' link='member_main.php' rank='member_List' target='main' />
	  <m:item name='会员级别设置' link='member_rank.php' rank='member_Type' target='main' />
	  <m:item name='积分头衔设置' link='member_scores.php' rank='member_Type' target='main' />
	  <m:item name='会员模型管理' link='member_model_main.php' rank='member_Type' target='main' />
	  <m:item name='会员短信管理' link='member_pm.php' rank='member_Type' target='main' />
	  <m:item name='会员留言管理' link='member_guestbook.php' rank='member_Type' target='main' />
	  <m:item name='会员动态管理' link='member_info_main.php?type=feed' rank='member_Type' target='main' />
	  <m:item name='会员心情管理' link='member_info_main.php?type=mood' rank='member_Type' target='main' />
	</m:top>

	$adminMenu1 ";