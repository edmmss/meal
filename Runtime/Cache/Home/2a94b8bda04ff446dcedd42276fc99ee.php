<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--标题块-->
  <title>悦娱游戏</title>
  <meta name="description" content="这是一个 index 页面">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Amaze UI" />
  <link rel="stylesheet" href="/equip/meal/Public/admin/css/amazeui.min.css"/>
  <link rel="stylesheet" href="/equip/meal/Public/admin/css/admin.css">
  <!--[if (gte IE 9)|!(IE)]><!-->
<script src="/equip/meal/Public/admin/js/jquery.min.js"></script>
<script src="/equip/meal/Public/admin/js/amazeui.min.js"></script>
<script src="/equip/meal/Public/jquery-1.7.2.min.js"></script>
<!--<![endif]-->
<script src="/equip/meal/Public/admin/js/app.js"></script>
  
</head>
<body>

    <header class="am-topbar admin-header">
      <div class="am-topbar-brand" id='1f'>
        <strong>悦娱游戏 /</strong> <small>订餐管理系统</small>
      </div>
      <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

      <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
          <li></li>
          <li class="am-dropdown" data-am-dropdown>
            <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
              <span class="am-icon-users"></span> <?php echo ($_SESSION['homeMealInfo']['username']); ?> <span class="am-icon-caret-down"></span>
            </a>
            <ul class="am-dropdown-content">
              <li><a href="<?php echo U('Home/User/editPass');?>"><span class="am-icon-cog"></span> 修改密码 </a></li>
              <?php if($_SESSION['homeMealInfo']['role'] == 1): ?><li><a href="<?php echo U('Admin/Index/index');?>"><span class="am-icon-cog"></span> 后台管理 </a></li>
              <?php else: endif; ?>
              <li><a href="<?php echo U('Home/Login/logout');?>"><span class="am-icon-power-off"></span> 退出</a></li>
            </ul>
          </li>
          <li><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
      </div>
    </header>


<!--这个div包含整体,勿修改!!!!!!!!!!!!!!!!!-->
<div class="am-cf admin-main">
  <!-- sidebar start -->
  

  <!-- sidebar end -->
  <script>
      // 控制器： 不同模块展开不同list
      var str = "/equip/meal/index.php/Home/Index";
                    var newstr = str.split('/').pop();
                    $('li[info=admin-'+newstr+']').children().eq(0).removeClass('am-collapsed');
                    $('li[info=admin-'+newstr+']').children().eq(1).addClass('am-in');
  </script>
  <!-- 内容模块-->
  

<style>
	.descender{
		float:left;
	}
	.descenderLeft{
		width:100%;
	}
	.content{
		width:470px;
		height:210px;
		padding-left:20px;
		float:left;
	}
	.insideLeft, .insideRight{
		float:left;
	}
	.standard{
		width:140px;
		float:left;
		font-size:10px;
		cursor:pointer;
        border:2px solid #ccc;
        color:black;
        padding:1px;
        margin:2px;
        text-align:center;
	}
	.shopCarFont, .shopCarFontBak{
		background:#0089DC;
        border-radius:2em;
        color:white;
        cursor:pointer;
        padding:6px;
        font-size:10px
	}
	.subtract,.add{
        cursor:pointer;
        border:2px solid #ccc;
    }
    .ordersLeft{
    	width:800px;
        margin-right:50px;
    }
    .ordersRight{
    	width:700px;
    }
    .ordersPersonFoodName,.ordersPersonFoodNum,.ordersLeft,.ordersRight,.ordersAllFoodName,.ordersAllFoodNum,.shopCarFoodName,.shopCarFoodNum,.shopCarTotal,.ordersPersonFoodDeleta,.ordersAllFoodDeleta,.notOrdersData{
    	float:left;
    }
    .ordersPersonFoodNum{
    	margin-left:20px;
    }
    #submitbox{
        border:1px solid #0089DC;
        border-top:3px solid #0089DC;
        height:105px;
        width:350px;
        position:fixed;
        background:#F7F7F7;
        transition: margin-right 1.5s;
    }
    .shopCarFoodName{
    	width:270px;
    }
    .shopCarFoodNum{
    	width:30px;
    }
    #bigImage{
        display:none;
        width:360px;
        height:360px;
        position:fixed;
    }
</style>

