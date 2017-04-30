<?php
namespace Home\Model;
use Think\Model;

    class SystemModel extends Model
    {
        /**
         * 功能：前台登录具体处理操作
         * @author chenbin
         * @since 
         * @param  $map  登录传入参数 
         * @return [array]
         * 
         */
    	public function loginHandle($map)
    	{	
    		if (empty($map['username'])) {
    			echo "<script>alert('用户名不能为空');history.go(-1);</script>";
    			exit;
    		}
    		if (empty($map['password'])) {
    			echo "<script>alert('密码不能为空');history.go(-1)</script>";
    			exit;
    		}
    		//查询数据库里是否存在该用户名
    		$arr['username'] = $map['username']; 
    		$row = M('User')->where($arr)->find();
    		if (!$row) {
    			echo "<script>alert('用户名不正确');history.go(-1)</script>";
    			exit;
    		}
    		//判断密码是否正确
    		$password = $map['password'];
    		$hash = $row['password'];
    		if (!password_verify ($password, $hash)) {
    			echo "<script>alert('密码不正确');history.go(-1)</script>";
    			exit;
    		}
    		//判断用户状态是否正常
    		$status = $row['status'];
    		if ($status == 2) {
    			echo "<script>alert('用户被禁用，请联系管理员');history.go(-1)</script>";
    			exit;
    		}

    		//查询系统表中的数据用来进行判断
			$sqlSystem = "SELECT id, status, merchantmumber 
                          FROM ".C('DB_PREFIX')."system 
                          ORDER BY id DESC 
                          LIMIT 1";
            $resSystem = $this->query($sqlSystem)[0];

    		//获取当前登录是什么角色
    		$role = $row['role'];
    		if ($role == 1) {
    			//这里是处理订餐员的
	    		//判断如果关闭了，登录后跳转其他页面填写商家编号
	    		if ($resSystem['status'] == 2) {
                    //这里要先存进session，但是不包含商家编号，不然会登不进去
                    session('homeMealInfo', $row);
                    redirect(U('Home/Index/merchantMumber'));
                    exit;
	    		}
    			//如果登录时是开启，就直接进入这里，从数据库中查询出商家编号存进session中	
	    		$row['number'] = $resSystem['merchantmumber'];
	    		return $row;
    		} else { 
    			//这里是处理普通用户的
    			//如果status是 2 为订餐员还未开启 返回null 
    			if ($resSystem['status'] == 2) {		
	    			$row['number'] = null;
                    return $row;
    			}
    			//最后返回的商家编号
    			$row['number'] = $resSystem['merchantmumber'];
    			return $row;
    		}	
    	}
    }