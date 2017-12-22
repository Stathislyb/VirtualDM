<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template{

    private $template_data;
    private $js_file;
    private $css_file;
	private $favicon_file;
    private $CI;
	private $pages;

    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
		$this->template_data = array(
				'html_head' => '',
				'nav_bar' => '',
				'content' => '',
				'html_footer' => '',
				'data' => NULL,
			);
        // default CSS and JS that they must be load in any pages

        $this->addJS( base_url('assets/jquery/jquery-3.2.1.min.js') );
		$this->addJS( base_url('assets/tether/tether.min.js') );
		$this->addJS( base_url('assets/bootstrap/js/bootstrap.min.js') );
		$this->addJS( base_url('assets/vue/vue.js') );
		$this->addJS( base_url('assets/iview/iview.min.js') );
		
        $this->addCSS( base_url('assets/bootstrap/css/bootstrap.min.css') );
		$this->addCSS( base_url('assets/font-awesome/css/font-awesome.min.css') );
		$this->addCSS( base_url('assets/iview/iview.css') );
		$this->addCSS( base_url('assets/css/style.css') );
		
		$this->addFavicon( base_url('assets/favicon.ico') );
    }
	
	public function addView( $folder, $page, $data=null){
	
        if ( ! file_exists('application/views/'.$folder.'/'.$page.'.php' ) ){
            show_404();
        }else{
            $this->template_data['data'] = $data;

            $this->pages .= $this->CI->load->view($folder.'/'.$page.'.php', $this->template_data, true);
			
        }
    }
	
    public function showViews($menu=true){
		$this->load_JS_and_css();
		$this->init_menu();

		if ($menu)
			$this->template_data['nav_bar'] = $this->CI->load->view('template/menu.php', $this->template_data, true);

		$this->template_data['content'] .= $this->pages;
		$this->CI->load->view('template/template.php', $this->template_data);
	
    }

    public function addJS( $name ){
        $js = new stdClass();
        $js->file = $name;
        $this->js_file[] = $js;
    }

    public function addCSS( $name ){
        $css = new stdClass();
        $css->file = $name;
        $this->css_file[] = $css;
    }
	
	public function addFavicon( $name ){
        $css = new stdClass();
        $css->file = $name;
        $this->favicon_file = $css;
    }

    private function load_JS_and_css(){

        if ( $this->css_file ){
            foreach( $this->css_file as $css ){
                $this->template_data['html_head'] .= "<link rel='stylesheet' type='text/css' href='".$css->file."'>". "\n";
            }
        }

        if ( $this->js_file ){
            foreach( $this->js_file as $js )
            {
                $this->template_data['html_head'] .= "<script type='text/javascript' src='".$js->file."'></script>". "\n";
            }
        }
		
		if ( $this->favicon_file ){
            $this->template_data['html_head'] .= "<link rel='icon' href='".$this->favicon_file->file."' type='image/gif' >". "\n";
            
        }
    }

    private function init_menu(){        
      // your code to init menus
      // it's a sample code you can init some other part of your page
    }
}