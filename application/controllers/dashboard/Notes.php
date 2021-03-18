<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notes extends Student_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'notes/';
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
		$this->data['main_content']='notes';	
		$this->data['menu']='notes';			
		$this->data['sub_menu']='notes';
		$this->data['tab']=$this->uri->segment(4);
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
        $filter=array();
        $filter['class_id']=$this->LOGIN_USER->class_id;
        // $this->db->where(" (group_id=0  OR group_id=".$this->LOGIN_USER->group_id.")");
        $this->data['subjects']=$this->subject_m->get_rows($filter,array('select'=>'name'));
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}
       
	// view the downloads for this subject
	public function view($rid){
		$row=$this->subject_m->get_by_primary($rid);
        if($row->class_id != $this->LOGIN_USER->class_id){
            $this->session->set_flashdata('error', "You cannot view the notes of this class");
            redirect($this->CONT_ROOT);                    
        }

        $filter=array();
        $filter['class_id']=$this->LOGIN_USER->class_id;
        $filter['subject_id']=$row->mid;
        $this->data['notes']=$this->download_m->get_rows($filter,array('select'=>'mid,name,about,file'));


        $this->data['main_content']='notes_view';    
        $this->data['menu']='notes';            
        $this->data['sub_menu']='notes';
        $this->data['tab']=$this->uri->segment(4);
        $this->data['record']=$row;
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
	}
       

/** 
* ////////////////////////////////////////////////////////////////////////////////////////
* ******************************** END OF CLASS ******************************************
* ///////////////////////////////////////////////////////////////////////////////////////
*/

}
	