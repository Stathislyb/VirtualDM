<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Main_model');
    }
	
	public function index(){
		$data = [];
		
		$ranks = $this->Main_model->get_ranks();
		$focus = $this->Main_model->get_focus();
		$actions = $this->Main_model->get_actions();
		$subjects = $this->Main_model->get_subjects();
		$meaning = $this->Main_model->get_meaning();
		$sceen_states = $this->Main_model->get_sceen_states();
		
		$app_data = array(
			'ranks' => $ranks,
			'focus' => $focus,
			'actions' => $actions,
			'subjects' => $subjects,
			'meaning' => $meaning,
			'sceen_states' => $sceen_states,
			'selected_value' => 0,
			'result' => 0,
			'chaos_factor' => 5,
			'event' => array(
				'show' => false,
				'title' => 'Asdsdasd',
				'meaning' => 'Xxvcxv Dgfgfg',
				'description' => 'Asdasd asdasd',
			),
		);
		
		$data['app_data'] = json_encode ( $app_data );
		
		$this->template->show("main", "main", $data);
	}
}
