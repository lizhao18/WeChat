<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
		echo "您好： " . cookie('user_name') . ', <a href="' . url('login/loginout') . '">退出</a>';    //点击退出会重定向到login类中的loginout方法
    }
  
  	public function register()
    {
     echo "您好，您已注册成功。".'<a href=" ' . url('login/index') . '">返回登陆界面</a>';  
    }
}
