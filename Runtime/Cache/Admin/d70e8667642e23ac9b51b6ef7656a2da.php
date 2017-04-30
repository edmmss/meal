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
      <div class="am-topbar-brand">
        <strong>悦娱游戏 /</strong> <small>订餐管理系统</small>
      </div>
      <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

      <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
          <li></li>
          <li class="am-dropdown" data-am-dropdown>
            <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
              <span class="am-icon-users"></span> 餐费减免 <span class="am-icon-caret-down"></span>
            </a>
            <ul class="am-dropdown-content">
              <li><a href="<?php echo U('Admin/Orders/derate');?>"><span class="am-icon-cog"></span> 减免页 </a></li>
            </ul>
          </li>
          <li class="am-dropdown" data-am-dropdown>
            <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
              <span class="am-icon-users"></span> <?php echo ($_SESSION['homeMealInfo']['username']); ?> <span class="am-icon-caret-down"></span>
            </a>
            <ul class="am-dropdown-content">
              <li><a href="<?php echo U('Home/Index/index');?>"><span class="am-icon-cog"></span> 前台点餐 </a></li>
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
  
         <div class="admin-sidebar">
         
          <!--导航栏块-->
         
              <ul class="am-list admin-sidebar-list">
                <li><a href="<?php echo U('index/index');?>"><span class="am-icon-home"></span> 首页</a></li>
                <li info="admin-User">
                  <a class="am-cf am-collapsed" data-am-collapse="{target: '#list-User'}"><span class="am-icon-bars"></span> 用户管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                  <ul class="am-list am-collapse admin-sidebar-sub" id="list-User" style="">
                    <li id="uselist"><a href="<?php echo U('Admin/User/index');?>" class="am-cf"><span class="am-icon-table"></span>用户列表<span class="am-badge am-badge-secondary am-margin-right am-fr"></span></a></li>
                  </ul>
                </li>

                <li info="admin-Orders">
                  <a class="am-cf am-collapsed" data-am-collapse="{target: '#list-Orders'}"><span class="am-icon-comments-o"></span> 食物订单管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                  <ul class="am-list am-collapse admin-sidebar-sub" id="list-Orders" style="">
                    <li id="uselist"><a href="<?php echo U('Admin/Orders/index');?>" class="am-cf"><span class="am-icon-table"></span> 食物订单列表<span class="am-badge am-badge-secondary am-margin-right am-fr"></span></a></li>
                    <!-- <li><a href="admin-gallery.html"><span class="am-icon-th"></span> 相册页面</a></li>
                    <li><a href="admin-log.html"><span class="am-icon-calendar"></span> 系统日志</a></li>
                    <li><a href="admin-404.html"><span class="am-icon-bug"></span> 404</a></li> -->
                  </ul>
                </li>           
 
                <li><a href="<?php echo U('Home/Login/logout');?>"><span class="am-icon-sign-out"></span> 注销</a></li>

              </ul>
          
            
              <!--公告栏块-1-->
            
                    <div class="am-panel am-panel-default admin-sidebar-panel">
                      <div class="am-panel-bd">
                        <p><span class="am-icon-bookmark"></span> 公告1</p>
                        <p>这里写公告之类的信息</p>
                      </div>
                    </div>
            

              <!--公告栏块-2-->
            
                  <div class="am-panel am-panel-default admin-sidebar-panel">
                    <div class="am-panel-bd">
                      <p><span class="am-icon-tag"></span> 公告2</p>
                      <p>这里写公告之类的信息</p>
                    </div>
                  </div>
            
  
        </div>
  
  <!-- sidebar end -->
  <script>
      // 控制器： 不同模块展开不同list
      var str = "/equip/meal/index.php/Admin/Orders";
                    var newstr = str.split('/').pop();
                    $('li[info=admin-'+newstr+']').children().eq(0).removeClass('am-collapsed');
                    $('li[info=admin-'+newstr+']').children().eq(1).addClass('am-in');
  </script>
  <!-- 内容模块-->
  
	  <div class="admin-content">

    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">食物订单列表</strong></div>
    </div>

    <div class="am-g">
      <div class="am-u-md-6 am-cf">
        <div class="am-fl am-cf">
          <div class="am-btn-toolbar am-fl">
            <div class="am-btn-group am-btn-group-xs">
              <a type="button" id='del' class="am-btn am-btn-default"><span class="am-icon-plus"></span> 批量删除 </a>
            </div>

          </div>
        </div>
      </div>
      <form action="<?php echo U('Admin/Orders/index');?>" method='get'>
<!--       <input name='m' value='Admin' style='display:none'>
      <input name='c' value='Orders' style='display:none'>
      <input name='a' value='index' style='display:none'> -->
