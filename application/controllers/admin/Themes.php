<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Themes extends Admin_Controller{

/** 
* ////////////////////////////////////////////////////////////////////////////////
* *************************** CONTANTS *******************************************
* ////////////////////////////////////////////////////////////////////////////////
*/	
	public $CONT_ROOT; //REFERENCE TO THIS CONTROLLER
	
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
	function __construct() {
        parent::__construct();
        
        //INIT CONSTANTS
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'themes/';
        //load all models for this controller
        $models = array();
        $this->load->model($models);
        
    }
	
/** 
* ////////////////////////////////////////////////////////////////////////////////
* ***************************** PUBLIC FUNCTIONS *********************************
* ////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index($tab='',$recheck=false){
		$this->data['main_content']='themes';	
		$this->data['menu']='themes';			
		$this->data['sub_menu']='themes';
        $this->data['tab']=$tab;
        $this->ANGULAR_INC[]='themes';
        ///////////////////////////////////////////////////////////// 
        $form=$this->input->safe_get();
        if(isset($form['tab'])&&!empty($form['tab'])){$this->data['tab']=strtolower($form['tab']);}
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}


    //save profile settings
    public function save($module='',$val=''){
        $redir=$this->LIB_CONT_ROOT.'themes';
        switch (strtolower($module)) {
            case 'theme':{                
                $form=$this->input->safe_get();
                $form[$this->system_setting_m->_BG_THEME]=$val;
                $this->system_setting_m->save_settings_array($form);
                $this->session->set_flashdata('success', 'Themes Updated Successfully.');
                redirect($redir, 'refresh'); 

            }
            break;            
            default:{
                $this->session->set_flashdata('error', 'Please choose a valid operation');
                redirect($redir, 'refresh');
            }
            break;
        }         
    
    }

/** 
* /////////////////////////////////////////////////////////////////////////////////////
* ************************** END OF CLASS *********************************************
* /////////////////////////////////////////////////////////////////////////////////////
*/

}
	