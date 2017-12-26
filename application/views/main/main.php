<script>
var html = `
	<div class="row mt-5">
		<vdm-scene-component></vdm-scene-component>
		<div class="col-md-8">
			<div class="col-md-12">
				<label class="title-label">Chaos:</label>
				<div class="chaos-select row justify-content-md-center" >
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
				<div class="rank-links row justify-content-md-center">
					<button type="button" 
						v-for="rank in ranks" 
						v-on:click="selectRank(rank)" 
						class="col-3 btn btn-outline-primary pointer mr-2 mb-1" 
						v-bind:class="{ active: rank.selected }" >
						{{ rank.title }}
					</button>
				</div>
			</div>
			<div class="col-md-12">
				<label class="title-label">Type your question:</label>
			</div> 	
			<div class="row justify-content-md-center">
				<div class="col-md-8">
					<input v-on:keydown="resetQuestion" v-on:keyup.enter="getResult()" v-model="question" type="text" class="form-control" id="question_input" placeholder="Type a yes or no question">
					<button type="button" 
						v-on:click="getResult()" 
						class="btn btn-primary pointer form-control mt-3" >
						Ask the DM
					</button>
				</div>
			</div> 			
			<div class="row justify-content-md-center">
				<div class="col-md-8 mt-3">
					<button type="button" 
						v-on:click="generateEvent()" 
						class="col btn btn-outline-danger pointer"  >
						Generate Random Event
					</button>
				</div>
			</div> 
			<div class="col-md-12 mt-4 mb-4">
			
				<div class="col-md-12 card no-padding" v-if="showresult">
					<h3 class="card-header">Dice Result</h3>
					<div class="card-block">
						<h3 class="card-title "><em>{{question}}</em></h3>
						<hr/>
						<h3><span data-toggle="tooltip" data-animation="false" data-placement="top" :data-original-title="rollMessage" :title="rollMessage">
							{{result_msg}}
						</span></h3>
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
		
		<div class="col-md-12 mt-4">
			<div class="col-md-12 card no-padding logs_card" v-if="showLogs">
				<h3 class="card-header">Scene Log</h3>
				<div class="card-block slim-scrollbar">
					<div  v-for="log_item in logs" class="row log_item" :class="log_item.type" data-toggle="tooltip" data-placement="left" data-animation="false" :data-original-title="log_item.tooltip">
						<div class="col-md-10 log_text">
							<div class="main-text">{{log_item.textMain}}</div>
							<div class="sub-text">{{log_item.textSub}}</div>
						</div>
						<div class="col-md-2 text-right font-italic">{{log_item.date}}</div>
					</div>
				</div>
			</div>
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
		resetQuestion:function(event){
			if(event.key != "Enter"){
				this.showresult = false;
			}
		},
		selectRank:function(rank){
			this.ranks.forEach(function(rank_element) {
				rank_element.selected = false;
			});
			rank.selected=true;
			this.selected_value = rank.value;		
			this.showresult = false;		
		},
		getResult:function(){
			if(this.threshold > 0 && this.question.trim().length > 1){
				// add question mark in the end if there is none
				var question_marked = this.question.replace(/ ?\?/g, '') + ' ?';
				if (this.question != question_marked) {
					this.question = question_marked;
				}
				// get the result
				this.result = this.RollDice(1,100);
				this.showresult = true;
				// log the question - reply
				var ajaxData = {
					action:"log_question", 
					data:{
						"adventure_id": this.adventure_id,
						"scene_id": 1,
						"question":this.question,
						"threshold":this.threshold,
						"result" : this.result,
						"reply" : this.result_msg,
					},
				};
				//var vdmComponent = this;
				this.makeAjaxCall(ajaxData
					// ,function(data){
						// vdmComponent.$Notice.success({title: data.message})
					// }, function(data){
						// vdmComponent.$Notice.success({title: data.message})
					// }
				);
			}else{
				if( this.selected_value == 0 ){
					this.$Notice.error({title: 'Please select the odds'});
				}
				if( this.question.trim().length <= 1 ){
					this.$Notice.error({title: 'Please type a question'});
				}
			}
		},
		setChaos:function(chaos){
			this.chaos_factor = chaos;
			this.showresult = false;
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
			
			// log the event
			var ajaxData = {
				action:"log_event", 
				data:{
					"adventure_id": this.adventure_id,
					"scene_id": 1,
					"title": focus_title,
					"description": this.event.meaning,
				},
			};
			this.makeAjaxCall(ajaxData);
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
		updateLogs: function(){
			var ajaxData = {
				action:"get_logs", 
				data:{
					"adventure_id": this.adventure_id,
					"scene_id": 1,
					"last_update": this.lastLogUpdate,
				},
			};
			var vdmComponent = this;
			this.makeAjaxCall(ajaxData, function(data){
				if(data.data != false){
					data.data.forEach(function(log_item) {
						if( new Date(vdmComponent.lastLogUpdate) < new Date(log_item.date) ){
							vdmComponent.lastLogUpdate = log_item.date;
						}
						vdmComponent.logs.push(log_item);
					});
					vdmComponent.sortLogs();
					vdmComponent.$nextTick(function() {  
						init_basics();
					});
				}
			});
		},
		sortLogs: function(){
			this.logs.sort(function(a,b){
				return new Date(b.date) - new Date(a.date);
			});
		},
		makeAjaxCall: function(ajaxData, successCallback = function(data){}, failCallback  = function(data){}){
			$.ajax({
				url : this.ajax_url,
				type: "POST",
				data : ajaxData,
				dataType:"json",
				success: function(data){
					if( data.status == 1){
						successCallback(data);
					}else{
						failCallback(data);
					}
				}
			});
		},
	},
	watch:{
		showresult: function(){
			if(this.showresult){
				this.$nextTick(function() {  
					init_basics();
				});
			}
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
		rollMessage: function(){
			return 'Rolled : '+this.result+' ('+this.threshold+'%)';
		},
		showLogs: function(){
			return (this.logs.length > 0);
		},
	},
	created: function () {
		this.updateLogs();

		setInterval(function () {
		  this.updateLogs();
		}.bind(this), 3000); 
	},
	template: html,
});

</script>