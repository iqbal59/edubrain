<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends Install_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'install/';
        $this->LIB_VIEW_DIR = 'installation/'; 
        //load all models for this controller
        $models = array();
        $this->load->model($models);
        
    }
	
/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** PUBLIC FUNCTIONS *****************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index(){


        $this->data['main_content']='install_intro';
        $this->data['menu']='install'; 
        $this->data['config_path']= APPPATH . 'config/config.php'; 
        //load theme directory & module
        $this->load->view($this->LIB_VIEW_DIR . 'master', $this->data);
			
	}
        
    
    //start installation process
    public function start($module='') {

        //////////////////////////////////////////////////
        switch (strtolower($module)) {
            case 'admin':{
                $this->data['main_content']='install_useracct';
                $this->data['menu']='install';
            }break;            
            case 'config':{
                $this->data['main_content']='install_config';
                $this->data['menu']='install';
            }break;            
            default:{
                $this->data['main_content']='install_start';
                $this->data['menu']='install'; 
            }break;
        }

        //load theme directory & module
        $this->load->view($this->LIB_VIEW_DIR . 'master', $this->data);
            
    }  

    //validate database credentials
    public function processdb() {

        $form=$this->input->safe_post(array('dbname','dbuser','dbpassword'));
        // //handle brute force attack.
        $redir=$this->CONT_ROOT.'start';
        ////////////////////////////////////////////////////////////////

        if(empty($form['dbname']) || empty($form['dbuser']) ){
            $this->session->set_flashdata('error', 'Please enter Database Name, User and Password!');
            redirect($redir, 'refresh');
            exit();
        }
        set_time_limit(120);
        error_reporting(0);
        $hostname = "localhost";
        $username = $form['dbuser'];
        $password = $form['dbpassword'];
        $dbname = $form['dbname'];


        // Create connection
        $conn = mysqli_connect($hostname, $username, $password, $dbname);
        // Check connection
        if (mysqli_connect_errno() ) {
            $this->session->set_flashdata('error', "Connection failed: " .mysqli_connect_error() );
            redirect($redir, 'refresh');
            exit();
        }

        update_file_text(APPPATH.'config/database.php','db_username',$username);
        update_file_text(APPPATH.'config/database.php','db_password',$password);
        update_file_text(APPPATH.'config/database.php','db_name',$dbname);
        update_file_text(APPPATH.'config/app.php','db_username',$username);
        update_file_text(APPPATH.'config/app.php','db_password',$password);
        update_file_text(APPPATH.'config/app.php','db_name',$dbname);

        ////start migration to current version
        $this->load->library('migration');
        if ($this->migration->current() === FALSE){
            $this->session->set_flashdata('error', "Installation Error: " .$this->migration->error_string() );
            redirect($redir, 'refresh');
            exit();
        }
        //enter default settings
        $this->load->database();
        $this->load->model(array('system_setting_m'));
        $this->system_setting_m->process_install_settings();

        ////////////////////////////////////////////////////////////////////////////////////////
        $this->session->set_flashdata('success', "Database connection created successfully.<br> Please create Admin account below.");
        redirect($this->CONT_ROOT.'start/admin', 'refresh');
        exit();            
    }  
    //create admin account
    public function processadmin() {        
        $form=$this->input->safe_post(array('name','email','password','mobile'));
        //handle brute force attack.
        $redir=$this->CONT_ROOT.'start/admin';
        ////////////////////////////////////////////////////////////////

        if(empty($form['name']) || empty($form['email']) || empty($form['password']) ){
            $this->session->set_flashdata('error', 'Please enter  Name, Admin Email and Password!');
            redirect($redir, 'refresh');
            exit();
        }

        $this->load->database();
        $this->load->model(array('user_m'));
        $this->user_m->add_row(array(
            'name'=>$form['name'],
            'mobile'=>$form['mobile'],
            'email'=>$form['email'],
            'password'=>$form['password'],
            'type'=>$this->user_m->TYPE_ADMIN,
        ));
 
        $this->session->set_flashdata('success', 'Admin account created successfully. Admin email : <strong>'.$form['email'].'</strong>');
        redirect($this->CONT_ROOT.'start/config', 'refresh');
        exit();            
    }  

    //finish installation process
    public function processconfig() {        
        $form=$this->input->safe_post(array('org_name','org_address','org_contact_number'));
        //handle brute force attack.
        $redir=$this->CONT_ROOT.'start/config';

        $this->load->database();
        $this->load->model(array('system_setting_m'));
        $this->system_setting_m->save_settings_array($form);

        //////////////////////////////////////////////////////////
        update_file_text(APPPATH.'config/routes.php','install','home');
        $timestamp=time();
        rename(APPPATH.'controllers/Install.php', APPPATH.'controllers/Install_'.$timestamp.'.php');

 
        $this->session->set_flashdata('success', 'Installation process completed successfully. You may now login in system.');
        redirect($this->APP_ROOT.'', 'refresh');
        exit();            
    }  


/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** END OF CLASS *********************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

}
	