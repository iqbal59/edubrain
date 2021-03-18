<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delete extends Admin_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'Delete/';
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

    public function mdl($module=''){

        $form=$this->input->safe_get();
        isset($form['rid']) ? $rid=$form['rid'] : $rid='';
        $redir=$this->LIB_CONT_ROOT.'index/'.strtolower($module);
        //check for demo   
        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_del_err') );
            redirect($redir); 
        }
        //check for necessary data   
        if(empty($rid)){
            $this->session->set_flashdata('error', 'Please choose a valid record' );
            redirect($redir);
        }
        ////////////////////////////////////
        switch (strtolower($module)) {
            case 'datesheet':{
                //remove class           
                $row=$this->datesheet_m->get_by_primary($rid);
                $redir=$this->LIB_CONT_ROOT.'detail/mdl/classes/'.strtolower($row->class_id).'/?tab=datesheet';     
                if($this->datesheet_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Record cannot be removed at this time' );
                    redirect($redir);
                }
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Record removed successfully' );
                redirect($redir);
            }
            break;  
            case 'syllabus':{
                //remove class           
                $row=$this->syllabus_m->get_by_primary($rid);
                $redir=$this->LIB_CONT_ROOT.'detail/mdl/classes/'.strtolower($row->class_id).'/?tab=syllabus';     
                if($this->syllabus_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Record cannot be removed at this time' );
                    redirect($redir);
                }
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Record removed successfully' );
                redirect($redir);
            }
            break;   
            case 'timetable':{
                //remove class           
                $row=$this->timetable_m->get_by_primary($rid);
                $redir=$this->LIB_CONT_ROOT.'detail/mdl/classes/'.strtolower($row->class_id).'/?tab=timetable';     
                if($this->timetable_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Record cannot be removed at this time' );
                    redirect($redir);
                }
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Record removed successfully' );
                redirect($redir);
            }
            break;  
            case 'homework':{
                $row=$this->homework_m->get_by_primary($rid); 
                $redir=$this->LIB_CONT_ROOT.'index/'.strtolower($module).'?sid='.$row->subject_id;
                //remove class                

                if($this->homework_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Record cannot be removed at this time' );
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Removed Subject Homework($row->homework)";
                $this->system_history_m->add_row($history);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Homework removed successfully' );
                redirect($redir);
            }
            break;  
            case 'notes':{
                $row=$this->download_m->get_by_primary($rid); 
                $redir=$this->LIB_CONT_ROOT.'index/'.strtolower($module).'?sid='.$row->subject_id;
                //remove class                

                if($this->download_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Note cannot be removed at this time' );
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Removed Subject Note($row->name)";
                $this->system_history_m->add_row($history);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Note removed successfully' );
                redirect($redir);
            }
            break;  
            case 'classes':{
                //remove class                
                $row=$this->class_m->get_by_primary($rid); 

                if($this->class_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Class cannot be removed at this time' );
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Removed class($row->name)";
                $this->system_history_m->add_row($history);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Class removed successfully' );
                redirect($redir);
            }
            break;  
            case 'classlinks':{
                //remove class                
                $row=$this->class_link_m->get_by_primary($rid); 

                if($this->class_link_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Class cannot be removed at this time' );
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Removed class zoom link($row->subject)";
                $this->system_history_m->add_row($history);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Class removed successfully' );
                redirect($redir);
            }
            break;  
            case 'sections':{
                //remove class                
                $row=$this->section_m->get_by_primary($rid);
                if($this->section_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Section cannot be removed at this time' );
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Removed class section($row->name)";
                $this->system_history_m->add_row($history);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Section removed successfully' );
                redirect($redir);
            }
            break; 
            case 'groups':{
                //remove class                
                $row=$this->group_m->get_by_primary($rid);
                if($this->group_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Group cannot be removed at this time' );
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Removed class group($row->name)";
                $this->system_history_m->add_row($history);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Group removed successfully' );
                redirect($redir);
            }
            break;  
            case 'subjects':{
                //remove class                
                $row=$this->subject_m->get_by_primary($rid);
                if($this->subject_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Subject cannot be removed at this time' );
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Removed Subject($row->name)";
                $this->system_history_m->add_row($history);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Subject removed successfully' );
                redirect($redir);
            }
            break;  
            case 'lessons':{
                //remove class                
                $row=$this->lesson_m->get_by_primary($rid);
                if($this->lesson_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Lesson cannot be removed at this time' );
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Removed Lesson($row->name)";
                $this->system_history_m->add_row($history);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Lesson removed successfully' );
                redirect($redir);
            }
            break;  
            case 'students':{
                //remove class                
                $row=$this->student_m->get_by_primary($rid);
                if($this->student_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Student cannot be removed at this time' );
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Removed Student($row->name)";
                $this->system_history_m->add_row($history);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Student removed successfully' );
                redirect($redir);
            }
            break;  
            case 'staff':{
                //remove class                
                $row=$this->staff_m->get_by_primary($rid);
                if($this->staff_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Staff cannot be removed at this time' );
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Removed Staff($row->name)";
                $this->system_history_m->add_row($history);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Staff removed successfully' );
                redirect($redir);
            }
            break;  
            case 'chatgroups':{
                //remove class                
                $row=$this->chat_group_m->get_by_primary($rid);
                if($this->chat_group_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Groups cannot be removed at this time' );
                    redirect($redir);
                }
                $this->chat_group_message_m->delete(NULL,array('chat_group_id'=>$row->mid));
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Removed Chat Group($row->name)";
                $this->system_history_m->add_row($history);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Group removed successfully' );
                redirect($redir);
            }
            break;  
            case 'messages':{
                //remove class                
                $row=$this->chat_m->get_by_primary($rid);
                if($this->chat_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Groups cannot be removed at this time' );
                    redirect($redir);
                }
                $this->chat_message_m->delete(NULL,array('chat_id'=>$row->mid));
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Removed Chat conversion of staff and student";
                $this->system_history_m->add_row($history);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Group removed successfully' );
                redirect($redir);
            }
            break;  
            case 'qbank':{
                //remove class                
                $row=$this->qbank_m->get_by_primary($rid);
                if($this->qbank_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Groups cannot be removed at this time' );
                    redirect($redir);
                }
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Question removed successfully' );
                redirect($redir);
            }
            break;  
            case 'quiz':{
                //remove class           
                $row=$this->quiz_m->get_by_primary($rid);
                $redir=$this->LIB_CONT_ROOT.'detail/mdl/classes/'.strtolower($row->class_id).'/?tab=quiz';     
                if($this->quiz_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Quiz cannot be removed at this time' );
                    redirect($redir);
                }
                $this->quiz_question_m->delete(NULL,array('quiz_id'=>$row->mid));
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Quiz removed successfully' );
                redirect($redir);
            }
            break;  
            case 'paper':{
                //remove class           
                $row=$this->paper_m->get_by_primary($rid);
                $redir=$this->LIB_CONT_ROOT.'detail/mdl/classes/'.strtolower($row->class_id).'/?tab=paper';     
                if($this->paper_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Paper cannot be removed at this time' );
                    redirect($redir);
                }
                $this->paper_question_m->delete(NULL,array('paper_id'=>$row->mid));
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Paper removed successfully' );
                redirect($redir);
            }
            break;  
            case 'quizbank':{
                //remove all questions in the quiz          
                $row=$this->quiz_m->get_by_primary($rid);
                $redir=$this->LIB_CONT_ROOT.'generate/mdl/quizbank/'.strtolower($row->mid); 
                $this->quiz_question_m->delete(NULL,array('quiz_id'=>$row->mid));
                $this->quiz_m->save(array('marks'=>'0'),$row->mid);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'All questions  removed successfully' );
                redirect($redir);
            }
            break;  
            case 'paperbank':{
                //remove all questions in the quiz          
                $row=$this->paper_m->get_by_primary($rid);
                $redir=$this->LIB_CONT_ROOT.'generate/mdl/paperbank/'.strtolower($row->mid); 
                $this->paper_question_m->delete(NULL,array('paper_id'=>$row->mid));
                $this->paper_m->save(array('marks'=>'0'),$row->mid);
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'All questions  removed successfully' );
                redirect($redir);
            }
            break;  
            case 'test':{
                //remove class           
                $row=$this->test_m->get_by_primary($rid);
                $redir=$this->LIB_CONT_ROOT.'index/test';     
                if($this->test_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Test cannot be removed at this time' );
                    redirect($redir);
                }
                $this->test_question_m->delete(NULL,array('test_id'=>$row->mid));
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Test removed successfully' );
                redirect($redir);
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
	