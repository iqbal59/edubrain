<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delete extends Staff_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'delete/';
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
                $redir=$this->LIB_CONT_ROOT.'detail/mdl/classes/'.strtolower($row->class_id);     
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
                $redir=$this->LIB_CONT_ROOT.'detail/mdl/classes/'.strtolower($row->class_id);     
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
	