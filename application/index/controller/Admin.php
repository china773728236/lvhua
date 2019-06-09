<?php
/*
 * 后台列表,列表,编辑页面
 * */
namespace app\index\controller;
use app\index\model\Admin as AdminModel;
//use app\index\controller\Cat;
//引入控制器类

use think\Db;

class Admin extends Init
{

    //后台列表
    public function lst()
    {
        //db(当前表)->alias(当前表的别名)->field(当前表的字段，另一张表的字段)->join('另一张表 表的别名'，当前表与另一张表相同的字段)->select();
        $res = db('admin')->alias('a')->field('a.id,username,b.title')->join('lvhua_auth_group b','a.group_id = b.id')->select();
        //$page = $res->render();
        $this->assign('res',$res);
      //  $this->assign('page',$page);
    //  dump($a);die;
        return view();
    }

    //后台增加管理员页面
    public function add()
    {
        //查询用户组表
        $res = db('auth_group')->select();
  $this->assign('res',$res);
        //如果是post提交过来的的话执行添加逻辑
if(request()->isPost())
{
    //拿到post数据
    $post = input('post.');
    //dump($post);die;
    //如果两次输入的密码一致
    if($post['pwd'] == $post['repwd'])
    {
        //加密密码
        $post['pwd'] = md5($post['pwd']);
        $post['repwd'] = md5($post['repwd']);


       //将加密后的数据添加进入数据库
        $res = db('admin')->insert($post);


        if($res)
        {
            $res_id = Db::name('admin')->getLastInsID();

            //如果管理员添加成功把管理员类型再添加进管理员明细表中
            $auth_access = array();
            $auth_access['uid'] = $res_id;
            $auth_access['group_id'] = $post['group_id'];
            db('auth_group_access')->insert($auth_access);
            $this->success('添加管理员成功',url('lst'));
        }else
            {
            $this->error('添加管理员失败');
        }

    }else
    {
        $this->error('前后密码不一致，请重新设置新密码!');
    }
    return;
}
        //
        return view();
    }

    //后台修改管理员名称页面
    public function editusr($id)
    {
        //先查询管理员名称
        $res = Db::name('admin')->find($id);
        //防止用户乱输入id
  if(!$res)
  {
      $this->error('用户不存在');
  }
        $this->assign('editusr',$res);
        //查询到后执行修改
        if (request()->isPost())
        {
            $data = input('post.');
            //dump($data);die;
            $res = db('admin')->update($data);
         //   dump($res);die;
            if($res)
            {
                $this->success('修改管理员名称成功!',url('admin/lst'));
            }else
            {
                $this->error('修改管理员名称失败!');
            }
            //dump($data);die;
        }
        return view();
    }

    //后台修改管理员密码
    public function editpwd($id)
    {
        //同样先拿到数据
        $res = Db::name('admin')->find($id);
        //防止用户乱输入id
        if(!$res)
        {
            $this->error('用户不存在');
        }
        $this->assign('editpwd',$res);
        //开始进行更改密码
        if (request()->isPost())
        {
            $data = input('post.');
          //  dump($data);die;
            //如果两次输入的密码一致
            if ($data['pwd'] == $data['repwd'])
            {
                //加密密码并更改密码
                $data['pwd'] = md5($data['pwd']);
                $data['repwd'] = md5($data['repwd']);
                $res = db('admin')->update($data);
                if ($res)
                {
                    $this->success('更改密码成功!',url('admin/lst'));
                }else
                {
                    $this->error('更改密码失败!');
                }
            }
        }
        return view();
    }


    //修改管理员权限
    public function editAuth()
    {
        //查询用户组表
        $res = db('auth_group')->select();

        $this->assign('res',$res);
        //同样先拿到数据
        $id = input('id');
        $res_admin = Db::name('admin')->find($id);
        //防止用户乱输入id
        if(!$res_admin)
        {
            $this->error('用户不存在');
        }
        $this->assign('res_admin',$res_admin);
        //拿到用户类型的ID
        $res_group_access = Db::name('auth_group_access')->where('uid',$id)->find();
       $this->assign('auth_access',$res_group_access);
       if(request()->isPost())
       {
           $data = input('post.');

           $res = db('auth_group_access')->where('uid',$data['id'])->update(['group_id' => $data['group_id']]);
           if ($res)
           {
               db('admin')->where('id',$data['id'])->update(['group_id' => $data['group_id']]);
               $this->success('更改权限成功!',url('lst'));
           }else
           {
               $this->error('未更改任何权限',url('lst'));
           }
       }
        return view();
    }


    //删除管理员
    public function del($id)
    {
        //dump($id);die;
        $res = db('admin')->delete($id);
        if ($res)
        {
           //删除管理员同时把管理员相应的权限一并删除
            db('auth_group_access')->where('uid',$id)->delete();
            $this->success('删除管理员成功!',url('admin/lst'));
        }else
        {
            $this->error('删除失败!');
        }
    }

    //退出登录
    public function logout()
    {
        //清除所有session信息
        session(null);
        $this->success('成功退出',url('login/index'));
    }







}
