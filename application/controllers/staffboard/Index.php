<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends Staff_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'index/';
    }
    
/** 
* ////////////////////////////////////////////////////////////////////////////////
* ***************************** PUBLIC FUNCTIONS *********************************
* ////////////////////////////////////////////////////////////////////////////////
*/  
    // default function for this controller (index) 
    public function index($module=''){

        $filter=array();
        $params=array();
        $search=array();
        $like=array();
        $form=$this->input->safe_get();   
        $this->data['form']=$form;
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
        /////////////////////////////////////////////////////////////////////////
        switch (strtolower($module)) { 
            case 'notes':{
                //add class
                $this->data['main_content']='index_notes';  
                $this->data['menu']='notes';            
                $this->data['sub_menu']='notes';
                ///////////////////////////////////////////////////////////////
                if(isset($form['name'])&&!empty($form['name'])){$like['name']=$form['name'];}
                count($like)>0 ? $params['like']=$like : '';
                ///////////////////////////////////////////////////////////////
                if(isset($form['sid']) && !empty($form['sid'])){$filter['subject_id']=$form['sid'];}else{echo 'Invalid Subject';exit;}
                $params['select']='mid,class_id,subject_id,name,about,file';
                $this->data['rows']=$this->download_m->get_rows($filter,$params);
                $this->data['subject']=$this->subject_m->get_by_primary($form['sid']);
                $this->data['cls']=$this->class_m->get_by_primary($this->data['subject']->class_id);
            }
            break;
            case 'homework':{
                //add class
                $this->data['main_content']='index_homework';  
                $this->data['menu']='homework';            
                $this->data['sub_menu']='homework';
                ///////////////////////////////////////////////////////////////
                if(isset($form['date'])&&!empty($form['date'])){$like['date']=$form['date'];}
                count($like)>0 ? $params['like']=$like : '';
                ///////////////////////////////////////////////////////////////
                if(isset($form['sid']) && !empty($form['sid'])){$filter['subject_id']=$form['sid'];}else{echo 'Invalid Subject';exit;}
                $this->data['subject']=$this->subject_m->get_by_primary($form['sid']);
                $this->data['cls']=$this->class_m->get_by_primary($this->data['subject']->class_id);
                $params['select']='mid,class_id,subject_id,homework,instructions,file,date';
                $this->data['rows']=$this->homework_m->get_rows($filter,$params);
            }
            break;
            case 'students':{
                //add class
                $this->data['main_content']='index_student';  
                $this->data['menu']='students';            
                $this->data['sub_menu']='students';
                if(isset($form['sid']) && !empty($form['sid'])){$subject=$this->subject_m->get_by_primary($form['sid']);}else{exit();}
                $filter['class_id']=$subject->class_id;
                ///////////////////////////////////////////////////////////////
                if(isset($form['name'])&&!empty($form['name'])){$like['name']=$form['name'];}
                count($like)>0 ? $params['like']=$like : '';
                if(isset($form['student_id'])&&!empty($form['student_id'])){$filter['student_id']=$form['student_id'];}
                if(isset($form['section_id'])&&!empty($form['section_id'])){$filter['section_id']=$form['section_id'];}
                ///////////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $params['select']='mid,name,student_id,mobile,image,father_name,dob,city,state,address,blood_group,religion,status,date,roll_number,class_id,group_id,section_id';
                $this->data['rows']=$this->student_m->get_rows($filter,$params);
            }
            break; 
            case 'lessons':{
                //add class
                $this->data['main_content']='index_lessons';  
                $this->data['menu']='lessons';            
                $this->data['sub_menu']='lessons';
                $cls_filter=array();
                ///////////////////////////////////////////////////////////////
                if(isset($form['name'])&&!empty($form['name'])){$like['name']=$form['name'];}
                if(isset($form['date'])&&!empty($form['date'])){
                    $date_array=explode('.',$form['date']);
                    $date=intval($date_array[0]).'-'.month_string(intval($date_array[1])).'-'.intval($date_array[2]);
                    $like['lesson_date']=$date;
                }
                count($like)>0 ? $params['like']=$like : '';
                ///////////////////////////////////////////////////////////////
                $this->data['subjects']=$this->subject_m->get_values_array('','name',array());
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                if(isset($form['sid']) && !empty($form['sid'])){$filter['subject_id']=$form['sid'];}
                $params['select']='mid,class_id,group_id,subject_id,name,about,host,video_link,lesson_no,lesson_date';
                $this->data['rows']=$this->lesson_m->get_rows($filter,$params);
                $this->data['my_subjects']=$this->staff_subject_m->get_values_array('','subject_id',array('staff_id'=>$this->LOGIN_USER->mid));
            }
            break;  
            case 'chatgroups':{
                //add class
                $this->data['main_content']='index_chatgroups';  
                $this->data['menu']='chatgroups';            
                $this->data['sub_menu']='chatgroups';
                ///////////////////////////////////////////////////////////////
                $search=array('name');
                if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
                isset($form['search']) ? $params['like']=$like : '';
                ///////////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $params['select']='mid,name,date,class_id,group_id,section_id';
                $this->data['rows']=$this->chat_group_m->get_rows($filter,$params);
            }
            break;  
            case 'messages':{
                //add class
                $this->data['main_content']='index_messages';  
                $this->data['menu']='messages';            
                $this->data['sub_menu']='messages';
                ///////////////////////////////////////////////////////////////
                $search=array('name');
                if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
                isset($form['search']) ? $params['like']=$like : '';
                ///////////////////////////////////////////
                $this->data['staff']=$this->staff_m->get_values_array('','name',array());
                $this->data['students']=$this->student_m->get_values_array('','name',array());
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $params['select']='mid,name,date,staff_id,student_id,stf_update,std_update';
                $params['orderby']='stf_update DESC';
                $filter['staff_id']=$this->LOGIN_USER->mid;
                $this->data['rows']=$this->chat_m->get_rows($filter,$params);
            }
            break; 
            case 'subjects':{
                //add class
                $this->data['main_content']='index_subjects';  
                $this->data['menu']='subjects';            
                $this->data['sub_menu']='subjects';
                ///////////////////////////////////////////////////////////////
                $search=array('name');
                if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
                isset($form['search']) ? $params['like']=$like : '';
                ///////////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $params['select']='mid,class_id,group_id,name';
                $params['orderby']='class_id ASC, group_id ASC, name ASC';

                $this->data['rows']=array();
                $my_subjects=$this->staff_subject_m->get_column_array('subject_id',array('staff_id'=>$this->LOGIN_USER->mid));
                $params['where_in']=array('mid'=>$my_subjects);
                if(is_array($my_subjects)&&count($my_subjects)>0){
                    $this->data['rows']=$this->subject_m->get_rows($filter,$params);                    
                }
            }
            break;   
            case 'qbank':{
                //add class
                $this->data['main_content']='index_qbank';  
                $this->data['menu']='qbank';            
                $this->data['sub_menu']='qbank';
                ///////////////////////////////////////////////////////////////
                if(isset($form['sid'])&&!empty($form['sid'])){$filter['subject_id']=$form['sid']; }
                $search=array('name');
                if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
                isset($form['search']) ? $params['like']=$like : '';
                ///////////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['subject']=$this->subject_m->get_by_primary($form['sid']);
                $this->data['subjects']=$this->subject_m->get_values_array('','name',array());
                $params['select']='mid,class_id,subject_id,lesson_id,chapter,question,hint,type,marks,difficulty';
                $this->data['rows']=$this->qbank_m->get_rows($filter,$params);
            }
            break;   
            case 'quiz':{
                //add class
                $this->data['main_content']='index_quiz';  
                $this->data['menu']='qbank';            
                $this->data['sub_menu']='qbank';
                ///////////////////////////////////////////////////////////////
                if(isset($form['sid'])&&!empty($form['sid'])){$filter['subject_id']=$form['sid']; } else {  redirect($this->LIB_CONT_ROOT);}
                $search=array('name');
                if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
                isset($form['search']) ? $params['like']=$like : '';
                ///////////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $this->data['subject']=$this->subject_m->get_by_primary($form['sid']);
                $params['select']='class_id,section_id,subject_id,name,marks,date,jd,start_time';
                $params['orderby']='jd DESC, start_time ASC';
                $this->data['rows']=$this->quiz_m->get_rows($filter,$params);
            }
            break;   
            case 'paper':{
                //add class
                $this->data['main_content']='index_paper';  
                $this->data['menu']='qbank';            
                $this->data['sub_menu']='qbank';
                ///////////////////////////////////////////////////////////////
                if(isset($form['sid'])&&!empty($form['sid'])){$filter['subject_id']=$form['sid']; }else { redirect($this->LIB_CONT_ROOT);}
                $search=array('name');
                if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
                isset($form['search']) ? $params['like']=$like : '';
                ///////////////////////////////////////////
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $this->data['subject']=$this->subject_m->get_by_primary($form['sid']);
                $params['select']='class_id,section_id,subject_id,name,marks,date,jd,start_time';
                $params['orderby']='jd DESC, start_time ASC';
                $this->data['rows']=$this->paper_m->get_rows($filter,$params);
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
    * *********************** AJAX FUNCTIONS ******************************
    * /////////////////////////////////////////////////////////////////////
    */

    // filter rows
    public function filter(){
        // get input fields into array
        $filter=array();
        $params=array();
        $search=array('name','mobile','email');
        $like=array();
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_get();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
        ///////////////////////////////////////////
        $params['limit']=$this->PAGE_LIMIT;
        isset($form['page']) ? $params['offset']=intval($form['page'])*$this->PAGE_LIMIT : '';
        isset($form['sortby'])&&!empty($form['sortby']) ? $params['orderby']=$form['sortby'] : $params['orderby']='mid DESC';
        isset($form['search']) ? $params['like']=$like : '';
        $params['select']='name,email,mobile,image,city,address,reset_code,status,type,auth,date,2fa_enabled';
        $this->RESPONSE['rows']=$this->user_m->get_rows($filter,$params);
        $this->RESPONSE['total_rows']=$this->user_m->get_rows($filter,'',true);
        ////////////////////////////////////////////////////////////////////////
        echo json_encode( $this->RESPONSE);
        
    }

    // create row
    public function add(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        $this->RESPONSE['message']=' Registered Successfully.';
        //check for necessary required data   
        $required=array('name','email','mobile','password');
        foreach ($required as $key) {
            if(!isset($form[$key]) || empty($form[$key])){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please provide required information ...';
            echo json_encode($this->RESPONSE);exit();
            }
        }   
        //check for necessary data   
        if($this->user_m->get_rows(array('email'=>$form['email']),'',true)>0){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Email already registered! Please choose another name...';
            echo json_encode($this->RESPONSE);exit();
        } 
        $rid=$this->user_m->add_row($form);
        if($rid===false){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Process stopped. Please try again later!';
            echo json_encode($this->RESPONSE);exit();            
        }

        //add data to user history
        $history=array('user_id'=>$this->LOGIN_USER->mid);
        $history['message']="Registered new user account for(".$form['name'].")";
        $this->system_history_m->add_row($history);

        //send back the resposne  
        echo json_encode($this->RESPONSE);exit();
    }

    // update row
    public function update(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        //check for necessary required data   
        $required=array('rid','name');
        foreach ($required as $key) {
            if(!isset($form[$key]) || empty($form[$key])){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please provide required information ...';
            echo json_encode($this->RESPONSE);exit();
            }
        }   
        //save data in database                
        if($this->user_m->save($form,$form['rid'])===false){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Process stopped. Please try again later!';
            echo json_encode($this->RESPONSE);exit();            
        } 

        //send back the resposne
        $this->RESPONSE['message']=' Data Saved Successfully.';  
        echo json_encode($this->RESPONSE);exit();
    }

    // load single row
    public function load(){
        // get input fields into array
        $filter=array();
        $params=array();
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_get();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        isset($form['rid']) ? $rid=$form['rid'] : $rid='';
        ///////////////////////////////////////////////////////////////////////////////////////////
        if(empty($rid)|| $this->user_m->get_rows(array('mid'=>$rid),'',true)<1){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please choose a valid record...';
            echo json_encode($this->RESPONSE);exit();
        }
        $row=$this->user_m->get_by_primary($rid);
        
        //send back resposne
        $this->RESPONSE['output']=$row;        
        echo json_encode($this->RESPONSE);
    }

    // update row
    public function delete(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        isset($form['rid']) ? $rid=$form['rid'] : $rid='';
        //check for demo   
        if($this->IS_DEMO){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']=$this->config->item('app_demo_del_err');
            echo json_encode($this->RESPONSE);exit();
        }
        //check for necessary data   
        if(empty($rid)){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please choose a valid record.';
            echo json_encode($this->RESPONSE);exit();
        }
        $row=$this->user_m->get_by_primary($form['rid']); 

        if($this->user_m->delete($rid)==false){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Process stopped. Please try again later!';
            echo json_encode($this->RESPONSE);exit();
        }

        //add data to user history
        $history=array('user_id'=>$this->LOGIN_USER->mid);
        $history['message']="Removed user account($row->name, $row->email, $row->mobile)";
        $this->system_history_m->add_row($history);

        //send back the resposne
        $this->RESPONSE['message']='Removed Successfully.';  
        echo json_encode($this->RESPONSE);exit();
    }


    /////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////


    // filter rows
    public function filterMasks(){
        // get input fields into array
        $filter=array();
        $params=array();
        $search=array('mask_id');
        $like=array();
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_get();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        ////////////////////////////////////////////////////////////////////////////////
        //check for necessary required data   
        $required=array('rid');
        foreach ($required as $key) {
            if(!isset($form[$key]) || empty($form[$key])){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please provide required information ...';
            echo json_encode($this->RESPONSE);exit();
            }
        } 
        isset($form['rid']) && !empty($form['rid']) ? $filter['user_id']=$form['rid'] : '';
        if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
        ///////////////////////////////////////////
        $params['limit']=$this->PAGE_LIMIT;
        isset($form['page']) ? $params['offset']=intval($form['page'])*$this->PAGE_LIMIT : '';
        isset($form['sortby'])&&!empty($form['sortby']) ? $params['orderby']=$form['sortby'] : $params['orderby']='mid DESC';
        isset($form['search']) ? $params['like']=$like : '';
        $this->RESPONSE['rows']=$this->user_masking_m->get_rows($filter,$params);
        $this->RESPONSE['total_rows']=$this->user_masking_m->get_rows($filter,'',true);
        ////////////////////////////////////////////////////////////////////////
        $countries=$this->country_m->get_values_array('','name',array());
        $i=0;
        foreach ($this->RESPONSE['rows'] as $row) {
            $masking=$this->system_masking_m->get_by_primary($row['mask_id']);
            $this->RESPONSE['rows'][$i]['masking']=$masking->name;
            if($masking->country_id>0){$this->RESPONSE['rows'][$i]['country']=$countries[$masking->country_id];}
            $i++;
        }
        ////////////////////////////////////////////////////////////////////////
        echo json_encode( $this->RESPONSE);        
    }
    // create row
    public function addMask(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        //check for necessary required data   
        $required=array('rid','mask_id');
        foreach ($required as $key) {
            if(!isset($form[$key]) || empty($form[$key])){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please provide required information ...';
            echo json_encode($this->RESPONSE);exit();
            }
        } 
        $user=$this->user_m->get_by_primary($form['rid']);
        $mask=$this->system_masking_m->get_by_primary($form['mask_id']);
        $form['user_id']=$form['rid'];
        $rid=$this->user_masking_m->add_row($form);
        if($rid===false){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Process stopped. Please try again later!';
            echo json_encode($this->RESPONSE);exit();            
        }

        //add data to user history
        $history=array('user_id'=>$this->LOGIN_USER->mid);
        $history['message']="Registered new masking($mask->name) for user($user->name)";
        $this->system_history_m->add_row($history);

        //send back the resposne  
        $this->RESPONSE['message']=' Data Saved Successfully.'; 
        echo json_encode($this->RESPONSE);exit();
    }
    // update row
    public function updateMask(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        //check for necessary required data   
        $required=array('rid');
        foreach ($required as $key) {
            if(!isset($form[$key]) || empty($form[$key])){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please provide required information ...';
            echo json_encode($this->RESPONSE);exit();
            }
        }   
        //save data in database                
        if($this->project_activity_m->save($form,$form['rid'])===false){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Process stopped. Please try again later!';
            echo json_encode($this->RESPONSE);exit();            
        } 

        //send back the resposne
        $this->RESPONSE['message']=' Data Saved Successfully.';  
        echo json_encode($this->RESPONSE);exit();
    }
    // update row
    public function deleteMask(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        isset($form['rid']) ? $rid=$form['rid'] : $rid='';
        //check for demo   
        if($this->IS_DEMO){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']=$this->config->item('app_demo_del_err');
            echo json_encode($this->RESPONSE);exit();
        }
        //check for necessary data   
        if(empty($rid)){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please choose a valid record.';
            echo json_encode($this->RESPONSE);exit();
        }
        $mask=$this->user_masking_m->get_by_primary($form['rid']);              
        $user=$this->user_m->get_by_primary($mask->user_id);
        $system_mask=$this->system_masking_m->get_by_primary($mask->mask_id);

        if($this->user_masking_m->delete($rid)==false){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Process stopped. Please try again later!';
            echo json_encode($this->RESPONSE);exit();
        }

        //add data to user history
        $history=array('user_id'=>$this->LOGIN_USER->mid);
        $history['message']="Removed masking($system_mask->name) from user($user->name) account.";
        $this->system_history_m->add_row($history);

        //send back the resposne
        $this->RESPONSE['message']='Removed Successfully.';  
        echo json_encode($this->RESPONSE);exit();
    }

    // update row
    public function toggleMaskStatus(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        //check for necessary required data   
        $required=array('rid');
        foreach ($required as $key) {
            if(!isset($form[$key]) || empty($form[$key])){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please provide required information ...';
            echo json_encode($this->RESPONSE);exit();
            }
        }   
        //save data in database  
        $status='enabled';
        $mask=$this->user_masking_m->get_by_primary($form['rid']);              
        $user=$this->user_m->get_by_primary($mask->user_id);
        $system_mask=$this->system_masking_m->get_by_primary($mask->mask_id);
        $data=array('is_active'=>1);
        if($mask->is_active==1){$data['is_active']=0;$status='disabled';}
        if($this->user_masking_m->save($data,$form['rid'])===false){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Process stopped. Please try again later!';
            echo json_encode($this->RESPONSE);exit();            
        } 

        //add data to user history
        $history=array('user_id'=>$this->LOGIN_USER->mid);
        $history['message']=" $status the masking($system_mask->name) for user($user->name)";
        $this->system_history_m->add_row($history);

        //send back the resposne
        $this->RESPONSE['message']=' Updated Successfully.';  
        echo json_encode($this->RESPONSE);exit();
    }
    /////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////

    // filter rows
    public function filterHistory(){
        // get input fields into array
        $filter=array();
        $params=array();
        $search=array('message');
        $like=array();
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_get();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        ////////////////////////////////////////////////////////////////////////////////
        //check for necessary required data   
        $required=array('rid');
        foreach ($required as $key) {
            if(!isset($form[$key]) || empty($form[$key])){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please provide required information ...';
            echo json_encode($this->RESPONSE);exit();
            }
        } 
        isset($form['rid']) && !empty($form['rid']) ? $filter['user_id']=$form['rid'] : '';
        if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
        ///////////////////////////////////////////
        $params['limit']=$this->PAGE_LIMIT;
        isset($form['page']) ? $params['offset']=intval($form['page'])*$this->PAGE_LIMIT : '';
        isset($form['sortby'])&&!empty($form['sortby']) ? $params['orderby']=$form['sortby'] : $params['orderby']='mid DESC';
        isset($form['search']) ? $params['like']=$like : '';
        $this->RESPONSE['rows']=$this->system_history_m->get_rows($filter,$params);
        $this->RESPONSE['total_rows']=$this->system_history_m->get_rows($filter,'',true);
        ////////////////////////////////////////////////////////////////////////
        echo json_encode( $this->RESPONSE);        
    }
    // del row
    public function deleteHistory(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        isset($form['rid']) ? $rid=$form['rid'] : $rid='';
        //check for demo   
        if($this->IS_DEMO){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']=$this->config->item('app_demo_del_err');
            echo json_encode($this->RESPONSE);exit();
        }
        //check for necessary data   
        if(empty($rid)){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please choose a valid record.';
            echo json_encode($this->RESPONSE);exit();
        }
        $record=$this->system_history_m->get_by_primary($form['rid']);

        //check for necessary data   
        if($record->user_id==$this->LOGIN_USER->mid){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='You can not remove your own history.';
            echo json_encode($this->RESPONSE);exit();
        }
        if($this->system_history_m->delete($rid)==false){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Process stopped. Please try again later!';
            echo json_encode($this->RESPONSE);exit();
        }

        //send back the resposne
        $this->RESPONSE['message']='Removed Successfully.';  
        echo json_encode($this->RESPONSE);exit();
    }
    /////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////

    
    // update row
    public function assignDepartment(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        //check for necessary required data   
        $required=array('rid','name','department_id','role');
        foreach ($required as $key) {
            if(!isset($form[$key]) || empty($form[$key])){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please provide required information ...';
            echo json_encode($this->RESPONSE);exit();
            }
        }   

        if($this->department_member_m->get_rows(array('user_id'=>$form['rid'],'department_id'=>$form['department_id']),'',true)>0){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Department already assigned to this user! Please choose another record...';
            echo json_encode($this->RESPONSE);exit();
        } 
        //save data in database        
        $form['user_id']=$form['rid'];        
        if($this->department_member_m->add_row($form)===false){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Process stopped. Please try again later!';
            echo json_encode($this->RESPONSE);exit();            
        } 

        //send back the resposne
        $this->RESPONSE['message']='Job Completed Successfully.';  
        echo json_encode($this->RESPONSE);exit();
    }


/** 
* /////////////////////////////////////////////////////////////////////////////////////
* ************************** END OF CLASS *********************************************
* /////////////////////////////////////////////////////////////////////////////////////
*/

}
    