<?php
namespace Admin\Model;
use Think\Model;

    class UserModel extends Model
    {
        /**
         * 功能：处理后台首页用户具体数据
         * @author chenbin
         * @since 
         * @return [array]  
         *
         */
    	public function getIndexData($op)
    	{
    		$str = "WHERE id > 0 ";
    		if (!empty($op['username'])) {
    			$str .= " AND username LIKE '%{$op['username']}%'";
    		}

    		if (!empty($op['role'])) {
    			$str .= " AND role = {$op['role']}";
    		}

            if (!empty($op['money'])) {
                if ($op['money'] == 1) {
                    $str .= " AND money >= 0";
                } else {
                    $str .= " AND money < 0";
                }
            }   

    		//每页显示数量
    		$num = 10;
    		$sqlCount = "SELECT COUNT(id) AS num 
    					 FROM ".C('DB_PREFIX')."user ".$str;
    		$count = $this->query($sqlCount)[0]['num'];

    		$page = new \Think\Page($count, $num);
    		$btn  = $page->show();

            //id倒叙，分页
    		$str .= " ORDER BY id DESC LIMIT {$page->firstRow}, {$page->listRows}";
    		$sql  = "SELECT id, username, role, status, addtime, money
    				FROM ".C('DB_PREFIX')."user ".$str;
    		$row  = $this->query($sql);

    		$strRole         = ['1'=>'订餐员', '2'=>'普通成员'];
    		$strStatus       = ['1'=>'正常', '2'=>'禁用'];
    		$strStatusSecond = ['1'=>'禁用', '2'=>'恢复'];
            //如果没有数据，返回空数组
    		if (!$row) {
    			$row = [];
    			return $row;
    		}
    		$row[0]['btn']   = $btn;
    		$row[0]['total'] = $count;

    		foreach ($row as $k=>&$v) {
    			$row[$k]['statusSecond']  = $strStatusSecond[$v['status']];
                $v['role']    = $strRole[$v['role']];
    			$v['status']  = $strStatus[$v['status']];		
    			$v['addtime'] = date('Y-m-d H:i:s', $v['addtime']); 
    		}
    		return $row;
    	}
    }