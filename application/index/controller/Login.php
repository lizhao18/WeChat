<?php
namespace app\index\controller;

use think\Controller;

class Login extends Controller
{
  public function index()
  {
  	return $this->fetch();
  }
  
  public function register()
  {
  	return $this->fetch();
  }
  
  // 处理登录逻辑
    public function doLogin()
    {
    	$param = input('post.');  //把post过来的数据赋给param
    	if(empty($param['user_name'])){    //如果param里的user_name这个变量为空
    		
    		$this->error('用户名不能为空');
    	}
    	
    	if(empty($param['user_pwd'])){    //如果param里的user_pwd这个变量为空
    		
    		$this->error('密码不能为空');
    	}
    	
    	// 验证用户名
    	$has = db('users')->where('user_name', $param['user_name'])->find();  //从数据库的users这个表的user_name字段查找，找出与param里user_name这个变量的值相同的记录，把整个记录赋给has
    	if(empty($has)){
    		
    		$this->error('用户名密码错误');
    	}
    	
    	// 验证密码
    	if($has['user_pwd'] != md5($param['user_pwd'])){   //如果has中的user_pwd这个变量（数据库中查找到的变量）和param中的user_pwd这个变量（用户传进来的变量）不一致
    		
    		$this->error('用户名密码错误');
    	}
    	
    	// 记录用户登录信息
    	cookie('user_id', $has['id'], 3600);  // 一个小时有效期
    	cookie('user_name', $has['user_name'], 3600);
    	
    	$this->redirect(url('index/index'));  //重定向到index类中的index方法（php语法中类名和函数名可以不区分大小写）
    }
  
   // 退出登录
    public function loginOut()
    {
    	cookie('user_id', null);
    	cookie('user_name', null);
    	
    	$this->redirect(url('login/index'));  //重定向到login类中的index方法
    }
  
  public function toregister(){
  	$this->redirect(url('Login/register'));
  }
}
?>