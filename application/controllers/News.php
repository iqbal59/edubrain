<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends Frontend_Controller{

/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** CONTANTS *************************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/	
	public $CONT_ROOT; //REFERENCE TO THIS CONTROLLER
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function __construct() {
        parent::__construct();
        
        //INIT CONSTANTS
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'news/';
        //load all models for this controller
    }
	
/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** PUBLIC FUNCTIONS *****************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index(){
		
		$this->data['main_content']='news'.'-'.$this->SITE_LANG;	
		$this->data['menu']='news';			
		$this->data['sub_menu']='news';



        $filter=array();
        $params=array('select'=>'title,date,slug,image');
        $records=$this->news_m->get_rows($filter,$params);         
        $this->data['records']=$records;
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}

    // view news details
    public function view($slug=''){
        if(empty($slug)){
            $this->session->set_flashdata('error', 'Page does not exist!');
            redirect($this->APP_ROOT.'error');
        }
        
        $this->data['main_content']='news-view';    
        $this->data['menu']='news';         
        $this->data['sub_menu']='news';
        $this->data['form_action']='';

        $this->data['record']=$this->news_m->get_by(array('slug'=>$slug),true);
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }


    


/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** END OF CLASS *********************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

}
	