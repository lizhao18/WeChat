<?php
namespace app\index\controller;

use think\Controller;

class Register extends Controller
{
 	
  // 处理登录逻辑
    public function doRegister()
    {
    	$param = input('post.');  //把post过来的数据赋给param
    	if(empty($param['user_name'])){    //如果param里的user_name这个变量为空
    		
    		$this->error('用户名不能为空');
    	}
    	
    	if(empty($param['user_pwd'])){    //如果param里的user_pwd这个变量为空
    		
    		$this->error('密码不能为空');
    	}
      
    	if(empty($param['user_pwd_confirm'])){    //如果param里的user_pwd_confirm这个变量为空
    		
    		$this->error('密码不能为空');
    	}
        if(($param['user_pwd']) != ($param['user_pwd_confirm']))
        {
          $this->error('两次输入密码不同！请重新输入');
        
        }
      
    	// 验证用户名
    	$has = db('users')->where('user_name', $param['user_name'])->find();  //从数据库的users这个表的user_name字段查找，找出与param里user_name这个变量的值相同的记录，把整个记录赋给has
    	if(!empty($has)){
    		$this->error('用户已存在,请重新注册');
    	}
    	
      	$pwd_md5 = md5($param['user_pwd']);
      	
      	$data = array(
          'id' => '0',
          'user_name' => $param['user_name'],
          'user_pwd' => $pwd_md5,
        );
      
      	db('users')->insert($data);
      	$this->redirect(url('index/register'));
 
}
}
?>