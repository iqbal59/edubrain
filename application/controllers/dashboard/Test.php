<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends Student_Controller{

/** 
* ////////////////////////////////////////////////////////////////////////////////////
* ************************** CONTANTS ************************************************
* ////////////////////////////////////////////////////////////////////////////////////
*/	
	public $CONT_ROOT; //REFERENCE TO THIS CONTROLLER
	public $_ALLOWED_TIME=10;	//allowed time of the test.
	public $_TEST_QUESTIONS=15;	//total questions in the test.
	
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
	function __construct() {
        parent::__construct();
        
        //INIT CONSTANTS
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'test/';
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
* /////////////////////////////////////////////////////////////////////////////////////////
* ****************************** PUBLIC FUNCTIONS ****************************************
* ////////////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index(){		
		$this->data['main_content']='testboard';	
		$this->data['menu']='test';			
		$this->data['sub_menu']='test';
		$this->data['tab']=$this->uri->segment(4);
		////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
        if(!isset($this->SETTINGS[$this->system_setting_m->_WS_EXAM_PRACTICE_TEST]) || intval($this->SETTINGS[$this->system_setting_m->_WS_EXAM_PRACTICE_TEST])<1 ){
            $this->session->set_flashdata('error', 'Permission Denied!!!');
            redirect($this->LIB_CONT_ROOT.'', 'refresh');        	
        }
		///////////////////////////////////////////////////////////////////////////////////////
		$filter=array();
		$filter['class_id']=$this->LOGIN_USER->class_id;
        $this->data['subjects_arr']=$this->subject_m->get_values_array('','name',$filter);
		// $this->db->where(" (group_id=0  OR group_id=".$this->LOGIN_USER->group_id.")");
		// $this->data['subjects']=$this->subject_m->get_rows($filter,array('select'=>'name'));
		$filter['student_id']=$this->LOGIN_USER->mid;
		$this->data['tests']=$this->test_m->get_rows($filter,array('select'=>'name,date,jd,subject_id,class_id,marks','orderby'=>'mid DESC'));
		//////////////////////////////////////////////////////////////////////////////////
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}

	// create new practice test
	public function create(){		
		////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
        // exit;
        $form=$this->input->safe_get();
        if(!isset($form['subject_id']) || empty($form['subject_id'])){
            $this->session->set_flashdata('error', 'Please select a test subject from drop down list.');
            redirect($this->LIB_CONT_ROOT.'test', 'refresh');
        }
		///////////////////////////////////////////////////////////////////////////////////////////////
        $subject=$this->subject_m->get_by_primary($form['subject_id']);
		///////////////////////////////////////////////////////////////////////////////////////////////
        $filter=array('subject_id'=>$subject->mid,'class_id'=>$subject->class_id,'type'=>'mcq');
        $params=array('select'=>'mid,chapter,question,detail,hint, option1,option2,option3,option4,answer,solution,marks','limit'=>$this->_TEST_QUESTIONS,'orderby'=>'mid RANDOM');

        if(isset($form['chapter']) && !empty($form['chapter'])){$filter['chapter']=$form['chapter'];}
        $qbank=$this->qbank_m->get_rows($filter,$params);
        if(is_array($qbank) && count($qbank)<$this->_TEST_QUESTIONS){
            $this->session->set_flashdata('error', 'This subject do not have any questions in data bank.');
	        if(isset($form['chapter']) && !empty($form['chapter'])){
	            $this->session->set_flashdata('error', 'This chapter do not have any questions in data bank.');
	        }
            redirect($this->LIB_CONT_ROOT.'test', 'refresh');
        }
		///////////////////////////////////////////////////////////////////////////////////////////////
        $form['student_id']=$this->LOGIN_USER->mid;
        $form['class_id']=$subject->class_id;
		$form['date']=$this->test_m->date;
		$form['jd']=$this->test_m->todayjd; 
		$form['name']='Test ('.mt_rand(1111,9999).')- '.$this->test_m->datetime;
        $rid=$this->test_m->add_row($form);

        //add questions to test
        $total_marks=0;
        $questions=array();
    	$q_row=array('subject_id'=>$subject->mid,'test_id'=>$rid,'class_id'=>$subject->class_id,'created'=>time(),'updated'=>time());
    	$sorting=0;
        foreach($qbank as $q){
        	$sorting++;
        	$q_row['chapter']=$q['chapter'];
        	$q_row['question']=$q['question'];
        	$q_row['detail']=$q['detail'];
        	$q_row['hint']=$q['hint'];
        	$q_row['option1']=$q['option1'];
        	$q_row['option2']=$q['option2'];
        	$q_row['option3']=$q['option3'];
        	$q_row['option4']=$q['option4'];
        	$q_row['answer']=$q['answer'];
        	$q_row['solution']=$q['solution'];
        	$q_row['marks']=$q['marks'];
        	$q_row['dbq_id']=$q['mid'];
        	$q_row['sorting']=$sorting;
        	$total_marks+=$q['marks'];

        	array_push($questions, $q_row);
        }
        //save questions in test
        $this->test_question_m->save_batch($questions);
        $this->test_m->save(array('marks'=>$total_marks),$rid); //update total marks

        $this->session->set_flashdata('success', 'Practice test created for you. Click on start test button to attempt the test.');
        redirect($this->LIB_CONT_ROOT.'test', 'refresh');


		// $this->data['main_content']='test_result';	
		// $this->data['menu']='test_result';			
		// $this->data['sub_menu']='test_result';
		// $this->data['tab']=$this->uri->segment(4);
		// $filter=array();
		// $filter['class_id']=$this->LOGIN_USER->class_id;
  //       $this->data['subjects_arr']=$this->subject_m->get_values_array('','name',$filter);
		// // $this->db->where(" (group_id=0  OR group_id=".$this->LOGIN_USER->group_id.")");
		// // $this->data['subjects']=$this->subject_m->get_rows($filter,array('select'=>'name'));
		// //////////////////////////////////////////////////////////////////////////////////
		// $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}

	// show result of student quiz tests
	public function result(){		
		$this->data['main_content']='test_result';	
		$this->data['menu']='test_result';			
		$this->data['sub_menu']='test_result';
		$this->data['tab']=$this->uri->segment(4);
		////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
		///////////////////////////////////////////////////////////////////////////////////////
		$filter=array();
		$filter['class_id']=$this->LOGIN_USER->class_id;
        $this->data['subjects_arr']=$this->subject_m->get_values_array('','name',$filter);
		// $this->db->where(" (group_id=0  OR group_id=".$this->LOGIN_USER->group_id.")");
		// $this->data['subjects']=$this->subject_m->get_rows($filter,array('select'=>'name'));
		//////////////////////////////////////////////////////////////////////////////////
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}
       
	// show quiz result detail to student
	public function detail($rid){		
        $this->data['main_content']='test_result_detail';  
        $this->data['menu']='test_result';            
        $this->data['sub_menu']='test_result';
        //////////////////////////////////////
        $row=$this->test_m->get_by_primary($rid);
        $this->data['test']=$row;
        $this->data['class']=$this->class_m->get_by_primary($row->class_id);
        $this->data['subject']=$this->subject_m->get_by_primary($row->subject_id);
        $this->data['student']=$this->student_m->get_by_primary($this->LOGIN_USER->mid);
        $this->data['answers']=$this->test_answer_m->get_values_array('question_id','answer',array('test_id'=>$row->mid,'student_id'=>$this->LOGIN_USER->mid));
        $this->data['attempts']=$this->test_attempt_m->get_by(array('test_id'=>$row->mid,'student_id'=>$this->LOGIN_USER->mid),true);
        $this->data['questions']=$this->test_question_m->get_rows(array('test_id'=>$row->mid),array('select'=>'question,type,option1,option2,option3,option4,answer,marks,solution'));

		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}
       
	// attempt quiz
	public function attempt($qid=''){	
		$screen='test_attempt';
        $get=$this->input->safe_get();
        $form=$this->input->safe_post();
		//////////////////////////////////////////////////////////////////////////////////
		if(empty($qid) || $this->test_m->get_rows(array('mid'=>$qid,'class_id'=>$this->LOGIN_USER->class_id,'student_id'=>$this->LOGIN_USER->mid),'',true)<1){			
            $this->session->set_flashdata('error', 'Please choose a valid test');
            redirect($this->CONT_ROOT);
		}
		$test=$this->test_m->get_by_primary($qid);
		if($this->test_m->todayjd != $test->jd){			
            $this->session->set_flashdata('error', 'Time over. You can only attempt the test in same day.');
            redirect($this->CONT_ROOT);
		}
		$this->data['test']=$test;
		$this->data['test_url']=$this->CONT_ROOT.'attempt/'.$test->mid;
		$this->data['subject']=$this->subject_m->get_by_primary($test->subject_id);
		$this->data['class']=$this->class_m->get_by_primary($test->class_id);

		//start quiz
		$attempt_filter=array('student_id'=>$this->LOGIN_USER->mid,'test_id'=>$test->mid);
		if($this->test_attempt_m->get_rows($attempt_filter,'',true)<1){
			//student just started the paper 
			$attempt_filter['start_time']=get_minutes_from_time();
			$attempt_filter['end_time']=get_minutes_from_time()+$this->_ALLOWED_TIME;
			$this->test_attempt_m->add_row($attempt_filter);
		}
		//////////////////////////////////////////////////////////////////////////////////////
		$attempt_filter=array('student_id'=>$this->LOGIN_USER->mid,'test_id'=>$test->mid);
		$attempt=$this->test_attempt_m->get_by($attempt_filter,true);
		$this->data['attempt']=$attempt;
		//check if time has expired			
		if($attempt->is_ended==1){
			//user has already ended the paper. redirect to root
			if(isset($_SESSION['current_question']) ){unset($_SESSION['current_question']) ;}
            $this->session->set_flashdata('error', 'Test time ended or test already attempted.');
            redirect($this->CONT_ROOT);
		}elseif(isset($get['finish'])){			
			$this->test_attempt_m->save(array('is_ended'=>1),$attempt->mid);
			if(isset($_SESSION['current_question']) ){unset($_SESSION['current_question']) ;}
			//show the paper end screen and result
			$screen='test_result';
			/////////////////////////////////////////////////////////////////////////////////////////
			$this->data['questions']=$this->test_question_m->get_rows(array('test_id'=>$test->mid),array('select'=>'mid,question,marks,answer,option1,option2,option3,option4,hint,detail'));
			$this->data['answers']=$this->test_answer_m->get_rows(array('test_id'=>$test->mid,'student_id'=>$this->LOGIN_USER->mid),array('select'=>'mid,question_id,answer'));
		}elseif($attempt->end_time<=get_minutes_from_time()){
				$this->test_attempt_m->save(array('is_ended'=>1),$attempt->mid);
				if(isset($_SESSION['current_question']) ){unset($_SESSION['current_question']) ;}
				//show the paper end screen and result
				$screen='test_result';
				///////////////////////////////////////////////////////////////////////////////
				$this->data['questions']=$this->test_question_m->get_rows(array('test_id'=>$test->mid),array('select'=>'mid,question,marks,answer,option1,option2,option3,option4,hint,detail'));
				$this->data['answers']=$this->test_answer_m->get_rows(array('test_id'=>$test->mid,'student_id'=>$this->LOGIN_USER->mid),array('select'=>'mid,question_id,answer'));
		}else{
			//student started the paper and working on paper
	        $this->data['indexes']=$this->test_question_m->get_column_array('mid',array('test_id'=>$test->mid),'mid ASC');
	        $this->data['questions']=$this->test_question_m->get_values_array('','question',array('test_id'=>$test->mid));
	        //////////////////////////////////////////////////////////////////////////////////////
			isset($_SESSION['current_question']) ? $current_question=$_SESSION['current_question'] : $current_question=0;
			if(isset($get['qi'])&&intval($get['qi'])>=0){$current_question=$get['qi'];$_SESSION['current_question']=$current_question;}
	        ////////////////////////////////////////////////////////////////////////////////////
	        if(isset($get['next'])){
	        	$current_question++;
	        	if($current_question >= count($this->data['questions'])-1){$current_question=count($this->data['questions'])-1;}
	        	$_SESSION['current_question']=$current_question;
	        }
	        if(isset($get['prev'])){
	        	$current_question--;
	        	if($current_question < 0){$current_question=0;}
	        	$_SESSION['current_question']=$current_question;
	        }
	        ////////////////////////////////////////////////////////////////////////////////
	        if(isset($form['answer'])&&!empty($form['answer'])){
	        	//user submitted the answer
	        	$s_qid=$form['question_id'];
	        	if($this->test_answer_m->get_rows(array('test_id'=>$test->mid,'question_id'=>$s_qid,'student_id'=>$this->LOGIN_USER->mid),'',true)>0){
	        		//update answer
	        		$this->test_answer_m->save(array('answer'=>$form['answer']),array('test_id'=>$test->mid,'question_id'=>$s_qid,'student_id'=>$this->LOGIN_USER->mid));
	        	}else{
	        		//save answer
	        		$this->test_answer_m->add_row(array('answer'=>$form['answer'],'test_id'=>$test->mid,'question_id'=>$s_qid,'student_id'=>$this->LOGIN_USER->mid,'class_id'=>$this->data['class']->mid,'subject_id'=>$this->data['subject']->mid));
	        	}
	        	///////////////////////////////////////////////////////
	        	if(isset($form['next'])&&$form['next']=='yes'){
		        	$current_question++;
		        	if($current_question >= count($this->data['questions'])-1){$current_question=count($this->data['questions'])-1;}
		        	$_SESSION['current_question']=$current_question;		        		
	        	}
	        }
	        /////////////////////////////////////////////////////////////////////////////////
	        $this->data['answers']=$this->test_answer_m->get_values_array('question_id','answer',array('test_id'=>$test->mid,'student_id'=>$this->LOGIN_USER->mid));
	        $this->data['question']=$this->test_question_m->get_new();
	        if(isset($this->data['indexes'][$current_question])){
		        $this->data['question']=$this->test_question_m->get_by_primary($this->data['indexes'][$current_question]);		        	
	        }
	        $this->data['current_question']=$current_question;
		}
	

		$this->load->view($this->LIB_VIEW_DIR.'exam/'.$screen, $this->data);	
	}
       

/** 
* ////////////////////////////////////////////////////////////////////////////////////
* **************************** END OF CLASS ******************************************
* ////////////////////////////////////////////////////////////////////////////////////
*/

}
	