<script>
var html = `
	<div class="row mt-5">
		<div class="col-md-12">
			<label class="title-label">Chaos:</label>
			<div class="chaos-select" >
				<button type="button"
					v-for="i in 9" 
					v-on:click="setChaos(i)" 
					class="btn btn-outline-warning pointer mr-2" 
					v-bind:class="{ active: isChaosSelect(i), text-underline: (i==5) }" >
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
					class="col btn btn-outline-success pointer mt-3"  >
					Generate Random Event
				</button>
			</div>
		</div> 
		<div class="col-md-12 mt-4">
		
				<div class="col-md-12 card no-padding" v-if="showresult">
					<h3 class="card-header">Dice Result</h3>
					<div class="card-block">
						<h3 class="card-title">Rolled : 
							<span data-toggle="tooltip" data-placement="top" title="Lower is better">
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
				if( focus_title=='' && focus_dice < focus_element.threshold){
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