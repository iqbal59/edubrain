<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Printer extends Admin_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'printer/';
    }
	
/** 
* ////////////////////////////////////////////////////////////////////////////////
* ***************************** PUBLIC FUNCTIONS *********************************
* ////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index(){
        $this->session->set_flashdata('error', 'Please choose a valid module');
        redirect($this->LIB_CONT_ROOT.'', 'refresh'); 
    }

    public function mdl($module='',$rid=''){
        $main_content='';
        switch (strtolower($module)) {
            /////add row
            case 'quiz':{
                //add class
                $main_content='print_quiz'; 
                //////////////////////////////////////////////
                $this->data['row']=$this->quiz_m->get_by_primary($rid);
                $this->data['class']=$this->class_m->get_by_primary($this->data['row']->class_id);
                $this->data['subject']=$this->subject_m->get_by_primary($this->data['row']->subject_id);
                //////////////////////////////////////////////
                $this->data['questions_mcq']=$this->quiz_question_m->get_rows(array('quiz_id'=>$rid,'type'=>'mcq'),array('select'=>'question,type,option1,option2,option3,option4,answer,marks,solution'));
            }
            break;  
            /////add row
            case 'paper':{
                //add class
                $main_content='print_paper';  
                //////////////////////////////////////////////
                $this->data['row']=$this->paper_m->get_by_primary($rid);
                $this->data['subject']=$this->subject_m->get_by_primary($this->data['row']->subject_id);
                $this->data['class']=$this->class_m->get_by_primary($this->data['row']->class_id);
                //////////////////////////////////////////////
                $this->data['questions_mcq']=$this->paper_question_m->get_rows(array('paper_id'=>$rid,'type'=>'mcq'),array('select'=>'question,type,option1,option2,option3,option4,answer,marks,solution'));
                $this->data['questions_short']=$this->paper_question_m->get_rows(array('paper_id'=>$rid,'type'=>'short'),array('select'=>'question,type,marks,solution'));
                $this->data['questions_long']=$this->paper_question_m->get_rows(array('paper_id'=>$rid,'type'=>'long'),array('select'=>'question,type,marks,solution'));
            }
            break;  
        }

        /////////////////////////////////////////////////////////////
        $this->data['module']=strtolower($module);
		$this->load->view($this->LIB_VIEW_DIR.$main_content, $this->data);	
	}

/** 
* /////////////////////////////////////////////////////////////////////////////////////
* ************************** END OF CLASS *********************************************
* /////////////////////////////////////////////////////////////////////////////////////
*/

}
	