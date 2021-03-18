<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lessons extends Student_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'lessons/';
    }
	
/** 
* ////////////////////////////////////////////////////////////////////////////////
* ***************************** PUBLIC FUNCTIONS *********************************
* ////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index($subject_id='',$chapter=''){
        $this->data['main_content']='lessons';  
        $this->data['menu']='lessons';            
        $this->data['sub_menu']='lessons';
        $this->data['subject_id']=$subject_id;
        $this->data['chapter']=$chapter;
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
        ///////////////////////////////////////////////////////////////
        $filter=array();
        $params=array('orderby'=>'lesson_no ASC');
        $search=array();
        $like=array();
        $form=$this->input->safe_get();
        //load group chat
        $search=array('name');
        if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
        isset($form['search']) ? $params['like']=$like : '';
        //////////////////////////////////////////////////////////////////////////
        $this->data['chapters']=$this->lesson_m->get_column_array('chapter',array('subject_id'=>$subject_id),'',true);
        $this->data['classes']=$this->class_m->get_values_array('','name',array());
        $this->data['groups']=$this->group_m->get_values_array('','name',array());
        $this->data['sections']=$this->section_m->get_values_array('','name',array());
        if(empty($subject_id)){
            //show subjects list
            $filter['class_id']=$this->LOGIN_USER->class_id;
            $this->db->where(" (group_id=0  OR group_id=".$this->LOGIN_USER->group_id.")");
            $this->data['rows']=$this->subject_m->get_rows($filter,array('select'=>'name'));
        }else{
            //show the lessons of subject
            $params['select']='mid,name,about,date,host,video_link,lesson_no,lesson_date,lesson_jd';
            $filter['subject_id']=$subject_id;
            if(isset($this->SETTINGS[$this->system_setting_m->_WS_LESSON_SCHEDULE]) && intval($this->SETTINGS[$this->system_setting_m->_WS_LESSON_SCHEDULE])>0){
                //apply lesson wise filter
                $filter['lesson_jd <=']=$this->user_m->todayjd;                
            }
            if(!empty($chapter)){$filter['chapter']=$chapter;}
            $this->data['subject']=$this->subject_m->get_by_primary($subject_id);
            $params['orderby']='lesson_no ASC';
            $this->data['rows']=$this->lesson_m->get_rows($filter,$params);
        }
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);  
	}
    // view lesson
    public function view($rid=''){
        $this->data['main_content']='lessons_view';  
        $this->data['menu']='lessons';  
        $this->data['sub_menu']='lessons';
        $this->data['iframe']=true;
        $this->ANGULAR_INC[]='lessons_view';

        //////////////////////////////////////////// 
        $this->data['lesson']=$this->lesson_m->get_by_primary($rid);
        $this->data['subject']=$this->subject_m->get_by_primary($this->data['lesson']->subject_id);
        //////////////////////////////////////////////////////
        // check if student class matches with lesson class
        if($this->data['lesson']->class_id != $this->LOGIN_USER->class_id){           
            $this->session->set_flashdata('error', 'Please choose a valid lecture...');
            redirect($this->LIB_CONT_ROOT);            
        }
        //save activity log
        $log="Played Lesson(".$this->data['lesson']->name.") of subject(".$this->data['subject']->name.")";
        $log_data=array('student_id'=>$this->LOGIN_USER->mid,'message'=>$log,'date'=>$this->student_m->date,'jd'=>$this->student_m->todayjd);
        $this->student_log_m->add_row($log_data);
        //marks student attendance
        $attendance=array('student_id'=>$this->LOGIN_USER->mid,'class_id'=>$this->LOGIN_USER->class_id,'subject_id'=>$this->data['subject']->mid,'jd'=>$this->lesson_m->todayjd);
        if($this->lesson_attendance_m->get_rows($attendance,'',true)<1){
            $attendance['datetime']=$this->lesson_attendance_m->datetime;
            $this->lesson_attendance_m->add_row($attendance,array('subject_id'));
        }
        //start watch time for this lesson
        $watchtime=array('student_id'=>$this->LOGIN_USER->mid,'class_id'=>$this->LOGIN_USER->class_id,'subject_id'=>$this->data['subject']->mid,'lesson_id'=>$rid,'jd'=>$this->lesson_m->todayjd);
        if($this->student_time_log_m->get_rows($watchtime,'',true)<1){
            $watchtime['start_time']=$this->student_time_log_m->datetime;
            $watchtime['end_time']=$this->student_time_log_m->datetime;
            $watchtime['start_timestamp']=time();
            $watchtime['end_timestamp']=time();
            $this->student_time_log_m->add_row($watchtime,array('subject_id','lesson_id'));
        }
        ////////////////////////////////////////////
        // $this->load->library('ytlinker');  

        $url='http://api.mozzine.com/ytlinker/index.php?url='.$this->data['lesson']->video_link;
        $resposne=json_decode($this->make_web_request($url));
        if(isset($resposne->status) && $resposne->status==true && isset($resposne->data) && !empty($resposne->data[0]->url)){
            // print_r($resposne->data);    exit;        
            $video_id=getVideoIdFromUrl($this->data['lesson']->video_link,'youtube');
            $this->data['iframe']=false;
            $this->data['video_image']='https://img.youtube.com/vi/' . $video_id . '/mqdefault.jpg';
            $this->data['video_link']=$resposne->data[0]->url;
            // if(isset($resposne->data[1])&&isset($resposne->data[1]->qualityLabel)&&!empty($resposne->data[1]->url)){
            //     if(strtolower($resposne->data[1]->qualityLabel)=='480p' || strtolower($resposne->data[1]->qualityLabel)=='720p'){
            //         $this->data['video_image']='https://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg';
            //         $this->data['video_link']=$resposne->data[1]->url;                    
            //     }
            // }
            // if(isset($resposne->data[2])&&isset($resposne->data[2]->qualityLabel)&&!empty($resposne->data[2]->url)){
            //     if(strtolower($resposne->data[2]->qualityLabel)=='480p' || strtolower($resposne->data[2]->qualityLabel)=='720p'){
            //         $this->data['video_image']='https://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg';
            //         $this->data['video_link']=$resposne->data[2]->url;                    
            //     }
            // }
        }
        // $this->ytlinker->initialize(getVideoIdFromUrl($this->data['lesson']->video_link,'youtube'));
        // $json=$this->ytlinker->get_info(getVideoIdFromUrl($this->data['lesson']->video_link,'youtube'));
        // $json=$this->ytlinker->get_video_info("pt40N_whXIU");
        // if($json===false){
        //     print 'invalid youtube link';
        // }else{
        //     print_r($json);            
        // }
        // exit;
        ////////////////////////////////////////////
        $this->lesson_m->update_column_value($rid,'views',1);
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }


    // create row
    public function updateWatchTime(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_get();
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
        //start watch time for this lesson
        $watchtime=array('student_id'=>$this->LOGIN_USER->mid,'class_id'=>$this->LOGIN_USER->class_id,'lesson_id'=>$form['rid'],'jd'=>$this->lesson_m->todayjd);
        if($this->student_time_log_m->get_rows($watchtime,'',true)<1){
            $lesson=$this->lesson_m->get_by_primary($form['rid']);
            $watchtime['subject_id']=$this->lesson->subject_id;
            $watchtime['lesson_id']=$this->lesson->mid;
            $watchtime['start_time']=$this->student_time_log_m->datetime;
            $watchtime['end_time']=$this->student_time_log_m->datetime;
            $watchtime['start_timestamp']=time();
            $watchtime['end_timestamp']=time();
            $this->student_time_log_m->add_row($watchtime,array('subject_id','lesson_id'));
        }else{
            $record=$this->student_time_log_m->get_by($watchtime,true);
            $new_data=array('end_timestamp'=>time());
            $new_data['end_time']=$this->student_time_log_m->datetime;
            $new_data['total_time']=$record->total_time+10;
            $this->student_time_log_m->save($new_data,$record->mid);            
        }
        //send back the resposne  
        echo json_encode($this->RESPONSE);exit();
    }



    // make a http get request
    public function make_web_request($url){  
        if(in_array  ('curl', get_loaded_extensions())) {
            $ch=curl_init();
            $timeout=5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            $result=curl_exec($ch);        //print $result;
            curl_close($ch);
            return $result;
        }
        else{
            $result = @file_get_contents($url);
            return $result;
        }
    }
/** 
* /////////////////////////////////////////////////////////////////////////////////////
* ************************** END OF CLASS *********************************************
* /////////////////////////////////////////////////////////////////////////////////////
*/

}
	