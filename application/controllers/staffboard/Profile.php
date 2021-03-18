<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends Staff_Controller{

/** 
* ////////////////////////////////////////////////////////////////////////////////////
* **************************** CONTANTS **********************************************
* ////////////////////////////////////////////////////////////////////////////////////
*/	
	public $CONT_ROOT; //REFERENCE TO THIS CONTROLLER
	
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
	function __construct() {
        parent::__construct();
        
        //INIT CONSTANTS
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'profile/';
        //load all models for this controller
        $this->load->model(array());
        //load all models for this controller
        $models = array();
        //load all models in above array
        foreach($models as $mdl=>$tbl){
            $this->load->model('common_m',$mdl);
            $this->$mdl->init(array('table'=>$tbl));
        }
        
    }
	
/** 
* //////////////////////////////////////////////////////////////////////////////////////////////
* ******************************** PUBLIC FUNCTIONS ********************************************
* //////////////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index(){		
		$this->data['main_content']='profile';	
		$this->data['menu']='profile';			
		$this->data['sub_menu']='profile';
		$this->data['tab']=$this->uri->segment(4);
        ////////////////////////////////////////////////////////////////////////////////
        if(isset($this->LOGIN_USER->reset_password) && $this->LOGIN_USER->reset_password>0){
            $this->session->set_flashdata('success', 'Please Update your password to proceed further.');
            redirect($this->LIB_CONT_ROOT.'profile/reset', 'refresh');
        }
		////////////////////////////////////////////////////////////////////////////////
		$filter=array();
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}
    // force password reset
    public function reset(){        
        $this->data['main_content']='profile_reset';  
        $this->data['menu']='profile';          
        $this->data['sub_menu']='profile';
        $this->data['tab']=$this->uri->segment(4);
        ////////////////////////////////////////////////////////////////////////////////
        $filter=array();
        $this->load->view($this->LIB_VIEW_DIR.'master', $this->data);   
    }
    // edit profile
	public function edit(){		
		$this->data['main_content']='profile_edit';	
		$this->data['menu']='profile';			
		$this->data['sub_menu']='profile';
		$this->data['tab']=$this->uri->segment(4);
		////////////////////////////////////////////////////////////////////////////////
		$filter=array();
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}
    

    //save profile pic
    public function save($module=''){
        switch (strtolower($module)) {
            case 'profile':{                
                $form=$this->input->safe_post(array("name","mobile","father_name"));
                if($this->IS_DEMO){
                    $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
                    redirect($this->LIB_CONT_ROOT.'profile/edit', 'refresh');                    
                }
                if(empty($form['name']) ){
                    $this->session->set_flashdata('error', 'Please provide name');
                    redirect($this->LIB_CONT_ROOT.'profile/edit', 'refresh');                    
                }
                $this->staff_m->save($form,$this->LOGIN_USER->mid);
                $this->session->set_flashdata('success', 'Profile Updated Successfully.');
                redirect($this->LIB_CONT_ROOT.'profile/edit', 'refresh'); 

            }
            break;
            case 'password':{                
                $form=$this->input->safe_post(array("password","npassword"));
                if($this->IS_DEMO){
                    $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
                    redirect($this->LIB_CONT_ROOT.'profile/edit/password', 'refresh');                    
                }
                if(empty($form['password']) || empty($form['npassword'])){
                    $this->session->set_flashdata('error', 'Please provide current and new password');
                    redirect($this->LIB_CONT_ROOT.'profile/edit/password', 'refresh');                    
                }
                if($this->staff_m->hash($form['password'])!=$this->LOGIN_USER->password){
                    $this->session->set_flashdata('error', 'Wrong Current password');
                    redirect($this->LIB_CONT_ROOT.'profile/edit/password', 'refresh');                    
                }
                $this->staff_m->save(array('password'=>$this->staff_m->hash($form['npassword'])),$this->LOGIN_USER->mid);
                $this->session->set_flashdata('success', 'Password Updated Successfully.');
                redirect($this->LIB_CONT_ROOT.'profile/edit/password', 'refresh'); 

            }
            break;
            case 'preset':{                
                $form=$this->input->safe_post(array("password"));
                if($this->IS_DEMO){
                    $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
                    redirect($this->LIB_CONT_ROOT.'profile/reset/password', 'refresh');                    
                }
                if(empty($form['password']) ){
                    $this->session->set_flashdata('error', 'Please provide new password');
                    redirect($this->LIB_CONT_ROOT.'profile/reset/password', 'refresh');                    
                }
                $this->staff_m->save(array('password'=>$this->staff_m->hash($form['password']),'reset_password'=>0),$this->LOGIN_USER->mid);
                $this->session->set_flashdata('success', 'Password Updated Successfully.');
                redirect($this->LIB_CONT_ROOT.'', 'refresh'); 

            }
            break;
            
            default:{
                $this->session->set_flashdata('error', 'Please choose a valid operation');
                redirect($this->LIB_CONT_ROOT.'profile/edit', 'refresh');
            }
            break;
        }         
    
    }


/** 
* ////////////////////////////////////////////////////////////////////////////////////
* ***************************** END OF CLASS *****************************************
* ////////////////////////////////////////////////////////////////////////////////////
*/

}
	