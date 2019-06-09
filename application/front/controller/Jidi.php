<?php
/*
 * 前台基地展示
 * */
namespace app\front\controller;
use app\front\model\Cat;
class JiDi  extends Init
{
    //后台列表
    public function index()
    {
        $id = input('id');
        $cat = new Cat();
        $all_id = $cat->sonTree($id);
        //查询文章(用sqlwhere中的IN查询当前ID下的文章)
        //db(当前表)->alias(当前表的别名)->field(当前表的字段，另一张表的字段)->join('另一张表 表的别名'，当前表与另一张表相同的字段)->select();
        //拿到方法名以便于在网址能正确的显示
        $res = db('article')->alias('a')->field('a.art_cat_id,art_keywords,b.id,enname')->
        join('lvhua_cat b','a.art_cat_id=b.id')->where("art_cat_id IN($all_id)")->limit(5)->select();
        $this->assign('res',$res);
     //默认显示第一条数据
        $res_first = db('article')->field('art_cat_id,art_content,art_keywords')->where('art_cat_id',$id)->find();
       $this->assign('res_first',$res_first);
        return view('jidi');
    }


}
