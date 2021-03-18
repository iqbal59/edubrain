<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add extends Staff_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'add/';
    }
	
/** 
* ////////////////////////////////////////////////////////////////////////////////
* ***************************** PUBLIC FUNCTIONS *********************************
* ////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index(){
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }

        $this->session->set_flashdata('error', 'Please choose a valid module');
        redirect($this->LIB_CONT_ROOT.'', 'refresh'); 
    }

    public function mdl($module=''){   
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
        ////////////////////////////////////////////////////////////////////////////////     
        $filter=array();
        $params=array();
        $search=array();
        $like=array();
        $form=$this->input->safe_get();
        switch (strtolower($module)) {
            /////add row
            case 'notes':{
                //add notes                
                if(isset($form['sid']) && !empty($form['sid'])){$filter['subject_id']=$form['sid'];}else{echo 'Invalid Subject';exit;}
                $this->data['subject']=$this->subject_m->get_by_primary($form['sid']);
                $this->data['main_content']='add_notes';  
                $this->data['menu']='notes';            
                $this->data['sub_menu']='notes';
            }
            break;  
            /////add row
            case 'homework':{
                //add notes                
                if(isset($form['sid']) && !empty($form['sid'])){$filter['subject_id']=$form['sid'];}else{echo 'Invalid Subject';exit;}
                $this->data['subject']=$this->subject_m->get_by_primary($form['sid']);
                $this->data['main_content']='add_homework';  
                $this->data['menu']='homework';            
                $this->data['sub_menu']='homework';
            }
            break;  
            ///////add row
            case 'lessons':{
                //add class
                $this->data['main_content']='add_lesson';  
                $this->data['menu']='lessons';            
                $this->data['sub_menu']='lessons';
                //////////////////////////////////////////
                $this->data['hosts']=$this->root_m->get_hosts();
                $this->data['subjects']=$this->subject_m->get_rows(array(),array('select'=>'mid,name,class_id,group_id'));
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['my_subjects']=$this->staff_subject_m->get_values_array('','subject_id',array('staff_id'=>$this->LOGIN_USER->mid));
            }
            break;  
            /////add row
            case 'qbank':{
                //add class
                $this->data['main_content']='add_qbank';  
                $this->data['menu']='qbank';            
                $this->data['sub_menu']='qbank';
                $this->ANGULAR_INC[]='add_qbank';
                //////////////////////////////////////////////
                $this->data['subject']=$this->subject_m->get_by_primary($form['sid']);
                $this->data['class']=$this->class_m->get_by_primary($this->data['subject']->class_id);
            }
            break;  
        }

        /////////////////////////////////////////////////////////////
        $this->data['module']=strtolower($module);
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
        $redir=$this->CONT_ROOT.'mdl/homework?sid='.$form['rid'];
        if(empty($form['homework']) ){
            $this->session->set_flashdata('error', "Please write homework");
            redirect($redir);                    
        }
        $subject=$this->subject_m->get_by_primary($form['rid']);
        $entry=array('class_id'=>$subject->class_id,'subject_id'=>$subject->mid);
        $entry['homework']=$form['homework'];
        $entry['date']=$form['date'];
        $entry['section_id']=$form['section_id'];
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
        $this->homework_m->add_row($entry);
        $this->session->set_flashdata('success', 'Homework assigned successfully.');
        redirect($redir);           
    
    }
    //save doc
    public function upload_note(){
        //upload artwork file
        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->LIB_CONT_ROOT.'', 'refresh');                    
        }
        $form=$this->input->safe_post();
        $redir=$this->CONT_ROOT.'mdl/notes?sid='.$form['rid'];
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
        $subject=$this->subject_m->get_by_primary($form['rid']);
        $data=array('file'=>$nfile_name,'class_id'=>$subject->class_id,'subject_id'=>$subject->mid);
        $data['name']=$form['name'];
        $data['about']=$form['about'];
        $this->download_m->add_row($data);
        $this->session->set_flashdata('success', 'Note uploaded successfully.');
        redirect($redir);           
    
    }
    //save profile pic
    public function upload_picture(){
        //upload artwork file
        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->CONT_ROOT.'profile/'.$form['usr'], 'refresh');                    
        }
        $form=$this->input->safe_post();
        $file_name='pic_'.mt_rand(1001,9999);
        $path='./uploads/images/user';
        $data=$this->upload_img('file',$file_name,$path);
        if($data['file_uploaded']==FALSE){
            $this->session->set_flashdata('error', $data['file_error']);
            redirect($this->CONT_ROOT.'profile/'.$form['usr'], 'refresh');
        }
        $nfile_name=$data['file_name'];
        $this->user_m->save(array('image'=>$nfile_name),$form['usr']);
        $this->session->set_flashdata('success', 'Image uploaded successfully.');
        redirect($this->CONT_ROOT.'profile/'.$form['usr'], 'refresh');           
    
    }
    ////////////////////upload file////////////////////////////////
    private function upload_img($file_name='file',$new_name='',$path){  
        $size='1500';    //1.5MB
        $allowed_types='jpg|jpeg|png|bmp';
        $upload_file_name=$file_name;    
        $min_width=150;
        $min_height=150;
        $upload_data=$this->upload_file($path,$size,$allowed_types,$upload_file_name,$new_name,$min_width,$min_height);
        return $upload_data;
    }  

    //upload file
    private function upload_sheet($file_name='file',$new_name=''){ 
       $path='./uploads/temp';
       $size='25220';
       $allowed_types='xls|xlsx';
       $upload_file_name=$file_name;        
       $upload_data=$this->upload_file($path,$size,$allowed_types,$upload_file_name,$new_name);
       return $upload_data;
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
            case 'lessons':{                
                $required=array('name','subject_id','lesson_date');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please provide required information');
                        redirect($redir);
                    }
                }
                $subject=$this->subject_m->get_by_primary($form['subject_id']);
                $form['class_id']=$subject->class_id;
                $form['group_id']=$subject->group_id;
                $form['lesson_no']=$this->lesson_m->get_rows(array('subject_id'=>$form['subject_id']),'',true)+1;
                $date_array=explode('.',$form['lesson_date']);
                $form['lesson_date']=intval($date_array[0]).'-'.month_string(intval($date_array[1])).'-'.intval($date_array[2]);
                $form['lesson_jd']=get_jd_from_date($form['lesson_date']);
                $rid=$this->lesson_m->add_row($form);
                if($rid===false){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Added new lesson(".$form['name'].") of subject($subject->name)";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Lesson added successfully.');
                redirect($redir);
            }
            break;
            ///////save data
            case 'qbank':{                
                $required=array('class_id','subject_id','type','question');
                if(isset($form['type'])){$_SESSION['type']=$form['type'];}
                if(isset($form['chapter'])){$_SESSION['chapter']=$form['chapter'];}
                if(isset($form['topic'])){$_SESSION['topic']=$form['topic'];}
                if(isset($form['marks'])){$_SESSION['marks']=$form['marks'];}
                if(isset($form['difficulty'])){$_SESSION['difficulty']=$form['difficulty'];}
                $redir.='?sid='.$form['subject_id'];
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please provide required data to continue');
                        redirect($redir);
                    }
                }
                $rid=$this->qbank_m->add_row($form);
                if($rid===false){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);
                }
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Question saved successfully.');
                redirect($redir);
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

    // create row
    public function saveQbank(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        //check for necessary required data   
        $required=array('class_id','subject_id','marks','type','question');
        foreach ($required as $key) {
            if(!isset($form[$key]) || empty($form[$key])){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please provide required information ...';
            echo json_encode($this->RESPONSE);exit();
            }
        }   
        $rid=$this->qbank_m->add_row($form);
        if($rid===false){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Process stopped. Please try again later!';
            echo json_encode($this->RESPONSE);exit();            
        }

        //send back the resposne  
        $this->RESPONSE['message']='Saved Successfully.';
        echo json_encode($this->RESPONSE);exit();
    }

/** 
* /////////////////////////////////////////////////////////////////////////////////////
* ************************** END OF CLASS *********************************************
* /////////////////////////////////////////////////////////////////////////////////////
*/

}
	