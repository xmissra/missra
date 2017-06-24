<?php   if(!defined('MIINC')) exit("Request Error!");
/**
 * 单表模型视图类
 *
 * @version        $Id: arc.sgpage.class.php
 * @package        Mi.Libraries
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
require_once(MIINC."/arc.partview.class.php");

/**
 * 单表模型列表视图类
 *
 * @package          SgListView
 * @subpackage       Mi.Libraries
 * @link             http://www.missra.com
 */
class sgpage
{
    var $dsql;
    var $dtp;
    var $TypeID;
    var $Fields;
    var $TypeLink;
    var $partView;

    /**
     *  php5构造函数
     *
     * @access    public
     * @param     int  $aid  内容ID
     * @return    string
     */
    function __construct($aid)
    {
        global $cfg_basedir,$cfg_templets_dir,$cfg_df_style,$envs;

        $this->dsql = $GLOBALS['dsql'];
        $this->dtp = new MiTagParse();
        $this->dtp->refObj = $this;
        $this->dtp->SetNameSpace("missra","{","}");
        $this->Fields = $this->dsql->GetOne("SELECT * FROM `#@__sgpage` WHERE aid='$aid' ");
        $envs['aid'] = $this->Fields['aid'];

        //设置一些全局参数的值
        foreach($GLOBALS['PubFields'] as $k=>$v)
        {
            $this->Fields[$k] = $v;
        }
        if($this->Fields['ismake']==1)
        {
            $pv = new PartView();
            $pv->SetTemplet($this->Fields['body'],'string');
            $this->Fields['body'] = $pv->GetResult();
        }
        $tplfile = $cfg_basedir.str_replace('{style}',$cfg_templets_dir.'/'.$cfg_df_style,$this->Fields['template']);
        $this->dtp->LoadTemplate($tplfile);
        $this->ParseTemplet();
    }

    //php4构造函数
    function sgpage($aid)
    {
        $this->__construct($aid);
    }

    /**
     *  显示内容
     *
     * @access    public
     * @return    void
     */
    function Display()
    {
        $this->dtp->Display();
    }

    /**
     *  获取内容
     *
     * @access    public
     * @return    void
     */
    function GetResult()
    {
        return $this->dtp->GetResult();
    }

    /**
     *  保存结果为文件
     *
     * @access    public
     * @return    void
     */
    function SaveToHtml()
    {
        $filename = $GLOBALS['cfg_basedir'].$GLOBALS['cfg_cmspath'].'/'.$this->Fields['filename'];
        $filename = preg_replace("/\/{1,}/", '/', $filename);
        $this->dtp->SaveTo($filename);
    }

    /**
     *  解析模板里的标签
     *
     * @access    public
     * @return    string
     */
    function ParseTemplet()
    {
        $GLOBALS['envs']['likeid'] = $this->Fields['likeid'];
        MakeOneTag($this->dtp,$this);
    }

    //关闭所占用的资源
    function Close()
    {
    }
}//End Class