<?php
namespace app\front\controller;
use app\front\model\Cat;
use think\Db;
class Index extends Init
{
    public function index()
    {
//产品中心
       $this->imgLst();
       //新闻中心-更多文章
        $this->newsLst();
//基地展示
        $this->product();
        return view();
    }

    //产品中心
    public function imgLst()
    {
        //先取出所有栏目(数组)
        $cat_res = Db::name('cat')->field('id')->where('enname','imglst')->find();
        $this->assign('cat_res',$cat_res);
        //从数组中取出第一个值
        foreach ($cat_res as $k => $v)
        {
            $cat_id = $v;
        }
        //取到所有的当前主栏目下的子栏目
        $cat = new Cat();
         $cat_all_id = $cat->sonTree($cat_id);
        $res_product = db('article')->alias('a')->field('a.art_title,art_look,art_img,art_cat_id,art_describe,zan,b.id,enname')->
        join('lvhua_cat b','a.art_cat_id=b.id')->where("art_cat_id IN($cat_all_id)")->order('art_id asc')->limit(4)->select();
        //热门推荐
        $this->assign('product',$res_product);

        //产品中心图片链接
        $this->assign('test',$res_product);
        //产品中心标题链接
        $this->assign('title',$res_product);
       // dump($res_product);die;
    }

    //新闻中心
    public function newsLst()
    {
         $arr = array();
        //取出新闻中心所有栏目
        $cat_news = Db::name('cat')->field('id,cat_name')->where('enname','artlst')->select();
 foreach ($cat_news as $k => $v)
 {
     $arr[] = $v['id'];
 }
 //打印出新闻中心的ID
        $news_id['id'] = $arr[1];
 $this->assign('news_id',$news_id);
 //把所有id转换成字符串
        $news_all_id = implode(',',$arr);
        //取到所有的当前主栏目下的所有文章

        $res_news = db('article')->alias('a')->field('a.art_id,art_content,art_time,art_title,art_img,art_cat_id,art_describe,b.id,enname')->
        join('lvhua_cat b','a.art_cat_id=b.id')->where("art_cat_id IN($news_all_id)")->order('art_id asc')->limit(2)->select();
        //更多资讯
        $this->assign('all_news',$res_news);
        //技术要领
        $this->assign('news_science',$res_news);
       // dump($res_news);die;
        //行业资讯
       // dump();die;
        //$message_id = $cat_news['id'];
       //$message_res = Db::name('article')->field('id,cat_name')->where('enname','artlst')->select();
       //dump($message_id);die;
        //$message
    }
//基地展示
    public function product()
    {
        //取出基地展示所有栏目
        $cat_jidi = Db::name('cat')->field('id,cat_name')->where('enname','jidi')->select();
        $arr = array();
        foreach ($cat_jidi as $k => $v)
        {
            $arr[] = $v['id'];
        }
        //把所有id转换成字符串
        $jidi_all_id = implode(',',$arr);
        //取到所有的当前主栏目下的所有文章

        $res_jidi = db('article')->alias('a')->field('a.art_id,art_content,art_time,art_title,art_img,art_cat_id,art_describe,b.id,enname')->
        join('lvhua_cat b','a.art_cat_id=b.id')->where("art_cat_id IN($jidi_all_id)")->order('art_id asc')->limit(4)->select();
        $this->assign('all_jidi',$res_jidi);
        //dump($res_jidi);die;
    }
}
