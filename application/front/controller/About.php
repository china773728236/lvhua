<?php
/*
 * 前台关于公司
 * */
namespace app\front\controller;
use app\front\model\Cat;
use think\Db;

class About extends Init
{

    public function index()
    {
        $id = input('id');
        $cat = new Cat();
        $all_id = $cat->sonTree($id);
        //查询文章(用sqlwhere中的IN查询当前ID下的文章)
        $res = Db::name('article')->where("art_cat_id IN($all_id)")->order('art_id asc')->limit(5)->select();
        //dump($res);die;
        $this->assign('res',$res);
        return view('about');
    }


}
