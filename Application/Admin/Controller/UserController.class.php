<?php
namespace Admin\Controller;
use Think\Controller;

    class UserController extends CommonController
    {
        /**
         * 功能：后台用户首页
         * 
         * @author chenbin
         * @since 
         * @param  [array]  $op 参数数组   
         * @return [array]  
         *
         */
    	public function index()
    	{
    		$op = I('get.');
    		$row = D('User')->getIndexData($op);
    		$this->assign('row', $row);
    		$this->display();
    	}
        
        /**
         * 功能：修改用户状态
         * 
         * @author chenbin
         * @since 
         * @return [string]  
         *
         */
    	public function status()
    	{
    		$userId = I('get.id');
    		$status = M('User')->where("id=$userId")->getField('status');
    		if ($status == 1) {
    			$status = 2;
    		} else {
    			$status = 1;
    		}
    		$sql = "UPDATE ".C('DB_PREFIX')."user SET status = {$status} WHERE id = '{$userId}'";
    		$res = M('User')->execute($sql);
    		if (!$res) {
    			$this->error('修改失败', U('Admin/User/index'), 2);
    			exit;
    		}
    		$this->success('修改成功', U('Admin/User/index'), 2);
    		exit;
    	}

        /**
         * 功能：删除用户
         * 
         * @author chenbin
         * @since 
         * @return [string]  
         *
         */
    	public function delete()
    	{
    		$userId = I('get.id');
    		if ($userId == $_SESSION['homeMealInfo']['id']) {
    			$this->error('不能删除当前使用的用户', U('Admin/User/index'), 2);
    			exit;
    		}

            //查询用户是否有购买过食物
            $sqlOrdersSel = "SELECT id FROM ".C('DB_PREFIX')."orders WHERE user_id = '{$userId}'";
            $resOrdersSel = M('Orders')->query($sqlOrdersSel);

            $sqlUser = "DELETE FROM ".C('DB_PREFIX')."user WHERE id = '{$userId}'";
            //开启事务
            M('User')->startTrans();
            $resUser = M('User')->execute($sqlUser);

            //判断该用户是否有购买过食物，有的话把用户相关食物订单一并删除
            if ($resOrdersSel) {
                //这里删除用户和用户相关食物的信息
                $sqlOrders = "DELETE FROM ".C('DB_PREFIX')."orders WHERE user_id = '{$userId}'";
                M('Orders')->startTrans();
                $resOrders = M('Orders')->execute($sqlOrders);

                if (!$resUser || !$resOrders) {
                    //事务回滚
                    M('User')->rollback();
                    M('Orders')->rollback();
                    $this->error('删除失败', U('Admin/User/index'), 2);
                    exit;
                } 
                    //事务提交
                    M('User')->commit();
                    M('Orders')->commit();
                    $this->success('删除成功', U('Admin/User/index'), 2);
                    exit;

            } else {
                //这里只是删除用户的信息
                if (!$resUser) {
                    //事务回滚
                    M('User')->rollback();
                    $this->error('删除失败', U('Admin/User/index'), 2);
                    exit;
                } 
                    //事务提交
                    M('User')->commit();
                    $this->success('删除成功', U('Admin/User/index'), 2);
                    exit;
            }  		
    	}

        /**
         * 功能：添加用户
         * 
         * @author chenbin
         * @since 
         * @return [string]  
         *
         */
    	public function addUser()
    	{
    		if (IS_GET) {
    			$this->display();
    			exit;
    		} 
    		$username = I('post.username');
    		$map = I('post.');
            //判断是否为空
    		if (empty($map['username'])) {
    			$this->error('请填写用户名', U('Admin/User/addUser'), 2);
    			exit;
    		}
    		if ($map['role'] == 0) {
    			$this->error('请选择角色', U('Admin/User/addUser'), 2);
    			exit;
    		}
            //判断用户是否已经注册
            $resUsername = M('User')->where("username='$username'")->find();
            if ($resUsername) {
                $this->error('该用户名已注册', U('Admin/User/addUser'), 2);
                exit;
            }
    		$map['addtime'] = time();
    		$map['password'] = password_hash('123456', PASSWORD_DEFAULT);
    		$map['status'] = 1;
    		$res = M('User')->add($map);
    		if (!$res) {
    			$this->error('添加失败', U('Admin/User/addUser'), 2);
    			exit;
    		}
    		$this->success('添加成功', U('Admin/User/index'), 2);
    		exit;
    	}

        /**
         * 功能：用户充值
         * 
         * @author chenbin
         * @since 
         * @return [string]  
         *
         */
    	public function pay()
    	{
    		if (IS_GET) {
    			$userId = I('get.id');
    			$row = M('User')->where("id=$userId")->find();
    			$this->assign('row', $row);
    			$this->display();
    			exit;
    		} 
    		$userId = I('post.id');
    		$money = I('post.money');
    		if (empty($money)) {
    			$this->error('请填写充值金额', U('Admin/User/pay', ['id'=>$userId]), 2);
    			exit;
    		}
    		$sql = "UPDATE ".C('DB_PREFIX')."user SET money = money + {$money} WHERE id = {$userId}";
    		$res = M('User')->execute($sql);
    		if (!$res) {
    			$this->error('充值失败', U('Admin/User/pay', ['id'=>$userId]), 2);
    			exit;
    		}
    		$this->success('充值成功', U('Admin/User/index'), 1);
    		exit;
    	}
    }