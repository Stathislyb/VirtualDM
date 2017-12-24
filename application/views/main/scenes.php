<script>
var html = `
	<div class="col-md-12 mb-4">
		<el-tabs v-model="selectedTab" type="card" editable @edit="handleSceneEdit">
		  <el-tab-pane
			v-for="scene in scenes"
			:key="scene.id"
			:label="scene.title" 
			:name="'scene_'+scene.id">
			<el-switch
				v-model="activeScene"
				:active-value="scene.id"
				inactive-value="0"
				active-text="Set scene as active">
			</el-switch>
			<button type="button"
				v-on:click="editSceneModal(scene.id)" 
				class="btn btn-outline-primary no-outline pointer float-right">
				<i class="fa fa-pencil-square-o centered" aria-hidden="true"></i>
			</button>
			<div class="scene-description">
				{{ scene.description }}
			</div>
		  </el-tab-pane>
		</el-tabs>
	</div>			
`;
</script>
<script>
Vue.component('vdm-scene-component', {
	data:function(){
		return <?php echo $data['app_data'] ?>
	},
	methods:{
		editSceneModal (sceneID){
			var sceneIndex = this.getSceneById(sceneID);
			var scene_obj = this.scenes[sceneIndex];
			var vdmComponent = this;
			this.$Modal.confirm({
				title: 'Edit Scene',
				okText: 'Save',
                cancelText: 'Cancel',
				content: '<div class="form-group"><label for="usr">Scene Title :</label>'+
						'<input type="text" class="form-control" id="new_scene_name" value="'+scene_obj.title+'" placeholder="Scene title"></Input>'+
						'</div><div class="form-group"><label for="usr">Scene description :</label>'+
					    '<textarea class="form-control" id="new_scene_description" :rows="4" placeholder="Scene description or summary">'+scene_obj.description+'</textarea ></div>'+
						'<div class="alert alert-danger hidden modal-error"> </div>',
				loading: true,
				onOk: () => {
					var name = $('#new_scene_name').val();
					var description = $('#new_scene_description').val();
					var formData = {
						action:"edit_scene", 
						data:{
							"adventure_id": vdmComponent.adventure_id,
							"scene_id": scene_obj.id,
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
								vdmComponent.scenes[sceneIndex].title = name;
								vdmComponent.scenes[sceneIndex].description = description;
								vdmComponent.$Modal.remove();
								vdmComponent.$Notice.success({title: data.message});
							}else{
								$('.ivu-btn-loading').find('i.ivu-load-loop').remove();
								$('.ivu-btn-loading').removeClass('ivu-btn-loading');
								vdmComponent.$Notice.error({title: data.message});
							}
						}
					});
				}
			});
		},
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
								vdmComponent.$Notice.success({title: data.message});
							}else{
								$('.ivu-btn-loading').find('i.ivu-load-loop').remove();
								$('.ivu-btn-loading').removeClass('ivu-btn-loading');
								vdmComponent.$Notice.error({title: data.message});
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
			this.activeScene = new_item.item_id;
		},
		removeScene (scene_index) {
			this.$Modal.confirm({
				title: 'Delete Scene',
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
								vdmComponent.$Notice.success({title: data.message});
							}else{
								vdmComponent.$Loading.error();
								vdmComponent.$Notice.error({title: data.message});
							}
						}
					});
				},
			});
		},
		handleSceneEdit(sceneName, action) {
			if (action === 'add') {
				this.addSceneModal();
			}
			if (action === 'remove') {
				var sceneID = sceneName.replace("scene_", "");
				var sceneIndex = this.getSceneById(sceneID);
				if(sceneIndex >= 0){
					this.removeScene(sceneIndex);
				}
			}
		},
		getSceneById(sceneID){
			var sceneIndex = -1;
			this.scenes.forEach((scene, index) => {
			  if (scene.id == sceneID) {
				sceneIndex = index;
			  }
			});
			return sceneIndex;
		}
	},
	template: html,
});

</script>