<div class="admin-content">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg"><a target="_blank" href="https://www.ele.me/shop/<?php echo ($_SESSION['homeMealInfo']['number']); ?>"><?php echo ($resMerchantName); ?></a></strong> / <small>快快点我</small></div>
    </div>
    <div class='descender descenderLeft'>
    	<div>
            <?php if($resFoodsData != null): if(is_array($resFoodsData)): foreach($resFoodsData as $key=>$v): ?><div class='content'>
        			<div>
        				<div class='insideLeft' style='width:120px;height:150px'><img style='cursor:pointer;' class='image' title="<?php echo ($v['description']); ?>" src="<?php echo ($v['image_path']); ?>"></div>
        				<div class='insideRight' style='width:330px;'>
        					<div style='height:20px;font-size:10px' class='foodName'><?php echo ($v['name']); ?></div>
        					<div style='height:40px'>
        						<?php if(is_array($v['standard'])): foreach($v['standard'] as $k=>$v2): ?><div class='standard'><?php echo ($v2); ?><font class='price' price="<?php echo ($k); ?>"></font></div><?php endforeach; endif; ?>
        					</div>
        				</div>
        			</div>
                    <?php if($v['stock'] != 0): ?><div class='shopCar'><font class='shopCarFont'>加入购物车</font></div>
                    <?php else: ?>
                        <div><font class='shopCarFontBak'>已售完</font></div><?php endif; ?>
        		</div><?php endforeach; endif; ?>
            <?php else: ?>
            <div style='margin-left:20px;color:red;font-weight:bold;font-size:20px'>订餐还未开始或商家编号有误</div><?php endif; ?>
    	</div>

    	<div class='descender'></div>
    </div>
    <div style='clear:both;'></div>
    <br><br><br>
    <!--个人下单情况-->
    <?php if($resFoodsData != null OR $_SESSION['homeMealInfo']['role'] == 1): ?><div class="am-g">
        <div class="am-u-sm-12">
            <div style='color:#0E90D2;font-weight:bold' id='2f'>下单情况</div><br>
            <div style='width:120%'>
            	<!--个人订单-->   
            	<div class='ordersLeft'>
                    <div style='height:30px;'></div>
                    <?php if(is_array($resPersonOrdersData)): foreach($resPersonOrdersData as $k=>$v): ?><div>       
                			<div style='height:30px;'><?php echo ($v['username']); ?></div>
                            <?php if(is_array($v['data'])): foreach($v['data'] as $k=>$v1): ?><div style='height:30px;width:400px;float:left;cursor:pointer;'>
                				     <div class='ordersPersonFoodName' style='width:330px;font-size:10px'><?php echo ($v1['foodname']); ?></div>
                			         <div class='ordersPersonFoodNum' style='width:25px;'>*<?php echo ($v1['num']); ?></div>
                                     <?php if($v['username'] == $_SESSION['homeMealInfo']['username']): ?><div class='ordersPersonFoodDeleta' style='cursor:pointer;color:red'>×</div>
                                    <?php else: endif; ?>
                			     </div><?php endforeach; endif; ?>
                		</div>
                		<div style='clear:both;'></div>
                        <div style='color:red;font-weight:bold'>总价格: <?php echo ($v['total']); ?></div>
                        <br><?php endforeach; endif; ?>
            		<!--个人订单结束-->
            	</div>
            	<!--全体订单-->
            	<div class='ordersRight'>
            		<div style='color:red;font-weight:bold'>全体下单情况</div>
                    <?php if(is_array($resAllOrdersData)): foreach($resAllOrdersData as $key=>$v): ?><div style='width:500px;height:30px;cursor:pointer;'>
                			<div class='ordersAllFoodName' style='width:380px;font-size:10px'><?php echo ($v['foodname']); ?></div>
                			<div class='ordersAllFoodNum' style='margin-left:50px;font-size:10px'>*<?php echo ($v['number']); ?></div>
                            <?php if($_SESSION['homeMealInfo']['role'] == 1): ?><div class='ordersAllFoodDeleta' style='cursor:pointer;color:red;font-size:10px;margin-left:20px'>×</div>
                            <?php else: endif; ?>
                		</div><?php endforeach; endif; ?>
            		<div>
            			<font style='color:red;font-weight:bold'>总价：<?php echo ($allTotal); ?></font>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <?php if($_SESSION['homeMealInfo']['role'] == 1): ?><button id='button'>提交并关闭这次订餐</button>&nbsp&nbsp&nbsp&nbsp
                			<button id='removeButton'>取消并关闭这次订餐</button>
                        <?php else: endif; ?>
            		</div>
                    <br>
                    <div style='color:red;font-weight:bold'>还未点餐的人儿</div>
                    <div class='notOrders' style='width:80%;height:200px'>
                        <?php if(is_array($resSurplusUser)): foreach($resSurplusUser as $key=>$v): ?><div class='notOrdersData' style='width:25%;height:30px'><?php echo ($v['username']); ?></div><?php endforeach; endif; ?>
                    </div>
            	</div>
            	<!--全体订单结束-->
            </div>
        </div>
    </div>
    <?php else: endif; ?>
