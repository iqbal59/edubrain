<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generate extends Admin_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'generate/';
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
        $filter=array();
        $params=array();
        $form=$this->input->safe_get();
        $post=$this->input->safe_post();
        $this->data['tab']='';
        if(isset($form['tab'])&&!empty($form['tab'])){$this->data['tab']=$form['tab'];}

        $this->data['form']=$form; 
        $this->data['msg_success']=''; 
        $this->data['msg_error']=''; 
        $this->data['mod_url']=$this->CONT_ROOT.'mdl/'.$module.'/'.$rid;  
        $this->data['mod_url_params']=''; 
        if(isset($form['chapter'])&&!empty($form['chapter'])){$this->data['mod_url_params'].='&chapter='.$form['chapter'];}
        if(isset($form['limit'])&&!empty($form['limit'])){$this->data['mod_url_params'].='&limit='.$form['limit'];}
        if(isset($form['topic'])&&!empty($form['topic'])){$this->data['mod_url_params'].='&topic='.$form['topic'];}
        if(isset($form['type'])&&!empty($form['type'])){$this->data['mod_url_params'].='&type='.$form['type'];}
        switch (strtolower($module)) {
            /////add row
            case 'quiz':{
                //add class
                $this->data['main_content']='generate_quiz';  
                $this->data['menu']='quiz';            
                $this->data['sub_menu']='quiz';
                if(empty($rid) && isset($form['cid']) && !empty($form['cid'])){
                    $rid=$form['cid'];
                }
                //////////////////////////////////////////////
                $this->data['class']=$this->class_m->get_by_primary($rid);
                $this->data['subjects']=$this->subject_m->get_values_array('','name',array('class_id'=>$rid));
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
            }
            break;  
            /////add row
            case 'quizbank':{
                //add class
                $this->data['main_content']='generate_quizbank';  
                $this->data['menu']='quiz';            
                $this->data['sub_menu']='quiz';
                $this->ANGULAR_INC[]='generate_quizbank';
                //////////////////////////////////////////////////////////////////////////////////
                $this->data['quiz']=$this->quiz_m->get_by_primary($rid);
                $this->data['class']=$this->class_m->get_by_primary($this->data['quiz']->class_id);
                $this->data['subject']=$this->subject_m->get_by_primary($this->data['quiz']->subject_id);
                //if paper time has started than it can not be edited.
                if($this->user_m->todayjd > $this->data['quiz']->jd){
                    $this->session->set_flashdata('error', 'Unable to edit because paper start time has been passed.');
                    redirect($this->LIB_CONT_ROOT.'detail/mdl/classes/'.$this->data['quiz']->class_id.'?tab=quiz');                    
                }elseif(get_minutes_from_time() >= ($this->data['quiz']->start_time-1) && $this->user_m->todayjd == $this->data['quiz']->jd){
                    $this->session->set_flashdata('error', 'Unable to edit because paper start time has been passed.');
                    redirect($this->LIB_CONT_ROOT.'detail/mdl/classes/'.$this->data['quiz']->class_id.'?tab=quiz');                    
                }                
                //////////////////////////////////////////////////////////////////////////////////
                switch (strtolower($this->data['tab'])) {
                    case 'add':{
                        if($_POST){                            
                            if(isset($post['type'])){$_SESSION['type']=$post['type'];}
                            if(isset($post['chapter'])){$_SESSION['chapter']=$post['chapter'];}
                            if(isset($post['topic'])){$_SESSION['topic']=$post['topic'];}
                            if(isset($post['marks'])){$_SESSION['marks']=$post['marks'];}
                            if(isset($post['difficulty'])){$_SESSION['difficulty']=$post['difficulty'];}
                            if(isset($post['saveqb'])){$_SESSION['saveqb']=$post['saveqb'];}
                            ///////////////////////////////////////////////////////////////////// 
                            if(empty($post['question'])){
                                $this->data['msg_error']='Please provide required information!';
                            }else{
                                $post['class_id']=$this->data['quiz']->class_id;
                                $post['subject_id']=$this->data['quiz']->subject_id;
                                $post['type']='mcq';
                                /////////////////////////////////////////////////////////
                                if($post['saveqb']>0){$this->qbank_m->add_row($post);}
                                $this->quiz_m->update_column_value($this->data['quiz']->mid,'marks',$post['marks']);
                                /////////////////////////////////////////////////////////
                                $post['quiz_id']=$this->data['quiz']->mid;
                                $post['sorting']=1; //mcq
                                if($post['type']=='short'){$post['sorting']=2; }//short
                                if($post['type']=='long'){$post['sorting']=3; }//long
                                /////////////////////////////////////////////////////////////////////////// 
                                if($this->quiz_question_m->add_row($post) ==false){
                                    $this->data['msg_error']='Process stopped. Please try again later!';
                                }
                                $this->data['msg_success']='Saved Successfully.';                            
                            }
                        }

                    }
                    break;                    
                    case 'qbadd':{    
                        if(isset($form['action']) && !empty($form['action']) &&!empty($form['qid'])){
                            switch (strtolower($form['action'])) {
                                case 'save':{
                                    //add question to question paper          
                                    $qbank=$this->qbank_m->get_by_primary($form['qid']);
                                    $data=array('class_id'=>$this->data['quiz']->class_id,'subject_id'=>$this->data['quiz']->subject_id,'quiz_id'=>$this->data['quiz']->mid);
                                    $data['question']=$qbank->question;
                                    $data['option1']=$qbank->option1;
                                    $data['option2']=$qbank->option2;
                                    $data['option3']=$qbank->option3;
                                    $data['option4']=$qbank->option4;
                                    $data['answer']=$qbank->answer;
                                    $data['hint']=$qbank->hint;
                                    $data['detail']=$qbank->detail;
                                    $data['marks']=$qbank->marks;
                                    $data['dbq_id']=$qbank->mid;
                                    $data['type']='mcq';
                                    /////////////////////////////////////////////////////////
                                    $this->quiz_m->update_column_value($this->data['quiz']->mid,'marks',$data['marks']);
                                    /////////////////////////////////////////////////////////
                                    /////////////////////////////////////////////////////////////////////////// 
                                    if($this->quiz_question_m->add_row($data) ==false){
                                        $this->data['msg_error']='Process stopped. Please try again later!';
                                    }
                                    $this->data['msg_success']='Saved Successfully.';
                                }
                                break;
                                case 'multisave':{
                                    $qus=explode("-", $form['qid']);
                                    $q_added=0;
                                    foreach($qus as $q){
                                        if(intval($q)>0){
                                            //add question to question paper          
                                            $qbank=$this->qbank_m->get_by_primary(intval($q));
                                            $data=array('class_id'=>$this->data['quiz']->class_id,'subject_id'=>$this->data['quiz']->subject_id,'quiz_id'=>$this->data['quiz']->mid);
                                            $data['question']=$qbank->question;
                                            $data['option1']=$qbank->option1;
                                            $data['option2']=$qbank->option2;
                                            $data['option3']=$qbank->option3;
                                            $data['option4']=$qbank->option4;
                                            $data['answer']=$qbank->answer;
                                            $data['hint']=$qbank->hint;
                                            $data['detail']=$qbank->detail;
                                            $data['marks']=$qbank->marks;
                                            $data['dbq_id']=$qbank->mid;
                                            $data['type']='mcq';
                                            /////////////////////////////////////////////////////////
                                            $this->quiz_m->update_column_value($this->data['quiz']->mid,'marks',$data['marks']);
                                            /////////////////////////////////////////////////////////
                                            /////////////////////////////////////////////////////////////////////////// 
                                            if($this->quiz_question_m->add_row($data)){
                                                $q_added++;
                                            }
                                        }
                                    }
                                    $this->data['msg_success']=$q_added.' questions added successfully.';
                                }
                                break;
                            }
                        }
                        /////////////////////////////////////////////////////////////////////////////////
                        isset($form['chapter'])&&!empty($form['chapter']) ? $filter['chapter']=$form['chapter'] : '';
                        isset($form['topic'])&&!empty($form['topic']) ? $params['like']=array('topic'=>$form['topic']) : '';
                        isset($form['limit'])&&!empty($form['limit']) ? $limit=intval($form['limit']) : $limit=10;;
                        $filter['type']='mcq';                    
                        $filter['class_id']=$this->data['quiz']->class_id;
                        $filter['subject_id']=$this->data['quiz']->subject_id;
                        ///////////////////////////////////////////
                        $already_added=$this->quiz_question_m->get_column_array('dbq_id',array('quiz_id'=>$this->data['quiz']->mid));
                        $params['select']='class_id,subject_id,chapter,type,question,detail,hint,type,option1,option2,option3,option4,answer,marks,difficulty';
                        $params['orderby']='mid RANDOM';
                        $params['limit']=$limit;
                        if(count($already_added)>0){$this->db->where_not_in('mid',$already_added);}
                        $this->data['rows']=$this->qbank_m->get_rows($filter,$params);
                        $i=0;
                        foreach($this->data['rows'] as $row){
                            if($row['answer']=='1'){$this->data['rows'][$i]['answer']=$row['option1'];}
                            if($row['answer']=='2'){$this->data['rows'][$i]['answer']=$row['option2'];}
                            if($row['answer']=='3'){$this->data['rows'][$i]['answer']=$row['option3'];}
                            if($row['answer']=='4'){$this->data['rows'][$i]['answer']=$row['option4'];}
                            $i++;
                        }
                        //////////////////////////////////////////////////////////////////////
                    }
                    break;                    
                    default:{    

                        if(isset($form['action']) && !empty($form['action']) &&!empty($form['qid'])){
                            switch (strtolower($form['action'])) {
                                case 'delete':{
                                    $record=$this->quiz_question_m->get_by_primary($form['qid']);
                                    $this->quiz_m->update_column_value($record->quiz_id,'marks',$record->marks,'minus');
                                    /////////////////////////////////////////////////////////////////////////// 
                                    if($this->quiz_question_m->delete($record->mid) ==false){
                                        $this->data['msg_error']='Process stopped. Please try again later!';
                                    }
                                    $this->data['msg_success']='Removed Successfully.';
                                }
                                break;
                            }
                        }
                        /////////////////////////////////////////////////////
                        $filter['quiz_id']=$this->data['quiz']->mid;
                        ////////////////////////////////////////////////////
                        $ques=array();
                        $params['select']='quiz_id,class_id,subject_id,chapter,question,detail,hint,type,option1,option2,option3,option4,answer,marks,difficulty';
                        $params['orderby']='mid ASC';
                        $this->data['rows']=$this->quiz_question_m->get_rows($filter,$params);
                        $i=0;
                        foreach($this->data['rows'] as $row){
                            if(in_array($row['question'],$ques)){$this->data['rows'][$i]['question'].=' (duplicate)';}else{array_push($ques, $row['question']);}
                            if($row['answer']=='1'){$this->data['rows'][$i]['answer']=$row['option1'];}
                            if($row['answer']=='2'){$this->data['rows'][$i]['answer']=$row['option2'];}
                            if($row['answer']=='3'){$this->data['rows'][$i]['answer']=$row['option3'];}
                            if($row['answer']=='4'){$this->data['rows'][$i]['answer']=$row['option4'];}
                            $i++;
                        }
                    }
                    break;
                }
            }
            break;  
            /////add row
            case 'paper':{
                //add class
                $this->data['main_content']='generate_paper';  
                $this->data['menu']='paper';            
                $this->data['sub_menu']='paper';
                if(empty($rid) && isset($form['cid']) && !empty($form['cid'])){
                    $rid=$form['cid'];
                }
                ///////////////////////////////////////////////
                $this->data['class']=$this->class_m->get_by_primary($rid);
                $this->data['subjects']=$this->subject_m->get_values_array('','name',array('class_id'=>$rid));
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
            }
            break;  
            /////add row
            case 'paperbank':{
                //add class
                $this->data['main_content']='generate_paperbank';  
                $this->data['menu']='paper';            
                $this->data['sub_menu']='paper';
                $this->ANGULAR_INC[]='generate_paperbank';
                //////////////////////////////////////////////
                $this->data['paper']=$this->paper_m->get_by_primary($rid);
                $this->data['class']=$this->class_m->get_by_primary($this->data['paper']->class_id);
                $this->data['subject']=$this->subject_m->get_by_primary($this->data['paper']->subject_id);
                //if paper time has started than it can not be edited.
                if($this->user_m->todayjd > $this->data['paper']->jd){
                    $this->session->set_flashdata('error', 'Unable to edit because paper start time has been passed.');
                    redirect($this->LIB_CONT_ROOT.'detail/mdl/classes/'.$this->data['paper']->class_id.'?tab=paper');                    
                }elseif(get_minutes_from_time() >= ($this->data['paper']->start_time-1) && $this->user_m->todayjd == $this->data['paper']->jd){
                    $this->session->set_flashdata('error', 'Unable to edit because paper start time has been passed.');
                    redirect($this->LIB_CONT_ROOT.'detail/mdl/classes/'.$this->data['paper']->class_id.'?tab=paper');                    
                }

                //////////////////////////////////////////////////////////////////////////////////
                switch (strtolower($this->data['tab'])) {
                    case 'add':{
                        if($_POST){                            
                            if(isset($post['type'])){$_SESSION['type']=$post['type'];}
                            if(isset($post['chapter'])){$_SESSION['chapter']=$post['chapter'];}
                            if(isset($post['topic'])){$_SESSION['topic']=$post['topic'];}
                            if(isset($post['marks'])){$_SESSION['marks']=$post['marks'];}
                            if(isset($post['difficulty'])){$_SESSION['difficulty']=$post['difficulty'];}
                            if(isset($post['saveqb'])){$_SESSION['saveqb']=$post['saveqb'];}
                            ///////////////////////////////////////////////////////////////////// 
                            if(empty($post['question'])){
                                $this->data['msg_error']='Please provide required information!';
                            }else{
                                $post['class_id']=$this->data['paper']->class_id;
                                $post['subject_id']=$this->data['paper']->subject_id;
                                /////////////////////////////////////////////////////////
                                if($post['saveqb']>0){$this->qbank_m->add_row($post);}
                                $this->paper_m->update_column_value($this->data['paper']->mid,'marks',$post['marks']);
                                /////////////////////////////////////////////////////////
                                $post['paper_id']=$this->data['paper']->mid;
                                $post['sorting']=1; //mcq
                                if($post['type']=='short'){$post['sorting']=2; }//short
                                if($post['type']=='long'){$post['sorting']=3; }//long
                                /////////////////////////////////////////////////////////////////////////// 
                                if($this->paper_question_m->add_row($post) ==false){
                                    $this->data['msg_error']='Process stopped. Please try again later!';
                                }
                                $this->data['msg_success']='Saved Successfully.';                            
                            }
                        }

                    }
                    break;                    
                    case 'qbadd':{    
                        if(isset($form['action']) && !empty($form['action']) &&!empty($form['qid'])){
                            switch (strtolower($form['action'])) {
                                case 'save':{
                                    //add question to question paper          
                                    $qbank=$this->qbank_m->get_by_primary($form['qid']);
                                    $data=array('class_id'=>$this->data['paper']->class_id,'subject_id'=>$this->data['paper']->subject_id,'paper_id'=>$this->data['paper']->mid);
                                    $data['question']=$qbank->question;
                                    $data['option1']=$qbank->option1;
                                    $data['option2']=$qbank->option2;
                                    $data['option3']=$qbank->option3;
                                    $data['option4']=$qbank->option4;
                                    $data['answer']=$qbank->answer;
                                    $data['hint']=$qbank->hint;
                                    $data['detail']=$qbank->detail;
                                    $data['marks']=$qbank->marks;
                                    $data['type']=$qbank->type;
                                    $data['dbq_id']=$qbank->mid;
                                    /////////////////////////////////////////////////////////
                                    $data['sorting']=1; //mcq
                                    if($data['type']=='short'){$data['sorting']=2; }//short
                                    if($data['type']=='long'){$data['sorting']=3; }//long
                                    /////////////////////////////////////////////////////////
                                    $this->paper_m->update_column_value($this->data['paper']->mid,'marks',$data['marks']);
                                    /////////////////////////////////////////////////////////
                                    /////////////////////////////////////////////////////////////////////////// 
                                    if($this->paper_question_m->add_row($data) ==false){
                                        $this->data['msg_error']='Process stopped. Please try again later!';
                                    }
                                    $this->data['msg_success']='Saved Successfully.';
                                }
                                break;
                                case 'multisave':{
                                    $qus=explode("-", $form['qid']);
                                    $q_added=0;
                                    foreach($qus as $q){
                                        if(intval($q)>0){
                                            //add question to question paper          
                                            $qbank=$this->qbank_m->get_by_primary(intval($q));
                                            $data=array('class_id'=>$this->data['paper']->class_id,'subject_id'=>$this->data['paper']->subject_id,'paper_id'=>$this->data['paper']->mid);
                                            $data['question']=$qbank->question;
                                            $data['option1']=$qbank->option1;
                                            $data['option2']=$qbank->option2;
                                            $data['option3']=$qbank->option3;
                                            $data['option4']=$qbank->option4;
                                            $data['answer']=$qbank->answer;
                                            $data['hint']=$qbank->hint;
                                            $data['detail']=$qbank->detail;
                                            $data['marks']=$qbank->marks;
                                            $data['type']=$qbank->type;
                                            $data['dbq_id']=$qbank->mid;
                                            /////////////////////////////////////////////////////////
                                            $data['sorting']=1; //mcq
                                            if($data['type']=='short'){$data['sorting']=2; }//short
                                            if($data['type']=='long'){$data['sorting']=3; }//long
                                            /////////////////////////////////////////////////////////
                                            $this->paper_m->update_column_value($this->data['paper']->mid,'marks',$data['marks']);
                                            /////////////////////////////////////////////////////////
                                            /////////////////////////////////////////////////////////////////////////// 
                                            if($this->paper_question_m->add_row($data)){
                                                $q_added++;
                                            }
                                        }
                                    }
                                    $this->data['msg_success']=$q_added.' questions added successfully.';
                                }
                                break;
                            }
                        }
                        /////////////////////////////////////////////////////////////////////////////////
                        isset($form['type'])&&!empty($form['type']) ? $filter['type']=$form['type'] : '';
                        isset($form['chapter'])&&!empty($form['chapter']) ? $filter['chapter']=$form['chapter'] : '';
                        isset($form['topic'])&&!empty($form['topic']) ? $params['like']=array('topic'=>$form['topic']) : '';
                        isset($form['limit'])&&!empty($form['limit']) ? $limit=intval($form['limit']) : $limit=10;
                        $filter['class_id']=$this->data['paper']->class_id;
                        $filter['subject_id']=$this->data['paper']->subject_id;
                        ///////////////////////////////////////////
                        $already_added=$this->paper_question_m->get_column_array('dbq_id',array('paper_id'=>$this->data['paper']->mid));
                        $params['select']='class_id,subject_id,chapter,type,question,detail,hint,type,option1,option2,option3,option4,answer,marks,difficulty';
                        $params['orderby']='mid RANDOM';
                        $params['limit']=$limit;
                        if(count($already_added)>0){$this->db->where_not_in('mid',$already_added);}
                        $this->data['rows']=$this->qbank_m->get_rows($filter,$params);
                        $i=0;
                        foreach($this->data['rows'] as $row){
                            if($row['answer']=='1'){$this->data['rows'][$i]['answer']=$row['option1'];}
                            if($row['answer']=='2'){$this->data['rows'][$i]['answer']=$row['option2'];}
                            if($row['answer']=='3'){$this->data['rows'][$i]['answer']=$row['option3'];}
                            if($row['answer']=='4'){$this->data['rows'][$i]['answer']=$row['option4'];}
                            $i++;
                        }
                        //////////////////////////////////////////////////////////////////////
                    }
                    break;                    
                    default:{    

                        if(isset($form['action']) && !empty($form['action']) &&!empty($form['qid'])){
                            switch (strtolower($form['action'])) {
                                case 'delete':{
                                    $record=$this->paper_question_m->get_by_primary($form['qid']);
                                    $this->paper_m->update_column_value($record->paper_id,'marks',$record->marks,'minus');
                                    /////////////////////////////////////////////////////////////////////////// 
                                    if($this->paper_question_m->delete($record->mid) ==false){
                                        $this->data['msg_error']='Process stopped. Please try again later!';
                                    }
                                    $this->data['msg_success']='Removed Successfully.';
                                }
                                break;
                            }
                        }
                        /////////////////////////////////////////////////////
                        $filter['paper_id']=$this->data['paper']->mid;
                        ////////////////////////////////////////////////////
                        $ques=array();
                        $params['select']='paper_id,class_id,subject_id,question,detail,hint,type,option1,option2,option3,option4,answer,marks,difficulty';
                        $params['orderby']='mid ASC';
                        $this->data['rows']=$this->paper_question_m->get_rows($filter,$params);
                        $i=0;
                        foreach($this->data['rows'] as $row){
                            if(in_array($row['question'],$ques)){$this->data['rows'][$i]['question'].=' (duplicate)';}else{array_push($ques, $row['question']);}
                            if($row['answer']=='1'){$this->data['rows'][$i]['answer']=$row['option1'];}
                            if($row['answer']=='2'){$this->data['rows'][$i]['answer']=$row['option2'];}
                            if($row['answer']=='3'){$this->data['rows'][$i]['answer']=$row['option3'];}
                            if($row['answer']=='4'){$this->data['rows'][$i]['answer']=$row['option4'];}
                            $i++;
                        }
                    }
                    break;
                }
            }
            break;  
        }

        /////////////////////////////////////////////////////////////
        $this->data['module']=strtolower($module);
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}


    /** 
    * /////////////////////////////////////////////////////////////////////
    * *********************** SAVE DATA ***********************************
    * /////////////////////////////////////////////////////////////////////
    */

    // create row
    public function save($module=''){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        $redir=$this->CONT_ROOT.'mdl/'.strtolower($module).'/';
        switch (strtolower($module)) {
            ///////save data
            case 'quiz':{                
                $required=array('name','subject_id','date');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter required information');
                        redirect($redir);
                    }
                }
                $subject=$this->subject_m->get_by_primary($form['subject_id']);
                $form['class_id']=$subject->class_id;
                $date_array=explode('.',$form['date']);
                $form['date']=intval($date_array[0]).'-'.month_string(intval($date_array[1])).'-'.intval($date_array[2]);
                $form['jd']=get_jd_from_date($form['date']);
                $form['start_time']=get_minutes_from_time($form['start_time'],false);              
                if($this->user_m->todayjd >= $form['jd'] && get_minutes_from_time()>=$form['start_time']){
                    $this->session->set_flashdata('error', 'Please select date and time in future');
                    redirect($redir);  
                }
                $rid=$this->quiz_m->add_row($form);
                if($rid===false){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Generated new quiz(".$form['name'].") of $subject->name";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Quiz generated successfully. Please add questions to quiz...');
                redirect($this->CONT_ROOT.'mdl/quizbank/'.$rid);
            }
            break;
            ///////save data
            case 'paper':{                
                $required=array('name','subject_id','date');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter required information');
                        redirect($redir);
                    }
                }
                $subject=$this->subject_m->get_by_primary($form['subject_id']);
                $form['class_id']=$subject->class_id;
                $date_array=explode('.',$form['date']);
                $form['date']=intval($date_array[0]).'-'.month_string(intval($date_array[1])).'-'.intval($date_array[2]);
                $form['jd']=get_jd_from_date($form['date']);
                $form['start_time']=get_minutes_from_time($form['start_time'],false);                
                if($this->user_m->todayjd >= $form['jd'] && get_minutes_from_time()>=$form['start_time']){
                    $this->session->set_flashdata('error', 'Please select date and time in future');
                    redirect($redir);  
                }
                
                $rid=$this->paper_m->add_row($form);
                if($rid===false){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Generated new paper(".$form['name'].") of $subject->name";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Paper generated successfully. Please add questions to quiz...');
                redirect($this->CONT_ROOT.'mdl/paperbank/'.$rid);
            }
            break;
            /////////////////////////////////////////////////////////////////////
            default:{
                $this->session->set_flashdata('error', 'Please choose a valid module...');
                redirect($this->LIB_CONT_ROOT);
            }
            break;
        }
    }

    /** 
    * /////////////////////////////////////////////////////////////////////
    * *********************** AJAX FUNCTIONS ******************************
    * /////////////////////////////////////////////////////////////////////
    */

    /** 
    * /////////////////////////////////////////////////////////////////////
    * *********************** AJAX FUNCTIONS ******************************
    * /////////////////////////////////////////////////////////////////////
    */

    // filter rows
    public function filter($module=''){
        // get input fields into array
        $filter=array();
        $params=array();
        $search=array();
        $like=array();
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_get();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        ////////////////////////////////////////////////////////////////////////////////
        switch (strtolower($module)) {
            /////load row
            case 'subjects':{
                isset($form['class_id'])&&!empty($form['class_id']) ? $filter['class_id']=$form['class_id'] : '';
                ///////////////////////////////////////////
                $params['select']='name,';
                $this->RESPONSE['rows']=$this->subject_m->get_rows($filter,$params);
            }
            break;  
            /////load row
            case 'questionbank':{
                (isset($form['rid'])&&!empty($form['rid']) || isset($form['pid'])&&!empty($form['pid']) ) ? '' : exit;
                isset($form['chapter'])&&!empty($form['chapter']) ? $filter['chapter']=$form['chapter'] : '';
                isset($form['type'])&&!empty($form['type']) ? $filter['type']=$form['type'] : '';
                isset($form['limit'])&&!empty($form['limit']) ? $limit=intval($form['limit']) : $limit=10;;
                ///////////////////////////////////////////
                if(isset($form['pid']) && !empty($form['pid'])){
                    $row=$this->paper_m->get_by_primary($form['pid']);
                }else{
                    $row=$this->quiz_m->get_by_primary($form['rid']);
                    $filter['type']='mcq';                    
                }
                $filter['class_id']=$row->class_id;
                $filter['subject_id']=$row->subject_id;
                $params['select']='class_id,subject_id,chapter,type,question,detail,hint,type,option1,option2,option3,option4,answer,marks,difficulty';
                $params['orderby']='mid RANDOM';
                $params['limit']=$limit;
                $this->RESPONSE['rows']=$this->qbank_m->get_rows($filter,$params);
                $i=0;
                foreach($this->RESPONSE['rows'] as $row){
                    if($row['answer']=='1'){$this->RESPONSE['rows'][$i]['answer']=$row['option1'];}
                    if($row['answer']=='2'){$this->RESPONSE['rows'][$i]['answer']=$row['option2'];}
                    if($row['answer']=='3'){$this->RESPONSE['rows'][$i]['answer']=$row['option3'];}
                    if($row['answer']=='4'){$this->RESPONSE['rows'][$i]['answer']=$row['option4'];}
                    $i++;
                }
            }
            break;  
            /////load row
            case 'quizbank':{
                isset($form['rid'])&&!empty($form['rid']) ? $filter['quiz_id']=$form['rid'] : exit;
                ///////////////////////////////////////////
                $ques=array();
                $params['select']='quiz_id,class_id,subject_id,chapter,question,detail,hint,type,option1,option2,option3,option4,answer,marks,difficulty';
                $params['orderby']='mid ASC';
                $this->RESPONSE['rows']=$this->quiz_question_m->get_rows($filter,$params);
                $i=0;
                foreach($this->RESPONSE['rows'] as $row){
                    if(in_array($row['question'],$ques)){$this->RESPONSE['rows'][$i]['question'].=' (duplicate)';}else{array_push($ques, $row['question']);}
                    if($row['answer']=='1'){$this->RESPONSE['rows'][$i]['answer']=$row['option1'];}
                    if($row['answer']=='2'){$this->RESPONSE['rows'][$i]['answer']=$row['option2'];}
                    if($row['answer']=='3'){$this->RESPONSE['rows'][$i]['answer']=$row['option3'];}
                    if($row['answer']=='4'){$this->RESPONSE['rows'][$i]['answer']=$row['option4'];}
                    $i++;
                }
            }
            break;  
            /////load row
            case 'paperbank':{
                isset($form['rid'])&&!empty($form['rid']) ? $filter['paper_id']=$form['rid'] : exit;
                ///////////////////////////////////////////
                $ques=array();
                $params['select']='paper_id,class_id,subject_id,question,detail,hint,type,option1,option2,option3,option4,answer,marks,difficulty';
                $params['orderby']='sorting ASC, mid ASC';
                $this->RESPONSE['rows']=$this->paper_question_m->get_rows($filter,$params);
                $i=0;
                foreach($this->RESPONSE['rows'] as $row){
                    if(in_array($row['question'],$ques)){$this->RESPONSE['rows'][$i]['question'].=' (duplicate)';}else{array_push($ques, $row['question']);}
                    if($row['answer']=='1'){$this->RESPONSE['rows'][$i]['answer']=$row['option1'];}
                    if($row['answer']=='2'){$this->RESPONSE['rows'][$i]['answer']=$row['option2'];}
                    if($row['answer']=='3'){$this->RESPONSE['rows'][$i]['answer']=$row['option3'];}
                    if($row['answer']=='4'){$this->RESPONSE['rows'][$i]['answer']=$row['option4'];}
                    $i++;
                }
            }
            break;  
        }
        ////////////////////////////////////////////////////////////////////////
        echo json_encode( $this->RESPONSE);
        
    }

    public function load($module=''){
        $form=$this->input->safe_get();
        $rid=$form['rid'];
        switch (strtolower($module)) {
            /////load row
            case 'qbank':{
                $this->RESPONSE['row']=$this->qbank_m->get_by_primary($rid);
            }
            break;  
            /////load row
            case 'quiz':{
                $row=$this->quiz_m->get_by_primary($rid);
                $row->total_time=$row->allowed_time;
                $row->total_questions=$this->quiz_question_m->get_rows(array('quiz_id'=>$row->mid),'',true);
                if($row->qbase_time<1){$row->total_time=$row->allowed_time*$row->total_questions;}
                $this->RESPONSE['row']=$row;
            }
            break;  
            /////load row
            case 'paper':{
                $row=$this->paper_m->get_by_primary($rid);
                $row->total_time=$row->allowed_time;
                $row->total_questions=$this->paper_question_m->get_rows(array('paper_id'=>$row->mid),'',true);
                $row->total_questions_detail='M:'.$this->paper_question_m->get_rows(array('paper_id'=>$row->mid,'type'=>'mcq'),'',true);
                $row->total_questions_detail.=',  S:'.$this->paper_question_m->get_rows(array('paper_id'=>$row->mid,'type'=>'short'),'',true);
                $row->total_questions_detail.=',  L:'.$this->paper_question_m->get_rows(array('paper_id'=>$row->mid,'type'=>'long'),'',true);
                $this->RESPONSE['row']=$row;
            }
            break;  
        }
        ////////////////////////////////////////////////////////////////////////
        echo json_encode( $this->RESPONSE);  
    }

    public function update($module=''){
        $form=$this->input->safe_post();
        $rid=$form['rid'];
        switch (strtolower($module)) {
            /////load row
            case 'qbank':{

                //check for necessary required data   
                $required=array('class_id','subject_id','type','question');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Please provide required information ...';
                    echo json_encode($this->RESPONSE);exit();
                    }
                }   
                if($this->qbank_m->save($form,$rid) ==false){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Process stopped. Please try again later!';
                    echo json_encode($this->RESPONSE);exit();            
                }
                $this->RESPONSE['message']='Saved Successfully.';
            }
            break;  
            /////load row
            case 'manualquizbank':{
                //check for necessary required data   
                $required=array('rid','answer','question');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Please provide required information ...';
                    echo json_encode($this->RESPONSE);exit();
                    }
                }  
                $quiz=$this->quiz_m->get_by_primary($rid);
                $form['class_id']=$quiz->class_id;
                $form['subject_id']=$quiz->subject_id;
                $form['type']='mcq';
                /////////////////////////////////////////////////////////
                if($form['saveqb']>0){$this->qbank_m->add_row($form);}
                $this->quiz_m->update_column_value($rid,'marks',$form['marks']);
                /////////////////////////////////////////////////////////
                $form['quiz_id']=$quiz->mid;
                /////////////////////////////////////////////////////////////////////////// 
                if($this->quiz_question_m->add_row($form) ==false){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Process stopped. Please try again later!';
                    echo json_encode($this->RESPONSE);exit();            
                }
                $this->RESPONSE['message']='Saved Successfully.';
            }
            break;  
            /////load row
            case 'qbquizbank':{
                //check for necessary required data   
                $required=array('rid','qid');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Please provide required information ...';
                    echo json_encode($this->RESPONSE);exit();
                    }
                }  
                $quiz=$this->quiz_m->get_by_primary($rid);
                $qbank=$this->qbank_m->get_by_primary($form['qid']);
                $data=array('class_id'=>$quiz->class_id,'subject_id'=>$quiz->subject_id,'quiz_id'=>$quiz->mid);
                $data['question']=$qbank->question;
                $data['option1']=$qbank->option1;
                $data['option2']=$qbank->option2;
                $data['option3']=$qbank->option3;
                $data['option4']=$qbank->option4;
                $data['answer']=$qbank->answer;
                $data['hint']=$qbank->hint;
                $data['detail']=$qbank->detail;
                $data['marks']=$qbank->marks;
                $data['type']='mcq';
                /////////////////////////////////////////////////////////
                $this->quiz_m->update_column_value($rid,'marks',$data['marks']);
                /////////////////////////////////////////////////////////
                /////////////////////////////////////////////////////////////////////////// 
                if($this->quiz_question_m->add_row($data) ==false){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Process stopped. Please try again later!';
                    echo json_encode($this->RESPONSE);exit();            
                }
                $this->RESPONSE['message']='Saved Successfully.';
            }
            break;  
            /////load row
            case 'manualpaperbank':{
                //check for necessary required data   
                $required=array('rid','question');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Please provide required information ...';
                    echo json_encode($this->RESPONSE);exit();
                    }
                }  
                $paper=$this->paper_m->get_by_primary($rid);
                $form['class_id']=$paper->class_id;
                $form['subject_id']=$paper->subject_id;
                /////////////////////////////////////////////////////////
                if($form['saveqb']>0){$this->qbank_m->add_row($form);}
                $this->paper_m->update_column_value($rid,'marks',$form['marks']);
                /////////////////////////////////////////////////////////
                $form['paper_id']=$paper->mid;
                $form['sorting']=1; //mcq
                if($form['type']=='short'){$form['sorting']=2; }//short
                if($form['type']=='long'){$form['sorting']=3; }//long
                /////////////////////////////////////////////////////////////////////////// 
                if($this->paper_question_m->add_row($form) ==false){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Process stopped. Please try again later!';
                    echo json_encode($this->RESPONSE);exit();            
                }
                $this->RESPONSE['message']='Saved Successfully.';
            }
            break;  
            /////load row
            case 'qbpaperbank':{
                //check for necessary required data   
                $required=array('rid','qid');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Please provide required information ...';
                    echo json_encode($this->RESPONSE);exit();
                    }
                }  
                $paper=$this->paper_m->get_by_primary($rid);
                $qbank=$this->qbank_m->get_by_primary($form['qid']);
                $data=array('class_id'=>$paper->class_id,'subject_id'=>$paper->subject_id,'paper_id'=>$paper->mid);
                $data['question']=$qbank->question;
                $data['option1']=$qbank->option1;
                $data['option2']=$qbank->option2;
                $data['option3']=$qbank->option3;
                $data['option4']=$qbank->option4;
                $data['answer']=$qbank->answer;
                $data['hint']=$qbank->hint;
                $data['detail']=$qbank->detail;
                $data['marks']=$qbank->marks;
                $data['type']=$qbank->type;
                $data['sorting']=1; //mcq
                if($data['type']=='short'){$data['sorting']=2; }//short
                if($data['type']=='long'){$data['sorting']=3; }//long
                /////////////////////////////////////////////////////////
                $this->paper_m->update_column_value($rid,'marks',$data['marks']);
                /////////////////////////////////////////////////////////
                /////////////////////////////////////////////////////////////////////////// 
                if($this->paper_question_m->add_row($data) ==false){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Process stopped. Please try again later!';
                    echo json_encode($this->RESPONSE);exit();            
                }
                $this->RESPONSE['message']='Saved Successfully.';
            }
            break;  
        }
        ////////////////////////////////////////////////////////////////////////
        echo json_encode( $this->RESPONSE);  
    }

    public function delete($module=''){
        $form=$this->input->safe_post();
        $rid=$form['rid'];
        switch (strtolower($module)) {
            /////load row
            case 'quizbank':{
                //check for necessary required data   
                $required=array('rid');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Please provide required information ...';
                    echo json_encode($this->RESPONSE);exit();
                    }
                }  
                $row=$this->quiz_question_m->get_by_primary($rid);
                $this->quiz_m->update_column_value($row->quiz_id,'marks',$row->marks,'minus');
                /////////////////////////////////////////////////////////////////////////// 
                if($this->quiz_question_m->delete($rid) ==false){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Process stopped. Please try again later!';
                    echo json_encode($this->RESPONSE);exit();            
                }
                $this->RESPONSE['message']='Removed Successfully.';
            }
            break;  
            /////load row
            case 'paperbank':{
                //check for necessary required data   
                $required=array('rid');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Please provide required information ...';
                    echo json_encode($this->RESPONSE);exit();
                    }
                }  
                $row=$this->paper_question_m->get_by_primary($rid);
                $this->paper_m->update_column_value($row->paper_id,'marks',$row->marks,'minus');
                /////////////////////////////////////////////////////////////////////////// 
                if($this->paper_question_m->delete($rid) ==false){
                    $this->RESPONSE['error']=TRUE;
                    $this->RESPONSE['message']='Process stopped. Please try again later!';
                    echo json_encode($this->RESPONSE);exit();            
                }
                $this->RESPONSE['message']='Removed Successfully.';
            }
            break;  
        }
        ////////////////////////////////////////////////////////////////////////
        echo json_encode( $this->RESPONSE);  
    }


/** 
* /////////////////////////////////////////////////////////////////////////////////////
* ************************** END OF CLASS *********************************************
* /////////////////////////////////////////////////////////////////////////////////////
*/

}
	