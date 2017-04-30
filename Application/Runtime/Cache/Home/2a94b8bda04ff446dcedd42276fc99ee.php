<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--标题块-->
  <title>后台管理系统</title>
  <meta name="description" content="这是一个 index 页面">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Amaze UI" />
  <link rel="stylesheet" href="/meal/Public/admin/css/amazeui.min.css"/>
  <link rel="stylesheet" href="/meal/Public/admin/css/admin.css">
  <!--[if (gte IE 9)|!(IE)]><!-->
<script src="/meal/Public/admin/js/jquery.min.js"></script>
<script src="/meal/Public/admin/js/amazeui.min.js"></script>
<script src="/meal/Public/jquery-1.7.2.min.js"></script>
<!--<![endif]-->
<script src="/meal/Public/admin/js/app.js"></script>
  
</head>
<body>

    <header class="am-topbar admin-header">
      <div class="am-topbar-brand">
        <strong>悦娱 /</strong> <small>订餐管理系统</small>
      </div>
      <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

      <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
          <li></li>
          <li class="am-dropdown" data-am-dropdown>
            <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
              <span class="am-icon-users"></span> <?php echo ($_SESSION['adminBlogInfo']['username']); ?> <span class="am-icon-caret-down"></span>
            </a>
            <ul class="am-dropdown-content">
              <li><a  href="<?php echo U('admin/person/index');?>"><span class="am-icon-user"></span> 修改密码 </a></li>
              <li><a href="#"><span class="am-icon-cog"></span> 设置</a></li>
              <li><a href="<?php echo U('admin/Login/logout');?>"><span class="am-icon-power-off"></span> 退出</a></li>
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
      var str = "/meal/Home/Index";
                    var newstr = str.split('/').pop();
                    $('li[info=admin-'+newstr+']').children().eq(0).removeClass('am-collapsed');
                    $('li[info=admin-'+newstr+']').children().eq(1).addClass('am-in');
  </script>
  <!-- 内容模块-->
  
<style>
    .shopCar{
        background:#0089DC;
        border-radius:2em;
        color:white;
        padding:6px;
        cursor:pointer;
    }
    .box{
        float:left;
        margin-left:10px;
        height:80px
    }
    .standard{
        cursor:pointer;
        border:2px solid #ccc;
        color:#ccc;
        padding:1px;
    }
    .subtract,.add{
        cursor:pointer;
        border:2px solid #ccc;
    }
    #submitbox{
        border:1px solid red;
        height:190px;
        width:350px;
        position:fixed;
        background:#F7F7F7;
    }
