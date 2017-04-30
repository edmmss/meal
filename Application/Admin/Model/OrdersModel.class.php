<?php
namespace Admin\Model;
use Think\Model;

    class OrdersModel extends Model
    {
        /**
         * 功能：处理后台首页食物具体数据
         * @author chenbin
         * @since 
         * @return [array]  
         *
         */
    	public function getIndexData($op)
    	{
    		$str = "WHERE o.id > 0 ";
    		if (!empty($op['username'])) {
    			$str .= " AND u.username LIKE '%{$op['username']}%'";
    		}

    		//每页显示数量
    		$num = 10;
    		$sqlCount = "SELECT COUNT(o.id) AS num 
    					 FROM ".C('DB_PREFIX')."orders o 
    					 LEFT JOIN ".C('DB_PREFIX')."user u ON o.user_id = u.id ".$str;
    		$count = $this->query($sqlCount)[0]['num'];
    		$Page = new \Think\Page($count, $num);

    		//此处为获取路径，根目录/模块名/控制器名/方法
    		$module_name = __ROOT__.'/index.php/' . MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;
    		//设置输入数量的按钮
	       	$Page->setConfig('header', '<p><span>%NOW_PAGE%</span>/<span title="%TOTAL_PAGE%" class="all">%TOTAL_PAGE%</span>&nbsp&nbsp&nbsp</p><p><input type="text" style="width:70px" id="page_num" class="txt_page"  /></p>&nbsp&nbsp&nbsp<a class="gopage" href="'.$module_name.'/p/">GO</a>');
	       	$Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
	       	//show1 为新添加的thinkphp内置方法，是另一种分页展示
			$btn = $Page->show1();

    		$str .= " ORDER BY o.id DESC LIMIT {$Page->firstRow}, {$Page->listRows}";
    		$sql = "SELECT o.id, u.username, o.foodname, o.price, o.num, o.total, o.addtime 
    				FROM ".C('DB_PREFIX')."orders o 
    				LEFT JOIN ".C('DB_PREFIX')."user u ON o.user_id = u.id ".$str;  	
    		$row = $this->query($sql);

            //如果没有数据，返回空数组
    		if (!$row) {
    			$row = [];
    			return $row;
    		}
    		$row[0]['btn'] = $btn;
    		$row[0]['count'] = $count;
    		foreach ($row as &$v) {	
    			$v['addtime'] = date('Y-m-d H:i:s', $v['addtime']); 
    		}
    		return $row;
    	}
    }