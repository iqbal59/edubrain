<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends Admin_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'maintenance/';
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
	public function index($tab=''){
		$this->data['main_content']='maintenance';	
		$this->data['menu']='system';			
		$this->data['sub_menu']='maintenance';
        $this->data['tab']=$tab;
        $this->ANGULAR_INC[]='maintenance';
        /////////////////////////////////////////////////////////////   
        $this->data['timezones']=json_decode($this->get_timezones());
        $this->data['classes']=$this->class_m->get_values_array('','name',array());
        $this->data['sections']=$this->section_m->get_values_array('','name',array());
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}


    //update the migration version
    public function update(){
        $this->load->library('migration');
        if ($this->migration->current() === FALSE){
            $this->session->set_flashdata('error', "Update Error: " .$this->migration->error_string() );
            redirect($this->LIB_CONT_ROOT.'', 'refresh');
            exit();
        }
        $this->session->set_flashdata('success', 'Version Updated Successfully.');
        redirect($this->LIB_CONT_ROOT.'', 'refresh'); 
    }

    //change password for complete class
    public function bulkpc(){
        $form=$this->input->safe_post();
        if(!isset($form['class_id']) || empty($form['class_id'])){
            $this->session->set_flashdata('error', 'Please select a valid class.');
            redirect($this->LIB_CONT_ROOT.'maintenance', 'refresh');
        }
        if(!isset($form['password']) || empty($form['password'])){
            $this->session->set_flashdata('error', 'Please enter new password.');
            redirect($this->LIB_CONT_ROOT.'maintenance', 'refresh');
        }
        $filter=array('class_id'=>$form['class_id']);
        $data=array('password'=>$this->student_m->hash($form['password']));
        if(isset($form['section_id']) && !empty($form['section_id'])){$filter['section_id']=$form['section_id'];}
        $this->student_m->save($data,$filter);

        $this->session->set_flashdata('success', 'Password changed for all students of selected class.');
        redirect($this->LIB_CONT_ROOT.'maintenance', 'refresh');
    
    }

    //clear failed login cache
    public function unblock_login(){
        $tables=array('login_session');
        foreach($tables as $tbl){
            $this->db->truncate($tbl);
        }
        $this->session->set_flashdata('success', 'Failed login cache cleared successfully.');
        redirect($this->LIB_CONT_ROOT.'maintenance', 'refresh');
    
    }

    //start new session. remove previous data
    public function start_session(){
        $tables=array('assignment','assignment_answers','chat_conversations','chat_conversations_messages','chat_groups_messages','homework','homework_answers','paper','paper_answers','paper_attempts','paper_docs','paper_questions','quiz','quiz_answers','quiz_attempts','quiz_questions','student_time_log','subject_lesson_attendance');
        foreach($tables as $tbl){
            $this->db->truncate($tbl);
        }
        $this->session->set_flashdata('success', 'New Session Started Successfully.');
        redirect($this->LIB_CONT_ROOT.'maintenance', 'refresh');
    
    }

    //save profile pic
    public function save($module=''){
        switch (strtolower($module)) {
            case 'settings':{                
                $form=$this->input->safe_post();
                $this->system_setting_m->save_settings_array($form);
                $this->session->set_flashdata('success', 'Settings Updated Successfully.');
                redirect($this->LIB_CONT_ROOT.'maintenance', 'refresh'); 

            }
            break;
            case 'frpstd':{                
                $this->student_m->save(array('reset_password'=>1),array('reset_password <>'=>1));
                $this->session->set_flashdata('success', 'Settings Updated Successfully.');
                redirect($this->LIB_CONT_ROOT.'maintenance', 'refresh'); 

            }
            break;
            case 'frpstf':{                
                $this->staff_m->save(array('reset_password'=>1),array('reset_password <>'=>1));
                $this->session->set_flashdata('success', 'Settings Updated Successfully.');
                redirect($this->LIB_CONT_ROOT.'maintenance', 'refresh'); 

            }
            break;
            
            default:{
                $this->session->set_flashdata('error', 'Please choose a valid operation');
                redirect($this->LIB_CONT_ROOT.'maintenance', 'refresh');
            }
            break;
        }         
    
    }

    //send message to all students
    public function sendsms(){
        $redir=$this->CONT_ROOT.'';
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
        $classes=$this->class_m->get_values_array('','name',array());
        $students=$this->student_m->get_rows(array(),array('select'=>'mid,student_id,name,mobile,father_name,roll_number,class_id,date'));
        $message=htmlspecialchars_decode($form['message']);
        $i=0;
        $new_pass='';
        $ch=$this->open_curl();
        foreach ($students as $row) { 
            $to=$row['mobile'];
            if(strlen($row['mobile'])>9){
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
            }   
        }
        $this->close_curl($ch);
        ////////////////////////////////////////////////////////////////////////////////
        $this->session->set_flashdata('success', 'Message sent to '.$i.' students.');
        redirect($redir);
    }

    //send message to all students
    public function sendstaffsms(){
        $redir=$this->CONT_ROOT.'';
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
        $teachers=$this->staff_m->get_rows(array(),array('select'=>'mid,staff_id,name,mobile,father_name,date'));
        $message=htmlspecialchars_decode($form['message']);
        $i=0;
        $new_pass='';
        $ch=$this->open_curl();
        foreach ($teachers as $row) { 
            $to=$row['mobile'];
            if(strlen($row['mobile'])>9){
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
            }   
        }
        $this->close_curl($ch);
        ////////////////////////////////////////////////////////////////////////////////
        $this->session->set_flashdata('success', 'Message sent to '.$i.' teachers.');
        redirect($redir);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////

    //save profile pic
    public function upload_logo(){
        //upload artwork file
        $file_name='pic_'.mt_rand(1001,9999);
        $path='./uploads/images/logo';
        $data=$this->upload_img('file',$file_name,$path);
        if($data['file_uploaded']==FALSE){
            $this->session->set_flashdata('error', $data['file_error']);
            redirect($this->CONT_ROOT.'', 'refresh');
        }
        $nfile_name=$data['file_name'];
        ////////////////////////////////////////////
        $config=array();
        $config['source_image'] = $path.'/'.$nfile_name;
        $config['new_image'] = $path.'/default.png';
        $config['maintain_ratio'] = TRUE;
        $config['width']         = 64;
        $config['height']       = 64;
        $c1=$this->load->library('image_lib',$config);
        // save 64x64 logo
        $this->image_lib->resize();
        $this->image_lib->clear();
        unset($this->image_lib);
        $config['new_image'] = $path.'/favicon.png';
        $config['width']         = 32;
        $config['height']       = 32;
        // save 32x32 logo
        $c2=$this->load->library('image_lib',$config);
        $this->image_lib->resize();


        $this->session->set_flashdata('success', 'Logo uploaded successfully.');
        redirect($this->CONT_ROOT.'', 'refresh');           
    
    }
    //save profile pic
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



    //create database backup    
    public function savebackup(){

        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->LIB_CONT_ROOT.'maintenance', 'refresh');                    
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
        
        
        echo "Backup downloading successfull";
        
    }

    //create system backup    
    public function savesystembackup($savedb=0){

        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->LIB_CONT_ROOT.'maintenance', 'refresh');                    
        }
        set_time_limit(3600);
        $filename='dbbackup_'.date('dmy').'.gz';
        $system_filename='systembackup_'.date('dmy').'.zip';
        // Load the download helper and send the file to your desktop
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');

        $this->zip->read_dir('./');
        //also save databse data.
        if($savedb>0){
            //create and download backup
            $this->load->dbutil();
            $backup = $this->dbutil->backup();   
            $this->zip->add_data($filename,$backup);         
        }

        $this->zip->download($system_filename);
        
        
        echo "Backup downloading successfull";
        
    }
    //create system backup    
    public function resetSettings(){
        $this->system_setting_m->reset_settings();
        $this->session->set_flashdata('success', 'Settings successfully reset to default settings.');
        redirect($this->LIB_CONT_ROOT.'maintenance', 'refresh');  
        
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////

    // create row
    public function checkUpdates(){
        if($this->IS_DEMO){
            $this->RESPONSE['updates_available']=false;     
            $this->RESPONSE['error']=true;
            $this->RESPONSE['message']=$this->config->item('app_demo_edit_err');
            echo json_encode($this->RESPONSE);exit();                   
        }
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';

        $this->RESPONSE['updates_available']=false;
        $this->load->library('fabsam');
        if($this->fabsam->is_updates_availeable()==true){
            $this->RESPONSE['updates_available']=true;
            $this->RESPONSE['message']='New Updates Are Available. Click below to install...';
            echo json_encode($this->RESPONSE);exit();
        }
        ////////////////////////////
        $this->RESPONSE['message']='System is already upto date...';
        echo json_encode($this->RESPONSE);exit();
    }

    // create row
    public function installUpdates(){

        if($this->IS_DEMO){
            $this->RESPONSE['updates_available']=false;
            $this->RESPONSE['message']=$this->config->item('app_demo_edit_err');
            echo json_encode($this->RESPONSE);exit();                   
        }
        set_time_limit(300);
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        ////////////////////////////////////////////////////////////////////////////
        $this->RESPONSE['updates_available']=true;
        $this->load->library('fabsam');

        $filename='file_'.date('dmyhis').'.zip';
        $download_path=ASSETSPATH.'updates'.DIRECTORY_SEPARATOR.'downloads'.DIRECTORY_SEPARATOR;
        $install_path=ASSETSPATH.'updates'.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR;
        $dest_home=FCPATH.DIRECTORY_SEPARATOR;
        $download_updates=$this->fabsam->download_updates($filename,$download_path);

        if($download_updates){
            //updates downloaded. now install the updates.
            $app_metadata=$this->fabsam->get_metadata();
            $zip= new ZipArchive;
            $res= $zip->open($download_path.$filename);
            if($res === true){
                $zip->extractTo($install_path);
                $zip->close();
                //////////////////////////////////////////////////////////////////////////////////////
                $dir='angular';
                if(file_exists($install_path.$dir)){
                    xcopy($install_path.$dir,$dest_home.$dir);                    
                }
                $dir='application'.DIRECTORY_SEPARATOR.'contollers';
                if(file_exists($install_path.$dir)){
                    xcopy($install_path.$dir,$dest_home.$dir);                    
                }
                $dir='application'.DIRECTORY_SEPARATOR.'core';
                if(file_exists($install_path.$dir)){
                    xcopy($install_path.$dir,$dest_home.$dir);                    
                }
                $dir='application'.DIRECTORY_SEPARATOR.'helpers';
                if(file_exists($install_path.$dir)){
                    xcopy($install_path.$dir,$dest_home.$dir);                    
                }
                $dir='application'.DIRECTORY_SEPARATOR.'migrations';
                if(file_exists($install_path.$dir)){
                    xcopy($install_path.$dir,$dest_home.$dir);                    
                }
                $dir='application'.DIRECTORY_SEPARATOR.'models';
                if(file_exists($install_path.$dir)){
                    xcopy($install_path.$dir,$dest_home.$dir);                    
                }
                $dir='application'.DIRECTORY_SEPARATOR.'views';
                if(file_exists($install_path.$dir)){
                    xcopy($install_path.$dir,$dest_home.$dir);                    
                }
                //************************************************************************************
                $config_home=$dest_home.'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR;
                $migrate_to='20190522163655';
                $version=$app_metadata->data[0]->version;
                $version_code=$app_metadata->data[0]->version_code;
                $find='$config[\'app_version\'] = ';
                $replace='$config[\'app_version\'] = "'.$version.'";  //';
                update_file_text($config_home.'app.php',$find,$replace);


                $find='$config[\'app_version_code\'] = ';
                $replace='$config[\'app_version_code\'] = '.$version_code.';  //';
                update_file_text($config_home.'app.php',$find,$replace);


                $find='$config[\'migration_version\']';
                $replace='$config[\'migration_version\'] = '.$migrate_to.'; //';
                update_file_text($config_home.'migration.php',$find,$replace);


                $this->load->library('migration');
                $this->migration->current();

                $this->system_setting_m->save_setting($this->system_setting_m->_INSTALL_VERSION,$version_code);
                
                ///////////////////////////////////////////////////////////////////////////////////////
                xdelete($dest_home.'application'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'Install.php');
                unlink($download_path.$filename);
                xdelete($install_path);

            }
        }else{
            $this->RESPONSE['error']=true;
            $this->RESPONSE['message']='Network Error! Please try again later...';
            echo json_encode($this->RESPONSE);exit();            
        }
        ////////////////////////////
        $this->RESPONSE['updates_available']=false;
        $this->RESPONSE['message']='System updated successfully...';
        echo json_encode($this->RESPONSE);exit();
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
    // send message
    private function send_message($ch,$mobile,$apikey,$masking,$to,$message){ 
        return true;
        $mobile=urlencode($mobile);
        $apikey=urlencode($apikey);
        $mask=urlencode($masking);
        $to=urlencode($to);
        $message=urlencode($message);
        $url='https://akspk.com/api/sendsms?mobile='.$mobile.'&apikey='.$apikey.'&mask='.$mask.'&to='.$to.'&message='.$message;
        $timeout=5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $result=curl_exec($ch);
        if(strtolower($result)!='message sent'){return true;}
        /////////////////////////////////////////////////
        return false;
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
    // check if sms parameters are valid
    private function is_valid_params($mobile,$apikey,$masking){  
        $mobile=urlencode($mobile);
        $apikey=urlencode($apikey);
        $url='https://akspk.com/api/isvalidapi?mobile='.$mobile.'&apikey='.$apikey;
        $ch=curl_init();
        $timeout=15;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $result=curl_exec($ch);
        //print $result;
        curl_close($ch);
        if(strtolower($result)!='yes'){return false;}
        /////////////////////////////////////////////////////

        $mobile=urlencode($mobile);
        $apikey=urlencode($apikey);
        $mask=urlencode($masking);
        $url='https://akspk.com/api/isvalidmask?mobile='.$mobile.'&apikey='.$apikey.'&mask='.$mask;
        $ch=curl_init();
        $timeout=5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $result=curl_exec($ch);
        //print $result;
        curl_close($ch);
        if(strtolower($result)!='yes'){return false;}
        /////////////////////////////////////////////////

        return true;
    }

    // get balance
    private function get_balance($mobile,$apikey){  

            $mobile=urlencode($mobile);
            $apikey=urlencode($apikey);
            $url='https://akspk.com/api/getaccountbalance?mobile='.$mobile.'&apikey='.$apikey;
            $ch=curl_init();
            $timeout=5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            $result=curl_exec($ch);
            //print $result;
            curl_close($ch);
            return $result;
    }

/** 
* /////////////////////////////////////////////////////////////////////////////////////
* ************************** END OF CLASS *********************************************
* /////////////////////////////////////////////////////////////////////////////////////
*/

}
	