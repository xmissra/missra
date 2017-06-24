<?php
/**
 * 我的收藏夹
 * 
 * @version        $Id: mystow.php
 * @package        Mi.Member
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/license.html
 * @link           http://www.missra.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
require_once(MIINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",GetCurUrl(),time()+3600,"/");
$type = empty($type)? "sys" : trim($type);
$tpl = '';
$menutype = 'mymi';
$rank = empty($rank)? "" : $rank;
if($rank == 'top'){
    $sql = "SELECT s.*,COUNT(s.aid) AS num,t.*  from #@__member_stow AS s LEFT JOIN `#@__member_stowtype` AS t on t.stowname=s.type group by s.aid order by num desc";
    $tpl = 'stowtop';
}else{
    $sql = "SELECT s.*,t.* FROM `#@__member_stow` AS s left join `#@__member_stowtype` AS t on t.stowname=s.type  where s.mid='".$cfg_ml->M_ID."' order by s.id desc";
    $tpl = 'mystow';
}

$dsql->Execute('nn','SELECT indexname,stowname FROM `#@__member_stowtype`');
while($row = $dsql->GetArray('nn'))
{
    $rows[]=$row;
}

$dlist = new DataListCP();
$dlist->pageSize = 20;
$dlist->SetTemplate(MIMEMBER."/templets/$tpl.htm");
$dlist->SetSource($sql);
$dlist->Display();