</style>
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">食物榜 /</strong></div>&nbsp&nbsp<small>快快点我</small>
        </div>
        <ul class="am-avg-sm-1 am-avg-md-6 am-margin am-padding am-text-center admin-content-list ">
            <?php if(is_array($resFoodsData)): foreach($resFoodsData as $key=>$v): ?><li style='width:450px' class='list'>
                    <p class="am-text-success">
                        <div class='box'>
                            <a href='#'><img title="<?php echo ($v['description']); ?>" src="<?php echo ($v['image_path']); ?>"></a><br>
                        </div>
                        <div class='box'>
                            <font class='foodName' style='font-weight:bold'><?php echo ($v['name']); ?></font><br><br>
                            <div style='width:300px;height:80px'>
                            <?php if(is_array($v['standard'])): foreach($v['standard'] as $k=>$v2): ?><font class='standard' tmp='0'><?php echo ($v2); ?><font class='price' price="<?php echo ($k); ?>"></font></font>&nbsp<?php endforeach; endif; ?>
                            </div>
                        </div>
                        <div style='clear:both;'></div><br><br>
                        <div>
                            <font class='subtract'>-</font>
                            <font class='num' style='color:red'>1</font>
                            <font class='add'>+</font>
                        </div>
                        <br>
                        <font class='shopCar'>加入购物车</font>
                    </p>
                </li><?php endforeach; endif; ?>
        </ul>
        <div class="am-g">
            <div class="am-u-sm-12">
                <div style='color:#0E90D2;font-weight:bold'>个人下单情况</div>
                <table class="am-table am-table-bd am-table-striped admin-content-table">
                    <thead>
                    <tr>
                        <th>订单号</th>
                        <th>食物</th>
                        <th>单价</th>
                        <th>数量</th>
                        <th>总金额</th>
                        <th>购买时间</th> 
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($resPersonOrdersData != null): if(is_array($resPersonOrdersData)): foreach($resPersonOrdersData as $key=>$v): ?><tr>
                                <td><?php echo ($v['id']); ?></td>
                                <td><?php echo ($v['foodname']); ?></td>
                                <td><?php echo ($v['price']); ?></td>
                                <td><?php echo ($v['num']); ?></td>
                                <td><?php echo ($v['total']); ?></td>
                                <td><?php echo ($v['addtime']); ?></td>
                            </tr><?php endforeach; endif; ?>
                        <tr><th style='color:red'>总价：<?php echo ($resPersonOrdersData[0]['allTotal']); ?>元</th></tr>
                    <?php else: ?>
                        <tr><th style='color:red'>暂无购买</th></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <br><br>
        <div class="am-g">
            <div class="am-u-sm-12">
                <div style='color:#0E90D2;font-weight:bold'>全体下单情况</div>
                <table class="am-table am-table-bd am-table-striped admin-content-table">
                    <thead>
                    <tr>
                        <th>食物</th>
                        <th>数量</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($resPersonOrdersData != null): if(is_array($resPersonOrdersData)): foreach($resPersonOrdersData as $key=>$v): ?><tr>
                                <td><?php echo ($v['foodname']); ?></td>
                                <td><?php echo ($v['num']); ?></td>
                            </tr><?php endforeach; endif; ?>
                        <tr><th style='color:red'>总价：<?php echo ($allTotal); ?>元</th></tr>
                    <?php else: ?>
                        <tr><th style='color:red'>暂无购买</th></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
    <!-- content end -->
    <div id='submitbox'>
        <div style='height:70px'>
            购物车&nbsp&nbsp&nbsp<font style='cursor:pointer;' id='empty'>清空</font>
        </div>
        <div style='height:30px'>
        </div>
        <div style='height:90px;' id='submit'>
            <div>总金额：<font id='total' style='color:red'>¥0</font>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<font id='confirm' style='cursor:pointer;'>提交</font></div>
        </div>
    </div>
    <script>
        //预先定义全局变量total，在后面使用
        var total = 0;
        //购物车固定显示
        $(window).scroll(function(){
            $('#submitbox').css({right:0, bottom:60});
        });
        //默认选择规格第一个
        $('.list').each(function(){
            $(this).find('.standard').eq(0).css({color:'#0089DC', border:'3px solid #0089DC'}).attr('tmp', 1);
        });
        //选择规格改变
        $('.standard').click(function(){
            $(this).css({color:'#0089DC', border:'2px solid #0089DC'}).attr('tmp', 1).siblings().not('.foodName').css({color:'#ccc', border:'2px solid #ccc'}).attr('tmp', 0);
        });
        //减少购买数量
        $('.subtract').click(function(){
            var num = parseInt($(this).parent().find('.num').html());
            if ( num <= 1 ) {
                num = 1;
            } else {
                num = num - 1;
            }            
             $(this).parent().find('.num').html(num);
        });
        //添加购买数量
        $('.add').click(function(){
            var num = parseInt($(this).parent().find('.num').html());
            num = num + 1;
            $(this).parent().find('.num').html(num);
        });
        //点击加入购物车
        $('.shopCar').click(function(){
            //获取选择的食品
            var foodName = $(this).parent().find('.foodName').html();  
            //获取食品数量 
            var num = parseInt($(this).parent().find('.num').html());
            //obj 是食品规格集的对象
            var obj = $(this).parent().find('.standard');
            $(this).parent().find('.standard').each(function(){
                var tmp = $(this).attr('tmp');
                if (tmp == 1) {
                    //循环判断获取食品规格
                    standard = $(this).html();
                    //循环获取食品单价
                    price = $(this).find('.price').attr('price').split('/')[0];
                }
            });
            //计算单条总数
            price = num * price;
            total += parseFloat(price); 
            //处理多位小数
            total = Math.round(total*100)/100;
            //食品名字拼接
            var foodNameGather = foodName + ' ' + standard;
            $('#total').html('¥'+parseFloat(total));
            //设置小窗高度
            var height = $('#submitbox').css('height');
            var height = parseInt(height) + 70;
            $('#submitbox').css('height', height);
            //动态插入小窗数据
            $('#submit').before('<div class="shopCarFood" style="height:70px;width:350px"><table><tr><td class="submitFoodNameGather" style="width:280px">'+foodNameGather+'</td><td class="submitNum" style="width:15px;">*'+num+'</td><td style="width:55px;color:red" class="submitPrice">¥'+price+'</td></tr></table></div>');
        });
        //点击清空
        $('#empty').click(function(){
            $('.shopCarFood').remove(); 
            $('#submitbox').css('height', 190); 
            total = 0;
            $('#total').html('¥0');
        });

        //点击确定按钮
        var dataJsonStr = '';
        $('#confirm').click(function(){
            //这是最后的总价格
            var lastTotal = $('#total').html().split('¥')[1];
            if (lastTotal == 0) {
                alert('亲，您还没选餐呢');
            } else {
                $('.shopCarFood').each(function(){
                    //获取最终食物的名称并去除掉<font>标签，每条数据的总价，数量
                    var foodname =  $(this).find('.submitFoodNameGather').not('.price').html().replace(/<\/?font[^>]*>/gi,"");
                    var total = $(this).find('.submitPrice').html();
                    var num = $(this).find('.submitNum').html();
                    //dataJsonStr 最后组装成json格式字符串AJAX到后台进行数据库添加
                    dataJsonStr += '{"foodname":'+'"'+foodname+'",'+'"total":'+'"'+total+'",'+'"num":'+'"'+num+'"},';
                });     
                //这里是处理最后的逗号       
                dataJsonStr = dataJsonStr.substr(0, (dataJsonStr.length)-1);
                dataJsonStr = '['+dataJsonStr+']';
                $.ajax({
                    //AJAX到后台进行数据库的数据插入
                    url: "<?php echo U('home/Index/add');?>",
                    type: 'post',
                    data: 'dataJsonStr='+dataJsonStr,
                    success: function(res) {
                        if (res) {
                            alert('购买成功');
                            window.location.reload();
                        } else {
                            alert('购买失败,请重新尝试');
                            window.location.reload();
                        }
                    }
                });
            }
        });
    </script>

</div>

<footer>
  <hr>
  <p class="am-padding-left">© chenbin<a href="http://www.mycodes.net/" target="_blank"></a></p>
</footer>
    
<!--[if lt IE 9]>
<script src="/meal/Public/admin/js/jquery1.11.1.min.js"></script>
<script src="/meal/Public/admin/js/modernizr.js"></script>
<script src="/meal/Public/admin/js/polyfill/rem.min.js"></script>
<script src="/meal/Public/admin/js/polyfill/respond.min.js"></script>
<script src="/meal/Public/admin/js/amazeui.legacy.js"></script>
<![endif]-->


</body>
</html>