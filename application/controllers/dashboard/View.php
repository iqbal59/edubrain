<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class View extends Student_Controller{

/** 
* //////////////////////////////////////////////////////////////////////////////////////
* ****************************** CONTANTS **********************************************
* ////////////////////////////////////////////////////////////////////////////////////
*/	
	public $CONT_ROOT; //REFERENCE TO THIS CONTROLLER
	
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
	function __construct() {
        parent::__construct();
        
        //INIT CONSTANTS
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'view/';
        //load all models for this controller
        $this->load->model(array());
        //load all models for this controller
        $models = array();
        //load all models in above array
        foreach($models as $mdl=>$tbl){
            $this->load->model('common_m',$mdl);
            $this->$mdl->init(array('table'=>$tbl));
        }
        
    }
	
/** 
* ///////////////////////////////////////////////////////////////////////////////////////
* ****************************** PUBLIC FUNCTIONS **************************************
* //////////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index(){	
        echo 'please choose a valid option';	
	}
       
    //show time table
    public function timetable(){        
        $this->data['main_content']='view_timetable';    
        $this->data['menu']='home';            
        $this->data['sub_menu']='home';
        $this->data['tab']=$this->uri->segment(4);
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
        $filter=array();
        $filter['class_id']=$this->LOGIN_USER->class_id;
        // $this->db->where(" (group_id=0  OR group_id=".$this->LOGIN_USER->group_id.")");
        $this->data['rows']=$this->timetable_m->get_rows($filter,array('select'=>'mid,class_id,section_id,title,file'));
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }
              
    //show date sheet
    public function datesheet(){        
        $this->data['main_content']='view_datesheet';    
        $this->data['menu']='home';            
        $this->data['sub_menu']='home';
        $this->data['tab']=$this->uri->segment(4);
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
        $filter=array();
        $filter['class_id']=$this->LOGIN_USER->class_id;
        // $this->db->where(" (group_id=0  OR group_id=".$this->LOGIN_USER->group_id.")");
        $this->data['rows']=$this->datesheet_m->get_rows($filter,array('select'=>'mid,class_id,section_id,title,file'));
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }
                      
    //show syllabus
    public function syllabus(){        
        $this->data['main_content']='view_syllabus';    
        $this->data['menu']='home';            
        $this->data['sub_menu']='home';
        $this->data['tab']=$this->uri->segment(4);
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
        $filter=array();
        $filter['class_id']=$this->LOGIN_USER->class_id;
        // $this->db->where(" (group_id=0  OR group_id=".$this->LOGIN_USER->group_id.")");
        $this->data['rows']=$this->syllabus_m->get_rows($filter,array('select'=>'mid,class_id,section_id,title,file'));
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }
              

/** 
* ////////////////////////////////////////////////////////////////////////////////////////
* ******************************** END OF CLASS ******************************************
* ///////////////////////////////////////////////////////////////////////////////////////
*/

}
	