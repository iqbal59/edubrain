<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add extends Admin_Controller{

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
        $this->session->set_flashdata('error', 'Please choose a valid module');
        redirect($this->LIB_CONT_ROOT.'', 'refresh'); 
    }

    public function mdl($module=''){
        $form=$this->input->safe_get();       
        $this->data['form']=$form; 
        switch (strtolower($module)) {
            /////add row
            case 'datesheet':{
                //add notes  
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                ///////////////////////////////////////////////////////////////////////////////
                $class_id=0;              
                if(isset($form['cid']) && !empty($form['cid'])){$class_id=$form['cid'];}else{echo 'Invalid Class';exit;}
                $this->data['record']=$this->class_m->get_by_primary($class_id);
                $this->data['main_content']='add_datesheet';  
                $this->data['menu']='classes';            
                $this->data['sub_menu']='classes';
            }
            break;  
            /////add row
            case 'syllabus':{
                //add notes  
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                ///////////////////////////////////////////////////////////////////////////////
                $class_id=0;              
                if(isset($form['cid']) && !empty($form['cid'])){$class_id=$form['cid'];}else{echo 'Invalid Class';exit;}
                $this->data['record']=$this->class_m->get_by_primary($class_id);
                $this->data['main_content']='add_syllabus';  
                $this->data['menu']='classes';            
                $this->data['sub_menu']='classes';
            }
            break;   
            /////add row
            case 'timetable':{
                //add notes  
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                ///////////////////////////////////////////////////////////////////////////////
                $class_id=0;              
                if(isset($form['cid']) && !empty($form['cid'])){$class_id=$form['cid'];}else{echo 'Invalid Class';exit;}
                $this->data['record']=$this->class_m->get_by_primary($class_id);
                $this->data['main_content']='add_timetable';  
                $this->data['menu']='classes';            
                $this->data['sub_menu']='classes';
            }
            break;  
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
            /////add row
            case 'classes':{
                //add class
                $this->data['main_content']='add_class';  
                $this->data['menu']='classes';            
                $this->data['sub_menu']='classes';
            }
            break;  
            /////add row
            case 'classlinks':{
                //add class
                $this->data['main_content']='add_classlinks';  
                $this->data['menu']='classlinks';            
                $this->data['sub_menu']='classlinks';
                $this->ANGULAR_INC[]='add_qbank';
                //////////////////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $this->data['teachers']=$this->staff_m->get_values_array('','name',array());
            }
            break;  
            /////add row
            case 'sections':{
                //add class
                $this->data['main_content']='add_section';  
                $this->data['menu']='sections';            
                $this->data['sub_menu']='sections';
            }
            break;  
            /////add row
            case 'groups':{
                //add class
                $this->data['main_content']='add_group';  
                $this->data['menu']='groups';            
                $this->data['sub_menu']='groups';
            }
            break;  
            /////add row
            case 'subjects':{
                //add class
                $this->data['main_content']='add_subject';  
                $this->data['menu']='subjects';            
                $this->data['sub_menu']='subjects';
                //////////////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
            }
            break;  
            /////add row
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
            }
            break;  
            /////add row
            case 'staff':{
                //add class
                $this->data['main_content']='add_staff';  
                $this->data['menu']='staff';            
                $this->data['sub_menu']='staff';
            }
            break;   
            /////add row
            case 'bulkstaff':{
                //add class
                $this->data['main_content']='add_bulkstaff';  
                $this->data['menu']='staff';            
                $this->data['sub_menu']='staff';
                //////////////////////////////////////////////
            }
            break;  
            /////add row
            case 'students':{
                //add class
                $this->data['main_content']='add_student';  
                $this->data['menu']='students';            
                $this->data['sub_menu']='students';
                //////////////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
            }
            break;   
            /////add row
            case 'bulkstudents':{
                //add class
                $this->data['main_content']='add_bulkstudent';  
                $this->data['menu']='students';            
                $this->data['sub_menu']='students';
                //////////////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
            }
            break;  
            /////add row
            case 'chatgroups':{
                //add class
                $this->data['main_content']='add_chatgroup';  
                $this->data['menu']='chatgroups';            
                $this->data['sub_menu']='chatgroups';
                //////////////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
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
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['subjects']=$this->subject_m->get_values_array('','name',array());
            }
            break;   
            /////add row
            case 'bulkqbank':{
                //add class
                $this->data['main_content']='add_bulkqbank';  
                $this->data['menu']='qbank';            
                $this->data['sub_menu']='qbank';
                $this->ANGULAR_INC[]='add_qbank';
                //////////////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['subjects']=$this->subject_m->get_values_array('','name',array());
            }
            break;  
        }

        /////////////////////////////////////////////////////////////
        $this->data['module']=strtolower($module);
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
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
    //save doc
    public function upload_datesheet(){
        //upload artwork file
        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->LIB_CONT_ROOT.'', 'refresh');                    
        }
        $form=$this->input->safe_post();
        $redir=$this->CONT_ROOT.'mdl/datesheet?cid='.$form['rid'];
        $file_name='doc_'.time().mt_rand(101,999);
        $path='./uploads/files/docs';
        if (!file_exists($path)) {
            @mkdir($path, 0777, true);
        }
        $data=$this->upload_img('file',$file_name,$path);
        if($data['file_uploaded']==FALSE){
            $this->session->set_flashdata('error', $data['file_error']);
            redirect($redir);
        }
        $nfile_name=$data['file_name'];
        $data=array('file'=>$nfile_name,'class_id'=>$form['rid']);
        $data['title']=$form['title'];
        isset($form['section_id']) && !empty($form['section_id']) ? $data['section_id']=$form['section_id'] : '';
        $this->datesheet_m->add_row($data);
        $this->session->set_flashdata('success', 'File uploaded successfully.');
        redirect($redir);           
    
    }
    //save doc
    public function upload_syllabus(){
        //upload artwork file
        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->LIB_CONT_ROOT.'', 'refresh');                    
        }
        $form=$this->input->safe_post();
        $redir=$this->CONT_ROOT.'mdl/syllabus?cid='.$form['rid'];
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
        $data=array('file'=>$nfile_name,'class_id'=>$form['rid']);
        $data['title']=$form['title'];
        isset($form['section_id']) && !empty($form['section_id']) ? $data['section_id']=$form['section_id'] : '';
        $this->syllabus_m->add_row($data);
        $this->session->set_flashdata('success', 'File uploaded successfully.');
        redirect($redir);           
    
    }
    //save doc
    public function upload_timetable(){
        //upload artwork file
        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->LIB_CONT_ROOT.'', 'refresh');                    
        }
        $form=$this->input->safe_post();
        $redir=$this->CONT_ROOT.'mdl/timetable?cid='.$form['rid'];
        $file_name='doc_'.time().mt_rand(101,999);
        $path='./uploads/files/docs';
        if (!file_exists($path)) {
            @mkdir($path, 0777, true);
        }
        $data=$this->upload_img('file',$file_name,$path);
        if($data['file_uploaded']==FALSE){
            $this->session->set_flashdata('error', $data['file_error']);
            redirect($redir);
        }
        $nfile_name=$data['file_name'];
        $data=array('file'=>$nfile_name,'class_id'=>$form['rid']);
        $data['title']=$form['title'];
        isset($form['section_id']) && !empty($form['section_id']) ? $data['section_id']=$form['section_id'] : '';
        $this->timetable_m->add_row($data);
        $this->session->set_flashdata('success', 'File uploaded successfully.');
        redirect($redir);           
    
    }
    ////////////////////upload file///////////////////////////////
    private function upload_img($file_name='file',$new_name='',$path){  
        $size='2500';    //1.5MB
        $allowed_types='jpg|jpeg|png|bmp';
        $upload_file_name=$file_name;    
        $min_width=32;
        $min_height=32;
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
        $redir=$this->CONT_ROOT.'mdl/'.strtolower($module).'';
        switch (strtolower($module)) {
            ///////save data
            case 'classes':{                
                $required=array('name');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter class name');
                        redirect($redir);
                    }
                }
                //check for necessary data   
                if($this->class_m->get_rows(array('name'=>$form['name']),'',true)>0){
                    $this->session->set_flashdata('error', 'This class name already registered');
                    redirect($redir);
                } 
                $rid=$this->class_m->add_row($form);
                if($rid===false){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Registered new class(".$form['name'].")";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Class name registered successfully.');
                redirect($redir);
            }
            break;
            ///////save data
            case 'classlinks':{                
                $required=array('subject_id','class_id','class_time','zoom_link');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter required information');
                        redirect($redir);
                    }
                }
                $subject=$this->subject_m->get_by_primary($form['subject_id']);
                $teacher=$this->staff_m->get_by_primary($form['teacher_id']);
                $form['subject']=$subject->name;
                $form['teacher_name']=$teacher->name;
                $rid=$this->class_link_m->add_row($form);
                if($rid===false){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Registered new zoom class of subject(".$form['subject'].")";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Class registered successfully.');
                redirect($redir);
            }
            break;
            ///////save data
            case 'sections':{                
                $required=array('name');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter section name');
                        redirect($redir);
                    }
                }
                //check for necessary data   
                if($this->section_m->get_rows(array('name'=>$form['name']),'',true)>0){
                    $this->session->set_flashdata('error', 'This section name already registered');
                    redirect($redir);
                } 
                $rid=$this->section_m->add_row($form);
                if($rid===false){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Registered new class section(".$form['name'].")";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Section name registered successfully.');
                redirect($redir);
            }
            break;
            ///////save data
            case 'groups':{                
                $required=array('name');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter group name');
                        redirect($redir);
                    }
                }
                //check for necessary data   
                if($this->group_m->get_rows(array('name'=>$form['name']),'',true)>0){
                    $this->session->set_flashdata('error', 'This group name already registered');
                    redirect($redir);
                } 
                $rid=$this->group_m->add_row($form);
                if($rid===false){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Registered new class group(".$form['name'].")";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Group name registered successfully.');
                redirect($redir);
            }
            break;
            ///////save data
            case 'subjects':{                
                $required=array('name','class_id');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter subject name and select class');
                        redirect($redir);
                    }
                }
                if($this->subject_m->get_rows(array('class_id'=>$form['class_id'],'name'=>$form['name']),'',true)>0){                    
                    $this->session->set_flashdata('error', 'This subject already registered for this class!');
                    redirect($redir);
                }
                $rid=$this->subject_m->add_row($form);
                if($rid===false){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);
                }
                $data=array('subject_id'=>$rid);
                if(is_array($form['groups']) && count($form['groups'])>0){
                    foreach($form['groups'] as $grp_id){
                        $data['group_id']=intval($grp_id);
                        $this->subject_group_m->add_row($data);
                    }
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Registered new subject(".$form['name'].")";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Subject registered successfully.');
                redirect($redir);
            }
            break;
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
            case 'staff':{                
                $required=array('name','father_name','mobile');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter staff name, father name and mobile number');
                        redirect($redir);
                    }
                }
                $form['staff_id']='lms-'.mt_rand(1111,9999);
                $name_array=explode(" ",$form['name']);
                if(isset($name_array[0])){$form['staff_id']=strtolower(trim($name_array[0])).mt_rand(111,999);}
                //check for necessary data   
                if($this->staff_m->get_rows(array('staff_id'=>$form['staff_id']),'',true)>0){
                    $form['staff_id']=$form['staff_id'].mt_rand(1,9);
                } 
                $rid=$this->staff_m->add_row($form);
                if($rid===false){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Registered new teacher(".$form['name'].")";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Staff registered successfully.');
                redirect($redir);
            }
            break;
            ///////save data
            case 'bulkstaff':{    
                set_time_limit(60*30);  //30 minutes            
                $required=array('');
                $is_error=false;
                // foreach ($required as $key) {
                //     if(!isset($form[$key]) || empty($form[$key])){
                //         $this->session->set_flashdata('error', 'Please select class');
                //         redirect($redir);
                //     }
                // }

                $new_file_name='file_'.date('ymdhis').mt_rand(11,99);
                $data=$this->upload_sheet('file',$new_file_name);
                if($data['file_uploaded']==FALSE){
                    $this->session->set_flashdata('error', $data['file_error']);
                    redirect($redir);
                }
                $file_name=$data['file_name']; 
                ///////EVERY THING IS FINE PROCESS FILE TO GET CONTACTS/////
                $staffs=array();
                $saved_staff=0; 
                $total_staff=0;
                ////////////////////////////////////////////////////////////
                ////////////////////////////////////////////////////////////
                //excel file is uploaded
                $this->load->library('excel');
                $file='./uploads/temp/'.$file_name;
                //read file from path
                $obj=  PHPExcel_IOFactory::load($file);
                
                $lastColumn ='E';
                $staff=array();
                $staff['status']=$this->staff_m->STATUS_ACTIVE;
                $staff['date']=$this->staff_m->date;
                $staff['image']='default.png';

                $i=0;
                foreach($obj->getActiveSheet()->getRowIterator() as $rowIndex => $row) {
                    //Convert the cell data from this row to an array of values
                    //just as though you'd retrieved it using fgetcsv()
                    $i++;
                    if($i<=1){continue;}
                    $this_row = $obj->getActiveSheet()->rangeToArray('A'.$rowIndex.':'.$lastColumn.$rowIndex);
                    $total_staff++;
                    $s_name=trim($this_row[0][0]);
                    $father_name=trim($this_row[0][1]);
                    $mobile=trim($this_row[0][2]);
                    $city=trim($this_row[0][3]);
                    $address=trim($this_row[0][4]);

                    if(!empty($s_name) && !empty($father_name) ){
                        $staff['staff_id']='lms-'.mt_rand(1111,9999);
                        $name_array=explode(" ",$s_name);
                        if(isset($name_array[0])){$staff['staff_id']=strtolower(trim($name_array[0])).mt_rand(1111,9999);}
                        $staff['password']=mt_rand(111,999);
                        $staff['name']=$s_name;
                        $staff['father_name']=$father_name;
                        $staff['mobile']=$mobile;
                        $staff['city']=$city;
                        $staff['address']=$address;
                        /////////////////////////////////////////
                        array_push($staffs,$staff);
                        $saved_staff++;
                    }else{
                        $is_error=true;
                    }
                }


                if($saved_staff>0 && $is_error==false){
                    $this->staff_m->save_batch($staffs);
                    $this->session->set_flashdata('success', $saved_staff.' staff members saved from total '.$total_staff.' staff successfully.');
                }else{
                    $this->session->set_flashdata('error', 'Missing required data.');
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Registered imported an excel file in staff module";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                redirect($redir);
            }
            break;
            ///////save data
            case 'students':{                
                $required=array('name','father_name','mobile','class_id');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter student name, father name and mobile number');
                        redirect($redir);
                    }
                }
                $form['student_id']='lms-'.mt_rand(1111,9999);
                $name_array=explode(" ",$form['name']);
                if(isset($name_array[0])){$form['student_id']=strtolower(trim($name_array[0])).mt_rand(111,999);}
                //check for necessary data   
                if($this->student_m->get_rows(array('student_id'=>$form['student_id']),'',true)>0){
                    $form['student_id']=$form['student_id'].mt_rand(1,9);
                } 
                $rid=$this->student_m->add_row($form);
                if($rid===false){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Registered new student(".$form['name'].")";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Student registered successfully.');
                redirect($redir);
            }
            break;
            ///////save data
            case 'bulkstudents':{    
                set_time_limit(60*30);  //30 minutes            
                $required=array('class_id');
                $is_error=false;
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please select class');
                        redirect($redir);
                    }
                }

                $class=$this->class_m->get_by_primary($form['class_id']);
                $new_file_name='file_'.date('ymdhis').mt_rand(11,99);
                $data=$this->upload_sheet('file',$new_file_name);
                if($data['file_uploaded']==FALSE){
                    $this->session->set_flashdata('error', $data['file_error']);
                    redirect($redir);
                }
                $file_name=$data['file_name']; 
                ///////EVERY THING IS FINE PROCESS FILE TO GET CONTACTS/////
                $students=array();
                $saved_students=0; 
                $total_students=0;
                ////////////////////////////////////////////////////////////
                ////////////////////////////////////////////////////////////
                //excel file is uploaded
                $this->load->library('excel');
                $file='./uploads/temp/'.$file_name;
                //read file from path
                $obj=  PHPExcel_IOFactory::load($file);
                
                $lastColumn ='F';
                $student=array();
                $student['class_id']=$form['class_id'];
                $student['section_id']=$form['section_id'];
                $student['group_id']=$form['group_id'];
                $student['status']=$this->student_m->STATUS_ACTIVE;
                $student['date']=$this->student_m->date;
                $student['image']='default.png';

                $i=0;
                foreach($obj->getActiveSheet()->getRowIterator() as $rowIndex => $row) {
                    //Convert the cell data from this row to an array of values
                    //just as though you'd retrieved it using fgetcsv()
                    $i++;
                    if($i<=1){continue;}
                    $this_row = $obj->getActiveSheet()->rangeToArray('A'.$rowIndex.':'.$lastColumn.$rowIndex);
                    $total_students++;
                    $s_name=trim($this_row[0][0]);
                    $father_name=trim($this_row[0][1]);
                    $mobile=trim($this_row[0][2]);
                    $roll_number=trim($this_row[0][3]);
                    $city=trim($this_row[0][4]);
                    $address=trim($this_row[0][5]);

                    if(!empty($s_name) && !empty($father_name) ){
                        $student['student_id']='lms-'.mt_rand(111,999);
                        $name_array=explode(" ",$s_name);
                        if(isset($name_array[0])){$student['student_id']=strtolower(trim($name_array[0])).mt_rand(1111,9999);}
                        $student['password']=mt_rand(111,999);
                        $student['name']=$s_name;
                        $student['father_name']=$father_name;
                        $student['mobile']=$mobile;
                        $student['city']=$city;
                        $student['address']=$address;
                        $student['roll_number']=$roll_number;
                        /////////////////////////////////////////
                        array_push($students,$student);
                        $saved_students++;
                    }else{
                        $is_error=true;
                    }
                }


                if($saved_students>0 && $is_error==false){
                    $this->student_m->save_batch($students);
                    $this->session->set_flashdata('success', $saved_students.' students saved from total '.$total_students.' students successfully.');
                }else{
                    $this->session->set_flashdata('error', 'Missing required data.');
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Registered imported an excel file in students module";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                redirect($redir);
            }
            break;
            ///////save data
            case 'chatgroups':{                
                $required=array('name');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter group name');
                        redirect($redir);
                    }
                }
                $rid=$this->chat_group_m->add_row($form);
                if($rid===false){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="created new chat group(".$form['name'].")";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Group created successfully.');
                redirect($redir);
            }
            break;
            ///////save data
            case 'qbank':{                
                $required=array('class_id','subject_id','type','question');
                if(isset($form['class_id'])){$_SESSION['class_id']=$form['class_id'];}
                if(isset($form['subject_id'])){$_SESSION['subject_id']=$form['subject_id'];}
                if(isset($form['type'])){$_SESSION['type']=$form['type'];}
                if(isset($form['chapter'])){$_SESSION['chapter']=$form['chapter'];}
                if(isset($form['topic'])){$_SESSION['topic']=$form['topic'];}
                if(isset($form['marks'])){$_SESSION['marks']=$form['marks'];}
                if(isset($form['difficulty'])){$_SESSION['difficulty']=$form['difficulty'];}
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
            ///////save data
            case 'bulkqbank':{    
                set_time_limit(60*30);  //30 minutes            
                $required=array('class_id','subject_id');
                $is_error=false;
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please select class and subject');
                        redirect($redir);
                    }
                }

                $class=$this->class_m->get_by_primary($form['class_id']);
                $new_file_name='qbfile_'.date('ymdhis').mt_rand(11,99);
                $data=$this->upload_sheet('file',$new_file_name);
                if($data['file_uploaded']==FALSE){
                    $this->session->set_flashdata('error', $data['file_error']);
                    redirect($redir);
                }
                $file_name=$data['file_name']; 
                ///////EVERY THING IS FINE PROCESS FILE TO GET CONTACTS/////
                $questions=array();
                $saved_questions=0; 
                $total_questions=0;
                ////////////////////////////////////////////////////////////
                ////////////////////////////////////////////////////////////
                //excel file is uploaded
                $this->load->library('excel');
                $file='./uploads/temp/'.$file_name;
                //read file from path
                $obj=  PHPExcel_IOFactory::load($file);
                
                $lastColumn ='L';
                $question=array();
                $question['class_id']=$form['class_id'];
                $question['subject_id']=$form['subject_id'];
                $question['day']=$this->qbank_m->day;
                $question['month']=$this->qbank_m->month;
                $question['year']=$this->qbank_m->year;
                $question['difficulty']=50;

                $i=0;
                foreach($obj->getActiveSheet()->getRowIterator() as $rowIndex => $row) {
                    //Convert the cell data from this row to an array of values
                    //just as though you'd retrieved it using fgetcsv()
                    $i++;
                    if($i<=1){continue;}
                    $this_row = $obj->getActiveSheet()->rangeToArray('A'.$rowIndex.':'.$lastColumn.$rowIndex);
                    $total_questions++;
                    isset($this_row[0][0]) ? $type=trim($this_row[0][0]):'';
                    isset($this_row[0][1]) ? $marks=trim($this_row[0][1]):'';
                    isset($this_row[0][2]) ? $q_statement=trim($this_row[0][2]):'';
                    isset($this_row[0][3]) ? $option1=trim($this_row[0][3]):'';
                    isset($this_row[0][4]) ? $option2=trim($this_row[0][4]):'';
                    isset($this_row[0][5]) ? $option3=trim($this_row[0][5]):'';
                    isset($this_row[0][6]) ? $option4=trim($this_row[0][6]):'';
                    isset($this_row[0][7]) ? $answer=trim($this_row[0][7]):'';
                    isset($this_row[0][8]) ? $hint=trim($this_row[0][8]):'';
                    isset($this_row[0][9]) ? $topic=trim($this_row[0][9]):'';
                    isset($this_row[0][10]) ? $detail=trim($this_row[0][10]):'';
                    isset($this_row[0][11]) ? $solution=trim($this_row[0][11]):'';

                    if(!empty($type) && !empty($marks) && !empty($q_statement) ){
                        $question['type']=strtolower($type);
                        $question['marks']=intval($marks);
                        $question['question']=$q_statement;
                        $question['option1']=$option1;
                        $question['option2']=$option2;
                        $question['option3']=$option3;
                        $question['option4']=$option4;
                        $question['answer']=intval($answer);
                        $question['hint']=$hint;
                        $question['topic']=$topic;
                        $question['detail']=$detail;
                        $question['solution']=$solution;
                        /////////////////////////////////////////
                        array_push($questions,$question);
                        $saved_questions++;
                    }else{
                        $is_error=true;
                    }
                }


                if($saved_questions>0 && $is_error==false){
                    $this->qbank_m->save_batch($questions);
                    $this->session->set_flashdata('success', $saved_questions.' questions saved from total '.$total_questions.' questions successfully.');
                }else{
                    $this->session->set_flashdata('error', 'Missing required data.');
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="imported an excel file in questions bank module";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
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

    /** 
    * /////////////////////////////////////////////////////////////////////
    * *********************** AJAX FUNCTIONS ******************************
    * /////////////////////////////////////////////////////////////////////
    */

    // filter rows
    public function filterSubjects(){
        // get input fields into array
        $filter=array();
        $params=array();
        $search=array();
        $like=array();
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_get();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        ////////////////////////////////////////////////////////////////////////////////
        isset($form['class_id'])&&!empty($form['class_id']) ? $filter['class_id']=$form['class_id'] : '';
        if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
        ///////////////////////////////////////////
        isset($form['sortby'])&&!empty($form['sortby']) ? $params['orderby']=$form['sortby'] : $params['orderby']='name ASC';
        $params['select']='name,';
        $this->RESPONSE['rows']=$this->subject_m->get_rows($filter,$params);
        ////////////////////////////////////////////////////////////////////////
        echo json_encode( $this->RESPONSE);
        
    }

    // create row
    public function saveQbank(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        //check for necessary required data   
        $required=array('class_id','subject_id','type','question');
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
	