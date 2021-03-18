<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subjects extends Student_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'subjects/';
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
		$this->data['main_content']='subjects';	
		$this->data['menu']='subjects';			
		$this->data['sub_menu']='subjects';
		$this->data['tab']=$this->uri->segment(4);
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
        $filter=array();
        $filter['class_id']=$this->LOGIN_USER->class_id;
        // $this->db->where(" (group_id=0  OR group_id=".$this->LOGIN_USER->group_id.")");
        $this->data['subjects']=$this->subject_m->get_rows($filter,array('select'=>'name'));
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}
       
	// view the downloads for this subject
	public function view($rid){
		$row=$this->subject_m->get_by_primary($rid);
        if($row->class_id != $this->LOGIN_USER->class_id){
            $this->session->set_flashdata('error', "You cannot view the notes of this class");
            redirect($this->CONT_ROOT);                    
        }

        $filter=array();
        $filter['class_id']=$this->LOGIN_USER->class_id;
        $filter['subject_id']=$row->mid;
        $this->data['notes']=$this->download_m->get_rows($filter,array('select'=>'mid,name,about,file'));


        $this->data['main_content']='notes_view';    
        $this->data['menu']='notes';            
        $this->data['sub_menu']='notes';
        $this->data['tab']=$this->uri->segment(4);
        $this->data['record']=$row;
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
	}
       
    // view the subject homework
    public function homework($rid){
        $row=$this->subject_m->get_by_primary($rid);
        if($row->class_id != $this->LOGIN_USER->class_id){
            $this->session->set_flashdata('error', "You cannot view the homework of this class");
            redirect($this->CONT_ROOT);                    
        }

        $filter=array();
        $filter['class_id']=$this->LOGIN_USER->class_id;
        $filter['subject_id']=$row->mid;
        $this->data['rows']=$this->homework_m->get_rows($filter,array('select'=>'mid,homework,instructions,date,section_id,file'));


        $this->data['main_content']='subjects_homework';    
        $this->data['menu']='subjects';            
        $this->data['sub_menu']='subjects';
        $this->data['tab']=$this->uri->segment(4);
        $this->data['record']=$row;
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    } 

    // view the subject homework
    public function homework_submit($rid){
        $row=$this->homework_m->get_by_primary($rid);
        if($row->class_id != $this->LOGIN_USER->class_id){
            $this->session->set_flashdata('error', "You cannot view the homework of this class");
            redirect($this->CONT_ROOT);                    
        }
        if($row->section_id > 0 && $row->section_id != $this->LOGIN_USER->section_id){
            $this->session->set_flashdata('error', "This homework is not for your section");
            redirect($this->CONT_ROOT);                    
        }

        $filter=array();
        $filter['work_id']=$row->mid;
        $filter['subject_id']=$row->subject_id;
        $filter['student_id']=$this->LOGIN_USER->mid;
        $this->data['rows']=$this->homework_answer_m->get_rows($filter,array('select'=>'mid,answer,file,date'));


        $this->data['main_content']='subjects_homework_submit';    
        $this->data['menu']='subjects';            
        $this->data['sub_menu']='subjects';
        $this->data['tab']=$this->uri->segment(4);
        $this->data['record']=$row;
        $this->data['subject']=$this->subject_m->get_by_primary($row->subject_id);
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }
       
    //save doc
    public function upload_homework(){
        //upload artwork file
        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->LIB_CONT_ROOT.'', 'refresh');                    
        }
        $form=$this->input->safe_post();
        $redir=$this->CONT_ROOT.'homework_submit/'.$form['rid'];
        if(empty($form['homework']) ){
            $this->session->set_flashdata('error', "Please write homework");
            redirect($redir);                    
        }
        $row=$this->homework_m->get_by_primary($form['rid']);
        $entry=array('class_id'=>$row->class_id,'work_id'=>$row->mid,'subject_id'=>$row->subject_id);
        $entry['student_id']=$this->LOGIN_USER->mid;
        $entry['answer']=$form['homework'];
        $entry['date']=date('d.m.Y');
        if($_FILES['file']['tmp_name']!='') {
            // do this, upload file
            $file_name='doc_'.time().mt_rand(101,999);
            $path='./uploads/files/docs';
            if (!file_exists($path)) {
                @mkdir($path, 0777, true);
            }
            $data=$this->upload_doc($path,'file',$file_name);
            if($data['file_uploaded']==FALSE){
                $this->session->set_flashdata('error', $data['file_error']);
                redirect($redir);
            }
            $nfile_name=$data['file_name'];
            $entry['file']=$nfile_name;
        } 
        $this->homework_answer_m->add_row($entry);
        $this->session->set_flashdata('success', 'Homework submitted successfully.');
        redirect($redir);           
    
    }
    //upload file
    private function upload_doc($path,$file_name='file',$new_name=''){ 
       $size='75220';
       $allowed_types='doc|docx|xls|xlsx|ppt|pptx|txt|pdf|zip|mp3|mp4|jpg|jpeg|png|bmp|rar';
       $upload_file_name=$file_name;        
       $upload_data=$this->upload_file($path,$size,$allowed_types,$upload_file_name,$new_name);
       return $upload_data;
    }   

/** 
* ////////////////////////////////////////////////////////////////////////////////////////
* ******************************** END OF CLASS ******************************************
* ///////////////////////////////////////////////////////////////////////////////////////
*/

}
	