<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>菜单管理</title>
		<link rel="stylesheet" href="/Public/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="/Public/css/global.css" media="all">
		<link rel="stylesheet" href="/Public/plugins/font-awesome/css/font-awesome.min.css">
	</head>

	<body>
		<div class="admin-main">
		
			<blockquote class="layui-elem-quote">
				<button  data="0" class="layui-btn layui-btn-small add">
					<i class="layui-icon">&#xe608;</i> 添加菜单
				</button>
			</blockquote>
			<fieldset class="layui-elem-field">
				<legend>菜单列表</legend>
				<div class="layui-field-box">
				<table class="layui-table">
					  <thead>
					    <tr>
					      <th>#</th>
					      <th>菜单名称</th>
					      <th>控制器名称</th>
					      <th>方法名称</th>
					      <th>菜单级别</th>
					      <th>管理</th>
					    </tr> 
					  </thead>
					  <tbody>
						<?php if(is_array($menu)): foreach($menu as $k=>$vo): ?><tr>
						      <?php $opt = explode('/',$vo['menu_name']); ?>
						      <td><?php echo ($k+1); ?></td>
						      <td><?php echo str_repeat("——",$vo["level"]); echo ($vo["title"]); ?></td>
						      <td><?php echo ($opt[0]); ?></td>
						      <td><?php echo ($opt[1]); ?></td>
						      <td>
						      <?php if(!$vo['pid']): ?>一级菜单
						      <?php else: ?>二级菜单<?php endif; ?>
						      </td>
						      <td>
						      	<a data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-mini add"><i class="layui-icon">&#xe608;</i>添加子菜单</a>
								<a data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-mini layui-btn-normal edit"><i class="layui-icon">&#xe642;</i>编辑</a>
								<a  data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-danger layui-btn-mini del"><i class="layui-icon">&#xe640;</i>删除</a>
								<?php if($vo['pid']): ?><a  data="<?php echo ($vo["id"]); ?>" class="layui-btn  layui-btn-warm layui-btn-mini see"><i class="layui-icon">&#xe615;</i>查看操作</a><?php endif; ?>
						      </td>
						    </tr><?php endforeach; endif; ?>
					  </tbody>
				</table>
			
				</div>
			</fieldset>
			<div class="admin-table-page">
				<div id="page" class="page">
				<?php echo ($page); ?>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
		<script>
			layui.use(['laypage','layer','form'], function() {
				var laypage = layui.laypage,
					$ = layui.jquery
					//请求表单
				 $('.add').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('Menu/addMenu');?>";
					$.get(url,{id:id},function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						
						layer.open({
							  title:'添加菜单',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px'], //宽高
							  content: data,
						});
					})
				 });
				
				//编辑菜单
				$('.edit').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('Menu/editMenu');?>";
					
					$.get(url,{id:id},function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						
						layer.open({
							  title:'编辑菜单',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px'], //宽高
							  content: data,
						});
					})
				 });
				
				//查看opt
				$('.see').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('Menu/viewOpt');?>";
					$.get(url,{id:id},function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						layer.open({
							  title:'查看三级菜单',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['1200px','500px'], //宽高
							  content: data,
						});
					})
				 });
				
				//删除
				$('.del').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('Menu/deleteMenu');?>";
					layer.confirm('确定删除吗?', {
						  icon: 3,
						  skin: 'layer-ext-moon',
						  btn: ['确认','取消'] //按钮
						}, function(){
							$.post(url,{id:id},function(data){
								if(data.status == 'error'){
									  layer.msg(data.msg,{icon: 5});//失败的表情
									  return;
								  }else{
									  layer.msg(data.msg, {
										  icon: 6,//成功的表情
										  time: 2000 //2秒关闭（如果不配置，默认是3秒）
										}, function(){
										   location.reload();
										}); 
								  }	
							})
					  });
				})
				
			});
		</script>
	</body>

</html>