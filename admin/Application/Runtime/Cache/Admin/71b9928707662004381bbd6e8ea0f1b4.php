<?php if (!defined('THINK_PATH')) exit();?><form class="layui-form">
<div class="layui-form-item">
    <label class="layui-form-label">菜单图标</label>
    <div class="layui-input-inline">
      <input type="text" name="menuicon" <?php if($id): ?>lay-verify="required"<?php endif; ?> placeholder="请输入菜单图标" autocomplete="off" class="layui-input">
    </div>
     <div class="layui-form-mid layui-word-aux">具体参考layui官网</div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">菜单名称</label>
    <div class="layui-input-inline">
      <input type="text" name="menuname" lay-verify="required" placeholder="请输入菜单名称" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">控制器名称</label>
    <div class="layui-input-inline">
      <input type="text" name="controller" <?php if($id): ?>lay-verify="required"<?php endif; ?> placeholder="请输入控制器名称" autocomplete="off"  class="layui-input">
    </div>
    
    <div class="layui-form-mid layui-word-aux">驼峰法命名</div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">方法名称</label>
    <div class="layui-input-inline">
      <input type="text" name="action" <?php if($id): ?>lay-verify="required"<?php endif; ?> placeholder="请输入方法名称" autocomplete="off"  class="layui-input">
     
    </div>
     <div class="layui-form-mid layui-word-aux">驼峰法命名</div>
  </div>
  <input type="hidden" name="pid" value="<?php echo ($id); ?>">
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="addmenu">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
<script>
layui.use('form', function(){
	var form = layui.form(),
   		 $ = layui.jquery
	  //监听提交
	  form.on('submit(addmenu)', function(data){
		  
	    var userInfo = data.field;
		var url = "<?php echo U('Menu/addMenu');?>";
		$.post(url,userInfo,function(data){
			if(data.status == 'error'){
				  layer.msg(data.msg,{icon: 5});//失败的表情
				  return;
			  }else if(data.status == 'success'){
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