<script>
var html = `
	<div class="row mt-5">
		<div class="col-md-12 mb-4">
			<div class="hide-tabs-border-left"></div>
			<div class="hide-tabs-border-right"></div>
			<Tabs type="card" closable @on-tab-remove="removeScene">
				<TabPane v-for="scene in scenes" :key="scene.id" :label="scene.title">{{ scene.description }}</TabPane>
				<Button type="ghost" @click="addScene" size="small" slot="extra">Add Scene</Button>
			</Tabs>
		</div>	
		<div class="col-md-8">
			<div class="col-md-12">
				<label class="title-label">Chaos:</label>
				<div class="chaos-select" >
					<button type="button"
						v-for="i in 9" 
						v-on:click="setChaos(i)" 
						class="btn btn-outline-warning pointer mr-2" 
						v-bind:class="{ active: isChaosSelect(i), underline: (i==5) }" >
						{{ i }}
					</button>
				</div>
			</div> 
			<div class="col-md-12">
				<label class="title-label">Select the Odds:</label>
				<div class="rank-links">
					<button type="button" 
						v-for="rank in ranks" 
						v-on:click="selectRank(rank)" 
						class="col btn btn-outline-primary pointer mr-2 mb-1" 
						v-bind:class="{ active: rank.selected }" >
						{{ rank.title }}
					</button>
				</div>
			</div> 
			<div class="col-md-12">
				<div class="col-md-3 no-padding">
					<button type="button" 
						v-on:click="generateEvent()" 
						class="col btn btn-outline-danger pointer mt-3"  >
						Generate Random Event
					</button>
				</div>
			</div> 
			<div class="col-md-12 mt-4">
			
					<div class="col-md-12 card no-padding" v-if="showresult">
						<h3 class="card-header">Dice Result</h3>
						<div class="card-block">
							<h3 class="card-title">Rolled : 
								<span data-toggle="tooltip" data-animation="false" data-placement="top" title="Lower is better">
									{{result}} ( {{threshold}}% )
								</span>
							</h3>
							<h3>So, {{result_msg}}</h3>
						</div>
					</div>
					
					<div class="col-md-12 card no-padding event_card" v-if="event.show">
						<h3 class="card-header">Random Event</h3>
						<div class="card-block">
							<h3 class="card-title">{{event.title}}</h3>
							<hr/>
							{{event.meaning}}<br/>
							<p class="event_description">{{event.description}}</p>
						</div>
					</div>
					
				</div>
			</div> 
		
		<div class="col-md-4">
			<vdm-thread-component></vdm-thread-component>
			<vdm-character-component></vdm-character-component>
		</div>
	</div>
`;
</script>
<script>
Vue.component('vdm-component', {
	data:function(){
		return <?php echo $data['app_data'] ?>
	},
	methods:{
		selectRank:function(rank){
			this.ranks.forEach(function(rank_element) {
				rank_element.selected = false;
			});
			rank.selected=true;
			this.selected_value = rank.value;
			
			this.result = this.RollDice(1,100);
		},
		setChaos:function(chaos){
			this.chaos_factor = chaos;
		},
		generateEvent:function(){
			var focus_dice = this.RollDice(1,100);
			var focus_title = '';
			this.focus.forEach(function(focus_element) {
				if( focus_title=='' && focus_dice <= focus_element.threshold){
					focus_title = focus_element.title;
				}
			});
			this.event.title = focus_title;
			
			var meaning_dice = this.RollDice(1,this.meaning.length);
			this.event.meaning = this.meaning[meaning_dice];
			
			var action_dice = this.RollDice(1,this.actions.length);
			var object_dice = this.RollDice(1,this.subjects.length);
			this.event.description = this.subjects[object_dice]+" "+this.actions[action_dice];
			this.event.show = true;
		},
		RollDice: function(min,max){
			return Math.floor(Math.random()*(max-min+1)+min);
		},
		isChaosSelect:function(i){
			var active = false;
			if(this.chaos_factor == i){
				active = true;
			}
			return active;
		},
		removeScene (name) {
			this['scene ' + name] = false;
		},
		addScene () {
			this.scenes.push({
				title : 'New scene', 
				description:'New scene description',
			});
		},
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
			var next_id = 1;
			if( this.threads_list.length > 0 ){
				next_id = this.threads_list[this.threads_list.length-1].id+1;
			}
			this.threads_list.push({
				id : new_thread.thread_id, 
				title:new_thread.thread_name,
				description:new_thread.thread_description,
			});
		},
		deleteThread (tread_index){
			this.threads_list.splice(tread_index, 1);
		},
		deleteCharacter (character_index){
			this.characters_list.splice(character_index, 1);
		},
		createCharacter (){
			var next_id = 1;
			if( this.characters_list.length > 0 ){
				next_id = this.characters_list[this.characters_list.length-1].id+1;
			}
			this.characters_list.push({
				id : next_id, 
				title:'New Character',
			});
		},
	},
	watch:{
		showresult: function(){
			this.$nextTick(function() {  
				init_basics();
			});
		},
		result: function(){
			var make_event = false;
			var check_num = 0;
			for(var i=1; i<10; i++){
				check_num = (i*10) + i;
				if( this.result == check_num && i <= this.chaos_factor){
					make_event = true;
				}
			}
			//make_event = true;
			if( make_event ){
				this.generateEvent();
			}else{
				this.event.show = false;
			}
		},
	},
	computed: {
		threshold: function(){
			var value = this.selected_value + (this.chaos_factor-5)*5;
			
			if(value < 0){
				value = 0;
			}
			if(value>100){
				value = 100;
			}
			
			return value;
		},
		result_msg: function(){
			var message = '';
			var margin = this.threshold / 10;
			var value_margin = 0;
			
			if( this.threshold < this.result ){
				and_margin = 100 - margin;
				but_margin = this.threshold + margin;
				if( this.result >= and_margin  ){
					message = 'No and ...';
				}else if( this.result >= but_margin){
					message = 'No.';
				}else{
					message = 'No but ...';
				}
			}else{
				and_margin = margin;
				but_margin = this.threshold - margin;
				if( this.result <= and_margin ){
					message = 'Yes and ...';
				}else if( this.result <= but_margin ){
					message = 'Yes!';
				}else{
					message = 'Yes but ...';
				}
			}
			return message;
		},
		showresult: function(){
			var show = false;
			if(this.result > 0 && this.threshold > 0){
				show = true;
			}
			return show;
		},
	},
	template: html,
});

</script>