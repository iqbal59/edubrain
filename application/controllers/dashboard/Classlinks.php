<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Classlinks extends Student_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'classlinks/';
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
		$this->data['main_content']='classlinks';	
		$this->data['menu']='classlinks';			
		$this->data['sub_menu']='classlinks';
		$this->data['tab']=$this->uri->segment(4);
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}
       
	// join class function - mark auto attendance
	public function joinclass($rid){
		$row=$this->class_link_m->get_by_primary($rid);
        if($row->class_id != $this->LOGIN_USER->class_id){
            $this->session->set_flashdata('error', "You cannot join this class");
            redirect($this->CONT_ROOT);                    
        }
        //mark attendance

        //save activity log
        $log="Joined zoom class of subject(".$row->subject.")";
        //marks student attendance
        $attendance=array('student_id'=>$this->LOGIN_USER->mid,'class_id'=>$this->LOGIN_USER->class_id,'subject_id'=>$row->subject_id,'jd'=>$this->lesson_m->todayjd);
        if($this->lesson_attendance_m->get_rows($attendance,'',true)<1){
            $attendance['datetime']=$this->lesson_attendance_m->datetime;
            $this->lesson_attendance_m->add_row($attendance,array('subject_id'));
        }
        //redirect to class
        redirect($row->zoom_link);   
	}
       

/** 
* ////////////////////////////////////////////////////////////////////////////////////////
* ******************************** END OF CLASS ******************************************
* ///////////////////////////////////////////////////////////////////////////////////////
*/

}
	