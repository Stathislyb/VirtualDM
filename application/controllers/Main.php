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
		$scene_states = $this->Main_model->get_scene_states();
		$scenes = $this->Main_model->get_sceens();
		
		$app_data = array(
			'ranks' => $ranks,
			'focus' => $focus,
			'actions' => $actions,
			'subjects' => $subjects,
			'meaning' => $meaning,
			'sceen_states' => $scene_states,
			'selected_value' => 0,
			'result' => 0,
			'chaos_factor' => 5,
			'event' => array(
				'show' => false,
				'title' => '',
				'meaning' => '',
				'description' => '',
			),
			'scenes' => $scenes,
			'characters_list' => array(
				array(
					'id'	=> 1,
					'label' => 'test1',
				),
				array(
					'id'	=> 2,
					'label' => 'test2',
				),
				array(
					'id'	=> 3,
					'label' => 'test3',
				),
				array(
					'id'	=> 4,
					'label' => 'test4',
				),
			),
			'threads_list' => array(
				array(
					'id'	=> 1,
					'label' => 'test1',
				),
				array(
					'id'	=> 2,
					'label' => 'test2',
				),
				array(
					'id'	=> 3,
					'label' => 'test3',
				),
				array(
					'id'	=> 4,
					'label' => 'test4',
				),
			),
		);
		
		$data['app_data'] = json_encode ( $app_data );
		
		$this->template->show("main", "main", $data);
	}
}
