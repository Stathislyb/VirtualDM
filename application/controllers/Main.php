<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Main_model');
    }
	
	public function index(){
		$data = [];
		
		// get the scenes' data and prepare to pass them to the component
		$scenes = $this->Main_model->get_scenes([
			'adventure_id' => 1,
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
		$active_scene_id = 1;
		$scenes_data = array(
			'ajax_url' => base_url().'index.php/Main/handle_post',
			'adventure_id' =>1,
			'scenes' => $scenes_list,
			'activeScene' => $active_scene_id, 
			'selectedTab' => 'scene_'.$active_scene_id,	
		);
		
		// get the threads' data and prepare to pass them to the component
		$threads = $this->Main_model->get_threads([
			'adventure_id' => 1,
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
			'adventure_id' =>1,
			'threads_list' => $threads_list,
		);
		
		// get the characters' data and prepare to pass them to the component
		$characters = $this->Main_model->get_characters([
			'adventure_id' => 1,
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
			'adventure_id' =>1,
			'characters_list' => $characters_list,
		);
		
		
		// get the main page's data and prepare to pass them to the component
		$ranks = $this->Main_model->get_ranks();
		$focus = $this->Main_model->get_focus();
		$actions = $this->Main_model->get_actions();
		$subjects = $this->Main_model->get_subjects();
		$meaning = $this->Main_model->get_meaning();
		$app_data = array(
			'ajax_url' => base_url().'index.php/Main/handle_post',
			'adventure_id' =>1,
			'ranks' => $ranks,
			'focus' => $focus,
			'actions' => $actions,
			'subjects' => $subjects,
			'meaning' => $meaning,
			'selected_value' => 0,
			'result' => 0,
			'chaos_factor' => 5,
			'question' => '',
			'showresult' => false,
			'logs' => array(),
			'lastLogUpdate' => 0,
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
			if ( $data['thread_id'] != 1 ) {
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
				'character_id'=> $data['adventure_id'],
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
				'last_update' => (isset($data['last_update']))?$data['last_update']:0,
			);
			
			$questions = $this->Main_model->get_questions($select_data);
			foreach($questions as $question){
				$logs[] = array(
					'type' => 'log_question',
					'textMain' =>  $question->question,
					'textSub' => $question->reply,
					'tooltip' => $question->result.' ('.$question->threshold.'%)',
					'date' => $question->created_date,
				);
			}
			
			$events = $this->Main_model->get_events($select_data);
			foreach($events as $event){
				$logs[] = array(
					'type' => 'log_event',
					'textMain' =>  $event->title,
					'textSub' => $event->description,
					'tooltip' => NULL,
					'date' => $event->created_date,
				);
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
		}elseif( $action == 'log_question' ){
			$this->log_question( $this->input->post('data') );
		}elseif( $action == 'log_event' ){
			$this->log_event( $this->input->post('data') );
		}elseif( $action == 'get_logs' ){
			$this->get_logs( $this->input->post('data') );
		}
    }
}