<!--   	  <div class="am-form-group am-margin-left am-fl">
            <select name="role" style="height:40px;width:130px">
              <option value="">角色分类</option>
              <option value="1" <?php echo $_GET['role'] == '1'? 'selected':''?>>订餐员</option>
              <option value="2" <?php echo $_GET['role'] == '2'? 'selected':''?>>普通成员</option>
            </select>
      </div> -->
      <div class="am-u-md-3 am-cf">
        <div class="am-fr">
          <div class="am-input-group am-input-group-sm">
            <input type="text" class="am-form-field username" value='<?php echo !empty($_GET['username'])? $_GET['username'] : ''?>' placeholder="用户名" name='username'>
                <span class="am-input-group-btn">
                  <input value='搜索' class="am-btn am-btn-default" id='sub' type="submit">
                </span>
          </div>
        </div>
      </div>
      </form>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12">
        <form class="am-form">
          <table class="am-table am-table-striped am-table-hover table-main">
            <thead>
              <tr>
                <th class="table-check"><input type="checkbox" name="" id="ck"></th>
                <th class="table-title">食物订单ID</th>
                <th class="table-title">用户名</th>
                <th class="table-title">食物名</th>
                <th class="table-type">单价</th>
                <th class="table-type">数量</th>
                <th class="table-author">总价</th>
                <th class="table-author">购买时间</th>
                <th class="table-date">操作</th>
              </tr>
          </thead>
          <tbody>
          <?php if(is_array($row)): foreach($row as $key=>$v): ?><tr>
              <td><input value="<?php echo ($v['id']); ?>" type="checkbox" name="" class='sck'></td>
              <td><?php echo ($v['id']); ?></td>
              <td><?php echo ($v['username']); ?></a></td>
              <td><?php echo ($v['foodname']); ?></a></td>
              <td><?php echo ($v['price']); ?></td>
              <td><?php echo ($v['num']); ?></td>
              <td><?php echo ($v['total']); ?></td>
              <td><?php echo ($v['addtime']); ?></td>
              <td>
                <div class="am-btn-toolbar">
                  <div class="am-btn-group am-btn-group-xs">
                    <a style='background:white' href="<?php echo U('Admin/Orders/delete', ['id'=>$v['id']]);?>" class="del am-btn am-btn-default am-btn-xs am-text-danger"><span class="am-icon-trash-o"></span> 删除</a>
                  </div>
                </div>
              </td>
            </tr><?php endforeach; endif; ?>
          </tbody>
        </table>
          <div class="am-cf">
  共 <font id='num'>
    <?php if($row == false): ?>0
    <?php else: ?>
      <?php echo ($row[0]['count']); endif; ?>
    </font> 条记录
                  <div class="am-fr">             
                  <ul class="am-pagination">
                   <?php echo ($row[0][btn]); ?>
                  </ul>
                </div>
          </div>
          <hr />
          <p>注：.....</p>
        </form>
      </div>
    </div>
  </div>

  	<script>
      $('.am-pagination a').wrap('<li></li>');
      $('.am-pagination p').wrap('<li></li>');
      $('.am-pagination').find('#page_num').unwrap('p').wrap('<li></li>');
      // $('#page_num').unwrap('<li></li>');

      //分页跳转
      $('#page_num').blur(function(){
          var url = $('.gopage').attr('href');
          var strs = url.substr(0);          
          var value = this.value;
          //最大分页数
          var all = $('.all').attr("title");
          //将字符转化为数字
          var i = parseFloat(all);
        if (!isNaN(value)) {
          if (value >= i) {
            value = i;
          } else if (value <= 1){
            value = 1;
          }   
          value = Math.ceil(value); 
        } else {
          value = '';
        }
        var nuwurl = strs + value ;
        //获取查询条件，如果有带查询条件就带上
        var username = $('.username').val();
        if (username != '') {
          //url模式为 2
          nuwurl += '/username/'+ username ;
        }
        $(".gopage").attr("href",nuwurl);
      });

      //批量删除
      $('#ck').click(function(){
        $(".sck").prop('checked',this.checked);
      }); 

      $('#del').click(function(){
        val = [];
        $("input:checked").each(function(i){
          val[val.length] = $("input:checked").eq(i).val();
        });
        str = val.join(',');
        $.ajax({
          url:  "<?php echo U('Admin/Orders/batchDetele');?>",
          type: 'post',
          data: "ids="+str,
          success: function(res) {
            if (res) {
              alert('删除成功');
              window.location.href = "<?php echo U('Admin/Orders/index');?>";
            } else {
              alert('操作失败');
              window.location.href = "<?php echo U('Admin/Orders/index');?>";
            }
          }
        });
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