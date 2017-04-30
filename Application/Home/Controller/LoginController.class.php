<?php
namespace Home\Controller;
use Think\Controller;
	
	class LoginController extends Controller 
	{
		/**
		 * 功能：前台登录控制器
		 * @author chenbin
		 * @since 
		 * @return 写入SESSION 
		 * 
		 */
	    public function login()
	    {
	    	if (IS_GET) {
	    		$this->display();
	    		exit;
	    	}
	    	$map = I('post.');
	    	$row = D('System')->loginHandle($map);

    		session('homeMealInfo', $row);
            $this->success('登录成功', U('Home/Index/index'));
	    }

	    /**
		 * 功能：前台退出处理
		 * @author chenbin
		 * @since 
		 *
		 */
	    public function logout()
	    {
	    	session('homeMealInfo', null);
        	$this->success('退出成功', U('Home/Login/login'));
	    }
	}