<?php
namespace Admin\Controller;
use Think\Controller;

    class CommonController extends Controller
    {
        public function _initialize()
        {
           if(!session('?homeMealInfo')){
               $this->redirect('Home/Login/login');
               exit;
           }
           //判断如果不是订餐员无法进入后台管理 
           if ($_SESSION['homeMealInfo']['role'] != 1) {
           		$this->error('亲，您没有权限', U('Home/Index/index'), 2);
           		exit;
           }
        }
    }