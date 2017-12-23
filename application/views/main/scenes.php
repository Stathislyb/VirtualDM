<script>
var html = `
	<div class="col-md-12 mb-4">
		<div class="hide-tabs-border-left"></div>
		<div class="hide-tabs-border-right"></div>
		<Tabs type="card" closable @on-tab-remove="removeScene">
			<TabPane v-for="scene in scenes" :key="scene.id" :label="scene.title">{{ scene.description }}</TabPane>
			<Button type="ghost" @click="addSceneModal" size="small" slot="extra">Add Scene</Button>
		</Tabs>
	</div>			
`;
</script>
<script>
Vue.component('vdm-scene-component', {
	data:function(){
		return <?php echo $data['app_data'] ?>
	},
	methods:{
		addSceneModal(){
			var vdmComponent = this;
			this.$Modal.confirm({
				title: 'Create New Scene',
				okText: 'Create',
                cancelText: 'Cancel',
				content: '<div class="form-group"><label for="usr">Scene Title :</label>'+
						'<input type="text" class="form-control" id="new_scene_name" placeholder="Scene title"></Input>'+
						'</div><div class="form-group"><label for="usr">Scene description :</label>'+
					    '<textarea class="form-control" id="new_scene_description" :rows="4" placeholder="Scene description or summary"></textarea ></div>'+
						'<div class="alert alert-danger hidden modal-error"> </div>',
				loading: true,
				onOk: () => {
					var name = $('#new_scene_name').val();
					var description = $('#new_scene_description').val();
					var formData = {
						action:"create_scene", 
						data:{
							"adventure_id": vdmComponent.adventure_id,
							"scene_name":name,
							"scene_description":description,
						},
					};
					$.ajax({
						url : vdmComponent.ajax_url,
						type: "POST",
						data : formData,
						dataType:"json",
						success: function(data){
							if( data.status == 1){
								vdmComponent.addScene({
									item_id:data.insert_id,
									item_name:name, 
									item_description:description
								});
								vdmComponent.$Modal.remove();
								vdmComponent.$Message.info(data.message);
							}else{
								$('.ivu-btn-loading').find('i.ivu-load-loop').remove();
								$('.ivu-btn-loading').removeClass('ivu-btn-loading');
								$('.modal-error').html(data.message).show();
							}
						}
					});
				}
			});
		},
		addScene (new_item) {
			this.scenes.push({
				id: new_item.item_id,
				state:1,
				title : new_item.item_name, 
				description: new_item.item_description,
			});
		},
		removeScene (scene_index) {
			this.$Modal.confirm({
				title: 'Delete Thread / Quest',
				okText: 'Delete',
                cancelText: 'Cancel',
				content: '<div class="alert alert-danger">Are you sure you want to delete this scene ?</div>',
				loading: true,
				onOk: () => {
					this.$Loading.start();
					var scene_id =this.scenes[scene_index].id
					var vdmComponent = this;
					var formData = {
								action:"delete_scene", 
								data:{
									"adventure_id": vdmComponent.adventure_id,
									"scene_id":scene_id,
								},
							};
					$.ajax({
						url : vdmComponent.ajax_url,
						type: "POST",
						data : formData,
						dataType:"json",
						success: function(data){
							if(data.status == 1){
								vdmComponent.scenes.splice(scene_index, 1);
								vdmComponent.$Loading.finish();
								vdmComponent.$Modal.remove();
							}else{
								vdmComponent.$Loading.error();
							}
							vdmComponent.$Message.info(data.message);
						}
					});
				},
				onCancel: () => {
					location.reload();
				},
			});
		},
	},
	template: html,
});

</script>