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
			<blockquote class="layui-elem-quote">权限分配

			</blockquote>
			<fieldset class="layui-elem-field">
				<legend>权限分配</legend>
				<div class="layui-field-box">
				<form class="layui-form">
				  <div class="layui-form-item">
				    <label class="layui-form-label">权限列表</label>
				     <?php if(is_array($menus)): foreach($menus as $k=>$vo): ?><div class="layui-input-block">
					     <input type="checkbox" name="menu[<?php echo ($vo["id"]); ?>]" value="<?php echo ($vo['id']); ?>" title="<?php echo ($vo["title"]); ?>" class="level_one" <?php if(in_array($vo['id'],$rulesArr)){echo "checked";} ?>>
					      <?php if(is_array($vo[$vo['id']])): foreach($vo[$vo['id']] as $key=>$v): ?><div class="layui-input-block">
					      	<input type="checkbox" name="menu[<?php echo ($v["id"]); ?>]" title="<?php echo ($v["title"]); ?>" value="<?php echo ($v['id']); ?>" class="level_two" <?php if(in_array($v['id'],$rulesArr)){echo "checked";} ?>>
					     <div class="layui-input-block">
					      		 <?php if(is_array($v[$v['id']])): foreach($v[$v['id']] as $key=>$v1): ?><input type="checkbox" name="menu[<?php echo ($v1["id"]); ?>]" title="<?php echo ($v1["title"]); ?>" value="<?php echo ($v1['id']); ?>" class="level_three" <?php if(in_array($v1['id'],$rulesArr)){echo "checked";} ?>><?php endforeach; endif; ?>
					      		</div>
					      		</div><?php endforeach; endif; ?>
				    </div><?php endforeach; endif; ?>
				  </div>
				  <div class="layui-form-item">
				    <div class="layui-input-block">
				      <button class="layui-btn" lay-submit lay-filter="auth">立即提交</button>
				      <button class="layui-btn layui-btn-primary" onclick="window.history.back(-1)" >返回</button>
				    </div>
				  </div>
				  <input type="hidden" name="role_id" value="<?php echo ($role_id); ?>">
				</form>
				</div>
			</fieldset>
		</div>
		<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
		<script>
			layui.use(['layer','form'], function() {
				var form = layui.form(),
					$ = layui.jquery
					//选中
				    $('.layui-form-checkbox').on('click', function (e){
						 var children = $(this).parent('.layui-input-block').find('.layui-form-checkbox');
						 var input = $(this).parent('.layui-input-block').find('input');
						 
						 if($(this).prev('input').hasClass('level_three')){
							 if($(this).hasClass('layui-form-checked') == true){
								 $(this).addClass('layui-form-checked')
								 $(this).prev('input').prop('checked',true);
							 }else{
								 $(this).removeClass('layui-form-checked');
								 $(this).prev('input').prop('checked',false);
							 }
						 }else{
							 if($(this).hasClass('layui-form-checked') == true){
								 children.addClass('layui-form-checked')
								 input.prop('checked',true);
							 }else{
								 children.removeClass('layui-form-checked');
								 input.prop('checked',false);
							 } 
							 
						 }
						 
					})
					//监听提交
					  form.on('submit(auth)', function(data){
					  
					    var menu_ids = data.field;
						var url = "<?php echo U('AuthGroup/ruleGroup');?>";
						$.post(url,menu_ids,function(data){
							if(data.status == 'error'){
								layer.msg(data.msg,{icon: 5});//失败的表情
								  return;
							}else{
								layer.msg(data.msg, {
									  icon: 6,//成功的表情
									  time: 2000 //2秒关闭（如果不配置，默认是3秒）
									}, function(){
										history.go(-1);
									}); 
							} 
						})
					    return false;//阻止表单跳转
					  });
				
			});
		</script>
	</body>

</html>