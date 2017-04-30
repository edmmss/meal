<?php
namespace Home\Controller;
use Think\Controller;

    class IndexController extends CommonController
    {
    	/**
		 * 功能：前台首页控制器
		 * @author chenbin
		 * @since 
		 * @return [array]  
		 *
		 */
        public function index()
        {
            //这里是判断订餐员进入后台或者修改密码返回到index页面时也需要跳转到merchantMumber 进行商家编号填写
            if ($_SESSION['homeMealInfo']['role'] == 1 && $_SESSION['homeMealInfo']['number'] == null) {
                $this->redirect('Home/Index/merchantMumber');
                exit;
            }
            //查询个人余额
            $userId = $_SESSION['homeMealInfo']['id'];
            $money = M('User')->where("id=$userId")->getField('money');
        	//食品列表数据
            $resFoodsData  = D('Orders')->getFoodsData();
            //获取当前店家名字
            $resMerchantName = D('Orders')->getMerchantName();
            //查询个人购买信息和每个人分别购买的食物
            $resPersonOrdersData = D('Orders')->getPersonOrdersData();
            //查询全体人员的购买信息的数组（包括数据和总价）
            $resAllOrdersData = D('Orders')->getAllOrdersData();
            //全体人员的总价
            $allTotal = $resAllOrdersData['allTotal'];
            //查询该次订单状态 system表 开启or关闭
            $status = D('Orders')->getStatusSystemData();
            //查询还有那些用户没有点餐
            $resSurplusUser = D('Orders')->getSurplusUser();

            $this->assign('money', $money);
            $this->assign('status', $status);
            $this->assign('allTotal', $allTotal);
            $this->assign('resFoodsData', $resFoodsData);
            $this->assign('resSurplusUser', $resSurplusUser);
            $this->assign('resMerchantName', $resMerchantName);
            $this->assign('resPersonOrdersData', $resPersonOrdersData);
            $this->assign('resAllOrdersData', $resAllOrdersData['data']);
            $this->display();
        }

        /**
		 * 功能：前台添加食物控制器
		 * @author chenbin
		 * @since 
		 * @return [array]  
		 *
		 */
        public function add()
        {
        	$dataStr = htmlspecialchars_decode(I('post.dataJsonStr'));
        	$dataAry = json_decode($dataStr, true);
            
        	$res = D('Orders')->addDataHandle($dataAry);
        	if (!$res) {
                if ($res == 0) {
                    $this->ajaxReturn(0);
                    exit;
                }
        		$this->ajaxReturn(false);
        		exit;
        	}
        	$this->ajaxReturn(true);	
        }

         /**
         * 功能：前台订餐员提交订餐
         * @author chenbin
         * @since 
         * @return [array]  
         *
         */
        public function submitOrder()
        {
            //获取当前用户的角色
            $role = $_SESSION['homeMealInfo']['role'];
            if ($role != 1) {
                $this->ajaxReturn('只有订餐员才能提交订单哦');
                exit;
            }
            $total = I('post.allTotal');
            //查询最新的id
            $maxId = M('System')->max('id');
            //更新为提交时间
            $time  = time(); 
            //提交订单时就修改 status 为2 关闭完成这次订单
            $sql = "UPDATE ".C('DB_PREFIX')."system SET status = 2, addtime = {$time}, total = {$total} WHERE id = {$maxId}";
            $res = M('System')->execute($sql);
            if (!$res) {
                $this->ajaxReturn('订单提交失败');
                exit;
            }
            $this->ajaxReturn('订单提交成功');
            exit;
        }

        /**
         * 功能：前台订单删除（个人操作）
         * @author chenbin
         * @since 
         * @return [array]  
         *
         */
        public function delete()
        {
            //判断订餐员是否已经提交订餐
            $systemMaxId = M('System')->max('id');
            $status = M('System')->where("id=$systemMaxId")->getField('status');
            if ($status == 2) {
                //1 代表订单已经提交，不能修改
                $this->ajaxReturn(1);
                exit;
            }
            $foodName = I('post.foodName');
            $user_id  = $_SESSION['homeMealInfo']['id']; 
            $sql = "DELETE FROM ".C('DB_PREFIX')."orders WHERE user_id = {$user_id} AND system_id = {$systemMaxId} AND foodname = '{$foodName}'";
            $res = M('Orders')->execute($sql);
            if (!$res) {
                //2 代表删除订单失败
                $this->ajaxReturn(2);
                exit;
            }
            //3 代表删除订单成功
            $this->ajaxReturn(3);
            exit;
        }

        /**
         * 功能：前台订单删除（订餐员操作）
         * @author chenbin
         * @since 
         * @return [array]  
         *
         */
        public function orderTakerDelete()
        {
            //获取食物名
            $foodName = I('post.allFoodName');
            //获取最新的systemID
            $systemMaxId = M('System')->max('id');
            $status = M('System')->where("id=$systemMaxId")->getField('status');
            if ($status == 2) {
                $this->ajaxReturn('其他订餐员已经关闭订餐哦');
                exit;
            }
            $sql = "DELETE FROM ".C('DB_PREFIX')."orders WHERE system_id = {$systemMaxId} AND foodname = '{$foodName}'";
            $res = M('Orders')->execute($sql);
            if (!$res) {
                $this->ajaxReturn('操作失败');
                exit;
            }
            $this->ajaxReturn('操作成功');
            exit;
        }

        /**
         * 功能：订餐员开启订餐
         * @author chenbin
         * @since 
         * @return [array]  
         *
         */
        public function system()
        {
            $systemMaxId = M('System')->max('id');
            //第一次没有数据的时候
            if (!empty($systemMaxId)) { 
                $status = M('System')->where("id=$systemMaxId")->getField('status');
                //如果其他订餐员已经申请，你就可以直接进去了
                if ($status == 1) {
                    $this->success('其他订餐员已经开启，现在直接进入点餐页面', U('Home/Index/index'), 2);
                    exit;
                }
            }
            if (empty(I('post.merchantMumber'))) {
                $this->error('商家编号不能为空', U('Home/Index/merchantMumber'), 2);
                exit;
            }
            $map['merchantmumber'] = I('post.merchantMumber');
            $map['status'] = 1;
            $map['addtime'] = time();
            $map['username'] = $_SESSION['homeMealInfo']['username'];
            $res = M('System')->add($map);
            if (!$res) {
                $this->error('操作失败', U('Home/Index/merchantMumber'), 2);
                exit;
            }
            //将商家编号存在session中
            $_SESSION['homeMealInfo']['number'] = I('post.merchantMumber');
            $this->success('操作成功', U('Home/Index/index'), 1);
            exit;
        }

        /**
         * 功能：取消订餐
         * @author chenbin
         * @since 
         * @return [array]  
         *
         */ 
        public function deleteSystem()
        {
            $res = D('Orders')->handleDeleteSystem();
            if (!$res) {
                $this->ajaxReturn(flase);
                exit;
            }
            $this->ajaxReturn(true);
            exit;
        }
    }