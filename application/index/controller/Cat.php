<?php
namespace app\index\controller;
use think\Db;
use app\index\model\Cat as CatModel;
use app\index\model\Article as ArtModel;
class Cat extends Init
{


    public function lst()
    {
        $cat = new CatModel();
       // dump ($cat);die;
       $cat_lst_res = $cat->catTree();
       //dump ($cat_lst_res);die;
        $this->assign('cat_lst',$cat_lst_res);
        return view();
    }

    //添加栏目
    public function add()
    {
        if(request()->isPost())
        {
         $data =   input('post.');
       //  dump($data);die;
            $validate = validate('cat');
            if(!$validate->check($data))
            {
                    $this->error($validate->getError());
}

            $res = Db::name('cat')->insert($data);

           if($res)
           {
               $this->success('添加栏目成功!',url('cat/lst'));
           }else
           {
               $this->error('添加栏目失败!');
           }


        }

        //我们需要在页面显示当前栏目以便于栏目分类
        $cat = new CatModel();
        $cat_pid_res = $cat->catTree();
        $this->assign('cat_pid',$cat_pid_res);
        return view();
    }


    //编辑栏目
    public function edit()
    {
        //我们需要在页面显示当前栏目以便于栏目分类
        $cat = new CatModel();
        $cat_pid_res = $cat->catTree();
        $this->assign('cat_pid',$cat_pid_res);
        //拿到当前的数据
        $id = input('id');
        $data = Db::name('cat')->find($id);
      //dump($data);die;
        $this->assign('now_cat',$data);
        //如果是post提交就开始更改
        if (request()->isPost())
        {
            $data = input('post.');
            $validate = validate('cat');
            if(!$validate->scene('edit')->check($data))
            {
                $this->error($validate->getError());
            }
            $res = db('cat')->update($data);
            if($res)
            {
                $this->success('更改栏目成功!',url('cat/lst'));
            }else
                {
                $this->error('没有更改栏目!',url('cat/lst'));
            }

        }
        return view();
    }



    //删除的方法
    public function del()
    {
        $id = input('id');

        $cat = new CatModel();

        $res = $cat->delTree($id);
        //删除栏目同时删除栏目下面的所有文章

        //把顶级栏目ID也赋值进去
        $res[] = $id;
foreach ($res as $k => $v)
{
    //把当前所有栏目下的ID赋值给文章表的art_cat_id字段，然后用文章表的art_cat_id字段删除文章数据
ArtModel::destroy(['art_cat_id'=>$v]);
}
        //如果有子级栏目，就进行批量删除
        //$res[] = $id;
        //dump($art_id);die;
        if($res)
        {
           $res = Db::table('lvhua_cat')->delete($res);
            if ($res)
            {
                $this->success('删除栏目成功!',url('cat/lst'));
            }else
            {
                $this->error('删除栏目失败!');
            }
        }


    }
}
