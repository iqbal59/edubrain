<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paper extends Student_Controller{

/** 
* ///////////////////////////////////////////////////////////////////////////////////////////
* ****************************** CONTANTS ***************************************************
* ///////////////////////////////////////////////////////////////////////////////////////////
*/	
	public $CONT_ROOT; //REFERENCE TO THIS CONTROLLER
	public $_TIME_MARGIN=30;	//margin to open paper screen in advance.
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function __construct() {
        parent::__construct();
        
        //INIT CONSTANTS
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'paper/';
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
* /////////////////////////////////////////////////////////////////////////////////////////////
* ******************************* PUBLIC FUNCTIONS ********************************************
* /////////////////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index(){		
		$this->data['main_content']='paperboard';	
		$this->data['menu']='paper';			
		$this->data['sub_menu']='paper';
		$this->data['tab']=$this->uri->segment(4);
		////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
		/////////////////////////////////////////////////////////////////////////////////
		$filter=array();
		$filter['class_id']=$this->LOGIN_USER->class_id;
		$this->data['subjects']=$this->subject_m->get_rows($filter,array('select'=>'name'));
		//////////////////////////////////////////////////////////////////////////////////
		$filter['class_id']=$this->LOGIN_USER->class_id;
        $this->data['subjects_arr']=$this->subject_m->get_values_array('','name',$filter);

		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}
    
	// show result of student paper tests
	public function result(){		
		$this->data['main_content']='paper_result';	
		$this->data['menu']='paper_result';			
		$this->data['sub_menu']='paper_result';
		$this->data['tab']=$this->uri->segment(4);
		////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
		////////////////////////////////////////////////////////////////////////////////
		$filter=array();
		$filter['class_id']=$this->LOGIN_USER->class_id;
		$this->data['subjects']=$this->subject_m->get_rows($filter,array('select'=>'name'));
		//////////////////////////////////////////////////////////////////////////////////
		$filter['class_id']=$this->LOGIN_USER->class_id;
        $this->data['subjects_arr']=$this->subject_m->get_values_array('','name',$filter);

		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}
       
	// show paper result detail to student
	public function detail($rid){		
        $this->data['main_content']='paper_result_detail';  
        $this->data['menu']='paper_result';            
        $this->data['sub_menu']='paper_result';
        //////////////////////////////////////
        $row=$this->paper_m->get_by_primary($rid);
        $this->data['paper']=$row;
        $this->data['class']=$this->class_m->get_by_primary($row->class_id);
        $this->data['subject']=$this->subject_m->get_by_primary($row->subject_id);
        $this->data['student']=$this->student_m->get_by_primary($this->LOGIN_USER->mid);
        $this->data['answers']=$this->paper_answer_m->get_values_array('question_id','answer',array('paper_id'=>$row->mid,'student_id'=>$this->LOGIN_USER->mid));
        $this->data['attempts']=$this->paper_attempt_m->get_by(array('paper_id'=>$row->mid,'student_id'=>$this->LOGIN_USER->mid),true);

        $this->data['answer_marks']=$this->paper_answer_m->get_values_array('question_id','marks',array('paper_id'=>$row->mid,'student_id'=>$this->LOGIN_USER->mid));
        $this->data['questions_mcq']=$this->paper_question_m->get_rows(array('paper_id'=>$row->mid,'type'=>'mcq'),array('select'=>'question,type,option1,option2,option3,option4,answer,marks,solution'));
        $this->data['questions_short']=$this->paper_question_m->get_rows(array('paper_id'=>$row->mid,'type'=>'short'),array('select'=>'paper_id,question,type,marks,solution'));
        $this->data['questions_long']=$this->paper_question_m->get_rows(array('paper_id'=>$row->mid,'type'=>'long'),array('select'=>'paper_id,question,type,marks,solution'));

		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}


    //save paper doc
    public function upload_paper_doc($paper_id){
        //upload artwork file
        $form=$this->input->safe_post();
        $redir=$this->CONT_ROOT.'attempt/'.$paper_id;
        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($redir);                    
        }
        $file_name='doc_'.time().mt_rand(1001,9999);
        $path='./uploads/files/exam';
        if (!file_exists($path)) {
		    @mkdir($path, 0777, true);
		}
        $data=$this->upload_img('file',$file_name,$path);
        if($data['file_uploaded']==FALSE){
            $this->session->set_flashdata('error', $data['file_error']);
            redirect($redir);
        }
        $nfile_name=$data['file_name'];
        $form['file_name']=$nfile_name;
        $form['paper_id']=$paper_id;
        $form['student_id']=$this->LOGIN_USER->mid;
        $form['class_id']=$this->LOGIN_USER->class_id;
        $form['date']=$this->user_m->date;
        $form['jd']=$this->user_m->todayjd;
        $this->paper_doc_m->add_row($form);
        $this->session->set_flashdata('success', 'File uploaded successfully.');
        redirect($redir);           
    
    }
    ////////////////////upload file///////////////////////////////
    private function upload_img($file_name='file',$new_name='',$path){  
        $size='10240';    //1.5MB
        $allowed_types='jpg|jpeg|png|bmp|pdf|xls|doc|docx|xlsx';
        $upload_file_name=$file_name;    
        $min_width=32;
        $min_height=32;
        $upload_data=$this->upload_file($path,$size,$allowed_types,$upload_file_name,$new_name);
        return $upload_data;
    }  
    ///////////////////////////////////////////////////////////////////////////
	// attempt paper 
	public function attempt($pid=''){	
		$screen='paper_attempt';
        $get=$this->input->safe_get();
        $form=$this->input->safe_post();
		///////////////////////////////////////////////////////////////////////////////
		if(empty($pid) || $this->paper_m->get_rows(array('mid'=>$pid,'class_id'=>$this->LOGIN_USER->class_id),'',true)<1){			
            $this->session->set_flashdata('error', 'Please choose a valid paper');
            redirect($this->CONT_ROOT);
		}
		$paper=$this->paper_m->get_by_primary($pid);
		if(get_minutes_from_time()<($paper->start_time-$this->_TIME_MARGIN)){			
            $this->session->set_flashdata('error', 'Please wait for the paper time to start.');
            redirect($this->CONT_ROOT);
		}
		$this->data['paper']=$paper;
		$this->data['paper_url']=$this->CONT_ROOT.'attempt/'.$paper->mid;
		$this->data['subject']=$this->subject_m->get_by_primary($paper->subject_id);
		$this->data['class']=$this->class_m->get_by_primary($paper->class_id);

		if(get_minutes_from_time()<$paper->start_time){
	        $this->data['body_init'] = ' class="coming_soon_style"'; 
			$screen='paper_wait';
		}else{
			//start paper
			$attempt_filter=array('student_id'=>$this->LOGIN_USER->mid,'paper_id'=>$paper->mid);
			if($this->paper_attempt_m->get_rows($attempt_filter,'',true)<1){
				//student just started the paper 
				if(isset($this->SETTINGS[$this->system_setting_m->_WS_EXAM_STRICT_START_TIME]) && intval($this->SETTINGS[$this->system_setting_m->_WS_EXAM_STRICT_START_TIME])>0){
					$attempt_filter['start_time']=$paper->start_time;
					$attempt_filter['end_time']=$paper->start_time+$paper->allowed_time;
				}else{
					$attempt_filter['start_time']=get_minutes_from_time();
					$attempt_filter['end_time']=get_minutes_from_time()+$paper->allowed_time;					
				}
				$this->paper_attempt_m->add_row($attempt_filter);
			}
			//////////////////////////////////////////////////////////////////////////////////////
			$attempt_filter=array('student_id'=>$this->LOGIN_USER->mid,'paper_id'=>$paper->mid);
			$attempt=$this->paper_attempt_m->get_by($attempt_filter,true);
			$this->data['attempt']=$attempt;
			//check if time has expired			
			if($attempt->is_ended==1){
				//user has already ended the paper. redirect to root
				if(isset($_SESSION['current_question']) ){unset($_SESSION['current_question']) ;}
	            $this->session->set_flashdata('error', 'Paper time ended or paper already attempted.');
	            redirect($this->CONT_ROOT);
			}elseif(isset($get['finish'])){			
				$this->paper_attempt_m->save(array('is_ended'=>1),$attempt->mid);
				if(isset($_SESSION['current_question']) ){unset($_SESSION['current_question']) ;}
				//show the paper end screen and result
				$screen='paper_result';
				/////////////////////////////////////////////////////////////////////////////////////////
				$this->data['questions']=$this->paper_question_m->get_rows(array('paper_id'=>$paper->mid),array('select'=>'mid,question,marks,answer,option1,option2,option3,option4,hint,detail','orderby'=>'sorting ASC, mid ASC'));
				$this->data['answers']=$this->paper_answer_m->get_rows(array('paper_id'=>$paper->mid,'student_id'=>$this->LOGIN_USER->mid),array('select'=>'mid,question_id,answer'));
			}elseif($attempt->end_time<=get_minutes_from_time()){		
				//paper time ended.
				if($attempt->is_ended==1){
					//user has already ended the paper. redirect to root
		            $this->session->set_flashdata('error', 'Paper time ended or paper already attempted.');
		            redirect($this->CONT_ROOT);
				}else{
					$this->paper_attempt_m->save(array('is_ended'=>1),$attempt->mid);
					if(isset($_SESSION['current_question']) ){unset($_SESSION['current_question']) ;}
					//show the paper end screen and result
					$screen='paper_result';
					/////////////////////////////////////////////////////////////////////////////////////////
					$this->data['questions']=$this->paper_question_m->get_rows(array('paper_id'=>$paper->mid),array('select'=>'mid,question,marks,answer,option1,option2,option3,option4,hint,detail'));
					$this->data['answers']=$this->paper_answer_m->get_rows(array('paper_id'=>$paper->mid,'student_id'=>$this->LOGIN_USER->mid),array('select'=>'mid,question_id,answer'));
				}	
			}else{
				//student started the paper and working on paper
		        $this->data['indexes']=$this->paper_question_m->get_column_array('mid',array('paper_id'=>$paper->mid),'sorting ASC, mid ASC');
		        $this->data['questions']=$this->paper_question_m->get_values_array('','question',array('paper_id'=>$paper->mid));
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
		        ////////////////////////////////////////////////////////////////////////////////////////
		        if(isset($form['answer'])&&!empty($form['answer'])){
		        	//user submitted the answer
		        	$s_qid=$form['question_id'];
		        	if($this->paper_answer_m->get_rows(array('paper_id'=>$paper->mid,'question_id'=>$s_qid,'student_id'=>$this->LOGIN_USER->mid),'',true)>0){
		        		//update answer
		        		$this->paper_answer_m->save(array('answer'=>$form['answer']),array('paper_id'=>$paper->mid,'question_id'=>$s_qid,'student_id'=>$this->LOGIN_USER->mid));
		        	}else{
		        		//save answer
		        		$this->paper_answer_m->add_row(array('answer'=>$form['answer'],'paper_id'=>$paper->mid,'question_id'=>$s_qid,'student_id'=>$this->LOGIN_USER->mid,'class_id'=>$this->data['class']->mid,'subject_id'=>$this->data['subject']->mid));
		        	}
		        	///////////////////////////////////////////////////////
		        	if(isset($form['next'])&&$form['next']=='yes'){
			        	$current_question++;
			        	if($current_question >= count($this->data['questions'])-1){$current_question=count($this->data['questions'])-1;}
			        	$_SESSION['current_question']=$current_question;		        		
		        	}
		        }
		        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		        $this->data['answers']=$this->paper_answer_m->get_values_array('question_id','answer',array('paper_id'=>$paper->mid,'student_id'=>$this->LOGIN_USER->mid));
		        $this->data['question']=$this->paper_question_m->get_new();
		        if(isset($this->data['indexes'][$current_question])){
			        $this->data['question']=$this->paper_question_m->get_by_primary($this->data['indexes'][$current_question]);		        	
		        }
		        $this->data['current_question']=$current_question;
		        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
		        $this->data['docs']=$this->paper_doc_m->get_rows(array('question_id'=>$this->data['question']->mid,'paper_id'=>$paper->mid,'student_id'=>$this->LOGIN_USER->mid),array('select'=>'mid,file_name,date'));
			}
		}
	

		$this->load->view($this->LIB_VIEW_DIR.'exam/'.$screen, $this->data);	
	}
       

/** 
* ////////////////////////////////////////////////////////////////////////////////////////
* **************************** END OF CLASS **********************************************
* ////////////////////////////////////////////////////////////////////////////////////////
*/

}
	