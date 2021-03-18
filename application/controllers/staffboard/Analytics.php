<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analytics extends Staff_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'analytics/';
    }
    
/** 
* ////////////////////////////////////////////////////////////////////////////////
* ***************************** PUBLIC FUNCTIONS *********************************
* ////////////////////////////////////////////////////////////////////////////////
*/  
    // default function for this controller (index)
    public function index(){
        $this->data['main_content']='analytics';  
        $this->data['menu']='analytics';            
        $this->data['sub_menu']='analytics'; 
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
        /////////////////////////////////////////////////////////////     
        $filter=array();
        $params=array('limit'=>1000);
        $search=array();
        $like=array();
        $form=$this->input->safe_get();   
        $this->data['classes']=$this->class_m->get_values_array('','name',array());
        $this->data['groups']=$this->group_m->get_values_array('','name',array());
        $this->data['sections']=$this->section_m->get_values_array('','name',array());
        $this->data['subjects_arr']=$this->subject_m->get_values_array('','name',array());
        $this->data['lessons']=$this->lesson_m->get_values_array('','name',array());
        /////////////////////////////////////////////////////////////
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }
    //view attendance
    public function attendance($class_id){
        $this->data['main_content']='analytics_attendance';  
        $this->data['menu']='analytics';            
        $this->data['sub_menu']='analytics';
        $this->data['class_id']=$class_id;
        ///////////////////////////////////////////////////////////// 
        $jd=$this->user_m->todayjd;
        $this->data['row']=$this->class_m->get_by_primary($class_id);    
        $filter=array();
        $params=array('limit'=>10000);
        $search=array();
        $like=array();
        $form=$this->input->safe_get();   
        isset($form['jd']) && !empty($form['jd']) ? $jd=intval($form['jd']) : '';
        //////////////////////////////////////////////////////////////////////
        $this->data['groups']=$this->group_m->get_values_array('','name',array());
        $this->data['sections']=$this->section_m->get_values_array('','name',array());
        $this->data['subjects']=$this->subject_m->get_values_array('','name',array('class_id'=>$class_id));
        $this->data['lessons']=$this->lesson_m->get_values_array('subject_id','name',array('class_id'=>$class_id,'lesson_jd'=>$jd));
        //////////////////////////////////////////////////////////////////////
        $filter['class_id']=$class_id;
        $params['select']='mid,name';
        $params['orderby']='name ASC';
        $this->data['students']=$this->student_m->get_rows($filter,$params);
        //////////////////////////////////////////////////////////////////////
        $att_fltr=array('jd'=>$jd,'class_id'=>$class_id);
        $params['select']='mid,subject_id,student_id,datetime';
        $params['orderby']='mid DESC';
        $this->data['att_log']=$this->lesson_attendance_m->get_rows($att_fltr,$params);
        $this->data['jd']=$jd;
        /////////////////////////////////////////////////////////////
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }

    //view reports
    public function report($module='',$rid=''){
        $filter=array();
        $params=array('limit'=>1000);
        $search=array();
        $like=array();
        $form=$this->input->safe_get();
        switch (strtolower($module)) {
            /////////load row
            case 'quiz':{
                $this->data['main_content']='analytics_report_quiz';  
                $this->data['menu']='analytics';            
                $this->data['sub_menu']='analytics';
                //////////////////////////////////////
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $row=$this->quiz_m->get_by_primary($rid);
                $this->data['quiz']=$row;
                $this->data['class']=$this->class_m->get_by_primary($row->class_id);
                $this->data['subject']=$this->subject_m->get_by_primary($row->subject_id);
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $std_filter=array('class_id'=>$row->class_id);
                if(isset($row->section_id) && intval($row->section_id)>0){$std_filter['section_id']=$row->section_id;}
                $this->data['students']=$this->student_m->get_rows($std_filter,array('select'=>'name,father_name,roll_number,group_id,section_id'));
                $this->data['std_answers']=$this->quiz_answer_m->get_rows(array('quiz_id'=>$row->mid),array('select'=>'question_id,student_id,answer,date'));
                $this->data['qz_answers']=$this->quiz_question_m->get_values_array('','answer',array('quiz_id'=>$row->mid));
                $this->data['qz_marks']=$this->quiz_question_m->get_values_array('','marks',array('quiz_id'=>$row->mid));
            }
            break;
            /////////load row
            case 'quizdetail':{
                $this->data['main_content']='analytics_report_quiz_detail';  
                $this->data['menu']='analytics';            
                $this->data['sub_menu']='analytics';
                //////////////////////////////////////
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $row=$this->quiz_m->get_by_primary($rid);
                $this->data['quiz']=$row;
                $this->data['class']=$this->class_m->get_by_primary($row->class_id);
                $this->data['subject']=$this->subject_m->get_by_primary($row->subject_id);
                $this->data['student']=$this->student_m->get_by_primary($form['std']);
                $this->data['answers']=$this->quiz_answer_m->get_values_array('question_id','answer',array('quiz_id'=>$row->mid,'student_id'=>$form['std']));
                $this->data['attempts']=$this->quiz_attempt_m->get_by(array('quiz_id'=>$row->mid,'student_id'=>$form['std']),true);
                $this->data['questions']=$this->quiz_question_m->get_rows(array('quiz_id'=>$row->mid),array('select'=>'question,type,option1,option2,option3,option4,answer,marks,'));
            }
            break;  
            /////////load row
            case 'paper':{
                $this->data['main_content']='analytics_report_paper';  
                $this->data['menu']='analytics';            
                $this->data['sub_menu']='analytics';
                //////////////////////////////////////
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $row=$this->paper_m->get_by_primary($rid);
                $this->data['paper']=$row;
                $this->data['class']=$this->class_m->get_by_primary($row->class_id);
                $this->data['subject']=$this->subject_m->get_by_primary($row->subject_id);
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $std_filter=array('class_id'=>$row->class_id);
                if(isset($row->section_id) && intval($row->section_id)>0){$std_filter['section_id']=$row->section_id;}
                $this->data['students']=$this->student_m->get_rows($std_filter,array('select'=>'name,father_name,roll_number,group_id,section_id'));
                $this->data['std_answers']=$this->paper_answer_m->get_rows(array('paper_id'=>$row->mid),array('select'=>'question_id,student_id,answer,marks,date'));
                $this->data['qz_answers']=$this->paper_question_m->get_values_array('','answer',array('paper_id'=>$row->mid));
                $this->data['qz_marks']=$this->paper_question_m->get_values_array('','marks',array('paper_id'=>$row->mid));
            }
            break;
            /////////load row
            case 'paperdetail':{

                $post=$this->input->safe_post();
                if(isset($post['qid']) && isset($post['marks'])){
                    $this->paper_answer_m->save(array('marks'=>$post['marks']),array('paper_id'=>$rid,'student_id'=>$form['std'],'question_id'=>$post['qid']));
                }
                ////////////////////////////////////////
                $this->data['main_content']='analytics_report_paper_detail';  
                $this->data['menu']='analytics';            
                $this->data['sub_menu']='analytics';
                //////////////////////////////////////
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $row=$this->paper_m->get_by_primary($rid);
                $this->data['paper']=$row;
                $this->data['module_url']=$this->CONT_ROOT.'report/paperdetail/'.$rid.'/?std='.$form['std'];
                $this->data['class']=$this->class_m->get_by_primary($row->class_id);
                $this->data['subject']=$this->subject_m->get_by_primary($row->subject_id);
                $this->data['student']=$this->student_m->get_by_primary($form['std']);
                $this->data['answers']=$this->paper_answer_m->get_values_array('question_id','answer',array('paper_id'=>$row->mid,'student_id'=>$form['std']));
                $this->data['answer_ids']=$this->paper_answer_m->get_values_array('question_id','mid',array('paper_id'=>$row->mid,'student_id'=>$form['std']));
                $this->data['answer_marks']=$this->paper_answer_m->get_values_array('question_id','marks',array('paper_id'=>$row->mid,'student_id'=>$form['std']));
                $this->data['attempts']=$this->paper_attempt_m->get_by(array('paper_id'=>$row->mid,'student_id'=>$form['std']),true);
                $this->data['questions_mcq']=$this->paper_question_m->get_rows(array('paper_id'=>$row->mid,'type'=>'mcq'),array('select'=>'question,type,option1,option2,option3,option4,answer,marks,solution'));
                $this->data['questions_short']=$this->paper_question_m->get_rows(array('paper_id'=>$row->mid,'type'=>'short'),array('select'=>'question,type,marks,solution'));
                $this->data['questions_long']=$this->paper_question_m->get_rows(array('paper_id'=>$row->mid,'type'=>'long'),array('select'=>'question,type,marks,solution'));
            }
            break;  
        }

        /////////////////////////////////////////////////////////////
        $this->data['module']=strtolower($module);
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }



/** 
* /////////////////////////////////////////////////////////////////////////////////////
* ************************** END OF CLASS *********************************************
* /////////////////////////////////////////////////////////////////////////////////////
*/

}
    