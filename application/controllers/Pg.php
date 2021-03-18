<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pg extends Frontend_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'pg/';
        //load all models for this controller
    }
	
/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** PUBLIC FUNCTIONS *****************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/	
	//load the statice page from views
	public function index($slug=''){        
        $this->data['main_content']='db_page'; 
        $this->data['menu']='page';         
        $this->data['sub_menu']='page';
        $form=$this->input->safe_get_post();
        $this->data['formdata']=$form;
        //check if page slug exist in database
        if($this->page_m->get_rows(array('slug'=>$slug),'',true)<1){
            $this->session->set_flashdata('error', 'Page does not exist!');
            redirect($this->APP_ROOT.'error');
        }
        $record=$this->page_m->get_by(array('slug'=>trim($slug)),true);
        $this->post_m->update_column_value($record->mid,'views',1);
        $this->data['record']=$record;
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }

/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** END OF CLASS *********************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

}
	