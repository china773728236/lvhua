<?php
/*
 * 前台联系我们
 * */
namespace app\front\controller;

class Contact extends Init
{
    //后台列表
    public function index()
    {
        return view('contact');
    }


}
