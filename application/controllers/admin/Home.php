<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Admin_Controller{

/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** CONTANTS *************************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/	
	public $CONT_ROOT; //REFERENCE TO THIS CONTROLLER
	
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
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
* ////////////////////////////////////////////////////////////////////////////////////////////
* ********************************* PUBLIC FUNCTIONS *****************************************
* /////////////////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index(){		
		$this->data['main_content']='dashboard';	
		$this->data['menu']='dashboard';			
		$this->data['sub_menu']='dashboard';
		$this->data['tab']=$this->uri->segment(4);
		////////////////////////////////////////////////////////////////////////////////////////////////////
		$filter=array();
		$this->data['total_admins']=$this->user_m->get_rows(array('type'=>$this->user_m->TYPE_ADMIN),'',true);
		$this->data['total_users']=$this->user_m->get_rows(array('type'=>$this->user_m->TYPE_USER),'',true);
		// $this->data['total_news']=$this->news_m->get_rows($filter,'',true);
		$this->data['total_students']=$this->student_m->get_rows($filter,'',true);
		// $this->data['today_students']=$this->student_m->get_rows(array('date'=>$this->user_m->date),'',true);
		$this->data['total_staff']=$this->staff_m->get_rows($filter,'',true);
		// $this->data['today_staff']=$this->staff_m->get_rows(array('date'=>$this->user_m->date),'',true);
		$this->data['total_lessons']=$this->lesson_m->get_rows($filter,'',true);
		// $this->data['today_lessons']=$this->lesson_m->get_rows(array('date'=>$this->user_m->date),'',true);
		$this->data['total_classes']=$this->class_m->get_rows($filter,'',true);
		$this->data['total_subjects']=$this->subject_m->get_rows($filter,'',true);
		$this->data['total_qbank']=$this->qbank_m->get_rows($filter,'',true);
		// $this->data['total_quizes']=$this->quiz_m->get_rows($filter,'',true);
		// $this->data['total_papers']=$this->paper_m->get_rows($filter,'',true);

		$filter['year']=$this->user_m->year;
		// $this->data['total_clicks_year']=$this->log_m->get_rows($filter,'',true);
		// $this->data['total_visits_year']=$this->log_m->get_rows($filter,array('distinct'=>true,'select'=>'ipaddress'),true);
		$filter['month']=$this->user_m->month;
		// $this->data['total_clicks_month']=$this->log_m->get_rows($filter,'',true);
		$this->data['total_visits_month']=$this->log_m->get_rows($filter,array('distinct'=>true,'select'=>'ipaddress'),true);
		$filter['day']=$this->user_m->day;
		// $this->data['total_clicks_today']=$this->log_m->get_rows($filter,'',true);
		$this->data['total_visits_today']=$this->log_m->get_rows($filter,array('distinct'=>true,'select'=>'ipaddress'),true);
		$this->data['today_qbank']=$this->qbank_m->get_rows($filter,'',true);


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
* //////////////////////////////////////////////////////////////////////////////////////////////////
* ******************************** END OF CLASS ****************************************************
* ///////////////////////////////////////////////////////////////////////////////////////////////////
*/

}
	