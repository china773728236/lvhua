<?php
namespace app\index\controller;

use think\Controller;

class Test extends Controller
{
    protected $beforeActionList = [
        //'first',
        'second' =>  ['only'=>'hello,te'],
       // 'three'  =>  ['only'=>'hello,data'],
    ];

    /*protected function first()
    {
        echo 'first<br/>';
    }*/

    protected function second()
    {
        echo 'second<br/>';
    }

    public function te()
    {
        echo 'three<br/>';
    }

   public function data()
    {
      return 'data';
    }


    public function hello()
    {
        return 'hello';
   }


}
