<?php

class Main_model extends CI_Model {

	public function get_ranks(){
		$result = array(
			array(
				'title' => "Almost Impossible",
				'value' => 10,
			),
			array(
				'title' => "Very Unlikely",
				'value' => 20,
			),
			array(
				'title' => "Unlikely",
				'value' => 30,
			),
			array(
				'title' => "Somewhat Unlikely",
				'value' => 40,
			),
			array(
				'title' => "Average",
				'value' => 50,
			),
			array(
				'title' => "Somewhat Likely",
				'value' => 60,
			),
			array(
				'title' => "Likely",
				'value' => 70,
			),
			array(
				'title' => "very Likely",
				'value' => 80,
			),
			array(
				'title' => "Almost Certain",
				'value' => 90,
			),
		);
		foreach($result as $key => $rank){
			$result[$key]['selected'] = false;
		}
		
		return $result;
	}

	public function get_focus(){
		$result = array(
			array(
				'title' => "Remote Event",
				'threshold' => 7,
			),
			array(
				'title' => "NPC Action",
				'threshold' => 22,
			), 
			array(
				'title' => "Introduce a new character",
				'threshold' => 30,
			), 
			array(
				'title' => "Thread related event", 
				'threshold' => 42,
			),
			array(
				'title' => "Open or Close a thread", 
				'threshold' => 47,
			),
			array(
				'title' => "PC Negative", 
				'threshold' => 55,
			),
			array(
				'title' => "PC Positive", 
				'threshold' => 63,
			),
			array(
				'title' => "Ambiguous Event", 
				'threshold' => 88,
			),
			array(
				'title' => "NPC Negative", 
				'threshold' => 94,
			),
			array(
				'title' => "NPC Positive",
				'threshold' => 100,
			),
		);

		return $result;
	}
	
	public function get_actions(){
		$result = array(
			"Attainment","Starting","Neglect","Fight","Recruit","Triumph","Violate","Oppose","Malice",
			"Communicate","Persecute","Increase","Decrease","Abandon","Gratify","Inquire","Antagonize",
			"Move","Waste","Truce","Release","Befriend","Judge","Desert","Dominate","Procrastinate","Praise",
			"Separate","Take","Break","Heal","Delay","Stop","Lie","Return","Immitate","Struggle","Inform","Bestow",
			"Postpone","Expose","Haggle","Imprison","Release","Celebrate","Develop","Travel","Block","Harm","Debase",
			"Overindulge","Adjourn","Adversity","Kill","Disrupt","Usurp","Create","Betray","Agree","Abuse",
			"Oppress","Inspect","Ambush","Spy","Attach","Carry","Open","Carelessness","Ruin","Extravagance",
			"Trick","Arrive","Propose","Divide","Refuse","Mistrust","Deceive","Cruelty","Intolerance","Trust",
			"Excitement","Activity","Assist","Care","Negligence","Passion","Work hard","Control","Attrack","Failure",
			"Pursue","Vengeance","Proceedings","Dispute","Punish","Guide","Transform","Overthrow","Oppress","Change",
		);

		return $result;
	}
	
	public function get_subjects(){
		$result = array(
			"Goals","Dreams","Environment","Outside","Inside","Reality","Allies","Enemies","Evil","Good","Emotions",
			"Opposition","War","Peace","The innocent","Love","The spiritual","The intellectual","New ideas","Joy",
			"Messages","Energy","Balance","Tension","Friendship","The physical","A project","Pleasures","Pain","Possessions",
			"Benefits","Plans","Lies","Expectations","Legal matters","Bureaucracy","Business","A path","News",
			"Exterior factors","Advice","A plot","Competition","Prison","Illness","Food","Attention","Success","Failure","Travel",
			"Jealousy","Dispute","Home","Investment","Suffering","Wishes","Tactics","Stalemate","Randomness","Misfortune",
			"Death","Disruption","Power","A burden","Intrigues","Fears","Ambush","Rumor","Wounds","Extravagance","A representative",
			"Adversities","Opulence","Liberty","Military","The mundane","Trials","Masses","Vehicle","Art","Victory","Dispute",
			"Riches","Status quo","Technology","Hope","Magic","Illusions","Portals","Danger","Weapons","Animals","Weather",
			"Elements","Nature","The public","Leadership","Fame","Anger","Information"
		);

		return $result;
	}
	
