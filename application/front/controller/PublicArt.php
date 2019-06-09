<?php
/*
 * 前台文章公用查询类
 * */
namespace app\front\controller;
use app\front\model\Cat;
use think\Controller;
use think\Db;

class PublicArt extends Controller
{
    //文章单页面查询
    public function artPage($id)
    {
        $res = Db::name('article')->where('art_cat_id',$id)->find();
        //dump($res);die;
        $this->assign('res',$res);
        return $res;

    }

    //找到所有属于基地展示的标题与链接
    public function jidiTitle($id)
    {
        $cat = new Cat();
        //先找到基地展示的ID
        $cats = $cat->field('cat_pid')->find($id);
        //找到父栏目的数据
        $cat_parent_res = db('article')->alias('a')->field('a.art_keywords,b.id,enname')->
        join('lvhua_cat b','a.art_cat_id=b.id')->where('id',$cats['cat_pid'])->find();
        $this->assign('cat_parent_res',$cat_parent_res);
        //查找所有属于基地展示下的子栏目标题
        $cat_title = Db::name('cat')->field('id,cat_name,enname')->where('cat_pid',$cats['cat_pid'])->select();
        $this->assign('title',$cat_title);
    }

    //当前文章的点击量
    public  function click($id,$art_id)
    {
        if($id)
        {

            $res_click = Db::execute("update lvhua_article set art_look=art_look+1 where art_id={$art_id}");
        }
    }


    //为您推荐的文章
    public function recommend()
    {

        /*$res = Db::execute("FROM `article` AS t1 JOIN (

SELECT ROUND(RAND() * ((SELECT MAX(art_id) FROM `article`)-(SELECT MIN(art_id) FROM `article`))+(SELECT MIN(art_id) FROM `article`)) AS art_id

from `article` limit 2) AS t2 on t1.art_id=t2.art_id

ORDER BY t1.art_id LIMIT 2;");*/
        $res = Db::query("FROM `article` AS t1 JOIN (

SELECT ROUND(RAND() * ((SELECT MAX(art_id) FROM `article`)-(SELECT MIN(art_id) FROM `article`))+(SELECT MIN(art_id) FROM `article`)) AS (select *

from `article` limit 2) AS t2 on t1.art_id=t2.art_id

ORDER BY t1.art_id LIMIT 2");
        dump($res);die;
    }


}
