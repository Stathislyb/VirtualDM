<script>
var html = `
	<div class="col-md-12 mb-4">
		<h3>List of Threads / Quests</h3>
		<button type="button"
			v-on:click="createThreadModal" 
			class="list-group-item pointer form-control bg-light-gray" data-animation="false" data-toggle="tooltip" data-original-title="Add New Thread or Quest" >
			<i class="fa fa-plus centered" aria-hidden="true"></i>
		</button>
		<div class="list-group list-container slim-scrollbar">
			<span v-for="(thread, index) in threads_list" :key="thread.id" data-animation="false" data-toggle="tooltip" data-placement="left" :data-original-title="thread.description">
				<button type="button"
					v-on:click="deleteThread(index,thread.id)" 
					class="list-group-item pointer float-right delete-btn">
					<i class="fa fa-trash-o centered" aria-hidden="true"></i>
				</button>
				<a v-on:click="editThreadModal(thread.id)" class="list-group-item">{{thread.title}}</a>
			</span>
		</div>
	</div>
			
`;
</script>
<script>
Vue.component('vdm-thread-component', {
	data:function(){
		return <?php echo $data['app_data'] ?>
	},
	methods:{
		editThreadModal(threadID){
			var threadIndex = this.getThreadById(threadID);
			var thread_obj = this.threads_list[threadIndex];
			var vdmComponent = this;
			this.$Modal.confirm({
				title: 'Edit Thread / Quest',
				okText: 'Save',
                cancelText: 'Cancel',
				content: '<div class="form-group"><label for="usr">Thread / Quest Name :</label>'+
						'<input type="text" class="form-control" value="'+thread_obj.title+'" id="edit_tread_name" placeholder="Thread / Quest name">'+
						'</div><div class="form-group"><label for="usr">Thread / Quest description :</label>'+
					    '<textarea class="form-control" id="edit_tread_description" :rows="4" placeholder="Thread / Quest description or summary">'+thread_obj.description+'</textarea ></div>'+
						'<div class="alert alert-danger hidden modal-error"> </div>',
				loading: true,
				onOk: () => {
					var thread_name = $('#edit_tread_name').val();
					var thread_description = $('#edit_tread_description').val();
					var formData = {
						action:"edit_thread", 
						data:{
							"adventure_id": vdmComponent.adventure_id,
							"thread_id":threadID,
							"thread_name":thread_name,
							"thread_description":thread_description,
						},
					};
					$.ajax({
						url : vdmComponent.ajax_url,
						type: "POST",
						data : formData,
						dataType:"json",
						success: function(data){
							if( data.status == 1){
								vdmComponent.threads_list[threadIndex].title = thread_name;
								vdmComponent.threads_list[threadIndex].description = thread_description;
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
		createThreadModal(){
			var vdmComponent = this;
			this.$Modal.confirm({
				title: 'Create New Thread / Quest',
				okText: 'Create',
                cancelText: 'Cancel',
				content: '<div class="form-group"><label for="usr">Thread / Quest Name :</label>'+
						'<input type="text" class="form-control" id="new_tread_name" placeholder="Thread / Quest name">'+
						'</div><div class="form-group"><label for="usr">Thread / Quest description :</label>'+
					    '<textarea class="form-control" id="new_tread_description" :rows="4" placeholder="Thread / Quest description or summary"></textarea ></div>'+
						'<div class="alert alert-danger hidden modal-error"> </div>',
				loading: true,
				onOk: () => {
					var thread_name = $('#new_tread_name').val();
					var thread_description = $('#new_tread_description').val();
					var formData = {
						action:"create_thread", 
						data:{
							"adventure_id": vdmComponent.adventure_id,
							"thread_name":thread_name,
							"thread_description":thread_description,
						},
					};
					$.ajax({
						url : vdmComponent.ajax_url,
						type: "POST",
						data : formData,
						dataType:"json",
						success: function(data){
							if( data.status == 1){
								var thread_item = {thread_name:thread_name, thread_description:thread_description}
								vdmComponent.createThread({
									thread_id:data.insert_id,
									thread_name:thread_name, 
									thread_description:thread_description
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
		createThread (new_thread){
			this.threads_list.push({
				id : new_thread.thread_id, 
				title:new_thread.thread_name,
				description:new_thread.thread_description,
			});
			this.$nextTick(function() {  
				init_basics();
			});
		},
		deleteThread (tread_index, thread_id){
			this.$Modal.confirm({
				title: 'Delete Thread / Quest',
				okText: 'Delete',
                cancelText: 'Cancel',
				content: '<div class="alert alert-danger">Are you sure you want to delete this thread / quest ?</div>',
				loading: true,
				onOk: () => {
					this.$Loading.start();
					var vdmComponent = this;
					var formData = {
							action:"delete_thread", 
							data:{
								"adventure_id": vdmComponent.adventure_id,
								"thread_id":thread_id,
							},
						};
					$.ajax({
						url : vdmComponent.ajax_url,
						type: "POST",
						data : formData,
						dataType:"json",
						success: function(data){
							if(data.status == 1){
								vdmComponent.threads_list.splice(tread_index, 1);
								vdmComponent.$Loading.finish();
								vdmComponent.$Modal.remove();
								vdmComponent.$Notice.success({title: data.message});
							}else{
								vdmComponent.$Loading.error();
								vdmComponent.$Notice.error({title: data.message});
							}
						}
					});
				}
			});
		},
		getThreadById(threadID){
			var threadIndex = -1;
			this.threads_list.forEach((thread, index) => {
			  if (thread.id == threadID) {
				threadIndex = index;
			  }
			});
			return threadIndex;
		}
	},
	template: html,
});

</script>