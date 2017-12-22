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
				<a class="list-group-item">{{thread.title}}</a>
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
		createThreadModal(){
			var vdmComponent = this;
			this.$Modal.confirm({
				title: 'Create New Thread / Quest',
				okText: 'Create',
                cancelText: 'Cancel',
				content: '<div class="form-group"><label for="usr">Thread / Quest Name :</label>'+
						'<input type="text" class="form-control" id="new_tread_name" placeholder="Thread / Quest name"></Input>'+
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
							}else{
								vdmComponent.$Loading.error();
							}
							vdmComponent.$Message.info(data.message);
						}
					});
				}
			});
		},
	},
	template: html,
});

</script>