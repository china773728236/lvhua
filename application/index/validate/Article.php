<?php
/*
 * 针对文章的验证
 * */
namespace app\index\validate;
use think\Validate;
class Article extends Validate
{
    //首先应该定义错误规则
   protected $rule =
       [
           //unique表示数据库中不能有文章标题是重复的
       'art_title' => 'require|max:15|unique:article',
           'art_author' => 'require|max:15',
           'art_content' => 'require',
           //'art_img' => 'image:type|fileSize:1024*2',
          // 'art_keywords' => 'require|max:5',
          // 'art_describe' => 'require|max:100',

       ];

   //打印提示信息
   protected $message =
       [
           //针对标题打印错误信息
           'art_title.max' => '标题长度不得超过15个字',
           'art_title.require' => '标题不得为空',
           'art_title.unique' => '文章标题不得重复',
         //  'art_img.image' => '请选择正确的图片',
           'art_img.fileSize' => '长度不能超过2M',




           'art_content.require' => '文章内容不得为空',



       ];

   //提示错误的场景
    protected $scene =
        [
            'articleAdd' => ['article_title','article_content','article_classify'],
            'articleEdit' => ['article_title','article_classify'],
            ];
}
?>
