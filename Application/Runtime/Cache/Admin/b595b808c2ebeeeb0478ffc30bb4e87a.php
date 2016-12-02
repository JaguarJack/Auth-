<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>后台管理模板</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">

		<link rel="stylesheet" href="/Public/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="/Public/css/global.css" media="all">
		<link rel="stylesheet" href="/Public/plugins/font-awesome/css/font-awesome.min.css">

	</head>

	<body>
		<div class="layui-layout layui-layout-admin">
			<div class="layui-header header header-demo">
				<div class="layui-main">
					<a class="logo" style="left: 0;" href="http://beginner.zhengjinfan.cn/demo/beginner_admin/">
						<span style="font-size: 22px;">后台管理</span>
					</a>
					<ul class="layui-nav">
						<li class="layui-nav-item">
							<a href="javascript:;">清除缓存</a>
						</li>
						<li class="layui-nav-item">
							<a href="#" target="_blank">浏览网站</a>
						</li>
						<li class="layui-nav-item">
							<a href="javascript:;" class="admin-header-user">
							
								<span><?php echo session('user_info')['user_name'];?></span>
							</a>
							<dl class="layui-nav-child">
								<dd>
									<a href="javascript:;"><i class="fa fa-user-circle" aria-hidden="true"></i> 个人信息</a>
								</dd>
								<dd>
									<a href="javascript:;"><i class="fa fa-gear" aria-hidden="true"></i> 设置</a>
								</dd>
								<dd>
									<a href="<?php echo U('Login/logout');?>"><i class="fa fa-sign-out" aria-hidden="true"></i> 注销</a>
								</dd>
							</dl>
						</li>
					</ul>
				</div>
			</div>
			<!-- 左边菜单 -->
			<div class="layui-side layui-bg-black">
				<div class="layui-side-scroll">
					<ul class="layui-nav layui-nav-tree admin-nav-tree">
						<?php if(is_array($menus)): foreach($menus as $key=>$v): ?><li class="layui-nav-item layui-nav-itemed">
							<a href="javascript:;"><?php echo ($v["title"]); ?></a>
							<dl class="layui-nav-child">
								<?php if(is_array($v[$v['id']])): foreach($v[$v['id']] as $key=>$val): ?><dd>
									<a href="javascript:;" data-url="<?php echo U($val['menu_name']);?>">
										<i class="layui-icon" style="top: 1px; font-size: 18px;"><?php echo html_entity_decode($val['icon']);?></i>
										<cite><?php echo ($val["title"]); ?></cite>
									</a>
								</dd><?php endforeach; endif; ?>
							</dl>
						</li><?php endforeach; endif; ?>
						
					</ul>
				</div>
			</div>
			<!-- 左边菜单 -->
			
			<div class="layui-body" style="bottom: 0;">
				<div class="layui-tab admin-nav-card" lay-filter="admin-tab">
					<ul class="layui-tab-title" id="admin-tab">
						<li class="layui-this">
							<i class="layui-icon" style="top: 2px; font-size: 16px;">&#xe609;</i>
							<cite>控制台</cite>
						</li>
					</ul>
					<div class="layui-tab-content" style="min-height: 150px; padding: 5px 0 0 0;" id="admin-tab-container">
						<div class="layui-tab-item layui-show">
							<iframe src="<?php echo U('Index/main');?>"></iframe>
						</div>
					</div>
				</div>
			</div>
			<div class="layui-footer footer footer-demo">
				<div class="layui-main">
					<p>2016 &copy;
						<a href="http://beginner.zhengjinfan.cn/demo/beginner_admin/">auth管理后台</a>
					</p>
				</div>
			</div>
			<div class="site-tree-mobile layui-hide">
				<i class="layui-icon">&#xe602;</i>
			</div>
			<div class="site-mobile-shade"></div>
			<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
			<script>
				layui.use(['element', 'layer'], function() {
					var element = layui.element(),
						$ = layui.jquery,
						layer = layui.layer;

					//iframe自适应
					$(window).on('resize', function() {
						var $content = $('.admin-nav-card .layui-tab-content');
						$content.height($(this).height() - 147);
						$content.find('iframe').each(function() {
							$(this).height($content.height());
						});
					}).resize();

					//添加tab
					var $tabs = $('#admin-tab');
					var $container = $('#admin-tab-container');
					//绑定 nav 点击事件
					$('ul.admin-nav-tree').find('dd > a').each(function() {
						var $this = $(this);
						//获取设定的url
						var url = $this.data('url');
						if(url !== undefined) {
							$this.on('click', function() {
								var iframe = '<iframe src="' + url + '"></iframe>';
								var aHtml = $this.html();
								var count = 0;
								var tabIndex;
								$tabs.find('li').each(function(i, e) {
									var $cite = $(this).children('cite');
									if($cite.text() === $this.find('cite').text()) {
										count++;
										tabIndex = i;
									};
								});
								//tab不存在
								if(count === 0) {
									//添加删除样式
									aHtml += '<i class="layui-icon layui-unselect layui-tab-close">&#x1006;</i>';
									//添加tab
									element.tabAdd('admin-tab', {
										title: aHtml,
										content: iframe
									});
									//iframe 自适应
									var $content = $('.admin-nav-card .layui-tab-content');
									$content.find('iframe').each(function() {
										$(this).height($content.height());
									});
									//绑定关闭事件
									$tabs = $('#admin-tab');
									var $li = $tabs.find('li');

									$li.eq($li.length - 1).children('i.layui-tab-close').on('click', function() {
										element.tabDelete('admin-tab', $(this).parent('li').index()).init();
									});
									//获取焦点
									element.tabChange('admin-tab', $li.length - 1);

								} else {
									//切换tab
									element.tabChange('admin-tab', tabIndex);
								}
							});
						}
					});

					$('#user').on('click', function() {
						$('#user-item').toggle();
					});

					//手机设备的简单适配
					var treeMobile = $('.site-tree-mobile'),
						shadeMobile = $('.site-mobile-shade');
					treeMobile.on('click', function() {
						$('body').addClass('site-mobile');
					});
					shadeMobile.on('click', function() {
						$('body').removeClass('site-mobile');
					});
				});
			</script>
		</div>
	</body>

</html>