	public function get_meaning(){
		$result = array(
			"Attainment of goals.",
			"The founding of a fellowship.",
			"Neglect of the environment.",
			"Blight.",
			"The beginning of an enterprise
			which may harm others.",
			"Ecstasy to the point of
			divorce from reality.",
			"Conquest by force.",
			"Macho excess.",
			"Willpower.",
			"The recruitment of allies.",
			"The triumph of an evil
			cause.",
			"Physical and emotional
			violation.",
			"Weakness in the face of
			opposition.",
			"Force applied with
			deliberate malice.",
			"A declaration of war.",
			"Persecution of the innocent.",
			"Love.",
			"Abandonment of the
			spiritual.",
			"Instant gratification.",
			"Intellectual inquiry.",
			"Antagonism towards new
			ideas.",
			"Joy and laughter.",
			"Written messages.",
			"Movement.",
			"Wasteful dispersal of
			energies.",
			"Truce.",
			"Balance disturbed.",
			"Tension released.",
			"Disloyalty.",
			"Friendship.",
			"Physical attraction.",
			"Love for the wrong reasons.",
			"Passion which interferes
			with judgment.",
			"A physical challenge.",
			"Desertion of a project.",
			"Domination.",
			"Procrastination.",
			"Acclaim.",
			"A journey which causes
			temporary separation.",
			"Loss.",
			"A matter concluded in
			plenty.",
			"Healing.",
			"Excessive devotion to the
			pleasures of the senses.",
			"Swiftness in bringing a
			matter to its conclusion.",
			"Delay in obtaining material
			possessions.",
			"Delay.",
			"Prosperity.",
			"Material difficulties.",
			"Cessation of benefits.",
			"Temporary companionship.",
			"Loss due to the
			machinations of another.",
			"Lies made public.",
			"Spite.",
			"A situation does not live up
			to expectations.",
			"Defeat.",
			"Return of an old friend.",
			"New alliances.",
			"Imitation of reality.",
			"Confusion in legal matters.",
			"Bureaucracy.",
			"Unfairness in a business
			matter.",
			"Journey by water.",
			"A path away from
			difficulties.",
			"A temporary respite in
			struggle.",
			"Stalemate.",
			"Publicity.",
			"Public recognition for one's
			efforts.",
			"Good news.",
			"Bad news.",
			"Indefinite postponement by
			another of a project.",
			"Cause for anxiety due to
			exterior factors.",
			"Delay in achieving one's
			goal.",
			"Theft.",
			"A journey by land.",
			"Good advice from an
			expert.",
			"The exposure and
			consequent failure of a plot.",
			"A project about to reach
			completion.",
			"Intellectual competition.",
			"Haggling.",
			"Imprisonment.",
			"Illness.",
			"Release.",
			"Opposition collapses.",
			"A matter believed to be of
			great importance is actually
			of small consequence.",
			"Loss of interest.",
			"Celebration of a success.",
			"Rapid development of an
			undertaking.",
			"Travel by air.",
			"Non-arrival of an expected
			communication.",
			"Jealousy.",
			"Dispute among par tners.",
			"A project does not work
			out.",
			"The possible loss of home.",
			"An investment proves
			worthless.",
			"Suffering.",
			"Mental imprisonment.",
			"Debasement.",
			"Material desires are wholly
			fulfilled.",
			"Overindulgence.",
			"Wishes fall shor t.",
			"Delaying tactics.",
			"Stalemate leading to
			adjournment.",
			"Adversity, but not
			insurmountable.",
			"Gambling.",
			"Lack of solidity.",
			"Misfortune.",
			"The death of a dream.",
			"Disruption.",
			"Temporary success.",
			"Usurped power.",
			"A balance is made, but it is
			temporary.",
			"Failure of a partnership.",
			"Possible loss of friendship.",
			"Betrayal.",
			"Abuse of power.",
			"Becoming a burden to
			another.",
			"Oppression of the few by
			the many.",
			"Intrigues.",
			"Resentment.",
			"Fears realized.",
			"A student.",
			"Messages.",
			"The bearer of bad news.",
			"Fears proven unfounded.",
			"A sentinel.",
			"Inspection or scrutiny.",
			"Ambush.",
			"Spying.",
			"Mutiny.",
			"News.",
			"Attachment to the point of
			obsession.",
			"The affairs of the world.",
			"Unexpected aid.",
			"A bearer of intelligence.",
			"Rumor.",
			"Old wounds reopened.",
			"Carelessness.",
			"Friendship strained.",
			"Guerrilla warfare.",
			"Ruin.",
			"Unwise extravagance.",
			"Dirty tricks.",
			"Arrival of a friend.",
			"Propositions.",
			"Fraud.",
			"Rivalry.",
			"A spiritual representative.",
			"Triumph over adversities.",
			"Travel by air.",
			"Frustration.",
			"Division.",
			"The refusal to listen to
			views at variance to one's
			own.",
			"Motherly figure.",
			"Opulence.",
			"Ill-natured gossip.",
			"Mistrust of those near.",
			"Liberty.",
			"Deceit.",
			"Cruelty from intolerance.",
			"A person not to be trusted.",
			"Excitement from activity.",
			"Someone of assistance.",
			"Father figure.",
			"A dull individual.",
			"Military.",
			"A judge.",
			"A wise counselor.",
			"The mundane.",
			"A teacher.",
			"Trials overcome.",
			"Frenzy.",
			"Negligence.",
			"Duality.",
			"Passion",
			"Hard work.",
			"The control of masses.",
			"Alliance as a formality, not
			sincere.",
			"Attraction to an object or
			person.",
			"Travel by vehicle.",
			"Success in an artistic or
			spiritual pursuit.",
			"Vengeance.",
			"An unethical victory.",
			"Judicial proceedings.",
			"Dispute.",
			"Legal punishment.",
			"Guidance from an elder.",
			"A journey.",
			"Good fortune.",
			"Too much of a good thing.",
			"The spiritual over the
			material.",
			"The material over the
			spiritual.",
			"Transformation and change.",
			"Disunion.",
			"Amassment of riches.",
			"Overthrow of the existing
			order.",
			"Communication by
			technological means.",
			"Oppression.",
			"Hope.",
			"Hope deceived, daydreams
			fail.",
			"Change of place.",
		);

		return $result;
	}
   
