<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit extends Staff_Controller{

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

        ////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
        ////////////////////////////////////////////////////////////////////////////////
        switch (strtolower($module)) {
            /////////////////edit lesson
            case 'lessons':{
                $this->data['main_content']='edit_lesson';  
                $this->data['menu']='lessons';            
                $this->data['sub_menu']='lessons';
                $this->data['iframe']=true;
                //////////////////////////////////////
                $this->data['hosts']=$this->root_m->get_hosts();
                $this->data['subjects']=$this->subject_m->get_rows(array(),array('select'=>'mid,name,class_id,group_id'));
                $this->data['classes']=$this->class_m->get_values_array('','name',array());
                $this->data['groups']=$this->group_m->get_values_array('','name',array());
                $this->data['row']=$this->lesson_m->get_by_primary($rid);
                $this->data['my_subjects']=$this->staff_subject_m->get_values_array('','subject_id',array('staff_id'=>$this->LOGIN_USER->mid));
                ///////////////////////////////////////////////
                $url='http://api.mozzine.com/ytlinker/index.php?url='.$this->data['row']->video_link;
                $resposne=json_decode($this->make_web_request($url));
                if(isset($resposne->status) && $resposne->status==true && isset($resposne->data) && !empty($resposne->data[0]->url)){
                    // print_r($resposne->data);    exit;        
                    $video_id=getVideoIdFromUrl($this->data['lesson']->video_link,'youtube');
                    $this->data['iframe']=false;
                    $this->data['video_image']='https://img.youtube.com/vi/' . $video_id . '/mqdefault.jpg';
                    $this->data['video_link']=$resposne->data[0]->url;
                    if(isset($resposne->data[1])&&isset($resposne->data[1]->qualityLabel)&&!empty($resposne->data[1]->url)){
                        if(strtolower($resposne->data[1]->qualityLabel)=='480p' || strtolower($resposne->data[1]->qualityLabel)=='720p'){
                            $this->data['video_image']='https://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg';
                            $this->data['video_link']=$resposne->data[1]->url;                    
                        }
                    }
                    if(isset($resposne->data[2])&&isset($resposne->data[2]->qualityLabel)&&!empty($resposne->data[2]->url)){
                        if(strtolower($resposne->data[2]->qualityLabel)=='480p' || strtolower($resposne->data[2]->qualityLabel)=='720p'){
                            $this->data['video_image']='https://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg';
                            $this->data['video_link']=$resposne->data[2]->url;                    
                        }
                    }
                }
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
                $this->data['row']=$this->qbank_m->get_by_primary($rid);
                $this->data['class']=$this->class_m->get_by_primary($this->data['row']->class_id);
                $this->data['subject']=$this->subject_m->get_by_primary($this->data['row']->subject_id);
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
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        $redir=$this->CONT_ROOT.'mdl/'.strtolower($module).'/'.$rid;
        switch (strtolower($module)) {
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

    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////

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
        }else{
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
	