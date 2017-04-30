<?php if (!defined('THINK_PATH')) exit(); if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>悦娱游戏</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
  <link rel="stylesheet" href="/equip/meal/Public/admin/css/amazeui.min.css"/>
  <script src="/equip/meal/Public/jquery-1.7.2.min.js"></script>
  <script src="/equip/meal/Public/Validform_v5.3.2/Validform_v5.3.2_min.js"></script>
  <style>
    .header {
      text-align: center;
    }
    .header h1 {
      font-size: 200%;
      color: #333;
      margin-top: 30px;
    }
    .header p {
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="header"> 
  <hr />
</div>
<div class="am-g">
  <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
    <h2>订餐登录</h2>
    <hr>
    <br>
    <br>

    <form method="post" action="<?php echo U('Home/Login/login');?>" class="am-form demoform">
      <label for="email">用户名:</label>
      <input type="text" name="username" id="email">
      <br>
      <label for="password">密码:</label>
      <input type="password" name="password" id="password">
      <br>
      <label for="remember-me">
      </label>
      <br />
      <div class="am-cf">
        <input type="submit" name="" value="登 录" class="am-btn am-btn-primary am-btn-sm am-fl">
      </div>
    </form>
    <hr>
    <p>©   <a href="http://www.yueyugame.com/" target="_blank">悦娱游戏</a></p>
  </div>
</div>
</body>
</html>