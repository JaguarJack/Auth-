<?php if (!defined('THINK_PATH')) exit();?><form class="layui-form">
  <div class="layui-form-item">
    <label class="layui-form-label">选择角色</label>
    <input type="hidden" name="user_id" value="<?php echo ($user_id); ?>" />
    <div class="layui-input-block">
    	<?php if(is_array($list)): foreach($list as $key=>$v): ?><input type="checkbox" title="<?php echo ($v["title"]); ?>" value="<?php echo ($v["id"]); ?>" name="group_id[<?php echo ($key); ?>]" <?php if($v['uid']): ?>checked<?php endif; ?>><div class="layui-unselect layui-form-checkbox layui-form-checked"><span>写作</span><i class="layui-icon"></i></div><?php endforeach; endif; ?>
     </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="role">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
<script>
layui.use('form', function(){
	var form = layui.form(),
   	$ = layui.jquery
   	$("button[type=reset]").click();	
	  //监听提交
	  form.on('submit(role)', function(data){
		  
	    var roleInfo = data.field;
	    
		var url = "<?php echo U('AuthGroup/giveRole');?>";
		$.post(url,roleInfo,function(data){
			if(data.status=='error'){
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
		
	    return false;//阻止表单跳转
	  });
	});
</script>