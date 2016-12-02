<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>Table</title>
		<link rel="stylesheet" href="/Public/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="/Public/css/global.css" media="all">
		<link rel="stylesheet" href="/Public/plugins/font-awesome/css/font-awesome.min.css">
	</head>

	<body>
		<div class="admin-main">
		
			<blockquote class="layui-elem-quote">
				<button  class="layui-btn layui-btn-small add">
					<i class="layui-icon">&#xe608;</i> 添加角色
				</button>
			</blockquote>
			<fieldset class="layui-elem-field">
				<legend>角色列表</legend>
				<div class="layui-field-box">
				<table class="layui-table">
					  <thead>
					    <tr>
					      <th>#</th>
					      <th>角色名称</th>
					      <th>权限列表</th>
					      <th>操作</th>
					    </tr> 
					  </thead>
					  <tbody>
					  <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
					      <td><?php echo ($key+1); ?></td>
					      <td><?php echo ($v["title"]); ?></td>
					      <td><a href="<?php echo U('AuthGroup/ruleGroup',array('role_id' => $v['id']));?>" class="layui-btn layui-btn-mini rule">查看</a>
</td>
					      <td>
					      	<a href="<?php echo U('AuthGroup/ruleGroup',array('role_id' => $v['id']));?>" class="layui-btn layui-btn-mini rule"><i class="layui-icon">&#xe608;</i>分配权限</a>
							<a data="<?php echo ($v["id"]); ?>" class="layui-btn layui-btn-mini layui-btn-normal edit"><i class="layui-icon">&#xe642;</i>编辑</a>
							<a  data="<?php echo ($v["id"]); ?>" class="layui-btn layui-btn-danger layui-btn-mini del"><i class="layui-icon">&#xe640;</i>删除</a>
					      </td>
					    </tr><?php endforeach; endif; ?>
					  </tbody>
				</table>
				<?php echo ($page); ?>
				</div>
			</fieldset>
			
			

		</div>
		<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
		<script>
			layui.use(['laypage','layer','form'], function() {
				var laypage = layui.laypage,
					$ = layui.jquery
					//请求表单
				 $('.add').click(function(){
					var url = "<?php echo U('AuthGroup/addGroup');?>";
					$.get(url,function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						
						layer.open({
							  title:'添加角色',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px'], //宽高
							  content: data,
						});
					})
				 });
				
				//编辑
				$('.edit').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('AuthGroup/editGroup');?>";
					
					$.get(url,{id:id},function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						
						layer.open({
							  title:'编辑角色',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px'], //宽高
							  content: data,
						});
					})
				 });
				
				
				//删除
				$('.del').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('AuthGroup/deleteGroup');?>";
					layer.confirm('确定删除吗?', {
						  icon: 3,
						  skin: 'layer-ext-moon',
						  btn: ['确认','取消'] //按钮
						}, function(){
							$.post(url,{id:id},function(data){
								if(data.status=='error'){
									  layer.msg(data.msg,{icon: 5});//失败的表情
									  return;
								  }else{
									  layer.msg(data.msg, {
										  icon: 6,//成功的表情
										  time: 2000 //2秒关闭（如果不配置，默认是3秒）
										}, function(){
										   window.location.reload();
										}); 
								  }	
							})
					  });
				})
				
			});
		</script>
	</body>

</html>