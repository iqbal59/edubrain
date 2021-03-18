<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Admin_Controller{

/** 
* ////////////////////////////////////////////////////////////////////////////////
* *************************** CONTANTS *******************************************
* ////////////////////////////////////////////////////////////////////////////////
*/  
    public $CONT_ROOT; //REFERENCE TO THIS CONTROLLER
    public $_version_path;
    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
    function __construct() {
        parent::__construct();        
        //INIT CONSTANTS
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'settings/';
        $this->_home_path='./';
        //load all models for this controller
        $models = array();
        $this->load->model($models);
        
    }
    
/** 
* ////////////////////////////////////////////////////////////////////////////////
* ***************************** PUBLIC FUNCTIONS *********************************
* ////////////////////////////////////////////////////////////////////////////////
*/  
    // default function for this controller (index)
    public function index($tab='',$recheck=false){
        $this->data['main_content']='settings'; 
        $this->data['menu']='system';           
        $this->data['sub_menu']='settings';
        $this->data['tab']=$tab;
        $this->ANGULAR_INC[]='settings';
        /////////////////////////////////////////////////////////////  
        $form=$this->input->safe_get();
        if(isset($form['recheck'])&&intval($form['recheck'])>0){$this->system_setting_m->recheck_settings();}  
        if(isset($form['tab'])&&!empty($form['tab'])){$this->data['tab']=strtolower($form['tab']);}
        $this->data['timezones']=$this->system_setting_m->get_timezones();
        $this->data['classes']=$this->class_m->get_values_array('','name',array());
        $this->data['sections']=$this->section_m->get_values_array('','name',array());
        $this->data['groups']=$this->group_m->get_values_array('','name',array());
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }

    // view change log
    public function changelog($tab=''){
        $this->data['main_content']='settings_changelog'; 
        $this->data['menu']='system';           
        $this->data['sub_menu']='settings';
        $this->data['tab']=$tab;
        ///////////////////////////////////////////////////////////// 
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }


    //update the migration version 
    public function update(){
        $this->config->load('migration');
        $this->load->library('migration');
        if ($this->migration->current() === FALSE){
            $this->session->set_flashdata('error', "Update Error: " .$this->migration->error_string() );
            redirect($this->LIB_CONT_ROOT.'', 'refresh');
            exit();
        }
        $this->session->set_flashdata('success', 'Version successfully Updated to '.$this->config->item('migration_version').'');
        redirect($this->LIB_CONT_ROOT.'settings', 'refresh'); 
    }

    //save profile settings
    public function save($module=''){
        $redir=$this->LIB_CONT_ROOT.'settings';
        switch (strtolower($module)) {
            case 'settings':{                
                $form=$this->input->safe_post();
                if(isset($form[$this->system_setting_m->_WS_EXAM_PRACTICE_TEST]) && strtolower($form[$this->system_setting_m->_WS_EXAM_PRACTICE_TEST])=='on'){
                    $form[$this->system_setting_m->_WS_EXAM_PRACTICE_TEST]=1;
                }else{
                    $form[$this->system_setting_m->_WS_EXAM_PRACTICE_TEST]=0;
                }

                if(isset($form[$this->system_setting_m->_WS_CHAPTER_WISE_LESSONING]) && strtolower($form[$this->system_setting_m->_WS_CHAPTER_WISE_LESSONING])=='on'){
                    $form[$this->system_setting_m->_WS_CHAPTER_WISE_LESSONING]=1;
                }else{
                    $form[$this->system_setting_m->_WS_CHAPTER_WISE_LESSONING]=0;
                }

                if(isset($form[$this->system_setting_m->_WS_EXAM_STRICT_START_TIME]) && strtolower($form[$this->system_setting_m->_WS_EXAM_STRICT_START_TIME])=='on'){
                    $form[$this->system_setting_m->_WS_EXAM_STRICT_START_TIME]=1;
                }else{
                    $form[$this->system_setting_m->_WS_EXAM_STRICT_START_TIME]=0;
                }

                if(isset($form[$this->system_setting_m->_WS_LESSON_SCHEDULE]) && strtolower($form[$this->system_setting_m->_WS_LESSON_SCHEDULE])=='on'){
                    $form[$this->system_setting_m->_WS_LESSON_SCHEDULE]=1;
                }else{
                    $form[$this->system_setting_m->_WS_LESSON_SCHEDULE]=0;
                }
                //update timezone in a file to load in my_model
                $file="./timezone.txt";
                $myfile = @fopen($file, "w");
                $timezone = $form[$this->system_setting_m->_WS_TIMEZONE];
                @fwrite($myfile, $timezone);
                @fclose($myfile);
                ///////////////////////////////////////////////

                $this->system_setting_m->save_settings_array($form);
                $this->session->set_flashdata('success', 'Settings Updated Successfully.');
                redirect($redir, 'refresh'); 

            }
            break;            
            default:{
                $this->session->set_flashdata('error', 'Please choose a valid operation');
                redirect($redir, 'refresh');
            }
            break;
        }         
    
    }

    //perform an action
    public function do_action(){
        $redir=$this->CONT_ROOT.'?tab=action';
        $form=$this->input->safe_get();
        $action= isset($form['action']) ? $form['action'] : '';
        switch (strtolower($action)) {
            case 'recheck':{
                //recheck settings
                $this->system_setting_m->recheck_settings();              
                $this->session->set_flashdata('success', "All settings and configuration re-validated successfully");
                redirect($redir);

            }break;
            case 'unblock':{
                //unblock failed login cache
                $tables=array('login_session');
                foreach($tables as $tbl){$this->db->truncate($tbl);}             
                $this->session->set_flashdata('success', "Failed login cache cleared successfully.");
                redirect($redir);

            }break;
            case 'start_session':{
                //unblock failed login cache
                $tables=array('assignment','assignment_answers','chat_conversations','chat_conversations_messages','chat_groups_messages','homework','homework_answers','paper','paper_answers','paper_attempts','paper_docs','paper_questions','quiz','quiz_answers','quiz_attempts','quiz_questions','student_time_log','subject_lesson_attendance');
                foreach($tables as $tbl){$this->db->truncate($tbl);}             
                $this->session->set_flashdata('success', "Previous data removed. New Session Started Successfully.");
                redirect($redir);

            }break;
            case 'enable_branching':{
                //enable multi branching system
                $this->system_setting_m->save_settings_array(array($this->system_setting_m->_MULTI_BRANCH=>1));
                //validate admin users.
                $this->session->set_flashdata('success', "Multi branch feature enabled successfully.");
                redirect($redir);

            }break;
            case 'frp_std':{
                //force students to reset password on their next login.
                $this->student_m->save(array('reset_password'=>1),array('reset_password <>'=>1));
                $this->session->set_flashdata('success', "Successful! All students will be forced to change password on their next login.");
                redirect($redir);

            }break;
            case 'frp_stf':{
                //force students to reset password on their next login.
                $this->staff_m->save(array('reset_password'=>1),array('reset_password <>'=>1));
                $this->session->set_flashdata('success', "Successful! All staff/teachers will be forced to change password on their next login.");
                redirect($redir);
            }break;
            case 'redo_id':{
                //force students to reset password on their next login.
                if(!isset($form['confirm']) || intval($form['confirm'])<1){
                    echo 'Please provide the confirm url parameter as 1. and press enter';
                    exit;
                }
                $key='lms';
                if(isset($form['key']) && !empty($form['key'])){
                    $key=strtolower($form['key']);
                }
                $students=$this->student_m->get_rows(array(),array('select'=>'mid'));
                $i=0;
                foreach($students as $std){
                    $i++;
                    $std_id=$key.mt_rand(1111,9999);                     
                    if($this->student_m->get_rows(array('student_id'=>$std_id),'',true)>0){
                        $std_id=$std_id.mt_rand(1,9);
                    } 
                    $this->student_m->save(array('student_id'=>$std_id),$std['mid']);
                }
                $this->session->set_flashdata('success', "Successful! Student ID's updated for $i students.");
                redirect($redir);

            }break;
            
            default:{                
                $this->session->set_flashdata('error', "Please choose a valid action");
                redirect($redir);
                exit();
            }
            break;
        }
        redirect($this->LIB_CONT_ROOT.'', 'refresh'); 
    }

    //change password for complete class
    public function bulkpc(){
        $redir=$this->LIB_CONT_ROOT.'settings?tab=bulkpc';
        $form=$this->input->safe_post();
        if(!isset($form['class_id']) || empty($form['class_id'])){
            $this->session->set_flashdata('error', 'Please select a valid class.');
            redirect($redir, 'refresh');
        }
        if(!isset($form['password']) || empty($form['password'])){
            $this->session->set_flashdata('error', 'Please enter new password.');
            redirect($redir, 'refresh');
        }
        $filter=array('class_id'=>$form['class_id']);
        $data=array('password'=>$this->student_m->hash($form['password']));
        if(isset($form['section_id']) && !empty($form['section_id'])){$filter['section_id']=$form['section_id'];}
        $this->student_m->save($data,$filter);

        $this->session->set_flashdata('success', 'Password changed for all students of selected class.');
        redirect($redir, 'refresh');
    
    }



    //send message to all students
    public function sendsms(){

        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->LIB_CONT_ROOT.'settings', 'refresh');                    
        }
        set_time_limit(3600);
        $redir=$this->CONT_ROOT.'?tab=sms';
        $form=$this->input->safe_post();
        $required=array('message');
        foreach ($required as $key) {
            if(!isset($form[$key]) || empty($form[$key])){
                $this->session->set_flashdata('error', 'Please enter message');
                redirect($redir);
            }
        }
        $mobile=$this->SETTINGS[$this->system_setting_m->_SMS_API_USERNAME];
        $apikey=$this->SETTINGS[$this->system_setting_m->_SMS_API_KEY];
        $mask=$this->SETTINGS[$this->system_setting_m->_SMS_MASK];
        if(!$this->is_valid_params($mobile,$apikey,$mask)){
            $this->session->set_flashdata('error', 'Invalid api details. Please update vendor api details first!!!');
            redirect($redir);
        }
        //////////////////////////////////////////////////////////////////
        $classes=$this->class_m->get_values_array('','name',array());
        $filter=array();

        if(isset($form['class_id']) && !empty($form['class_id'])){$filter['class_id']=$form['class_id'];}
        if(isset($form['group_id']) && !empty($form['group_id'])){$filter['group_id']=$form['group_id'];}
        if(isset($form['section_id']) && !empty($form['section_id'])){$filter['section_id']=$form['section_id'];}
        if(isset($form['student_id']) && !empty($form['student_id'])){$filter['student_id']=$form['student_id'];}
        $students=$this->student_m->get_rows($filter,array('select'=>'mid,student_id,name,mobile,father_name,roll_number,class_id,date'));

        if(count($students)<1){
            $this->session->set_flashdata('error', 'There are no students for selected criteria!!!');
            redirect($redir);
        }
        $message=htmlspecialchars_decode($form['message']);
        $i=0;
        $failed=0;
        $new_pass='';
        $ch=$this->open_curl();
        foreach ($students as $row) { 
            $to=$row['mobile'];
            if(strlen($row['mobile'])>8){
                $i++;        
                ///////////////////////////////////////
                if(strpos($message, "{NEWPASSWORD}") !== false){
                    $new_pass=mt_rand(11111,99999);
                    $this->student_m->save(array('password'=>$this->student_m->hash($new_pass)),$row['mid']);
                }
                ///////////////////////////////////////
                //conversion keys
                $key_vars=array(
                        '{NAME}'=>$row['name'],
                        '{ID}'=>$row['student_id'],
                        '{ROLLNO}'=>$row['roll_number'],
                        '{CLASS}'=>$classes[$row['class_id']],
                        '{NEWPASSWORD}'=>$new_pass
                    );
                ////////////////////////////////////////
                $sms=strtr($message, $key_vars);
                $this->send_message($ch,$mobile,$apikey,$mask,$to,$sms);
            }else{
                $failed++;
            }   
        }
        $this->close_curl($ch);
        ////////////////////////////////////////////////////////////////////////////////
        $this->session->set_flashdata('success', 'Message sent to '.$i.' students and failed for '.$failed.' students.');
        redirect($redir);
    }

    //send message to all students
    public function sendstaffsms(){

        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->LIB_CONT_ROOT.'settings', 'refresh');                    
        }

        set_time_limit(3600);
        $redir=$this->CONT_ROOT.'?tab=staffsms';
        $form=$this->input->safe_post();
        $required=array('message');
        foreach ($required as $key) {
            if(!isset($form[$key]) || empty($form[$key])){
                $this->session->set_flashdata('error', 'Please enter message');
                redirect($redir);
            }
        }
        $mobile=$this->SETTINGS[$this->system_setting_m->_SMS_API_USERNAME];
        $apikey=$this->SETTINGS[$this->system_setting_m->_SMS_API_KEY];
        $mask=$this->SETTINGS[$this->system_setting_m->_SMS_MASK];
        if(!$this->is_valid_params($mobile,$apikey,$mask)){
            $this->session->set_flashdata('error', 'Invalid api details. Please update api details first!!!');
            redirect($redir);
        }
        //////////////////////////////////////////////////////////////////
        $filter=array();
        if(isset($form['staff_id']) && !empty($form['staff_id'])){$filter['staff_id']=$form['staff_id'];}
        $teachers=$this->staff_m->get_rows($filter,array('select'=>'mid,staff_id,name,mobile,father_name,date'));

        if(count($teachers)<1){
            $this->session->set_flashdata('error', 'There are no staff for selected criteria!!!');
            redirect($redir);
        }
        $message=htmlspecialchars_decode($form['message']);
        $i=0;
        $failed=0;
        $new_pass='';
        $ch=$this->open_curl();
        foreach ($teachers as $row) { 
            $to=$row['mobile'];
            if(strlen($row['mobile'])>8){
                $i++;        
                ///////////////////////////////////////
                if(strpos($message, "{NEWPASSWORD}") !== false){
                    $new_pass=mt_rand(11111,99999);
                    $this->staff_m->save(array('password'=>$this->staff_m->hash($new_pass)),$row['mid']);
                }
                ///////////////////////////////////////
                //conversion keys
                $key_vars=array(
                        '{NAME}'=>$row['name'],
                        '{ID}'=>$row['staff_id'],
                        '{NEWPASSWORD}'=>$new_pass
                    );
                ////////////////////////////////////////
                $sms=strtr($message, $key_vars);
                $this->send_message($ch,$mobile,$apikey,$mask,$to,$sms);
            }else{
                $failed++;
            }   
        }
        $this->close_curl($ch);
        ////////////////////////////////////////////////////////////////////////////////
        $this->session->set_flashdata('success', 'Message sent to '.$i.' teachers and failed for '.$failed.' teachers.');
        redirect($redir);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////

    //save logo picture
    public function upload_logo(){
        //upload artwork file
        $file_name='pic_'.mt_rand(1001,9999);
        $path='./uploads/images/logo';
        $data=$this->upload_img('file',$file_name,$path);
        if($data['file_uploaded']==FALSE){
            $this->session->set_flashdata('error', $data['file_error']);
            redirect($this->CONT_ROOT.'?tab=logo', 'refresh');
        }
        $nfile_name=$data['file_name'];
        ////////////////////////////////////////////
        $config=array();
        $config['source_image'] = $path.'/'.$nfile_name;
        $config['new_image'] = $path.'/default.png';
        $config['maintain_ratio'] = TRUE;
        $config['width']         = 128;
        $config['height']       = 128;
        $c1=$this->load->library('image_lib',$config);
        // save 64x64 logo
        if (!$this->image_lib->resize()){
            $this->session->set_flashdata('error', ''.$this->image_lib->display_errors());
            redirect($this->CONT_ROOT.'?tab=logo', 'refresh');
        }else{
            $this->image_lib->clear();
            unset($this->image_lib);
        }

        $config['new_image'] = $path.'/favicon.png';
        $config['width']         = 32;
        $config['height']       = 32;
        // save 32x32 logo
        $c2=$this->load->library('image_lib',$config);        
        if (!$this->image_lib->resize()){
            $this->session->set_flashdata('error', ''.$this->image_lib->display_errors());
            redirect($this->CONT_ROOT.'?tab=logo', 'refresh');
        }else{
            $this->image_lib->clear();
            unset($this->image_lib);
        }

        $this->session->set_flashdata('success', 'Logo uploaded successfully.');
        redirect($this->CONT_ROOT.'?tab=logo', 'refresh');           
    
    }
    //save profile picture
    public function upload_picture(){
        //upload artwork file
        $file_name='pic_'.mt_rand(1001,9999);
        $path='./uploads/images/user';
        $data=$this->upload_img('file',$file_name,$path);
        if($data['file_uploaded']==FALSE){
            $this->session->set_flashdata('error', $data['file_error']);
            redirect($this->LIB_CONT_ROOT.'profile', 'refresh');
        }
        $nfile_name=$data['file_name'];
        $this->user_m->save(array('image'=>$nfile_name),$this->LOGIN_USER->mid);
        $this->session->set_flashdata('success', 'Image uploaded successfully.');
        redirect($this->LIB_CONT_ROOT.'profile', 'refresh');           
    
    }
    ////////////////////upload file///////////////////////////////
    private function upload_img($file_name='file',$new_name='',$path){   
        $size=isset($this->SETTINGS['max_upload_size']) ? $this->SETTINGS['max_upload_size'] : '800';    //0.8MB
        $allowed_types='jpg|jpeg|png|bmp';
        $upload_file_name=$file_name;    
        $min_width=32;
        $min_height=32;
        $upload_data=$this->upload_file($path,$size,$allowed_types,$upload_file_name,$new_name,$min_width,$min_height);
        return $upload_data;
    }  


    //////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////


    //create database backup    
    public function savebackup(){

        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->LIB_CONT_ROOT.'settings', 'refresh');                    
        }
        set_time_limit(3600);
        $filename='dbbackup_'.date('dmy').'.gz';
        // Load the download helper and send the file to your desktop
        $this->load->helper('file');
        $this->load->helper('download');
        //create and download backup
        $this->load->dbutil();
        $backup = $this->dbutil->backup();
        force_download($filename, $backup);
        
        
        echo "Backup downloading successful";
        
    }

    //create system backup    
    public function savesystembackup($savedb=0){

        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->LIB_CONT_ROOT.'settings', 'refresh');                    
        }
        set_time_limit(3600);
        $filename='dbbackup_'.date('dmy').'.gz';
        $system_filename='lms_backup_'.date('dmy').'.zip';
        // Load the download helper and send the file to your desktop
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');

        $this->zip->read_dir('./');
        //also save database data.
        if($savedb>0){
            //create and download backup
            $this->load->dbutil();
            $backup = $this->dbutil->backup();   
            $this->zip->add_data($filename,$backup);         
        }

        $this->zip->download($system_filename);
        
        
        echo "Backup downloading successful";
        
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////

    // send message
    private function get_timezones($contentinet=false){ 
        $ch=curl_init();
        $url='http://api.mozzine.com/timezone/list.php';
        if($contentinet){$url.='?continent';}
        $timeout=5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $result=curl_exec($ch);
        curl_close($ch);
        /////////////////////////////////////////////////
        return $result;
    }
    ////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////

    // send message
    private function send_message($ch,$username,$apikey,$masking,$to,$message){ 

        $vendor=isset($this->SETTINGS[$this->system_setting_m->_SMS_VENDOR]) ? $this->SETTINGS[$this->system_setting_m->_SMS_VENDOR] : '';
        $base_url=$this->get_vendor_base_url($vendor);
        switch (strtolower($vendor)) {
            case 'dotclick':{
                //default vendor is akspk
                $params=array('mobile'=>$username,'key'=>$apikey,'sender'=>$masking,'receiver'=>$to,'msgdata'=>$message);
                //validate api details
                $url=$base_url.'/api_sms/api.php';
                $response=$this->do_get_request($ch,$url,$params);
                return true;
                // if(strtolower($response)!='message sent'){return false;}

            }
            break;
            
            default:{
                //default vendor is akspk
                $params=array('mobile'=>$username,'apikey'=>$apikey,'mask'=>$masking,'to'=>$to,'message'=>$message);
                //validate api details
                $url=$base_url.'/api/sendsms';
                $response=$this->do_get_request($ch,$url,$params);
                if(strtolower($response)!='message sent'){return false;}
            }
            break;
        }
        /////////////////////////////////////////////////
        return true;
    }
    // check if sms parameters are valid
    private function is_valid_params($username,$apikey,$masking=''){ 
        return true;
        $vendor=isset($this->SETTINGS[$this->system_setting_m->_SMS_VENDOR]) ? $this->SETTINGS[$this->system_setting_m->_SMS_VENDOR] : '';
        $base_url=$this->get_vendor_base_url($vendor);
        switch (strtolower($vendor)) {
            case 'sms92':{

            }
            break;
            
            default:{
                //default vendor is akspk
                $params=array('mobile'=>$username,'apikey'=>$apikey);
                //validate api details
                $url=$base_url.'/api/isvalidapi';
                $ch=$this->open_curl();
                $response=$this->do_get_request($ch,$url,$params);
                if(strtolower($response)!='yes'){
                    $this->close_curl($ch);
                    return false;
                }
                //validate mask
                $params['mask']=$masking;
                $url=$base_url.'/api/isvalidmask';
                $response=$this->do_get_request($ch,$url,$params);
                if(strtolower($response)!='yes'){
                    $this->close_curl($ch);
                    return false;
                }
                $this->close_curl($ch);
            }
            break;
        }
        /////////////////////////////////////////////////
        return true;
    }

    // get balance
    private function get_balance($username,$apikey){
            return 1000000;
            $vendor=isset($this->SETTINGS[$this->system_setting_m->_SMS_VENDOR]) ? $this->SETTINGS[$this->system_setting_m->_SMS_VENDOR] : '';
            $base_url=$this->get_vendor_base_url($vendor);
            switch (strtolower($vendor)) {
                case 'sms92':{

                }
                break;
                
                default:{
                    //default vendor is akspk
                    $params=array('mobile'=>$username,'apikey'=>$apikey);
                    $url=$base_url.'/api/getaccountbalance';
                    $ch=$this->open_curl();
                    $response=$this->do_get_request($ch,$url,$params);
                    $this->close_curl($ch);
                    return $response;
                }
                break;
            }
            return false;
    }
    ////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////

    // get balance
    private function get_vendor_base_url($vendor){
            switch (strtolower($vendor)) {
                case 'dotclick':{
                    return 'http://csms.dotklick.com/';
                }
                break;                
                default:{
                    return 'https://akspk.com';
                }
                break;
            }
    }
    //make a web request (HTTP Get)
    private function do_get_request($ch,$url,$params=array()){  
            if(is_array($params) && count($params)>0){
                $url.='?';
                foreach($params as $key=>$val){
                    $url.='&'.$key.'='.urlencode($val);
                }
            }
            $ch=curl_init();
            $timeout=5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            $result=curl_exec($ch);
            return $result;
    }
    // send message
    private function open_curl(){ 
        $ch=curl_init();
        return $ch;
    }
    // send message
    private function close_curl($ch){ 
        curl_close($ch);
    }
/** 
* /////////////////////////////////////////////////////////////////////////////////////
* ************************** END OF CLASS *********************************************
* /////////////////////////////////////////////////////////////////////////////////////
*/

}
    