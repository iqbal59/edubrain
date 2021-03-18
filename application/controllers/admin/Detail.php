<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detail extends Admin_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'detail/';
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
        $filter=array();
        $params=array('limit'=>1000);
        $search=array();
        $like=array();
        $form=$this->input->safe_get();
        $this->data['tab']='';
        if(isset($form['tab'])&&!empty($form['tab'])){$this->data['tab']=$form['tab'];}

        switch (strtolower($module)) {
            /////////////////edit class
            case 'homework':{
                if(empty($rid)){
                    $this->session->set_flashdata('error', 'Please choose a valid subject');
                    redirect($this->LIB_CONT_ROOT.'index/homework');
                }
                $this->data['main_content']='detail_homework';  
                $this->data['menu']='homework';            
                $this->data['sub_menu']='homework';
                //////////////////////////////////////
                $this->data['homework']=$this->homework_m->get_by_primary($rid);
                $this->data['class']=$this->class_m->get_by_primary($this->data['homework']->class_id);
                $this->data['subject']=$this->subject_m->get_by_primary($this->data['homework']->subject_id);
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                //////////////////////////////////////
                $filter['work_id']=$rid;
                $this->data['rows']=$this->homework_answer_m->get_rows($filter,array('select'=>'class_id,student_id,subject_id,answer,file,date','orderby'=>'mid ASC'));
                ///////////////////////////////////////////////////////////////////////////////////
                // $filter=array('class_id'=>$this->data['homework']->class_id);
                // $this->data['students']=$this->student_m->get_values_array('','name',$filter);
            }
            break; 
            /////////////////edit class
            case 'classes':{
                if(empty($rid)){
                    $this->session->set_flashdata('error', 'Please choose a valid class');
                    redirect($this->LIB_CONT_ROOT.'index/classes');
                }
                $this->data['main_content']='detail_class';  
                $this->data['menu']='classes';            
                $this->data['sub_menu']='classes';
                //////////////////////////////////////
                $this->data['row']=$this->class_m->get_by_primary($rid);
                //////////////////////////////////////
                $filter['class_id']=$rid;
                $this->data['total_student']=$this->student_m->get_rows($filter,'',true);
                $this->data['total_lesson']=$this->lesson_m->get_rows($filter,'',true);
                $this->data['total_qbank']=$this->qbank_m->get_rows($filter,'',true);
                $this->data['total_paper']=$this->paper_m->get_rows($filter,'',true);
                $this->data['subjects_arr']=$this->subject_m->get_values_array('','name',$filter);
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                //////////////////////////////////////
                $this->data['subjects']=$this->subject_m->get_rows($filter,array('select'=>'name'));
                $this->data['quizez']=$this->quiz_m->get_rows($filter,array('select'=>'class_id,subject_id,name,marks,date,jd,start_time'));
                $this->data['papers']=$this->paper_m->get_rows($filter,array('select'=>'class_id,subject_id,name,marks,date,jd,start_time'));
                $this->data['datesheet']=$this->datesheet_m->get_rows($filter,array('select'=>'class_id,section_id,title,file'));
                $this->data['syllabus']=$this->syllabus_m->get_rows($filter,array('select'=>'class_id,section_id,title,file'));
                $this->data['timetable']=$this->timetable_m->get_rows($filter,array('select'=>'class_id,section_id,title,file'));
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
                $this->data['main_content']='detail_student';  
                $this->data['menu']='students';            
                $this->data['sub_menu']='students';
                //////////////////////////////////////
                $this->data['row']=$this->student_m->get_by_primary($rid);
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['sections']=$this->section_m->get_values_array('','name',array());
                $this->data['subjects_arr']=$this->subject_m->get_values_array('','name',array());
                $this->data['lessons']=$this->lesson_m->get_values_array('','name',array('class_id'=>$this->data['row']->class_id));
                //////////////////////////////////////////////////////////////////////

                $params['select']='mid,message,date';
                $params['orderby']='mid DESC';
                $filter['student_id']=$this->data['row']->mid;
                $this->data['activity_log']=$this->student_log_m->get_rows($filter,$params);
                $params['select']='mid,ip_address,date';
                $this->data['login_log']=$this->student_login_m->get_rows($filter,$params);
                //////////////////////////////////////////////////////////////////////
                $params['select']='mid,subject_id,status,datetime';
                $params['orderby']='mid DESC';
                $filter['student_id']=$this->data['row']->mid;
                $this->data['att_log']=$this->lesson_attendance_m->get_rows($filter,$params);
                //////////////////////////////////////////////////////////////////////
                $params['select']='mid,subject_id,lesson_id,date,start_time,end_time,total_time';
                $params['orderby']='mid DESC';
                $filter['student_id']=$this->data['row']->mid;
                $this->data['time_log']=$this->student_time_log_m->get_rows($filter,$params);
                $this->data['total_watch_time']=$this->student_time_log_m->get_column_result('total_time',$filter);
                $filter['jd']=$this->user_m->todayjd;
                $this->data['today_watch_time']=$this->student_time_log_m->get_column_result('total_time',$filter);
                unset($filter['jd']);
                unset($filter['student_id']);
                //////////////////////////////////////////////////////////////////////
                $params['select']='mid,class_id,group_id,name';
                $params['orderby']='class_id ASC, group_id ASC, name ASC';
                $filter['class_id']=$this->data['row']->class_id;
                $this->data['subjects']=$this->subject_m->get_rows($filter,$params);
                //////////////////////////////////////////////////////////////////////
                $total_days=0;
                $present_days=0;
                $attendance=array();
                $fltr=array('student_id'=>$this->data['row']->mid,'month'=>$this->user_m->month,'year'=>$this->user_m->year);
                $att_log=$this->lesson_attendance_m->get_rows($fltr,array('select'=>'class_id,subject_id,day,datetime'));
                $days=days_in_month($this->user_m->month,$this->user_m->year);
                for($d=1;$d<=$days;$d++){
                    foreach($this->data['subjects'] as $sub){
                        $total_days++;                               
                        $attendance[$d][$sub['mid']]="";
                        if($d<=$this->user_m->day){$attendance[$d][$sub['mid']]="<span class='text-danger'>A</span>";}
                        foreach($att_log as $att){
                            if($att['day'] == $d){
                                if($att['subject_id'] == $sub['mid']){
                                    $attendance[$d][$sub['mid']]="<span class='text-success' title='".$att['datetime']."'>P</span>";
                                    $present_days++;

                                }
                            }
                        }
                    }                    
                }
                $this->data['daily_att_log']=$attendance;
                $this->data['daily_att_percent']= $total_days>0 ? round(($present_days/$total_days)*100,2) : '0';
                //////////////////////////////////////////////////////////////////////
            }
            break;  
            /////////////////edit staff
            case 'staff':{
                $this->data['main_content']='detail_staff';  
                $this->data['menu']='staff';            
                $this->data['sub_menu']='staff';
                //////////////////////////////////////
                empty($rid) ? redirect($this->LIB_CONT_ROOT) : '';
                $this->data['row']=$this->staff_m->get_by_primary($rid);
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['subjects_arr']=$this->subject_m->get_values_array('','name',array());
                $this->data['subjects']=$this->subject_m->get_rows(array(),array('select'=>'mid,class_id,name'));
                //////////////////////////////////////////////////////////////////////
                $params['select']='mid,subject_id,class_id,date';
                $params['orderby']='class_id ASC';
                $filter['staff_id']=$this->data['row']->mid;
                $this->data['staff_subjects']=$this->staff_subject_m->get_rows($filter,$params);
                //////////////////////////////////////////////////////////////////////
                $params['select']='mid,message,date';
                $params['orderby']='mid DESC';
                $filter['staff_id']=$this->data['row']->mid;
                $this->data['activity_log']=$this->staff_log_m->get_rows($filter,$params);
                $params['select']='mid,ip_address,date';
                $this->data['login_log']=$this->staff_login_m->get_rows($filter,$params);
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
        }

        /////////////////////////////////////////////////////////////
        $this->data['module']=strtolower($module);
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}


    //save profile pic
    public function upload_picture(){
        //upload artwork file
        $form=$this->input->safe_post();
        $redir=$this->CONT_ROOT.'mdl/students/'.$form['rid'];
        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($redir);                    
        }
        $file_name='pic_'.time().mt_rand(1001,9999);
        $path='./uploads/images/user';
        $data=$this->upload_img('file',$file_name,$path);
        if($data['file_uploaded']==FALSE){
            $this->session->set_flashdata('error', $data['file_error']);
            redirect($redir);
        }
        $nfile_name=$data['file_name'];
        $this->student_m->save(array('image'=>$nfile_name),$form['rid']);
        $this->session->set_flashdata('success', 'Photo uploaded successfully.');
        redirect($redir);           
    
    }
    //save profile pic
    public function upload_picture_staff(){
        //upload artwork file
        $form=$this->input->safe_post();
        $redir=$this->CONT_ROOT.'mdl/staff/'.$form['rid'];
        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($redir);                    
        }
        $file_name='pic_'.time().mt_rand(1001,9999);
        $path='./uploads/images/user';
        $data=$this->upload_img('file',$file_name,$path);
        if($data['file_uploaded']==FALSE){
            $this->session->set_flashdata('error', $data['file_error']);
            redirect($redir);
        }
        $nfile_name=$data['file_name'];
        $this->staff_m->save(array('image'=>$nfile_name),$form['rid']);
        $this->session->set_flashdata('success', 'Photo uploaded successfully.');
        redirect($redir);           
    
    }
    ////////////////////upload file///////////////////////////////
    private function upload_img($file_name='file',$new_name='',$path){  
        $size='5500';    //1.5MB
        $allowed_types='jpg|jpeg|png|bmp';
        $upload_file_name=$file_name;    
        $min_width=32;
        $min_height=32;
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
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        $redir=$this->CONT_ROOT.'mdl/'.strtolower($module).'/'.$rid;
        switch (strtolower($module)) {
            ///////save data
            case 'staff':{
                $required=array('subjects');
                foreach ($required as $key) {
                    if(!isset($form[$key]) || empty($form[$key])){
                        $this->session->set_flashdata('error', 'Please select a valid subjects');
                        redirect($redir.'?tab=subjects');
                    }
                } 

                $data=array('staff_id'=>$rid);
                //validate subjects
                if(is_array($form['subjects']) && count($form['subjects'])>0){
                    foreach($form['subjects'] as $sub_id){
                        //check for necessary data   
                        if($this->staff_subject_m->get_rows(array('staff_id'=>$rid,'subject_id'=>$sub_id),'',true)<1){
                            //assign subject to teacher
                            $subject=$this->subject_m->get_by_primary($sub_id);
                            $data['subject_id']=$subject->mid;
                            $data['class_id']=$subject->class_id;
                            $data['group_id']=$subject->group_id;
                            $this->staff_subject_m->add_row($data);
                        } 
                    }
                }
                //////////////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Subjects assigned successfully.');
                redirect($redir.'?tab=subjects');  
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


    public function del($module=''){

        $form=$this->input->safe_get();
        isset($form['rid']) ? $rid=$form['rid'] : $rid='';
        isset($form['sid']) ? $sid=$form['sid'] : $sid='';
        $redir=$this->CONT_ROOT.'mdl/'.strtolower($module).'/'.$sid;
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
            case 'staff':{
                //remove class                
                $row=$this->staff_subject_m->get_by_primary($rid);
                if($this->staff_subject_m->delete($rid)==false){
                    $this->session->set_flashdata('error', 'Subject cannot be removed at this time' );
                    redirect($redir.'?tab=subjects');
                }
                ///////////////////////////////////////////////////
                $this->session->set_flashdata('success', 'Subject removed successfully' );
                redirect($redir.'?tab=subjects');
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
	