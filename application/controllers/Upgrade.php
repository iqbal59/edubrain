<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upgrade extends Install_Controller{

/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** CONTANTS *************************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/	
	public $CONT_ROOT; //REFERENCE TO THIS CONTROLLER
    public $_home_path;
    public $_download_path;
    public $_temp_path;
    public $_extract_path;
    public $_file_name;
    public $_zip_file_path;
    public $_log;
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function __construct() {
        parent::__construct();
        set_time_limit(0);
        //INIT CONSTANTS
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'upgrade/';
        $this->LIB_VIEW_DIR = 'installation/'; 
        //load all models for this controller
        $models = array();
        $this->load->model($models);
        ///////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////
        $this->_file_name='lms_file_'.date('ymd');
        $this->_home_path='./';
        $this->_download_path=$this->_home_path.'assets'.DIRECTORY_SEPARATOR.'downloads'.DIRECTORY_SEPARATOR;
        $this->_temp_path=$this->_home_path.'uploads'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
        $this->_extract_path=$this->_temp_path.'extract'.DIRECTORY_SEPARATOR;
        $this->_zip_file_path=$this->_temp_path.$this->_file_name.'.zip';
        $this->_log='';
        
    }
	
/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** PUBLIC FUNCTIONS *****************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index(){

        $this->data['main_content']='upgrade_intro';
        $this->data['menu']='install'; 
        $this->data['config_path']= APPPATH . 'config/config.php'; 
        //load theme directory & module
        $this->load->view($this->LIB_VIEW_DIR . 'master', $this->data);
			
	}
    public function domanual(){

        $this->load->library('migration');
        $this->migration->current();
        //redirect back
        $this->session->set_flashdata('success', "Upgrade Completed. ");
        redirect($this->LIB_CONT_ROOT.'auth/login', 'refresh');    
            
    }
        
    //upload file
    private function upload_zip($file_name='file',$new_name=''){ 
       $path='./uploads/temp';
       $size='95220';
       $allowed_types='zip';
       $upload_file_name=$file_name;        
       $upload_data=$this->upload_file($path,$size,$allowed_types,$upload_file_name,$new_name);
       return $upload_data;
    }   
    
    //start installation process
    public function start(){

        if($this->IS_DEMO){
            $this->session->set_flashdata('error', $this->config->item('app_demo_edit_err'));
            redirect($this->CONT_ROOT.'', 'refresh');                
        }
        //clear temp folder before proceed
        if(file_exists($this->_zip_file_path)){
            @unlink($this->_zip_file_path);
            $this->_log.="existing uploaded file removed from temp directory <br>";
        }
        @xdelete($this->_extract_path);
        $this->_log.="already extracted files deleted from the directory<br>";

        $form=$this->input->safe_post(array());
        $new_file_name=$this->_file_name;
        $data=$this->upload_zip('file',$this->_file_name);
        if($data['file_uploaded']==FALSE){
            $this->session->set_flashdata('error', $data['file_error']);
            redirect($this->CONT_ROOT);
        }
        //////////////////////////////////////////////////////////////////
        // extract file and show that updated version information
        $zip= new ZipArchive;
        $open_zip= $zip->open($this->_zip_file_path);
        if($open_zip){
            //extract zip
            $zip->extractTo($this->_extract_path);
            $zip->close();
            $this->_log.="uploaded zip file has been extracted in target directory<br>";
        }else{
            //extraction error            
            $this->session->set_flashdata('error', 'Upgrade process stopped due to an extraction error. Please contact support team');
            redirect($this->CONT_ROOT.'', 'refresh');  
        }
        ///////////////////////////////////////////////////////
        // validate that a valid version file has been uploaded
        $dir='application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR;
        $conf_file='app.php';
        if(!file_exists($this->_extract_path.$dir.$conf_file)){
            echo 'please upload a valid zip file issued by vendor';
            exit(1);
        }
        ///////////////////////////////////////////////////////

        //copy new migration files
        $dir='application'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR;
        $conf_file='Upgrade.php';
        if(file_exists($this->_extract_path.$dir.$conf_file)){
            if(copy($this->_extract_path.$dir.$conf_file,$this->_home_path.$dir.$conf_file)){
                $this->_log.="Upgrade.php controller file copied<br>";                
            }
        }
        $dir='application'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'installation'.DIRECTORY_SEPARATOR;
        $conf_file='upgrade_intro.php';
        if(file_exists($this->_extract_path.$dir.$conf_file)){
            if(copy($this->_extract_path.$dir.$conf_file,$this->_home_path.$dir.$conf_file)){
                $this->_log.="upgrade_intro.php view file copied<br>";
            }
        }
        $conf_file='upgrade_start.php';
        if(file_exists($this->_extract_path.$dir.$conf_file)){
            if(copy($this->_extract_path.$dir.$conf_file,$this->_home_path.$dir.$conf_file)){
                $this->_log.="upgrade_start.php view file copied<br>";
            }
        }

        $conf_file='upgrade_complete.php';
        if(file_exists($this->_extract_path.$dir.$conf_file)){
            if(copy($this->_extract_path.$dir.$conf_file,$this->_home_path.$dir.$conf_file)){
                $this->_log.="upgrade_complete.php view file copied<br>";
            }
        }

        //////////////////////////////////////////////////////     
        //changes made in this helper file for copying so copy this file first
        $dir='application'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR;
        $conf_file='tools_helper.php';
        if(file_exists($this->_extract_path.$dir.$conf_file)){
            if(copy($this->_extract_path.$dir.$conf_file,$this->_home_path.$dir.$conf_file)){
                $this->_log.="tools_helper.php helper file copied<br>";
            }
        }
        //////////////////////////////////////////////////////     
        $this->data['main_content']='upgrade_start';
        $this->data['menu']='install'; 
        $this->data['config_path']= APPPATH . 'config/config.php'; 
        //load theme directory & module
        $this->load->view($this->LIB_VIEW_DIR . 'master', $this->data);
    }  

    //start installation process
    public function complete(){
        set_time_limit(0);
        $app_name=$this->config->item('app_name');
        $app_description=$this->config->item('app_description');
        $app_doc_name=$this->config->item('app_doc_name');
        $result_code=0;
        // copy all new files to actual folder
        //////////////////////////////////////////////////////////////////////////////////////
        $dir='angular';
        if(file_exists($this->_extract_path.$dir)){
            $this->_log.=xcopy($this->_extract_path.$dir,$this->_home_path.$dir);
            $result_code++;
        }
        $dir='application'.DIRECTORY_SEPARATOR.'controllers';
        if(file_exists($this->_extract_path.$dir)){
            $this->_log.=xcopy($this->_extract_path.$dir,$this->_home_path.$dir);
            $result_code++;
        }
        $dir='application'.DIRECTORY_SEPARATOR.'core';
        if(file_exists($this->_extract_path.$dir)){
            $this->_log.=xcopy($this->_extract_path.$dir,$this->_home_path.$dir);
            $result_code++;
        }
        $dir='application'.DIRECTORY_SEPARATOR.'helpers';
        if(file_exists($this->_extract_path.$dir)){
            $this->_log.=xcopy($this->_extract_path.$dir,$this->_home_path.$dir);
            $result_code++;
        }
        $dir='application'.DIRECTORY_SEPARATOR.'migrations';
        if(file_exists($this->_extract_path.$dir)){
            $this->_log.=xcopy($this->_extract_path.$dir,$this->_home_path.$dir);
            $result_code++;
        }
        $dir='application'.DIRECTORY_SEPARATOR.'models';
        if(file_exists($this->_extract_path.$dir)){
            $this->_log.=xcopy($this->_extract_path.$dir,$this->_home_path.$dir);
            $result_code++;
        }
        $dir='application'.DIRECTORY_SEPARATOR.'views';
        if(file_exists($this->_extract_path.$dir)){
            $this->_log.=xcopy($this->_extract_path.$dir,$this->_home_path.$dir);
            $result_code++;
        }
        
        //copy assets folder
        $dir='assets'.DIRECTORY_SEPARATOR.'downloads';
        if(file_exists($this->_extract_path.$dir)){
            $this->_log.=xcopy($this->_extract_path.$dir,$this->_home_path.$dir);
            $result_code++;
        }
        $dir='assets'.DIRECTORY_SEPARATOR.'portal';
        if(file_exists($this->_extract_path.$dir)){
            $this->_log.=xcopy($this->_extract_path.$dir,$this->_home_path.$dir);
            $result_code++;
        }
        $dir='assets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'css';
        if(file_exists($this->_extract_path.$dir)){
            $this->_log.=xcopy($this->_extract_path.$dir,$this->_home_path.$dir);
            $result_code++;
        }
        
        //copy app and migration file
        $dir='application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR;
        $conf_file='app.php';
        if(file_exists($this->_extract_path.$dir.$conf_file)){
            if(copy($this->_extract_path.$dir.$conf_file,$this->_home_path.$dir.$conf_file)){
                $this->_log.="application/config/app.php file copied.<br>";
                $result_code++;
            }else{
                $this->_log.="application/config/app.php file can not be copied.<br>";
            }
        }
        $conf_file='migration.php';
        if(file_exists($this->_extract_path.$dir.$conf_file)){
            if(copy($this->_extract_path.$dir.$conf_file,$this->_home_path.$dir.$conf_file)){
                $this->_log.="application/config/migration.php file copied.<br>";
                $result_code++;
            }else{
                $this->_log.="application/config/migration.php file can not be copied.<br>";
            }
        }
        //************************************************************************************
        $config_home=$this->_home_path.'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR; 

        $find='$config[\'app_name\'] = ';
        $replace='$config[\'app_name\'] = "'.$app_name.'";  //';
        update_file_text($config_home.'app.php',$find,$replace);


        $find='$config[\'app_description\'] = ';
        $replace='$config[\'app_description\'] = "'.$app_description.'";  //';
        update_file_text($config_home.'app.php',$find,$replace);


        $find='$config[\'app_doc_name\'] = ';
        $replace='$config[\'app_doc_name\'] = "'.$app_doc_name.'";  //';
        update_file_text($config_home.'app.php',$find,$replace);


        $this->load->library('migration');
        $this->migration->current();
        
        ///////////////////////////////////////////////////////////////////////////////////////
        //validate default settings
        $models = array('system_setting_m');
        $this->load->model($models);
        $this->system_setting_m->recheck_settings();
        ///////////////////////////////////////////////////////////////////////////////////////

        //clear temp folder after upgrade
        if(file_exists($this->_zip_file_path)){unlink($this->_zip_file_path);}
        @xdelete($this->_extract_path);

        //////////////////////////////////////////////////////     
        $this->data['main_content']='upgrade_complete';
        $this->data['menu']='install'; 
        $this->data['config_path']= APPPATH . 'config/config.php'; 
        //load theme directory & module
        $this->load->view($this->LIB_VIEW_DIR . 'master', $this->data);  
    }  



/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** END OF CLASS *********************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

}
	