   public function get_threads($data=[]){
		$result = false;
		if( $data['adventure_id'] > 0 ){
			$this->db->select('id, name, description');
			$this->db->where('adventure_id', $data['adventure_id']);
			$this->db->where('status', 1);
			$query = $this->db->get('threads');
			
			if($query->num_rows() > 0){
				$result = $query->result();
			}
		}
		
		return $result;
	}
	
	public function insert_thread($data=[]){
		$this->db->insert('threads', $data);
		return  $this->db->insert_id();
	}
	
	public function update_thread($data=[]){
		$result = false;
		if( $data['thread_id'] > 0 ){
			$this->db->where('id', $data['thread_id']);
			$this->db->update("threads", $data['thread_data']);
			
			if($this->db->affected_rows() > 0){
				$result = true;
			}
		}
		
		return $result;
	}
	
	public function get_characters($data=[]){
		$result = false;
		if( $data['adventure_id'] > 0 ){
			$this->db->select('id, name, description');
			$this->db->where('adventure_id', $data['adventure_id']);
			$this->db->where('status', 1);
			$query = $this->db->get('characters');
			
			if($query->num_rows() > 0){
				$result = $query->result();
			}
		}
		
		return $result;
	}
	
	public function insert_character($data=[]){
		$this->db->insert('characters', $data);
		return  $this->db->insert_id();
	}
   
	public function update_character($data=[]){
		$result = false;
		if( $data['character_id'] > 0 ){
			$this->db->where('id', $data['character_id']);
			$this->db->update("characters", $data['character_data']);
			
			if($this->db->affected_rows() > 0){
				$result = true;
			}
		}
		
		return $result;
	}
	
	public function get_scenes($data=[]){
		$result = false;
		if( $data['adventure_id'] > 0 ){
			$this->db->select('id, name, description, scene_state');
			$this->db->where('adventure_id', $data['adventure_id']);
			$this->db->where('status', 1);
			$query = $this->db->get('scenes');
			
			if($query->num_rows() > 0){
				$result = $query->result();
			}
		}
		
		return $result;
	}
	
	public function insert_scene($data=[]){
		$this->db->insert('scenes', $data);
		return  $this->db->insert_id();
	}
   
	public function update_scene($data=[]){
		$result = false;
		if( $data['scene_id'] > 0 ){
			$this->db->where('id', $data['scene_id']);
			$this->db->update("scenes", $data['scene_data']);
			
			if($this->db->affected_rows() > 0){
				$result = true;
			}
		}
		
		return $result;
	}
}
?>