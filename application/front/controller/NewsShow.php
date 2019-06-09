<?php
/*
 * 前台图片详情页
 * */
namespace app\front\controller;
use app\front\controller\PublicArt;
use app\front\model\Cat;
use think\Db;

class NewsShow extends Init
{
    //后台列表
    public function index()
    {
        $id = input('id');

        $res =  Db::name('article')->where('art_id',$id)->find();
        //dump($res);die;
        $this->assign('res',$res);
      //获取随即文章推荐给用户
        //先拿到最顶级栏目ID
         $art_cat_id = $res['art_cat_id'];
        $cat = new Cat();
        $cat_all_id = $cat->getParentId($art_cat_id);
        //循坏数据
        foreach ($cat_all_id as $k => $v)
        {
            $cat_id_res[]  = $v['id'];
        }
        $cat_id = $cat_id_res[0];
       //dump($cat_id);die;
        $art = new PublicArt();
        //$art->recommend();
        return view('newsshow');
    }


}
