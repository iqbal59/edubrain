<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit extends Admin_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'edit/';
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
        switch (strtolower($module)) {
            /////////////////edit class
            case 'classes':{
                $this->data['main_content']='edit_class';  
                $this->data['menu']='classes';            
                $this->data['sub_menu']='classes';
                //////////////////////////////////////
                $this->data['row']=$this->class_m->get_by_primary($rid);
            }
            break;   
            /////////////////edit subject
            case 'classlinks':{
                $this->data['main_content']='edit_classlinks';  
                $this->data['menu']='classlinks';            
                $this->data['sub_menu']='classlinks';
                //////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['row']=$this->class_link_m->get_by_primary($rid);
            }
            break;  
            /////////////////edit section
            case 'sections':{
                $this->data['main_content']='edit_section';  
                $this->data['menu']='sections';            
                $this->data['sub_menu']='sections';
                //////////////////////////////////////
                $this->data['row']=$this->section_m->get_by_primary($rid);
            }
            break;  
            /////////////////edit group
            case 'groups':{
                $this->data['main_content']='edit_group';  
                $this->data['menu']='groups';            
                $this->data['sub_menu']='groups';
                //////////////////////////////////////
                $this->data['row']=$this->group_m->get_by_primary($rid);
            }
            break;  
            /////////////////edit subject
            case 'subjects':{
                $this->data['main_content']='edit_subject';  
                $this->data['menu']='subjects';            
                $this->data['sub_menu']='subjects';
                //////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['subject_groups']=$this->subject_group_m->get_values_array('group_id','subject_id',array('subject_id'=>$rid));
                $this->data['row']=$this->subject_m->get_by_primary($rid);
            }
            break;  
            /////////////////edit lesson
            case 'lessons':{
                $this->data['main_content']='edit_lesson';  
                $this->data['menu']='lessons';            
                $this->data['sub_menu']='lessons';
                //////////////////////////////////////
                $this->data['hosts']=$this->root_m->get_hosts();
                $this->data['subjects']=$this->subject_m->get_rows(array(),array('select'=>'mid,name,class_id,group_id'));
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['row']=$this->lesson_m->get_by_primary($rid);
            }
            break;  
            /////////////////edit student
            case 'students':{
                $this->data['main_content']='edit_student';  
                $this->data['menu']='students';            
                $this->data['sub_menu']='students';
                //////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $this->data['row']=$this->student_m->get_by_primary($rid);
            }
            break;  
            /////////////////edit staff
            case 'staff':{
                $this->data['main_content']='edit_staff';  
                $this->data['menu']='staff';            
                $this->data['sub_menu']='staff';
                //////////////////////////////////////
                $this->data['row']=$this->staff_m->get_by_primary($rid);
            }
            break;   
            /////////////////edit student
            case 'chatgroups':{
                $this->data['main_content']='edit_chatgroup';  
                $this->data['menu']='chatgroups';            
                $this->data['sub_menu']='chatgroups';
                //////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $this->data['row']=$this->chat_group_m->get_by_primary($rid);
            }
            break;  
            /////add row
            case 'qbank':{
                //add class
                $this->data['main_content']='edit_qbank';  
                $this->data['menu']='qbank';            
                $this->data['sub_menu']='qbank';
                $this->ANGULAR_INC[]='edit_qbank';
                //////////////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['subjects']=$this->subject_m->get_values_array('','name',array());
                $this->data['row']=$this->qbank_m->get_by_primary($rid);
            }
            break;  
            /////add row
            case 'quiz':{
                //add class
                $this->data['main_content']='edit_quiz';  
                $this->data['menu']='quiz';            
                $this->data['sub_menu']='quiz';
                //////////////////////////////////////////////
                $this->data['row']=$this->quiz_m->get_by_primary($rid);
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $this->data['class']=$this->class_m->get_by_primary($this->data['row']->class_id);
                $this->data['subjects']=$this->subject_m->get_values_array('','name',array('class_id'=>$this->data['row']->class_id));
                //if paper time has started than it can not be edited.
                if(get_minutes_from_time() >= ($this->data['row']->start_time-1) && $this->user_m->todayjd == $this->data['row']->jd){
                    $this->session->set_flashdata('error', 'Unable to edit because paper start time has been passed.');
                    redirect($this->LIB_CONT_ROOT.'detail/mdl/classes/'.$this->data['row']->class_id);                    
                }
            }
            break;  
            /////add row
            case 'paper':{
                //add class
                $this->data['main_content']='edit_paper';  
                $this->data['menu']='paper';            
                $this->data['sub_menu']='paper';
                //////////////////////////////////////////////
                $this->data['row']=$this->paper_m->get_by_primary($rid);
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $this->data['class']=$this->class_m->get_by_primary($this->data['row']->class_id);
                $this->data['subjects']=$this->subject_m->get_values_array('','name',array('class_id'=>$this->data['row']->class_id));
                //if paper time has started than it can not be edited.
                if(get_minutes_from_time() >= ($this->data['row']->start_time-1) && $this->user_m->todayjd == $this->data['row']->jd){
                    $this->session->set_flashdata('error', 'Unable to edit because paper start time has been passed.');
                    redirect($this->LIB_CONT_ROOT.'detail/mdl/classes/'.$this->data['row']->class_id);                    
                }
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
    ////////////////////upload file///////////////////////////////
    private function upload_img($file_name='file',$new_name='',$path){  
        $size='1500';    //1.5MB
        $allowed_types='jpg|jpeg|png|bmp';
        $upload_file_name=$file_name;    
        $min_width=150;
        $min_height=150;
        $upload_data=$this->upload_file($path,$size,$allowed_types,$upload_file_name,$new_name,$min_width,$min_height);
        return $upload_data;
    }  

    /** 
    * /////////////////////////////////////////////////////////////////////
    * *********************** SAVE DATA ***********************************
    * /////////////////////////////////////////////////////////////////////
    */

    // create row
    public function save($module='',$rid=''){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        $get=$this->input->safe_get();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        $redir=$this->CONT_ROOT.'mdl/'.strtolower($module).'/'.$rid;
        switch (strtolower($module)) {
            ///////save class data
            case 'classes':{
                $required=array('name');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter class name');
                        redirect($redir);
                    }
                }   

                //check for necessary data   
                if($this->class_m->get_rows(array('name'=>$form['name'],'mid <>'=>$rid),'',true)>0){
                    $this->session->set_flashdata('error', 'This class name already registered');
                    redirect($redir);
                } 
                $row=$this->class_m->get_by_primary($rid);
                if(!$this->class_m->save($form,$rid)){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);          
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="updated class name($row->name to ".$form['name'].")";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Class name updated successfully.');
                redirect($redir);  
            }
            break;
            ///////save data
            case 'classlinks':{
                $required=array('class_time','zoom_link');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter required information');
                        redirect($redir);
                    }
                } 
                $row=$this->class_link_m->get_by_primary($rid);
                if(!$this->class_link_m->save($form,$rid)){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);          
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="updated zoom class link of subject($row->subject)";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Class updated successfully.');
                redirect($redir);  
            }
            break;
            ///////save section data
            case 'sections':{
                $required=array('name');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter section name');
                        redirect($redir);
                    }
                } 
                //check for necessary data   
                if($this->section_m->get_rows(array('name'=>$form['name'],'mid <>'=>$rid),'',true)>0){
                    $this->session->set_flashdata('error', 'This section name already registered');
                    redirect($redir);
                } 
                $row=$this->section_m->get_by_primary($rid);
                if(!$this->section_m->save($form,$rid)){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);          
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="updated section name($row->name to ".$form['name'].")";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Section name updated successfully.');
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
                if($this->group_m->get_rows(array('name'=>$form['name'],'mid <>'=>$rid),'',true)>0){
                    $this->session->set_flashdata('error', 'This group name already registered');
                    redirect($redir);
                } 
                $row=$this->group_m->get_by_primary($rid);
                if(!$this->group_m->save($form,$rid)){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);          
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="updated group name($row->name to ".$form['name'].")";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Group name updated successfully.');
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
                $row=$this->subject_m->get_by_primary($rid);
                if(!$this->subject_m->save($form,$rid)){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);          
                }

                $data=array('subject_id'=>$row->mid);
                // $slected_groups=
                $subject_groups=$this->subject_group_m->get_values_array('group_id','subject_id',array('subject_id'=>$row->mid));
                //delete existing groups removed by user
                foreach($subject_groups as $key=>$val){
                    if(!in_array($key, $form['groups'])){
                        $this->subject_group_m->delete(NULL,array('subject_id'=>$row->mid,'group_id'=>$key));
                    }
                }
                //validate groups
                if(is_array($form['groups']) && count($form['groups'])>0){
                    foreach($form['groups'] as $grp_id){
                        $data['group_id']=intval($grp_id);
                        if($this->subject_group_m->get_rows($data,'',true)<1){
                            $this->subject_group_m->add_row($data);                            
                        }
                    }
                }
                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="updated subject($row->name)";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Subject updated successfully.');
                redirect($redir);  
            }
            break;
            ///////save data
            case 'lessons':{
                $required=array('name','subject_id','lesson_no','lesson_date');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter required information');
                        redirect($redir);
                    }
                } 
                $row=$this->lesson_m->get_by_primary($rid);
                if($row->lesson_date != $form['lesson_date']){
                    $date_array=explode('.',$form['lesson_date']);
                    $form['lesson_date']=intval($date_array[0]).'-'.month_string(intval($date_array[1])).'-'.intval($date_array[2]);
                    $form['lesson_jd']=get_jd_from_date($form['lesson_date']);
                }
                if($row->subject_id != $form['subject_id']){
                    //subject changed
                    $subject=$this->subject_m->get_by_primary($form['subject_id']);
                    $form['class_id']=$subject->class_id;
                    $form['group_id']=$subject->group_id;
                }
                if(!$this->lesson_m->save($form,$rid)){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);          
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="updated lesson($row->name) of subject($subject->name)";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Lesson updated successfully.');
                redirect($redir);  
            }
            break;
            ///////save data
            case 'staff':{
                $required=array('name','mobile','father_name');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter staff name, father name and mobile number');
                        redirect($redir);
                    }
                } 
                $row=$this->staff_m->get_by_primary($rid);

                //check for necessary data   
                if($this->staff_m->get_rows(array('staff_id'=>$form['staff_id'],'mid <>'=>$rid),'',true)>0){
                    $this->session->set_flashdata('error', 'This id already assigned to another member');
                    redirect($redir);
                } 
                if(!empty($form['password'])){
                    $form['password']=$this->user_m->hash($form['password']);
                }else{
                    unset($form['password']);
                }
                if(!$this->staff_m->save($form,$rid)){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);          
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="updated staff account of($row->name)";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Staff account updated successfully.');
                redirect($redir);  
            }
            break;
            ///////save data
            case 'students':{
                $required=array('name','mobile','father_name');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter student name, father name and mobile number');
                        redirect($redir);
                    }
                } 
                $row=$this->student_m->get_by_primary($rid);

                //check for necessary data   
                if($this->student_m->get_rows(array('student_id'=>$form['student_id'],'mid <>'=>$rid),'',true)>0){
                    $this->session->set_flashdata('error', 'This student id already assigned to another student');
                    redirect($redir);
                } 
                if(!empty($form['password'])){
                    $form['password']=$this->user_m->hash($form['password']);
                }else{
                    unset($form['password']);
                }
                if(!$this->student_m->save($form,$rid)){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);          
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="updated student account of($row->name)";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Student account updated successfully.');
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
                $row=$this->chat_group_m->get_by_primary($rid);
                if(!$this->chat_group_m->save($form,$rid)){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);          
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="updated chat group($row->name)";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Group updated successfully.');
                redirect($redir);  
            }
            break;
            ///////save data
            case 'quiz':{
                $required=array('name','date');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter required information');
                        redirect($redir);
                    }
                } 
                $row=$this->quiz_m->get_by_primary($rid);
                $form['start_time']=get_minutes_from_time($form['start_time'],false);
                $form['jd']=$row->jd;
                if($row->date != $form['date']){
                    $date_array=explode('.',$form['date']);
                    $form['date']=intval($date_array[0]).'-'.month_string(intval($date_array[1])).'-'.intval($date_array[2]);
                    $form['jd']=get_jd_from_date($form['date']);
                }
                if($this->user_m->todayjd >= $form['jd'] && get_minutes_from_time()>=$form['start_time']){
                    $this->session->set_flashdata('error', 'Please select date and time in future');
                    redirect($redir);  
                }
                if(!$this->quiz_m->save($form,$rid)){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);          
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="updated quiz($row->name).";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Quiz updated successfully.');
                redirect($redir);  
            }
            break;
            ///////save data
            case 'paper':{
                $required=array('name','date');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter required information');
                        redirect($redir);
                    }
                } 
                $row=$this->paper_m->get_by_primary($rid);
                $form['start_time']=get_minutes_from_time($form['start_time'],false);
                $form['jd']=$row->jd;
                if($row->date != $form['date']){
                    $date_array=explode('.',$form['date']);
                    $form['date']=intval($date_array[0]).'-'.month_string(intval($date_array[1])).'-'.intval($date_array[2]);
                    $form['jd']=get_jd_from_date($form['date']);
                }
                if($this->user_m->todayjd >= $form['jd'] && get_minutes_from_time()>=$form['start_time']){
                    $this->session->set_flashdata('error', 'Please select date and time in future');
                    redirect($redir);  
                }
                if(!$this->paper_m->save($form,$rid)){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);          
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="updated paper($row->name).";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Paper updated successfully.');
                redirect($redir);  
            }
            break;
            ///////save data
            case 'paperresult':{
                $redir=$this->LIB_CONT_ROOT.'index/paper';
                $required=array();
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter required information');
                        redirect($redir);
                    }
                } 
                $row=$this->paper_m->get_by_primary($rid);
                if($this->user_m->todayjd > $row->jd){
                    $this->session->set_flashdata('error', 'You cannot declare the result before paper date!');
                    redirect($redir);  
                }
                $data=array('show_result'=>$get['status'],'result_date'=>$this->user_m->date);
                if(!$this->paper_m->save($data,$rid)){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);          
                }

                //add data to user history
                $history=array('user_id'=>$this->LOGIN_USER->mid);
                $history['message']="Declared the result of paper($row->name).";
                $this->system_history_m->add_row($history);
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Paper result declaration updated successfully. Student can view result in their portal after declaration.');
                redirect($redir);  
            }
            break;
            ///////save data
            case 'qbank':{
                $required=array('type','question');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please enter required information');
                        redirect($redir);
                    }
                } 
                $row=$this->qbank_m->get_by_primary($rid);
                if(!$this->qbank_m->save($form,$rid)){
                    $this->session->set_flashdata('error', 'Data cannot be saved at this time');
                    redirect($redir);          
                }
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Question updated successfully.');
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
	