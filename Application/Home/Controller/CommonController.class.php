<?php
namespace Home\Controller;
use Think\Controller;

    class CommonController extends Controller
    {
        public function _initialize()
        {
        	//判断是否已经登录了
        	if(!session('?homeMealInfo')){
           		$this->redirect('Home/Login/login');
           		exit;
        	}
        	//查询最新的订单是否开启与商家编号
        	$sql = "SELECT id, status, merchantmumber 
                    FROM ".C('DB_PREFIX')."system 
                    ORDER BY id DESC 
                    LIMIT 1";
			$row = M('System')->query($sql)[0];

			//status 1 为订单开启
			if ($row['status'] == 1) {
                $_SESSION['homeMealInfo']['number']    = $row['merchantmumber'];
			} else {
				$_SESSION['homeMealInfo']['number'] = null;
			}
            $_SESSION['homeMealInfo']['system_id'] = $row['id'];
        }
    }