<?php
/*
 * 前台图片详情页
 * */
namespace app\front\controller;
use app\front\model\Cat;
use app\front\controller\PublicArt;
use think\Db;

class Proart extends Init
{
    //后台列表
    public function index()
    {

        $id = input('id');
        $public_art = new PublicArt();
        $public_art->artPage($id);
        //当前位置
        $cat = new Cat();
        $now_post = $cat->getParentId($id);
        $this->assign('now_post',$now_post);
        return view('proart');
    }


//ajax点赞
public function zanAjax()
{
    $zan_res = input('art_id');
//获取到当前用户的ip
    $user_ip = $_SERVER['REMOTE_ADDR'];
    //如果当前ip没有点过赞
    $res = Db::name('click_ip')->field('ip')->where('art_id',$zan_res)->find();
    if($res == '')
    {
         //如果用户点赞在数据库中点赞数+1
     $add_zan = Db::execute("update lvhua_article set zan=zan+1 where art_id= $zan_res");
     if($add_zan)
     {
        $data['ip'] = $user_ip;
        $data['art_id'] = $zan_res; 
        //将该ip写入ip表中
        $add_ip = db('click_ip')->insert($data);
        //查询出点赞数
        $zan_lst = Db::name('article')->field('zan')->where('art_id',$zan_res)->find();
        if ($zan_lst) {
            # code...
            echo $zan_lst['zan'];

        }
     }
    }else{
        echo "您已经赞过一次了";die;
    }
    
}


}
