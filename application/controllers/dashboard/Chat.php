<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends Student_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'chat/';
    }
	
/** 
* ////////////////////////////////////////////////////////////////////////////////
* ***************************** PUBLIC FUNCTIONS *********************************
* ////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index($module=''){
        exit('404 Error!');	
	}
    // default function for this controller (index)
    public function groupview($rid='',$page=0){

        $filter=array();
        $params=array();
        $search=array();
        $like=array();
        $form=$this->input->safe_get();
        //load group chat
        $this->data['main_content']='chat_groupview';  
        $this->data['menu']='chatgroups';            
        $this->data['sub_menu']='chatgroups';
        $this->ANGULAR_INC[]='chat_groupview';
        $params['limit']=1000;
        $params['offset']=intval($page)*$params['limit'];
        ///////////////////////////////////////////////////////////////
        $search=array('name');
        if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
        isset($form['search']) ? $params['like']=$like : '';
        ///////////////////////////////////////////
        $this->data['classes']=$this->class_m->get_values_array('','name',array());
        $this->data['groups']=$this->group_m->get_values_array('','name',array());
        $this->data['sections']=$this->section_m->get_values_array('','name',array());
        $this->data['students']=$this->student_m->get_values_array('','name',array());
        $this->data['staff']=$this->staff_m->get_values_array('','name',array());
        $this->data['users']=$this->user_m->get_values_array('','name',array());
        $params['select']='mid,message';
        $filter['chat_group_id']=$rid;
        $this->data['row']=$this->chat_group_m->get_by_primary($rid);
        $this->data['rows']=$this->chat_group_message_m->get_rows($filter,$params);

        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }


    // one to one chat function
    public function messages($sid='',$page=0){

        $filter=array();
        $params=array();
        $search=array();
        $like=array();
        $form=$this->input->safe_get();
        //load group chat
        $this->data['main_content']='chat_messages';  
        $this->data['menu']='messages';            
        $this->data['sub_menu']='messages';
        $this->ANGULAR_INC[]='chat_messages';
        $params['limit']=1000;
        $params['offset']=intval($page)*$params['limit'];
        ///////////////////////////////////////////////////////////////
        $chat_id=0;
        $user_filter=array('staff_id'=>$sid,'student_id'=>$this->LOGIN_USER->mid);
        if($this->chat_m->get_rows($user_filter,'',true)<1){
            //first interaction with teacher. add to conversation
            $conversation=array('staff_id'=>$sid,'student_id'=>$this->LOGIN_USER->mid);
            $chat_id=$this->chat_m->add_row($conversation,array('int'=>'staff_id'));
        }else{
            $chat_id=$this->chat_m->get_by($user_filter,true)->mid;
        }        
        $this->data['chat_id']=$chat_id;

        $this->chat_m->save(array('stf_update'=>0),$chat_id);
        ///////////////////////////////////////////////////////////////
        $search=array('name');
        if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
        isset($form['search']) ? $params['like']=$like : '';
        ///////////////////////////////////////////
        $this->data['classes']=$this->class_m->get_values_array('','name',array());
        $this->data['groups']=$this->group_m->get_values_array('','name',array());
        $this->data['sections']=$this->section_m->get_values_array('','name',array());
        $this->data['staff']=$this->staff_m->get_by_primary($sid);
        /////////////////////////////////////////////////////////////////
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }


    //save profile pic
    public function upload_picture(){
        //upload artwork file
        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->LIB_CONT_ROOT, 'refresh');                    
        }
        $form=$this->input->safe_post();
        $chat=$this->chat_m->get_by_primary($form['rid']);
        $redir=$this->CONT_ROOT.'messages/'.$chat->staff_id;
        $file_name='file_'.time().mt_rand(1001,9999);
        $path='./uploads/files/chat';
        $data=$this->upload_img('file',$file_name,$path);
        if($data['file_uploaded']==FALSE){
            $this->session->set_flashdata('error', $data['file_error']);
            redirect($redir);
        }
        $nfile_name=$data['file_name'];
        $data=array();
        if(strpos(strtolower($nfile_name),".png") !== false || strpos(strtolower($nfile_name),".jpg") !== false || strpos(strtolower($nfile_name),".jpeg") !== false || strpos(strtolower($nfile_name),".bmp") !== false || strpos(strtolower($nfile_name),".gif") !== false){
            $data['image']=$nfile_name;
        }else{
            $data['file']=$nfile_name;
        }
        $data['chat_id']=$chat->mid;
        $data['student_id']=$this->LOGIN_USER->mid;
        $data['date']=$this->user_m->datetime;
        $this->chat_message_m->add_row($data);
        $this->session->set_flashdata('success', 'File uploaded successfully.');
        redirect($redir);           
    
    }
    //save profile pic
    public function group_upload_picture(){
        //upload artwork file
        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->LIB_CONT_ROOT, 'refresh');                    
        }
        $form=$this->input->safe_post();
        $redir=$this->CONT_ROOT.'groupview/'.$form['rid'];
        $file_name='file_'.time().mt_rand(1001,9999);
        $path='./uploads/files/chat';
        $data=$this->upload_img('file',$file_name,$path);
        if($data['file_uploaded']==FALSE){
            $this->session->set_flashdata('error', $data['file_error']);
            redirect($redir);
        }
        $nfile_name=$data['file_name'];
        $data=array();
        if(strpos(strtolower($nfile_name),".png") !== false || strpos(strtolower($nfile_name),".jpg") !== false || strpos(strtolower($nfile_name),".jpeg") !== false || strpos(strtolower($nfile_name),".bmp") !== false || strpos(strtolower($nfile_name),".gif") !== false){
            $data['image']=$nfile_name;
        }else{
            $data['file']=$nfile_name;
        }
        $data['chat_group_id']=$form['rid'];
        $data['student_id']=$this->LOGIN_USER->mid;
        $data['date']=$this->user_m->datetime;
        $this->chat_group_message_m->add_row($data);
        $this->session->set_flashdata('success', 'File uploaded successfully.');
        redirect($redir);           
    
    }
    ////////////////////upload file///////////////////////////////
    private function upload_img($file_name='file',$new_name='',$path){  
        $size='15000';    //1.5MB
        $allowed_types='jpg|jpeg|png|bmp|pdf|zip|xls|xlsx|ppt|pptx|doc|docx';
        $upload_file_name=$file_name;    
        $min_width=150;
        $min_height=150;
        $upload_data=$this->upload_file($path,$size,$allowed_types,$upload_file_name,$new_name);
        return $upload_data;
    }  

    /** 
    * /////////////////////////////////////////////////////////////////////
    * *********************** AJAX FUNCTIONS ******************************
    * /////////////////////////////////////////////////////////////////////
    */

    // filter rows
    public function filterGroupMessages(){
        // get input fields into array
        $filter=array();
        $params=array('orderby'=> 'created ASC');
        $search=array();
        $like=array();
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_get();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
        ///////////////////////////////////////////
        $params['limit']=1000;
        $filter['chat_group_id']=$form['rid'];
        $params['select']='student_id,staff_id,message,image,file,day,month,year,date,created';
        $this->RESPONSE['rows']=$this->chat_group_message_m->get_rows($filter,$params);
        ////////////////////////////////////////////////////////////////////////
        $students=$this->student_m->get_values_array('','name',array());
        $staff=$this->staff_m->get_values_array('','name',array());
        $i=0;
        foreach($this->RESPONSE['rows'] as $row){

            if($row['day']==$this->user_m->day && $row['month']==$this->user_m->month && $row['year']==$this->user_m->year){
                $this->RESPONSE['rows'][$i]['time']=ago_time($row['created']);
            }else{
                $this->RESPONSE['rows'][$i]['time']=$row['date'];
            }
            if($row['student_id']>0){$this->RESPONSE['rows'][$i]['student_name']=$students[$row['student_id']];}
            if($row['staff_id']>0){$this->RESPONSE['rows'][$i]['staff_name']=$staff[$row['staff_id']];}
            ////////////////////////////////////////////////////////////////////////////////////////////////////
            $i++;
        }
        ///////////////////////////////////////////////
        echo json_encode($this->RESPONSE);
        
    }

    // create row
    public function addGroupMessage(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        //check for necessary required data   
        $required=array('rid','message');
        foreach ($required as $key) {
            if(!isset($form[$key]) || empty($form[$key])){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please provide required information ...';
            echo json_encode($this->RESPONSE);exit();
            }
        }   
        $form['chat_group_id']=$form['rid'];
        $form['student_id']=$this->LOGIN_USER->mid;
        $form['date']=$this->user_m->datetime;
        $rid=$this->chat_group_message_m->add_row($form);
        if($rid===false){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Process stopped. Please try again later!';
            echo json_encode($this->RESPONSE);exit();            
        }
        //send back the resposne  
        echo json_encode($this->RESPONSE);exit();
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


    /** 
    * /////////////////////////////////////////////////////////////////////
    * *********************** AJAX FUNCTIONS ******************************
    * /////////////////////////////////////////////////////////////////////
    */

    // filter rows
    public function filterMessages(){
        // get input fields into array
        $filter=array();
        $params=array('orderby'=> 'created ASC');
        $search=array();
        $like=array();
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_get();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($form['search'])){foreach($search as $value){$like[$value]=$form['search'];} }
        ///////////////////////////////////////////
        $params['limit']=1000;
        $filter['chat_id']=$form['rid'];
        $params['select']='student_id,staff_id,message,image,file,day,month,year,date,created';
        $this->RESPONSE['rows']=$this->chat_message_m->get_rows($filter,$params);
        ////////////////////////////////////////////////////////////////////////
        $chat=$this->chat_m->get_by_primary($form['rid']);
        $student=$this->student_m->get_by_primary($chat->student_id);
        $staff=$this->staff_m->get_by_primary($chat->staff_id);
        $i=0;
        foreach($this->RESPONSE['rows'] as $row){

            if($row['day']==$this->user_m->day && $row['month']==$this->user_m->month && $row['year']==$this->user_m->year){
                $this->RESPONSE['rows'][$i]['time']=ago_time($row['created']);
            }else{
                $this->RESPONSE['rows'][$i]['time']=$row['date'];
            }
            if($row['student_id']>0){$this->RESPONSE['rows'][$i]['student_name']=$student->name;}
            if($row['staff_id']>0){$this->RESPONSE['rows'][$i]['staff_name']=$staff->name;}
            ////////////////////////////////////////////////////////////////////////////////////////////////////
            $i++;
        }
        ///////////////////////////////////////////////
        echo json_encode($this->RESPONSE);
        
    }

    // create row
    public function addMessage(){
        // get input fields into array       
        $this->RESPONSE['error']=FALSE;
        $form=$this->input->safe_post();
        ENVIRONMENT !== 'production' ? $this->RESPONSE['request']=$form: '';
        //check for necessary required data   
        $required=array('rid','message');
        foreach ($required as $key) {
            if(!isset($form[$key]) || empty($form[$key])){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Please provide required information ...';
            echo json_encode($this->RESPONSE);exit();
            }
        }   
        $chat=$this->chat_m->get_by_primary($form['rid']);
        $form['chat_id']=$chat->mid;
        $form['student_id']=$chat->student_id;
        $form['date']=$this->user_m->datetime;
        $rid=$this->chat_message_m->add_row($form);
        if($rid===false){
            $this->RESPONSE['error']=TRUE;
            $this->RESPONSE['message']='Process stopped. Please try again later!';
            echo json_encode($this->RESPONSE);exit();            
        }
        $this->chat_m->save(array('name'=>$form['message'],'std_update'=>1),$chat->mid);
        //send back the resposne  
        echo json_encode($this->RESPONSE);exit();
    }

    // update row
    public function deleteMessage(){
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



/** 
* /////////////////////////////////////////////////////////////////////////////////////
* ************************** END OF CLASS *********************************************
* /////////////////////////////////////////////////////////////////////////////////////
*/

}
	