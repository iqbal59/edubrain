<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Admin_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'users/';
    }
	
/** 
* ////////////////////////////////////////////////////////////////////////////////
* ***************************** PUBLIC FUNCTIONS *********************************
* ////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index($tab=''){
		$this->data['main_content']='users';	
		$this->data['menu']='users';			
		$this->data['sub_menu']='users';
        $this->data['tab']=$tab;
        $this->ANGULAR_INC[]='users';

        /////////////////////////////////////////////////////////////
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}

    // view contact list
    public function profile($rid='',$tab=''){
        $this->data['main_content']='users_profile'; 
        $this->data['menu']='users';         
        $this->data['sub_menu']='users_profile';
        $this->data['tab']=$tab;
        $this->ANGULAR_INC[]='users_profile';

        if(empty($rid) || $this->user_m->get_rows(array(),'',true)<1){
            $this->session->set_flashdata('error', 'Please choose a valid record');
            redirect($this->LIB_CONT_ROOT.'', 'refresh'); 
        }
        $record=$this->user_m->get_by_primary($rid);   
        $this->data['record']=$record;       


        /////////////////////////////////////////////////////////////
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
	