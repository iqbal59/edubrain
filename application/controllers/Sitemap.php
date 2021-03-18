<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends Frontend_Controller{

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
        $this->CONT_ROOT=$this->LIB_CONT_ROOT.'sitemap/';
        //load all models for this controller
    }
	
/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** PUBLIC FUNCTIONS *****************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/	
	// default function for this controller (index)
	public function index(){
		
		$this->data['main_content']='sitemap';	
		$this->data['menu']='sitemap';			
		$this->data['sub_menu']='sitemap';

        $this->data['domain_name']='mozzinehosting.com';
        $this->data['home_page']='http://mozzinehosting.com';
        $hard_pages=array(
            $this->APP_ROOT.''=>$this->PAGE_TITLE.'',
            $this->APP_ROOT.'about'=>'About Mozzine Hosting',
            $this->APP_ROOT.'contact'=>'Contact Mozzine Hosting',
            $this->APP_ROOT.'policy'=>'Mozzine Hosting: Legal Policy',
            $this->APP_ROOT.'privacy'=>'Mozzine Hosting: Privacy Policy',
            $this->APP_ROOT.'terms'=>'Mozzine Hosting: Terms of Services',
        );
        $this->data['hard_pages']=$hard_pages;
        /////////////////////////////////////////////////////////////////////////////
        $db_pages=array();
        $pages=$this->page_m->get_rows(array(),array('select'=>'title,seo_desc,slug','orderby'=>'mid DESC'));
        $this->data['db_pages']=$pages;
        //////////////////////////////////////////////////////////////////////////////
        $blog_posts=array();
        $blog=$this->post_m->get_rows(array(),array('select'=>'title,seo_desc,slug','orderby'=>'mid DESC'));
        $this->data['blog_posts']=$blog;
        ///////////////////////////////////////////////////////////////////////////////

        $this->data['total_pages']=count($hard_pages)+count($db_pages)+count($blog_posts)+1;
        $this->data['last_updated']=date('Y, M ').(date('d')-1).date(' H:i:s');  //2020, May 19 04:56:20set to 4 hours before
		$this->load->view($this->LIB_VIEW_DIR.'sitemap', $this->data);	
	}


/** 
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
* ***************************************** END OF CLASS *********************************************************
* ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/

}
	