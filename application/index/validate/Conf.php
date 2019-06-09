<?php
namespace app\index\validate;
use think\Validate;
class Cat extends Validate
{
    protected $rule =
        [
            'cat_name'  =>  'require|max:5',
        ];
    protected $message =
        [
            'cat_name.require' => '栏目不能为空',
            'cat_name.max' => '名称不能超过五个字',
        ];
    //验证场景
    protected $scene =
        [
            'edit' => ['cat_name' => 'max:5'],
        ];
}