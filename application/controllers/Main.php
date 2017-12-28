<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Main_model');
    }
	
	public function index($adventure_id = 1){
		$this->adventure($adventure_id);
	}
	
	public function adventure($adventure_id = 1){
		$adventure_id = $adventure_id;
		
		// get the adventure's data and prepare to pass them to the component
		$adventure = $this->Main_model->get_adventure([
			'adventure_id' => $adventure_id,
		]);
		
		$selected_scene = $adventure->selected_scene;
		$chaos_factor = $adventure->chaos_factor;
		
		// get the scenes' data and prepare to pass them to the component
		$scenes = $this->Main_model->get_scenes([
			'adventure_id' => $adventure_id,
		]);
		$scenes_list = array();
		if( $scenes != false ){
			foreach($scenes as $scene){
				$scenes_list[] = array(
					'id'	=> $scene->id,
					'state' => $scene->scene_state,
					'title' => $scene->name,
					'description' => $scene->description,
				);
			}
		}
		$scenes_data = array(
			'ajax_url' => base_url().'index.php/Main/handle_post',
			'adventure_id' =>$adventure_id,
			'scenes' => $scenes_list,
			'activeScene' => $selected_scene, 
			'initialActiveScene' => $selected_scene,
			'selectedTab' => 'scene_'.$selected_scene,	
		);
		
		// get the threads' data and prepare to pass them to the component
		$threads = $this->Main_model->get_threads([
			'adventure_id' => $adventure_id,
		]);
		$threads_list = array();
		if( $threads != false ){
			foreach($threads as $thread){
				$threads_list[] = array(
					'id'	=> $thread->id,
					'title' => $thread->name,
					'description' => $thread->description,
				);
			}
		}
		$threads_data = array(
			'ajax_url' => base_url().'index.php/Main/handle_post',
			'adventure_id' => $adventure_id,
			'threads_list' => $threads_list,
		);
		
		// get the characters' data and prepare to pass them to the component
		$characters = $this->Main_model->get_characters([
			'adventure_id' => $adventure_id,
		]);
		$characters_list = array();
		if( $characters != false ){
			foreach($characters as $character){
				$characters_list[] = array(
					'id'	=> $character->id,
					'title' => $character->name,
					'description' => $character->description,
				);
			}
		}
		$characters_data = array(
			'ajax_url' => base_url().'index.php/Main/handle_post',
			'adventure_id' => $adventure_id,
			'characters_list' => $characters_list,
		);
		
		
		// get the main page's data and prepare to pass them to the component
		$ranks = $this->Main_model->get_ranks();
		$ranks_list = array();
		$ranks_weight = 0;
		$ranks_multiplier = 0;
		if( $ranks != false ){
			$ranks_middle = floor( count($ranks) / 2 );
			foreach($ranks as $index => $rank){
				
				$ranks_list[] = array(
					'title'	=> $rank->title,
					'weight' => $rank->weight,
					'selected' => ($index == $ranks_middle)?true:false,
				);
				$ranks_weight += $rank->weight;
			}
			// $ranks_weight+1 because want to leave room for failure
			$ranks_multiplier = ceil(100/($ranks_weight+1));
		}
		
		$focus = $this->Main_model->get_focus();
		$focus_list = array();
		$focus_weight = 0;
		$focus_multiplier = 0;
		if( $focus != false ){
			foreach($focus as $focus_item){
				$focus_list[] = array(
					'title'	=> $focus_item->title,
					'weight' => $focus_item->weight,
				);
				$focus_weight += $focus_item->weight;
			}
			if($focus_weight > 0){
				$focus_multiplier = ceil(100/$focus_weight);
			}
		}
		
		$meaning = $this->Main_model->get_meaning();
		$meaning_list = array();
		$meaning_weight = 0;
		$meaning_multiplier = 0;
		if( $meaning != false ){
			foreach($meaning as $meaning_item){
				$focus_list[] = array(
					'title'	=> $meaning_item->title,
					'weight' => $meaning_item->weight,
				);
				$meaning_weight += $meaning_item->weight;
			}
			if($meaning_weight > 0){
				$meaning_multiplier = ceil(100/$meaning_weight);
			}
		}
		
		$app_data = array(
			'ajax_url' => base_url().'index.php/Main/handle_post',
			'adventure_id' => $adventure_id,
			'adventureName' => $adventure->name,
			'adventureDescription' => $adventure->description,
			'selected_scene' => $selected_scene,
			'ranks' => $ranks_list,
			'ranks_multiplier' => $ranks_multiplier,
			'focus' => $focus_list,
			'focus_multiplier' => $focus_multiplier,
			'meaning' => $meaning,
			'meaning_multiplier' => $meaning_multiplier,
			'result' => 0,
			'chaos_factor' => $chaos_factor,
			'question' => '',
			'showresult' => false,
			'logs' => array(),
			'lastLogQuestion' => 0,
			'lastLogEvent' => 0,
			'event' => array(
				'show' => false,
				'title' => '',
				'meaning' => '',
				'description' => '',
			),
		);
		
		$data['app_data'] = json_encode ( $scenes_data );
		$this->template->addView("main", "scenes", $data);
		$data['app_data'] = json_encode ( $threads_data );
		$this->template->addView("main", "threads", $data);
		$data['app_data'] = json_encode ( $characters_data );
		$this->template->addView("main", "characters", $data);
		$data['app_data'] = json_encode ( $app_data );
		$this->template->addView("main", "main", $data);
		
		$this->template->showViews();
	}
	
	public function create_thread( $data = [] ){
		$data = $this->security->xss_clean($data);
		try {
			$this->db->trans_start();
			
			if ( $data['adventure_id'] != 1 ) {
				throw new Exception('Wrong adventure id.');
			}
			if ( empty(trim($data['thread_name'])) ) {
				throw new Exception('Please fill the quest\'s name.');
			}
			
			$insert_data = array(
				'adventure_id'=> $data['adventure_id'],
				'name'=> $data['thread_name'],
				'description'=> $data['thread_description'],
			);
			$insert_id = $this->Main_model->insert_thread($insert_data);
			
			$this->db->trans_complete();
			$message = "The thread was created successfully";
			$status = 1 ;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$status = 0 ;
			$message = $e->getMessage();
			$insert_id = 0;
		}
		
		$result = array(
			'status' => $status,
			'message' => $message,
			'insert_id'=> $insert_id,
		);
		
		echo json_encode($result);
    }
	
	public function edit_thread( $data = [] ){
		$data = $this->security->xss_clean($data);
		try {
			$this->db->trans_start();
			
			if ( $data['adventure_id'] != 1 ) {
				throw new Exception('Wrong adventure id.');
			}
			if ( !($data['thread_id'] > 0) ) {
				throw new Exception('Wrong quest id.');
			}
			if ( empty(trim($data['thread_name'])) ) {
				throw new Exception('Please fill the quest\'s name.');
			}
			
			$update_data = array(
				'adventure_id'=> $data['adventure_id'],
				'thread_id'=> $data['thread_id'],
				'thread_data' => array(
					'name'=> $data['thread_name'],
					'description'=> $data['thread_description'],
				),
			);
			$insert_id = $this->Main_model->update_thread($update_data);
			
			$this->db->trans_complete();
			$message = "The thread was created successfully";
			$status = 1 ;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$status = 0 ;
			$message = $e->getMessage();
			$insert_id = 0;
		}
		
		$result = array(
			'status' => $status,
			'message' => $message,
			'insert_id'=> $insert_id,
		);
		
		echo json_encode($result);
    }
	
	public function delete_thread( $data = [] ){
		$data = $this->security->xss_clean($data);
		try {
			$this->db->trans_start();
			
			if ( !($data['thread_id'] > 0) ) {
				throw new Exception('Wrong thread id.');
			}
			
			$update_data = array(
				'thread_id'=> $data['thread_id'],
				'thread_data' => array(
					'status' => 0,
				),
			);
			$result = $this->Main_model->update_thread($update_data);
			
			if ( $result === false ) {
				throw new Exception('Update failed.');
			}
			
			$this->db->trans_complete();
			$message = "The thread was deleted successfully";
			$status = 1 ;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$status = 0 ;
			$message = $e->getMessage();
		}
		
		$result = array(
			'status' => $status,
			'message' => $message,
		);
		
		echo json_encode($result);
    }
	
	public function create_character( $data = [] ){
		$data = $this->security->xss_clean($data);
		try {
			$this->db->trans_start();
			
			if ( $data['adventure_id'] != 1 ) {
				throw new Exception('Wrong adventure id.');
			}
			if ( empty(trim($data['character_name'])) ) {
				throw new Exception('Please fill the character\'s name.');
			}
			
			$insert_data = array(
				'adventure_id'=> $data['adventure_id'],
				'name'=> $data['character_name'],
				'description'=> $data['character_description'],
			);
			$insert_id = $this->Main_model->insert_character($insert_data);
			
			$this->db->trans_complete();
			$message = "The character was created successfully";
			$status = 1 ;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$status = 0 ;
			$message = $e->getMessage();
			$insert_id = 0;
		}
		
		$result = array(
			'status' => $status,
			'message' => $message,
			'insert_id'=> $insert_id,
		);
		
		echo json_encode($result);
    }
	
	public function edit_character( $data = [] ){
		$data = $this->security->xss_clean($data);
		try {
			$this->db->trans_start();
			
			if ( $data['adventure_id'] != 1 ) {
				throw new Exception('Wrong adventure id.');
			}
			if ( !($data['character_id'] >0) ) {
				throw new Exception('Wrong character id.');
			}
			if ( empty(trim($data['character_name'])) ) {
				throw new Exception('Please fill the character\'s name.');
			}
			
			$update_data = array(
				'character_id'=> $data['character_id'],
				'character_data' => array(
					'name'=> $data['character_name'],
					'description'=> $data['character_description'],
				),
			);
			$insert_id = $this->Main_model->update_character($update_data);
			
			$this->db->trans_complete();
			$message = "The character was updated successfully";
			$status = 1 ;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$status = 0 ;
			$message = $e->getMessage();
			$insert_id = 0;
		}
		
		$result = array(
			'status' => $status,
			'message' => $message,
			'insert_id'=> $insert_id,
		);
		
		echo json_encode($result);
    }
	
	public function delete_character( $data = [] ){
		$data = $this->security->xss_clean($data);
		try {
			$this->db->trans_start();
			
			if ( !($data['character_id'] > 0) ) {
				throw new Exception('Wrong character id.');
			}
			
			$update_data = array(
				'character_id'=> $data['character_id'],
				'character_data' => array(
					'status' => 0,
				),
			);
			$result = $this->Main_model->update_character($update_data);
			
			if ( $result === false ) {
				throw new Exception('Update failed.');
			}
			
			$this->db->trans_complete();
			$message = "The character was deleted successfully";
			$status = 1 ;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$status = 0 ;
			$message = $e->getMessage();
		}
		
		$result = array(
			'status' => $status,
			'message' => $message,
		);
		
		echo json_encode($result);
    }
	
	public function create_scene( $data = [] ){
		$data = $this->security->xss_clean($data);
		try {
			$this->db->trans_start();
			
			if ( $data['adventure_id'] != 1 ) {
				throw new Exception('Wrong adventure id.');
			}
			if ( empty(trim($data['scene_name'])) ) {
				throw new Exception('Please fill the scene\'s name.');
			}
			
			$insert_data = array(
				'adventure_id'=> $data['adventure_id'],
				'name'=> $data['scene_name'],
				'description'=> $data['scene_description'],
			);
			$insert_id = $this->Main_model->insert_scene($insert_data);
			
			$this->db->trans_complete();
			$message = "The scene was created successfully";
			$status = 1 ;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$status = 0 ;
			$message = $e->getMessage();
			$insert_id = 0;
		}
		
		$result = array(
			'status' => $status,
			'message' => $message,
			'insert_id'=> $insert_id,
		);
		
		echo json_encode($result);
    }
	
	public function edit_scene( $data = [] ){
		$data = $this->security->xss_clean($data);
		try {
			$this->db->trans_start();
			
			if ( $data['adventure_id'] != 1 ) {
				throw new Exception('Wrong adventure id.');
			}
			if ( !($data['scene_id'] > 0) ) {
				throw new Exception('Wrong scene id.');
			}
			if ( empty(trim($data['scene_name'])) ) {
				throw new Exception('Please fill the scene\'s name.');
			}
			
			$update_data = array(
				'scene_id'=> $data['scene_id'],
				'scene_data' => array(
					'name'=> $data['scene_name'],
					'description'=> $data['scene_description'],
				),
			);
			$insert_id = $this->Main_model->update_scene($update_data);
			
			$this->db->trans_complete();
			$message = "The scene was updated successfully";
			$status = 1 ;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$status = 0 ;
			$message = $e->getMessage();
			$insert_id = 0;
		}
		
		$result = array(
			'status' => $status,
			'message' => $message,
			'insert_id'=> $insert_id,
		);
		
		echo json_encode($result);
    }
	
	public function delete_scene( $data = [] ){
		$data = $this->security->xss_clean($data);
		try {
			$this->db->trans_start();
			
			if ( !($data['scene_id'] > 0) ) {
				throw new Exception('Wrong scene id.');
			}
			
			$update_data = array(
				'scene_id'=> $data['scene_id'],
				'scene_data' => array(
					'status' => 0,
				),
			);
			$result = $this->Main_model->update_scene($update_data);
			
			if ( $result === false ) {
				throw new Exception('Update failed.');
			}
			
			$this->db->trans_complete();
			$message = "The scene was deleted successfully";
			$status = 1 ;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$status = 0 ;
			$message = $e->getMessage();
		}
		
		$result = array(
			'status' => $status,
			'message' => $message,
		);
		
		echo json_encode($result);
    }
	
	public function change_scene( $data = [] ){
		$data = $this->security->xss_clean($data);
		try {
			$this->db->trans_start();
			
			if ( $data['adventure_id'] != 1 ) {
				throw new Exception('Wrong adventure id.');
			}
			if ( !($data['scene_id'] > 0) ) {
				throw new Exception('Wrong scene id.');
			}
			
			$update_data = array(
				'adventure_id'=> $data['adventure_id'],
				'adventure_data' => array(
					'selected_scene'=> $data['scene_id'],
				),
			);
			$update_result = $this->Main_model->update_adventure($update_data);
			
			$this->db->trans_complete();
			$message = "The scene was selected successfully";
			$status = 1 ;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$status = 0 ;
			$message = $e->getMessage();
			$update_result = false;
		}
		
		$result = array(
			'status' => $status,
			'message' => $message,
			'update_result'=> $update_result,
		);
		
		echo json_encode($result);
    }
	
	public function log_question( $data = [] ){
		$data = $this->security->xss_clean($data);
		try {
			$this->db->trans_start();
			
			if ( $data['adventure_id'] != 1 || !($data['scene_id'] > 0) || empty(trim($data['question']))
				|| empty(trim($data['reply'])) || empty(trim($data['result'])) || empty(trim($data['threshold'])) ) {
				throw new Exception('Missing data, the question could not be logged.');
			}
			
			$insert_data = array(
				'adventure_id'=> $data['adventure_id'],
				'scene_id'=> $data['scene_id'],
				'question'=> $data['question'],
				'threshold'=> $data['threshold'],
				'result'=> $data['result'],
				'reply'=> $data['reply'],
			);
			$insert_id = $this->Main_model->insert_question($insert_data);
			
			$this->db->trans_complete();
			$message = "The question was logged successfully";
			$status = 1 ;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$status = 0 ;
			$message = $e->getMessage();
			$insert_id = 0;
		}
		
		$result = array(
			'status' => $status,
			'message' => $message,
			'insert_id'=> $insert_id,
		);
		
		echo json_encode($result);
    }
	
	public function log_event( $data = [] ){
		$data = $this->security->xss_clean($data);
		try {
			$this->db->trans_start();
			
			if ( $data['adventure_id'] != 1 || !($data['scene_id'] > 0) || empty(trim($data['title']))
				|| empty(trim($data['description'])) ) {
				throw new Exception('Missing data, the event could not be logged.');
			}
			
			$insert_data = array(
				'adventure_id'=> $data['adventure_id'],
				'scene_id'=> $data['scene_id'],
				'title'=> $data['title'],
				'description'=> $data['description'],
			);
			$insert_id = $this->Main_model->insert_event($insert_data);
			
			$this->db->trans_complete();
			$message = "The event was logged successfully";
			$status = 1 ;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$status = 0 ;
			$message = $e->getMessage();
			$insert_id = 0;
		}
		
		$result = array(
			'status' => $status,
			'message' => $message,
			'insert_id'=> $insert_id,
		);
		
		echo json_encode($result);
    }
	
	public function get_logs( $data = [] ){
		$data = $this->security->xss_clean($data);
		$logs=array();
		try {
			$this->db->trans_start();
			
			if ( $data['adventure_id'] != 1 || !($data['scene_id'] > 0) ) {
				throw new Exception('Missing data, could not retrieve the questions.');
			}
			
			$select_data = array(
				'adventure_id'=> $data['adventure_id'],
				'scene_id'=> $data['scene_id'],
				'last_question_update' => (isset($data['last_question_update']))?$data['last_question_update']:0,
				'last_event_update' => (isset($data['last_event_update']))?$data['last_event_update']:0,
			);
			
			$questions = $this->Main_model->get_questions($select_data);
			if($questions !== false){
				foreach($questions as $question){
					$logs[] = array(
						'id' => $question->id,
						'type' => 'log_question',
						'textMain' =>  $question->question,
						'textSub' => $question->reply,
						'tooltip' => $question->result.' ('.$question->threshold.'%)',
						'date' => $question->created_date,
					);
				}
			}
			
			$events = $this->Main_model->get_events($select_data);
			if($events !== false){
				foreach($events as $event){
					$logs[] = array(
						'id' => $event->id,
						'type' => 'log_event',
						'textMain' =>  $event->title,
						'textSub' => $event->description,
						'tooltip' => NULL,
						'date' => $event->created_date,
					);
				}
			}
			
			$this->db->trans_complete();
			$message = "The question was logged successfully";
			$status = 1 ;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$status = 0 ;
			$message = $e->getMessage();
		}
		
		$result = array(
			'status' => $status,
			'message' => $message,
			'data'=> $logs,
		);
		
		echo json_encode($result);
    }
	
	// handle and root the ajax posts
	public function handle_post(){
		$action = $this->input->post('action');
		if( $action == 'create_thread' ){
			$this->create_thread( $this->input->post('data') );
		}elseif( $action == 'edit_thread' ){
			$this->edit_thread( $this->input->post('data') );
		}elseif( $action == 'delete_thread' ){
			$this->delete_thread( $this->input->post('data') );
		}elseif( $action == 'create_character' ){
			$this->create_character( $this->input->post('data') );
		}elseif( $action == 'edit_character' ){
			$this->edit_character( $this->input->post('data') );
		}elseif( $action == 'delete_character' ){
			$this->delete_character( $this->input->post('data') );
		}elseif( $action == 'create_scene' ){
			$this->create_scene( $this->input->post('data') );
		}elseif( $action == 'delete_scene' ){
			$this->delete_scene( $this->input->post('data') );
		}elseif( $action == 'edit_scene' ){
			$this->edit_scene( $this->input->post('data') );
		}elseif( $action == 'change_scene' ){
			$this->change_scene( $this->input->post('data') );
		}elseif( $action == 'log_question' ){
			$this->log_question( $this->input->post('data') );
		}elseif( $action == 'log_event' ){
			$this->log_event( $this->input->post('data') );
		}elseif( $action == 'get_logs' ){
			$this->get_logs( $this->input->post('data') );
		}
    }
}
