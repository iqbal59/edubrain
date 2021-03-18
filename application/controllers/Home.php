<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Frontend_Controller{

/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** CONTANTS *************************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/	
	public $CONT_ROOT; //REFERENCE TO THIS CONTROLLER
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function __construct() {
        parent::__construct();
        
        //INIT CONSTANTS
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'home/';
        //load all models for this controller
    }
	
/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** PUBLIC FUNCTIONS *****************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index(){
		
		$this->data['main_content']='home';
		$this->data['menu']='home';			
		$this->data['sub_menu']='home';
        $this->data['form_action']='';
		$this->load->view($this->LIB_VIEW_DIR.'master', $this->data);	
	}


    //subscribe to news latter
    public function subscribe(){
        
        $this->data['main_content']='contact'; 
        $this->data['menu']='contact';         
        $this->data['sub_menu']='contact';
        $form=$this->input->safe_post();

        if(!isset($form['email']) || empty($form['email']) || !filter_var($form['email'], FILTER_VALIDATE_EMAIL)){
            $this->session->set_flashdata('error', 'Please enter a valid email address');
            redirect($this->APP_ROOT.'#subscription');
        }
        //check if user trying to subscribe multiple times from same ip address
        $ip_address=$this->input->ip_address();
        if($this->subscriber_m->get_rows(array('ip'=>$ip_address,'month'=>$this->user_m->month,'year'=>$this->user_m->year),'',true)>0){
            $this->session->set_flashdata('error', 'You are already subscribed!');
            redirect($this->APP_ROOT.'#subscription');
        }   
        //check if email already registered in the system
        if($this->subscriber_m->get_rows(array('email'=>$form['email']),'',true)>0){
            $this->session->set_flashdata('error', 'You are already subscribed!!');
            redirect($this->APP_ROOT.'#subscription');
        }   
        $record=array('email'=>$form['email'],'ip'=>$ip_address);
        $record['date']=$this->user_m->date;
        $record['day']=$this->user_m->day;
        $record['month']=$this->user_m->month;
        $record['year']=$this->user_m->year;
        $this->subscriber_m->add_row($record);
        //notify user about success
        $this->session->set_flashdata('success', 'You are successfully subscribed. We will notify you about upcoming news and events. Thanks');
        redirect($this->APP_ROOT.'#subscription'); 
    }

    
/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** END OF CLASS *********************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

}
	