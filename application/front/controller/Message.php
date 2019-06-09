<?php
/*
 * 前台关于公司详情页
 * */
namespace app\front\controller;

class Message extends Init
{
    //后台列表
    public function index()
    {
        return view('message');
    }

    //后台增加页面
    public function add()
    {
        return view();
    }

    //后台编辑页面
    public function edit()
    {
        return view();
    }
}