</div>
  <!-- content end -->
    <?php if($resFoodsData != null): ?><div id='submitbox'>
            <div style='height:30px'>
                <font id='show' style='cursor:pointer;'>购物车&nbsp&nbsp&nbsp</font><font id='hide' style='cursor:pointer;'>隐藏</font>&nbsp&nbsp&nbsp<font style='cursor:pointer;color:#0089DC' id='empty'>[清空]</font>
            </div>
            <div style='height:5px;'>
            </div>
            <div style='height:40px;' id='submit'>
                <div>总金额：<font id='total' style='color:red'>¥0</font><font id='confirm' style='cursor:pointer;margin-left:100px'>提交</font></div>
            </div>
            <div style='height:25px'><a href='#1f'>回到顶部</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href='#2f'>个人下单情况</a></div>
        </div>
    <?php else: endif; ?>

    <div id='bigImage' style="cursor:pointer" imageTmp='1'><img></div>
    <script>
    	//定义空数组来存放添加到购物车的临时数据
        var foodNameArr = [];
        //定义购物车中的数量
        var num = 1;
        //定义购物车一行中的总价
        var total = 0;
    </script>
    <script>
        //购物车固定显示
        $(window).scroll(function(){
            $('#submitbox').css({right:-300, bottom:60});
        });
        //隐藏购物车
        $('#hide').click(function(){
        	$('#submitbox').css('marginRight', '0px');
        });
        //显示购物车
        $('#show').click(function(){
        	$('#submitbox').css('marginRight', '300px');
        });
        //默认选择规格第一个
        $('.content').each(function(){
            $(this).find('.standard').eq(0).css({color:'#0089DC', border:'2px solid #0089DC'}).attr('tmp', 1);
        });
        //选择规格改变
        $('.standard').click(function(){
            $(this).css({color:'#0089DC', border:'2px solid #0089DC'}).attr('tmp', 1).siblings().not('.foodName').css({color:'black', border:'2px solid #ccc'}).attr('tmp', 0);
        });
         //点击加入购物车
        $('.shopCarFont').click(function(){
            //将购物车显示出来
            $('#submitbox').css('marginRight', '300px');
            //获取选择的食品
            var foodName = $(this).parent().parent().find('.foodName').html();  
            //obj 是食品规格集的对象
            var obj = $(this).parent().parent().find('.standard');
            $(this).parent().parent().find('.standard').each(function(){
                var tmp = $(this).attr('tmp');
                if (tmp == 1) {
                    //循环判断获取食品规格并去除掉<font>标签
                    standard = $(this).html().replace(/<\/?font[^>]*>/gi,"");
                    //循环判断获取食品单价
                    price = $(this).find('.price').attr('price').split('/')[0];
                }
            });
            //这是食物名与规格的临时名称
            var tmpFoodName = foodName +' '+ standard;
            //判断数组中是否包含某个元素, 如果没有找到则返回 -1
            if(jQuery.inArray(tmpFoodName, foodNameArr) >= 0) {
            	//循环判断哪一样食物需要进行数量和总价的增加
            	$('.shopCarFoodName').each(function(){
            		var tmp = $(this).html();
            		if (tmpFoodName == tmp) {
                        //如果添加的食物在购物车已经有，数量就加一
            			num = parseInt($(this).parent().find('.shopCarFoodNum').html()) + 1;
            			total = num * price;
                        //处理多位小数，避免出现很多位小数
                        total = Math.round(total*100)/100;
            			$(this).parent().find('.shopCarFoodNum').html(num);
            			$(this).parent().find('.shopCarTotal').html(total);
            		}
            	}); 
            } else {
            	//要进行初始化，不然会被上面的操作影响
            	num = 1;
	            total = price * num ;
            	//没有就添加到临时数组以便之后进行判断
            	foodNameArr[foodNameArr.length] = tmpFoodName;
	        	//如果没有就直接动态插入
        		$('#submit').before('<div style="height:38px"><div class="shopCarFoodName" style="font-size:10px">'+tmpFoodName+'</div><div class="shopCarFoodNum" style="font-size:10px">'+num+'</div><div class="shopCarTotal" style="font-size:10px">'+total+'</div></div>');
            	//设置小窗高度
            	var height = $('#submitbox').css('height');
            	//随着订单的增加小窗高度随之改变
            	var height = parseInt(height) + 42;
            	//当订单大于五单的时候，出现滚动条
            	if ($('.shopCarFoodName').length > 5) {
                	$('#submitbox').css({'overflow-y': 'scroll', 'overflow-x': 'hidden'});
            	} else {
                	$('#submitbox').css('height', height);
            	}     
            }
            //算出最后购物车内的总价
            var shopCarTotal = 0;
            $('.shopCarTotal').each(function(){
            	shopCarTotal += parseFloat($(this).html());
            });
            //处理多位小数，避免出现很多位小数
            shopCarTotal = Math.round(shopCarTotal*100)/100;
            $('#total').html('¥'+shopCarTotal);
        });

        //点击清空
        $('#empty').click(function(){
            $('.shopCarFoodName').parent().remove(); 
            $('#submitbox').css('height', 105); 
            //清空购物车的总价
            shopCarTotal = 0;
            //清空临时数组,这是注意不能使用var 这样的话就是重新定义js数组了
            foodNameArr = [];
            $('#total').html('¥0');
            //滚动条取消
            $('#submitbox').css({'overflow-y': 'hidden', 'overflow-x': 'hidden'});
        });

        //点击确定按钮
        var dataJsonStr = '';
        $('#confirm').click(function(){
            //这是最后的总价格
            var lastTotal = $('#total').html().split('¥')[1];
            if (lastTotal == 0) {
                alert('亲，您还没选餐呢');
            } else {
                $('.shopCarFoodName').each(function(){
                    //获取最终食物的名称并去除掉<font>标签，每条数据的总价，数量
                    var foodname =  $(this).html();
                    var total = $(this).parent().find('.shopCarTotal').html();
                    var number = $(this).parent().find('.shopCarFoodNum').html();
                    //dataJsonStr 最后组装成json格式字符串AJAX到后台进行数据库添加
                    dataJsonStr += '{"foodname":'+'"'+foodname+'",'+'"total":'+'"'+total+'",'+'"num":'+'"'+number+'"},';
                });     
                //这里是处理最后的逗号       
                dataJsonStr = dataJsonStr.substr(0, (dataJsonStr.length)-1);
                dataJsonStr = '['+dataJsonStr+']';
                //处理 & 符号
                dataJsonStr = dataJsonStr.replace(/&amp/ig, '-');
                
                $.ajax({
                    //AJAX到后台进行数据库的数据插入
                    url: "<?php echo U('Home/Index/add');?>",
                    type: 'post',
                    data: 'dataJsonStr='+dataJsonStr,
                    success: function(res) {
                        if (res) {
                            alert('购买成功');
                            window.location.reload();
                            window.location.href = "<?php echo U('Home/Index/index#2f');?>";
                        } else {
                            if (res == 0) {
                                alert('订餐员已经关闭订餐了');
                                window.location.reload();
                            } else {
                                alert('购买失败,请重新尝试');
                                window.location.reload();
                            }         
                        }
                    }
                });
            }
        });

        //订餐员提交操作
        $('#button').click(function(){
            $.ajax({
                //提交订单
                url: "<?php echo U('Home/Index/submitOrder');?>",
                data: 'allTotal='+<?php echo ($allTotal); ?>,
                type: 'post',
                success: function(res) {
                    if (res) {
                        alert(res);
                        window.location.reload();
                    }
                }
            });
        });

        //个人订单删除操作
        $('.ordersPersonFoodDeleta').click(function(){
            //获取订单ID
            var foodName = $(this).parent().find('.ordersPersonFoodName').html();
            if (confirm('您确定要取消该食物吗?')) {
                $.ajax({
                    url: "<?php echo U('Home/Index/delete');?>",
                    data: "foodName="+foodName,
                    type: 'post',
                    success: function(res) {
                        if (res == 1) {
                            alert('订餐已经关闭，不能再修改');
                            window.location.reload();
                        } else if (res == 2) {
                            alert('操作异常');
                        } else if (res == 3) {
                            alert('删除成功');
                            window.location.reload();
                        }
                    }
                });
            }
        });

        //订餐员删除订餐操作
        $('.ordersAllFoodDeleta').click(function(){
            //获取当前食物名
            var allFoodName = $(this).parent().find('.ordersAllFoodName').html();
            if (confirm('您确定要取消该食物吗?')) {
                $.ajax({
                    url: "<?php echo U('Home/Index/orderTakerDelete');?>",
                    //获取这一次订餐的总价格
                    data: "allFoodName="+allFoodName,
                    type: 'post',
                    success: function(res) {
                        alert(res);
                        window.location.reload();
                    }   
                });
            }
        });


        //鼠标经过全体下单情况是背景变色
        $('.ordersAllFoodName').parent().mouseenter(function(){
            $(this).css('background', '#F7F7F7').siblings().css('background', 'white');
        });
        //鼠标离开时变回白色
        $('.ordersAllFoodName').parent().mouseleave(function(){
            $(this).css('background', 'white');
        });
        
        //鼠标经过个人下单情况是背景变色
        $('.ordersPersonFoodName').parent().mouseenter(function(){
            $(this).css('background', '#F7F7F7').siblings().css('background', 'white');
        });
        //鼠标离开时变回白色
        $('.ordersPersonFoodName').parent().mouseleave(function(){
            $(this).css('background', 'white');
        });

        //取消订餐按钮
        $('#removeButton').click(function(){
            //弹出询问框，是否确定要取消
            if (confirm('您确定要取消本次订餐吗?')) {
                $.ajax({
                    type: 'post',
                    url: "<?php echo U('Home/Index/deleteSystem');?>",
                    success: function(res) {
                        if (res) {
                            alert('操作成功');
                            window.location.reload();
                        } else {
                            alert('操作失败');
                            window.location.reload();
                        }
                        
                    }
                });
            }
        });

        //点击图片显示大图
        $('.image').click(function(e){
            //判断大图片是否已经开启,1为未开启
            if ($('#bigImage').attr('imageTmp') == 1) {
                var imagePath = $(this).attr('src');
                //如果没有图片就不执行
                if (imagePath != '') {
                    //改变像素
                    imagePath = imagePath.replace(/\d+x\d+/, '360x360');
                    $('#bigImage').find('img').attr('src', imagePath);
                    $('#bigImage').attr('imageTmp', 2);
                    $('#bigImage').fadeIn('slow');
                    //隐藏滚动条
                    $('body').css({'overflow-y': 'hidden', 'overflow-x': 'hidden'});
                    //让大图一开始就需要适应浏览器的大小
                    box();
                    //阻止事件传播到body元素中
                    e.stopPropagation();
                }
            }
        });

        //点击隐藏大图
        $('body').click(function(){
            $('#bigImage').attr('imageTmp', 1);
            $('body').css({'overflow-y': 'scroll', 'overflow-x': 'hidden'});
            $('#bigImage').fadeOut('slow');
        });

        //当浏览器页面发生改变时，DIV随着页面的改变居中。
        function box(){
            //获取DIV为‘box’的盒子
            var oBox = document.getElementById('bigImage');
            //获取元素自身的宽度
            var L1 = oBox.offsetWidth;
            //获取元素自身的高度
            var H1 = oBox.offsetHeight;
            //获取实际页面的left值。（页面宽度减去元素自身宽度/2）
            var Left = (document.documentElement.clientWidth-L1)/2;
            //获取实际页面的top值。（页面宽度减去元素自身高度/2）
            var top = (document.documentElement.clientHeight-H1)/2;
            oBox.style.left = Left+'px';
            oBox.style.top = top+'px';
        };
        //修改窗口大小触发
        $(window).resize(function(){
            box();
        });
    </script>

</div>

<footer>
  <hr>
  <p class="am-padding-left">© 悦娱游戏<a href="http://www.mycodes.net/" target="_blank"></a></p>
</footer>
    
<!--[if lt IE 9]>
<script src="/equip/meal/Public/admin/js/jquery1.11.1.min.js"></script>
<script src="/equip/meal/Public/admin/js/modernizr.js"></script>
<script src="/equip/meal/Public/admin/js/polyfill/rem.min.js"></script>
<script src="/equip/meal/Public/admin/js/polyfill/respond.min.js"></script>
<script src="/equip/meal/Public/admin/js/amazeui.legacy.js"></script>
<![endif]-->


</body>
</html>