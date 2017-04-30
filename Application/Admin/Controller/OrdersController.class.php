<?php
namespace Admin\Controller;
use Think\Controller;

    class OrdersController extends CommonController
    {
        /**
         * 功能：后台食物首页
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
    		$row = D('Orders')->getIndexData($op);
    		$this->assign('row', $row);
    		$this->display();
    	}

        /**
         * 功能：删除食物
         * 
         * @author chenbin
         * @since 
         * @return [string]  
         *
         */
    	public function delete()
    	{
    		$ordersId = I('get.id');
    		$sql = "DELETE FROM ".C('DB_PREFIX')."orders WHERE id = '{$ordersId}'";
    		$res = M('Orders')->execute($sql);
    		if (!$res) {
    			$this->error('删除失败', U('Admin/Orders/index'), 2);
    			exit;
    		}
    		$this->success('删除成功', U('Admin/Orders/index'), 2);
    		exit;
    	}

        /**
         * 功能：批量删除食物
         * 
         * @author chenbin
         * @since 
         * @return [string]  
         *
         */
    	public function batchDetele()
    	{
    		$idsStr = I('post.ids');
    		//判断如果字符串里面存在 on, 就替换掉
    		$idsStr = str_replace('on,', '', $idsStr);
    		$sql = "DELETE FROM ".C('DB_PREFIX')."orders WHERE id IN ({$idsStr})";
    		$res = M('Orders')->execute($sql);
    		if (!$res) {
    			$this->ajaxReturn(false);
    			exit;
    		}
    		$this->ajaxReturn(true);
    		exit;
    	}

        /**
         * 功能：减免
         * 
         * @author chenbin
         * @since 
         * @return [string]  
         *
         */
        public function derate()
        {
            if (IS_GET) {
                $this->display();
                exit;
            }
            $money = I('post.money');
            if (empty($money)) {
                $this->error('请填写金额', U('Admin/Orders/derate'), 2);
                exit;
            }
            //状态为 1：正常 才能减免 
            $sql = "UPDATE ".C('DB_PREFIX')."user SET money = money + {$money} WHERE status = 1";
            $res = M('User')->execute($sql);
            if (!$res) {
                $this->error('操作失败', U('Admin/Orders/derate'), 2);
                exit;
            }
            $this->success('操作成功', U('Admin/User/index'), 2);
            exit;
        }

   	}