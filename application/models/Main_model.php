<?php

class Main_model extends CI_Model {

	public function get_ranks(){
		$this->db->select('*');
		$this->db->where('status', 1);
		$query = $this->db->get('dc_ranks');
		
		if($query->num_rows() > 0){
			$result = $query->result();
		}
	

		return $result;
	}

	public function get_focus(){
		$this->db->select('*');
		$this->db->where('status', 1);
		$query = $this->db->get('event_focus');
		
		if($query->num_rows() > 0){
			$result = $query->result();
		}
	

		return $result;
	}
	
	public function get_meaning(){
		$this->db->select('*');
		$this->db->where('status', 1);
		$query = $this->db->get('event_meaning');
		
		if($query->num_rows() > 0){
			$result = $query->result();
		}
	

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
	
	public function insert_question($data=[]){
		$this->db->insert('questions', $data);
		return  $this->db->insert_id();
	}
	
	public function insert_event($data=[]){
		$this->db->insert('events', $data);
		return  $this->db->insert_id();
	}
	
	public function get_questions($data=[]){
		$result = false;
		if( $data['adventure_id'] > 0 && $data['scene_id'] > 0){
			$this->db->select('id, question, reply, threshold, result, created_date');
			$this->db->where('adventure_id', $data['adventure_id']);
			$this->db->where('scene_id', $data['scene_id']);
			$this->db->where('id > ', $data['last_question_update']);
			$this->db->where('status', 1);
			$this->db->order_by('id', 'desc');
			$query = $this->db->get('questions');
			
			if($query->num_rows() > 0){
				$result = $query->result();
			}
		}
		
		return $result;
	}
	
	public function get_events($data=[]){
		$result = false;
		if( $data['adventure_id'] > 0 && $data['scene_id'] > 0){
			$this->db->select('id, title, description, created_date');
			$this->db->where('adventure_id', $data['adventure_id']);
			$this->db->where('scene_id', $data['scene_id']);
			$this->db->where('id > ', $data['last_event_update']);
			$this->db->where('status', 1);
			$this->db->order_by('id', 'desc');
			$query = $this->db->get('events');
			
			if($query->num_rows() > 0){
				$result = $query->result();
			}
		}
		
		return $result;
	}
	
	public function update_adventure($data=[]){
		$result = false;
		if( $data['adventure_id'] > 0 ){
			$this->db->where('id', $data['adventure_id']);
			$this->db->update("adventures", $data['adventure_data']);
			
			if($this->db->affected_rows() > 0){
				$result = true;
			}
		}
		
		return $result;
	}
	
	public function get_adventure($data=[]){
		
		$this->db->select('*');
		$this->db->where('id', $data['adventure_id']);
		$query = $this->db->get('adventures'); 
		
		return $query->row();
	}
	
}
?>