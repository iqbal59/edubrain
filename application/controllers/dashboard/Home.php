<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Student_Controller{

/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** CONTANTS *************************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/	
	public $CONT_ROOT; //REFERENCE TO THIS CONTROLLER
	
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
	function __construct() {
        parent::__construct();
        
        //INIT CONSTANTS
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'home/';
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
* //////////////////////////////////////////////////////////////////////////////////////////////////
* ********************************* PUBLIC FUNCTIONS ***********************************************
* //////////////////////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index(){	
		$this->data['main_content']='home';	
		$this->data['menu']='home';			
		$this->data['sub_menu']='home';
		$this->data['tab']=$this->uri->segment(4);
		////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
		///////////////////////////////////////////////////////////////////////////////
        $this->data['staff']=$this->staff_m->get_values_array('','name',array());
        $this->data['subjects_arr']=$this->subject_m->get_values_array('','name',array());
		$filter=array();
		$filter['class_id']=$this->LOGIN_USER->class_id;
		$this->db->where(" (group_id=0  OR group_id=".$this->LOGIN_USER->group_id.")");
		$this->data['subjects']=$this->subject_m->get_rows($filter,array('select'=>'name'),true);

		//////////////////////////////////////////////////////////////////////////////////
		$this->db->where(" (group_id=0  OR group_id=".$this->LOGIN_USER->group_id.")");
		$this->data['my_lessons']=$this->lesson_m->get_rows($filter,'',true);
		$this->db->where(" student_id=".$this->LOGIN_USER->mid);
		$this->data['my_lessons_played']=$this->lesson_attendance_m->get_rows($filter,'',true);
		//////////////////////////////////////////////////////////////////////////////////
		$this->db->where(" student_id=".$this->LOGIN_USER->mid);
		$this->data['my_watch_time']=$this->student_time_log_m->get_column_result('total_time',$filter);
		//////////////////////////////////////////////////////////////////////////////////
		$this->data['my_quiz']=$this->quiz_m->get_rows($filter,'',true);
		$filter=array();
		$this->db->where(" student_id=".$this->LOGIN_USER->mid);
		$this->data['my_quiz_solved']=$this->quiz_attempt_m->get_rows($filter,'',true);
		//////////////////////////////////////////////////////////////////////////////////
		$this->data['my_paper']=$this->paper_m->get_rows($filter,'',true);
		$filter=array();
		$this->db->where(" student_id=".$this->LOGIN_USER->mid);
		$this->data['my_paper_solved']=$this->paper_attempt_m->get_rows($filter,'',true);
		//////////////////////////////////////////////////////////////////////////////////
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}
       
	// search data
	public function search(){		
        $form=$this->input->safe_post();
        $redir=$this->LIB_CONT_ROOT.'index/'.strtolower($form['type']).'/?search='.$form['search'];
        if(!empty($form['type'])){redirect($redir);}
        redirect($this->LIB_CONT_ROOT);	
	}
       


/** 
* /////////////////////////////////////////////////////////////////////////////////////////////////
* ************************************** END OF CLASS ******************************************
* /////////////////////////////////////////////////////////////////////////////////////////////////
*/

}
	