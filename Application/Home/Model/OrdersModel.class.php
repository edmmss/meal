<?php
namespace Home\Model;
use Think\Model;

    class OrdersModel extends Model
    {
    	/**
		 * 功能：处理前台首页食品具体数据
		 * @author chenbin
		 * @since 
		 * @return [array]  
		 *
		 */
        public function getFoodsData()
        {
            //获取原始食物数据
            $dataArt = $this->getOriginalData();
            $start   = 'http://fuss10.elemecdn.com/';
            $end     = '?imageMogr2/thumbnail/100x100';
            //预先定义新数组，稍后用于组装有用的数组
            $tmpArt  = [];
            foreach ($dataArt as $k => $v) {
            	$foodsArt = $v['foods'];
            	foreach ($foodsArt as $k2 => &$v2) {
        			//图片路径的处理
                    $strMiddle = substr($v2['image_path'], 0, 1).'/'.substr($v2['image_path'], 1, 2).'/'.substr($v2['image_path'], 3);
            		//去重复，将值放到键进行判断
            		if (!isset($tmpArt[$v2['name']])) {
                        //判断json数据中是否有图片
                        if (!empty($v2['image_path'])) {
                            //判断图片是jpeg、png、bmp格式
                            if (strpos($strMiddle, 'png')) {
                                $tmpArt[$v2['name']]['image_path']  = $start.$strMiddle.'.png'.$end;
                            } else if (strpos($strMiddle, 'jpeg')) {
                                $tmpArt[$v2['name']]['image_path']  = $start.$strMiddle.'.jpeg'.$end;
                            } else if (strpos($strMiddle, 'bmp')) {
                                $tmpArt[$v2['name']]['image_path']  = $start.$strMiddle.'.bmp'.$end;
                            } 
                            $tmpArt[$v2['name']]['description'] = $v2['description'];
                        } else {
                            $tmpArt[$v2['name']]['description'] = '暂无图片';
                        }
            			//食品的规格
            			foreach ($v2['specfoods'] as $k3 => $v3) {
            				//键传食品单价,如果有original_price 就用此作为价格 否则就用 price
                            empty($v3['original_price'])? $tmpArt[$v2['name']]['standard'][$v3['price'].'/'.$k3] = $v3['specs'][0]['value'].'('.$v3['price'].')' : $tmpArt[$v2['name']]['standard'][$v3['original_price'].'/'.$k3] = $v3['specs'][0]['value'].'('.$v3['original_price'].')';
                            //获取库存
                            $tmpArt[$v2['name']]['stock'] = $v3['stock'];
            			}
            			//食品名字处理
                        $tmpArt[$v2['name']]['name'] = $v2['name'];			
            		} 		
            	}
            }

            return $tmpArt;
        }

        /**
		 * 功能：处理添加食品的数据并插入数据库
		 * 
		 * @author chenbin
		 * @since 
		 * @param  [array]  $dataAry 	购买食物数组
		 * @return [array]  
		 *
		 */
        public function addDataHandle($dataAry)
        {
            $userId = $_SESSION['homeMealInfo']['id'];
            //获取最新的systemID
            $systemMaxId = $_SESSION['homeMealInfo']['system_id'];
            //判断当前订餐是否还在开启，防止订餐员已经关闭但用户并没有刷新页面
            $status = M('System')->where("id=$systemMaxId")->getField('status');
            if ($status == 2) {
                //返回0 代表订餐已经关闭
                return 0;
            }
        	$tmpAry = [];

       		foreach ($dataAry as &$v) {
                $tmpAry[$v['foodname']]['name']      = $v['foodname'];
                $tmpAry[$v['foodname']]['total']     = $v['total'];
       			$tmpAry[$v['foodname']]['num']       = $v['num'];
    			$tmpAry[$v['foodname']]['price']     = $v['total'] / $v['num'];
       			$tmpAry[$v['foodname']]['addtime']   = time();
                $tmpAry[$v['foodname']]['user_id']   = $userId;
       			$tmpAry[$v['foodname']]['system_id'] = $systemMaxId;
                //用于减去用户的剩余金额
                $total += $v['total'];
        	}

            //对sql语句进行处理
        	$startSql = "INSERT INTO ".'`'.C('DB_PREFIX')."orders` (`total`,`foodname`,`num`,`price`,`addtime`,`user_id`,`system_id`) VALUES ";
        	foreach ($tmpAry as $v) {
        		$endSql .= "('{$v['total']}', '{$v['name']}', '{$v['num']}', '{$v['price']}', '{$v['addtime']}', '{$v['user_id']}', '{$v['system_id']}'),";
        	}
        	//去除最后的逗号
            $endSql = rtrim($endSql, ',');
        	$sql = $startSql.$endSql;

            //开启事务
            $this->startTrans();
            M('User')->startTrans();
        	$res = $this->execute($sql);
            //减去用户的剩余金额
            $sqlMoney = "UPDATE ".C('DB_PREFIX')."user SET money = money - {$total} WHERE id = {$userId}";
            $resMoney = M('User')->execute($sqlMoney);
        	if (!$res || !$resMoney) {
                //回滚事务
                $this->rollback();
                M('User')->rollback();
        		return false;
        	} 
            //提交事务
            $this->commit();
            M('User')->commit();
        	return true;
        }

        /**
		 * 功能：获取个人与每个人分别购买的食物的数据处理
		 * 
		 * @author chenbin
		 * @since 
		 * @return [array]  
		 *
		 */
        public function getPersonOrdersData()
        {
            //获取个人的ID
        	$userId = $_SESSION['homeMealInfo']['id'];
            //获取用户名
            $userName = $_SESSION['homeMealInfo']['username'];
            //获取最新的systemID,思路：先把所有数据查询出来再进行逻辑处理，以当前用户排正序
            $systemMaxId = $_SESSION['homeMealInfo']['system_id'];
        	$sql = "SELECT o.id, o.user_id, o.foodname, o.num, o.price, u.username 
        			FROM ".C('DB_PREFIX')."orders o
        			LEFT JOIN ".C('DB_PREFIX')."user u ON o.user_id = u.id
        			WHERE system_id = {$systemMaxId}
                    ORDER BY user_id = {$userId} DESC"; 

        	//先把所有数据查询出来再进行数据处理
            $row = $this->query($sql);

            $tmpArr = [];

            //判断如果全部人都没有下单的时候
            if (empty($row)) {
                $tmpArr[$userName]['username'] = '<font style="color:red;font-weight:bold">您自己还没购买哦</font>';
                return $tmpArr;
            }

            
            //判断当前用户是否有购买
            if (!array_key_exists($userName, $row)) {
                 $tmpArr[$userName]['username'] = '<font style="color:red;font-weight:bold">您自己还没购买哦</font>';
            }

            //再处理其他用户的数据
            foreach ($row as $k => $v) {
                if (!isset($tmpArr[$v['username']]['data'][$v['foodname']])) {
                    $tmpArr[$v['username']]['username'] = $v['username'];
                    $tmpArr[$v['username']]['data'][$v['foodname']]['num'] = $v['num']; 
                    $tmpArr[$v['username']]['data'][$v['foodname']]['foodname'] = $v['foodname'];
                } else {
                    $tmpArr[$v['username']]['data'][$v['foodname']]['num'] += $v['num'];
                }
                //计算出每个人这一次总价格
                $tmpArr[$v['username']]['total'] += $v['price'] * $v['num'];
            }

        	return $tmpArr;
        }

        /**
		 * 功能：获取全体订单信息数据
		 * 
		 * @author chenbin
		 * @since 
		 * @return [array]  
		 *
		 */
        public function getAllOrdersData()
        {
            //获取最新的systemID
            $systemMaxId = $_SESSION['homeMealInfo']['system_id'];

            $sql = "SELECT foodname, SUM(num) AS number, SUM(num) * price AS total
                    FROM ".C('DB_PREFIX')."orders  
                    WHERE system_id = {$systemMaxId}
                    GROUP BY foodname
                    ORDER BY number ASC";

        	$row = $this->query($sql);

            //计算出总体下单的总价
            foreach ($row as $v) {
                $allTotal += $v['total'];
            }

            //如果没有数据，就赋值总价为 0 元
            if (empty($allTotal)) {
                $allTotal = 0;
            }

        	return ['data'=>$row, 'allTotal'=>$allTotal];
        }

        /**
         * 功能：获取订单状态
         * 
         * @author chenbin
         * @since 
         * @return [string]  
         *
         */
        public function getStatusSystemData()
        {
            $sql = "SELECT status FROM ".C('DB_PREFIX')."system WHERE id = (SELECT MAX(id) FROM ".C('DB_PREFIX')."system)";
            $res = $this->query($sql)[0]['status'];
            return $res;
        }

        /**
         * 功能：处理取消订餐
         * 
         * @author chenbin
         * @since 
         * @return [string]  
         *
         */
        public function handleDeleteSystem()
        {
            //查询最新的id
            $systemMaxId = $_SESSION['homeMealInfo']['system_id'];
            //删除这一次订餐的所有订单
            $sqlDelete = "DELETE FROM ".C('DB_PREFIX')."orders WHERE system_id = {$systemMaxId}";
            $resDelete = $this->execute($sqlDelete);

            //提交订单时就修改 status 为2 关闭完成这次订单
            $sql = "DELETE FROM ".C('DB_PREFIX')."system WHERE id = {$systemMaxId}";
            $res = M('System')->execute($sql);
            if (!$res) {
                return false;
            }
            return true;
        }

        /**
         * 功能：获取店家名
         * 
         * @author chenbin
         * @since 
         * @return [string]  
         *
         */
        public function getMerchantName()
        {
            $merchantMumber = $_SESSION['homeMealInfo']['number'];
            $dataArt = file_get_contents("http://mainsite-restapi.ele.me/shopping/restaurant/".$merchantMumber."?extras%5B%5D=activity&extras%5B%5D=license&extras%5B%5D=identification&extras%5B%5D=albums&extras%5B%5D=flavors&latitude=23.13324&longitude=113.38605");
            $dataArt = json_decode($dataArt, true);
            //拼接商家名与商家编号
            $resMerchantName = $dataArt['name'];
            return $resMerchantName;
        }

        /**
         * 功能：通过接口网址获取最原始数据
         * @author chenbin
         * @since 
         * @return [array] 
         */
        public function getOriginalData()
        {
            //商家编号
            $merchantMumber = $_SESSION['homeMealInfo']['number'];
            $url = "http://mainsite-restapi.ele.me/shopping/v1/menu?restaurant_id=$merchantMumber";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            //false 是直接打印到页面中
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $dataArt = curl_exec($ch);
            curl_close($ch);

            $dataArt = json_decode($dataArt, true);
            
            return $dataArt;
        }

        /**
         * 功能：获取当前还有那些用户没有点餐的数据
         * @author chenbin
         * @since 
         * @return [array] 
         */
        public function getSurplusUser()
        {
            $systemId = $_SESSION['homeMealInfo']['system_id'];
            $sql = "SELECT DISTINCT u.username
                    FROM ".C('DB_PREFIX')."orders o 
                    LEFT JOIN ".C('DB_PREFIX')."user u ON o.user_id = u.id
                    WHERE o.system_id = {$systemId} AND u.status = 1 
                    GROUP BY o.user_id";
            //已经点餐的了
            $row = $this->query($sql);

            //查询全部用户
            $sqlUser = "SELECT username
                        FROM ".C('DB_PREFIX')."user 
                        WHERE status = 1";

            $rowUser = M('User')->query($sqlUser);

            //差集判断
            //外围循环
            foreach ($rowUser as $kUser => $vUser) {
                foreach ($row as $v) {
                    if ($vUser['username'] == $v['username']) 
                        unset($rowUser[$kUser]);
                }
            }
            
            //返回的是还没有点餐的用户
            return $rowUser;
        }
    }