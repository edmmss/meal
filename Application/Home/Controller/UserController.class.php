<?php
namespace Home\Controller;
use Think\Controller;

    class UserController extends CommonController
    {
        /**
         * 功能：用户修改密码
         * @author chenbin
         * @since 
         * @return [array]  
         *
         */
    	public function editPass()
    	{
    		if (IS_GET) {
    			$this->display();
    			exit;
    		}
    		$map = I('post.');
    		foreach ($map as $v) {
    			if (empty($v)) {
    				$this->error('请填写完整', U('Home/User/editPass'), 2);
    				exit;
    			}
    		}
    		if ($map['newPassword'] != $map['confirmPassword']) {
    			$this->error('两次密码不正确', U('Home/User/editPass'), 2);
    			exit;
    		}
    		$password = $map['password'];
    		$userId = $_SESSION['homeMealInfo']['id'];
    		$hash = M('User')->where("id=$userId")->getField('password');

    		if (!password_verify($password, $hash)) {
    			$this->error('原密码错误', U('Home/User/editPass'), 2);
    			exit;
    		}
    		$newPassword = $map['newPassword'];
    		$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    		$tmp['password'] = $newPassword;
    		$res = M('User')->where("id=$userId")->save($tmp);
    		if (!$res) {
    			$this->error('修改失败', U('Home/User/editPass'), 2);
    			exit;
    		}
    		$this->success('修改成功', U('Home/Index/index'), 2);

    	}
    }