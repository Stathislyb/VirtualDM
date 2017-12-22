<script>
var html = `
	<div class="col-md-12">
		<h3>List of Characters</h3>
		<button type="button"
			v-on:click="createCharacterModal" 
			class="list-group-item pointer form-control bg-light-gray" data-animation="false" data-toggle="tooltip" data-original-title="Add New Character" >
			<i class="fa fa-plus centered" aria-hidden="true"></i>
		</button>
		<div class="list-group list-container slim-scrollbar">
			<span v-for="(character, index) in characters_list" :key="character.id" data-animation="false" data-toggle="tooltip" data-placement="left" :data-original-title="character.description">
				<button type="button"
					v-on:click="deleteCharacter(index, character.id)" 
					class="list-group-item pointer float-right delete-btn">
					<i class="fa fa-trash-o centered" aria-hidden="true"></i>
				</button>
				<a class="list-group-item">{{character.title}}</a>
			</span>
		</div>
	</div>
			
`;
</script>
<script>
Vue.component('vdm-character-component', {
	data:function(){
		return <?php echo $data['app_data'] ?>
	},
	methods:{
		createCharacterModal(){
			var vdmComponent = this;
			this.$Modal.confirm({
				title: 'Create New Character',
				okText: 'Create',
                cancelText: 'Cancel',
				content: '<div class="form-group"><label for="usr">Character Name :</label>'+
						'<input type="text" class="form-control" id="new_character_name" placeholder="Character name"></Input>'+
						'</div><div class="form-group"><label for="usr">Character description :</label>'+
					    '<textarea class="form-control" id="new_character_description" :rows="4" placeholder="Character description"></textarea ></div>'+
						'<div class="alert alert-danger hidden modal-error"> </div>',
				loading: true,
				onOk: () => {
					var character_name = $('#new_character_name').val();
					var character_description = $('#new_character_description').val();
					var formData = {
						action:"create_character", 
						data:{
							"adventure_id": vdmComponent.adventure_id,
							"character_name":character_name,
							"character_description":character_description,
						},
					};
					$.ajax({
						url : vdmComponent.ajax_url,
						type: "POST",
						data : formData,
						dataType:"json",
						success: function(data){
							if( data.status == 1){
								var character_item = {character_name:character_name, character_description:character_description}
								vdmComponent.createCharacter({
									character_id:data.insert_id,
									character_name:character_name, 
									character_description:character_description
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
		createCharacter (new_character){
			this.characters_list.push({
				id : new_character.character_id, 
				title:new_character.character_name,
				description:new_character.character_description,
			});
			this.$nextTick(function() {  
				init_basics();
			});
		},
		deleteCharacter (character_index, character_id){
			this.$Modal.confirm({
				title: 'Delete Thread / Quest',
				okText: 'Delete',
                cancelText: 'Cancel',
				content: '<div class="alert alert-danger">Are you sure you want to delete this character ?</div>',
				loading: true,
				onOk: () => {
					this.$Loading.start();
					var vdmComponent = this;
					var formData = {
								action:"delete_character", 
								data:{
									"adventure_id": vdmComponent.adventure_id,
									"character_id":character_id,
								},
							};
					$.ajax({
						url : vdmComponent.ajax_url,
						type: "POST",
						data : formData,
						dataType:"json",
						success: function(data){
							if(data.status == 1){
								vdmComponent.characters_list.splice(character_index, 1);
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