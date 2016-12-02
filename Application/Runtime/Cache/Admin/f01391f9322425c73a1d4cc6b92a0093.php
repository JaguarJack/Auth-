<?php if (!defined('THINK_PATH')) exit();?><table class="layui-table">
		  <thead>
		    <tr>
		      <th>#</th>
		      <th>菜单名称</th>
		      <th>控制器名称</th>
		      <th>方法名称</th>
		      <th>管理</th>
		    </tr> 
		  </thead>
		  <tbody>
			<?php if(is_array($opts)): foreach($opts as $k=>$vo): ?><tr>
			      <?php $opt = explode('/',$vo['menu_name']); ?>
			      <td><?php echo ($k+1); ?></td>
			      <td><?php echo ($vo["title"]); ?></td>
			      <td><?php echo ($opt[0]); ?></td>
			      <td><?php echo ($opt[1]); ?></td>
			      <td>
					<a data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-mini layui-btn-normal _edit"><i class="layui-icon">&#xe642;</i>编辑</a>
					<a  data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-danger layui-btn-mini _del"><i class="layui-icon">&#xe640;</i>删除</a>
			      </td>
			    </tr><?php endforeach; endif; ?>
		  </tbody>
	</table>
		<script>
			layui.use(['layer','form'], function() {
				var $ = layui.jquery;
				//编辑菜单
				$('._edit').click(function(){
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
				//删除
				$('._del').click(function(){
					var id = $(this).attr('data');
					var url = "<?php echo U('Menu/deleteMenu');?>";
					layer.confirm('确定删除吗?', {
						  icon: 3,
						  skin: 'layer-ext-moon',
						  btn: ['确认','取消'] //按钮
						}, function(){
							$.post(url,{id:id},function(data){
								if(data.status == 'error'){
									layer.msg(data.msg,{icon: 5});
									return;
								}
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