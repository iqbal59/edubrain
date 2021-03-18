<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lessons extends Staff_Controller{

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
	public function index($subject_id=''){
        $this->data['main_content']='lessons';  
        $this->data['menu']='lessons';            
        $this->data['sub_menu']='lessons';
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
        ///////////////////////////////////////////
        $this->data['classes']=$this->class_m->get_values_array('','name',array());
        $this->data['groups']=$this->group_m->get_values_array('','name',array());
        $this->data['sections']=$this->section_m->get_values_array('','name',array());
        $params['select']='mid,name,about,date,host,video_link,lesson_no';
        $filter['subject_id']=$subject_id;
        $this->data['subject']=$this->subject_m->get_by_primary($subject_id);
        $this->data['rows']=$this->lesson_m->get_rows($filter,$params);
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);  
	}
    // view lesson
    public function view($rid=''){
        $this->data['main_content']='lessons_view';  
        $this->data['menu']='lessons';            
        $this->data['sub_menu']='lessons';

        ////////////////////////////////////////////
        $this->lesson_m->update_column_value($rid,'views',1);
        $this->data['lesson']=$this->lesson_m->get_by_primary($rid);
        $this->data['subject']=$this->subject_m->get_by_primary($this->data['lesson']->subject_id);
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }




/** 
* /////////////////////////////////////////////////////////////////////////////////////
* ************************** END OF CLASS *********************************************
* /////////////////////////////////////////////////////////////////////////////////////
*/

}
	