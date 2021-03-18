<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detail extends Staff_Controller{

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
	