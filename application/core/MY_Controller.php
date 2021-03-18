<?php
//root controller of app
class MY_Controller extends CI_Controller {

    //Global Vars
    public $APP_ROOT;
    public $CDN_ROOT;
    public $RES_ROOT;
    public $UPLOADS_ROOT;
    public $ANGULAR_ROOT;
    public $BODY_INIT = '';
    public $FILE_VERSION = '?ver=2.4.0';
    public $SORT_ICON= ' ng-class="{\'icon-sort-amount-asc\':appConfig.sortAsc,\'icon-sort-amount-desc\':appConfig.sortDesc}" ';
    public $MODAL_OPTIONS = ' data-toggle="modal" data-backdrop="static" data-kayboard="false" ';
    public $POPOVER_ICON = ' class="icon icon-question3" style="font-size: 0.9em;" data-html="true" data-popup="popover" data-trigger="hover" data-placement="top"  ';
    public $SETTINGS = array();
    public $data = array();
    public $PAGE_LIMIT=100;
    public $PAGINATION_LIMIT=5;
    public $PRINT_PAGE_LAYOUT ='';
    public $PRINT_PAGE_SIZE ='A4';
    public $ANGULAR_INC = array();
    public $THEME_INC = array();
    public $HEADER_INC = array();
    public $FOOTER_INC = array();
    public $RESPONSE = array();
    public $IS_DEMO = false;
    public $LOGIN_FLAG = false;
    public $IS_DEV_MODE_ENABLE = false;
    public $SITE_LANG = 'en';         
    public $PAGE_TITLE = 'LMS and online exam system';      //keep it under 60 chars   
    public $PAGE_SUBTITLE = 'LMS and online exam system';      //keep it under 60 chars   
    public $PAGE_URL = '';         
    public $PAGE_AUTHOR = 'LMS - Exam System';         
    public $SEO_DESC = 'Best LMS and online exam system developed by fabsampk : codecanyon';         
    public $SEO_KEYWORDS = '';       
    public $SEO_IMAGE = '';       
    public $SEO_URL = 'https://www.mozzine.work/';         
    public $META_PUBLISHED_TIME = '';   //2020-01-09T09:01:35+00:00   
    public $META_MODIFIED_TIME = '';    //2020-01-09T09:01:35+00:00   
    public $META_SITE_NAME = 'Mozzine LMS';   
    public $PORTAL_URL = '';   
    public $BG_THEME = '';   


    ///////////////////// CONTSTRUCTOR FOR INIT ADMIN APP //////////////////////////
    function __construct() {
        parent::__construct();
        ///////GENERAL SETTINGS/////////////
        ini_set('memory_limit','2048M');
        ini_set('allow_url_fopen',1);

        //INIT HOST NAME
        //INIT APP Globals	
        //$this->FILE_VERSION .=date('dmY').time();
        $this->tools->set_base_url();
        $this->APP_ROOT = base_url();
        $this->RES_ROOT = $this->APP_ROOT.'assets/portal/';
        $this->UPLOADS_ROOT = $this->APP_ROOT . 'uploads/';
        $this->ANGULAR_ROOT = $this->APP_ROOT . 'angular/';
        $this->THEME_RES_ROOT = $this->APP_ROOT.'assets/themes/default/';
        $this->data['main_content'] = 'index';
        $this->data['menu'] = '';
        $this->data['sub_menu'] = '';
        $this->data['page_title'] =  'Home';
        //SITE TEMPLATED VARS
        $this->data['body_init'] = ''; 
        ///////LOAD GENERAL MODELS FOR THIS LIBRARY
        $models = array('user_m','system_history_m','system_setting_m','login_session_m','root_m','staff_m','student_m');
        $this->load->model($models);
    }

    //upload method for subclasses
    public function upload_file($path,$size,$allowed_types,$upload_file_name,$new_name='',$min_width=0,$min_height=0,$max_width=0,$max_height=0){
        $config['upload_path']=$path;   //$path='./assets/uploads/artwork';
        $config['allowed_types']=$allowed_types;    //$allowed_types='jpg|png|';
        $config['min_height']=$min_height;
        $config['min_width']=$min_width;
        $config['overwrite']=true;
        $config['max_size']=$size;  //in KiloBytes //$size='5120';
        $config['max_width']=$max_width;
        $config['max_height']=$max_height;
        if(!empty($new_name)){$config['file_name']=$new_name;}
        $this->load->library('upload',$config);
        if(!$this->upload->do_upload($upload_file_name)){
            $upload_data =$this->upload->data();
            $upload_data['file_uploaded']=FALSE;
            $error=$this->upload->display_errors();
            $upload_data['file_error']=$error;
            return $upload_data;                
        }else{
            $upload_data =$this->upload->data();
            $upload_data['file_uploaded']=TRUE;
            return $upload_data;
        }
    }
    

}

//////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////CLASS FOR Frontend ACCESS//////////////
//////////////////////////////////////////////////////////////////////////////////
class Install_Controller extends MY_Controller {

    //Global Vars
    public $LIB_CONT_ROOT = '';
    public $LIB_VIEW_DIR = '';
    public $LOGIN_ID = '';
    public $LOGIN_USER = NULL;
    public $LOGIN_FLAG = FALSE;
    public $IS_SUPER_ADMIN = FALSE;
    public $IS_ADMIN = FALSE;
    public $IS_USER = FALSE;
    public $IS_STAFF = FALSE;

    ///////////////////// CONTSTRUCTOR FOR INIT ADMIN APP //////////////////////////
    function __construct() {
        parent::__construct();
        // INIT CONSTANTS
        $this->LIB_CONT_ROOT = $this->APP_ROOT;
        $this->LIB_VIEW_DIR = 'public/default/'; 
        $this->THEME_RES_ROOT = $this->APP_ROOT.'assets/themes/default/';
        $this->data['main_content'] = 'index';
        ////////////////////////////////////////////////////////////////////////
        ////////////DEFINE GLOBAL VARIABLES---LOAD CONSTANTS IN DATA ARRAY//////

        $this->data['LIB_CONT_ROOT'] = $this->LIB_CONT_ROOT;  //HELPFUL IN VIEW FILES
        $this->data['LIB_VIEW_DIR'] = $this->LIB_VIEW_DIR; //HELPFUL IN VIEW DIR (MASTER.PHP)
        /////////////////////////////////////////////////////////////////////        
        $this->data['LOGIN_ID'] = $this->LOGIN_ID;
        $this->data['LOGIN_USER'] = $this->LOGIN_USER;
        $this->data['LOGIN_FLAG'] = $this->LOGIN_FLAG;
    }

}

//////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////CLASS FOR Front-end ACCESS//////////////
//////////////////////////////////////////////////////////////////////////////////
class Frontend_Controller extends MY_Controller {

    //Global Vars
    public $LIB_CONT_ROOT = '';
    public $LIB_VIEW_DIR = '';
    public $LOGIN_ID = '';
    public $LOGIN_USER = '';

    ///////////////////// CONTSTRUCTOR FOR INIT ADMIN APP //////////////////////////
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->SETTINGS=$this->system_setting_m->get_settings_array();
        isset($this->SETTINGS[$this->system_setting_m->_WS_PUBLISH_TIME])?$this->META_PUBLISHED_TIME=$this->SETTINGS[$this->system_setting_m->_WS_PUBLISH_TIME]:'';
        isset($this->SETTINGS[$this->system_setting_m->_WS_MODIFY_TIME])?$this->META_MODIFIED_TIME=$this->SETTINGS[$this->system_setting_m->_WS_MODIFY_TIME]:'';
        $theme='default';
        if(isset($this->SETTINGS[$this->system_setting_m->_WS_TIMEZONE]) && !empty($this->SETTINGS[$this->system_setting_m->_WS_TIMEZONE])){date_default_timezone_set($this->SETTINGS[$this->system_setting_m->_WS_TIMEZONE]);}
        //development/maintenance is in progress
        if(isset($this->SETTINGS[$this->system_setting_m->_MAINTENANCE_MODE]) && strtolower($this->SETTINGS[$this->system_setting_m->_MAINTENANCE_MODE])=='on'){$this->IS_DEV_MODE_ENABLE= true;}
        if(isset($this->SETTINGS[$this->system_setting_m->_WS_THEME])){$theme=$this->SETTINGS[$this->system_setting_m->_WS_THEME];}
        if(isset($this->SETTINGS[$this->system_setting_m->_BG_THEME])){$this->BG_THEME=$this->SETTINGS[$this->system_setting_m->_BG_THEME];}
        ////////////////////////////////////////////////////////////////////////////////////
        // INIT CONSTANTS
        $this->LIB_CONT_ROOT = $this->APP_ROOT;
        $this->LIB_VIEW_DIR = 'public/'.$theme.'/'; 
        $this->THEME_RES_ROOT = $this->APP_ROOT.'assets/themes/'.$theme.'/';
        $this->data['main_content'] = 'index';
        ////////////////////////////////////////////////////////////////////////
        ////////////DEFINE GLOBAL VARIABLES---LOAD CONSTANTS IN DATA ARRAY//////
        $models = array(
            'log_m'=>$this->root_m->_MDL_LOG,
            'news_m'=>$this->root_m->_MDL_NEWS,
            'student_login_m'=>$this->root_m->_MDL_STUDENT_LOGIN,
            'staff_login_m'=>$this->root_m->_MDL_STAFF_LOGIN,
            'user_login_m'=>$this->root_m->_MDL_USER_LOGIN,
        );
        //load all models in above array
        foreach($models as $mdl=>$tbl){
            $this->load->model('common_m',$mdl);
            $this->$mdl->init(array('table'=>$tbl));
        }
        $this->SETTINGS=$this->system_setting_m->get_settings_array();
        ///////////////////////////CHECK FOR DEVELOPMENT MODE/////////////////////////////////
        if(strtolower($this->SETTINGS[$this->system_setting_m->_MAINTENANCE_MODE])=='on'){
            //development/maintenance is in progress
            $this->IS_DEV_MODE_ENABLE= true;
        }

        $this->data['LIB_CONT_ROOT'] = $this->LIB_CONT_ROOT;
        $this->data['LIB_VIEW_DIR'] = $this->LIB_VIEW_DIR;
        ///////////////////////////////////////////////////
        // save visit info
        $visit=array('date'=>$this->user_m->date,'day'=>$this->user_m->day,'month'=>$this->user_m->month,'year'=>$this->user_m->year);
        $visit['ipaddress']=$this->input->ip_address();
        $visit['user_agent']=$this->input->user_agent();
        $this->log_m->add_row($visit);
        ///////////////////////////////////////////////////

        if ($this->user_m->loggedin() ) {
            $login_id = decode64($this->session->userdata('login_id'));
            if ($this->user_m->is_loggedin($login_id) == true) {
                $this->LOGIN_FLAG=true;
                $this->LOGIN_ID = $this->session->userdata('login_id');
                $this->LOGIN_USER = $this->user_m->get_by_primary($this->LOGIN_ID);
            }
        }
    }

}


/////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////Class for Dashboard Controller///////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

class Staff_Controller extends MY_Controller {

    public $LIB_CONT_ROOT = '';
    public $LIB_VIEW_DIR = '';
    public $LOGIN_ID = '';
    public $LOGIN_USER = '';
    public $LOGIN_USER_FILTER = array();

    /**
     * ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     * ***************************************** CONTSTRUCTOR FOR INIT ADMIN APP **************************************
     * ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     */
    function __construct() {
        parent::__construct();
        /////////load all general models for application ////////////////////
        $models = array(
            'log_m'=>$this->root_m->_MDL_LOG,
            'news_m'=>$this->root_m->_MDL_NEWS,
            'chat_m'=>$this->root_m->_MDL_CHAT,
            'chat_message_m'=>$this->root_m->_MDL_CHAT_MESSAGE,
            'chat_group_m'=>$this->root_m->_MDL_CHAT_GROUP,
            'chat_group_message_m'=>$this->root_m->_MDL_CHAT_GROUP_MESSAGE,
            'class_m'=>$this->root_m->_MDL_CLASS,
            'group_m'=>$this->root_m->_MDL_GROUP,
            'section_m'=>$this->root_m->_MDL_SECTION,
            'staff_log_m'=>$this->root_m->_MDL_STAFF_LOG,
            'staff_subject_m'=>$this->root_m->_MDL_STAFF_SUBJECT,
            'student_log_m'=>$this->root_m->_MDL_STUDENT_LOG,
            'student_time_log_m'=>$this->root_m->_MDL_STUDENT_TIME_LOG,
            'subject_m'=>$this->root_m->_MDL_STUBJECT,
            'subject_group_m'=>$this->root_m->_MDL_STUBJECT_GROUP,
            'lesson_m'=>$this->root_m->_MDL_STUBJECT_LESSON,
            'lesson_attendance_m'=>$this->root_m->_MDL_STUBJECT_LESSON_ATTENDANCE,
            'qbank_m'=>$this->root_m->_MDL_QBANK,
            'quiz_m'=>$this->root_m->_MDL_QUIZ,
            'quiz_question_m'=>$this->root_m->_MDL_QUIZ_QUESTION,
            'quiz_answer_m'=>$this->root_m->_MDL_QUIZ_ANSWER,
            'quiz_attempt_m'=>$this->root_m->_MDL_QUIZ_ATTEMPT,
            'test_m'=>$this->root_m->_MDL_TEST,
            'test_question_m'=>$this->root_m->_MDL_TEST_QUESTION,
            'test_answer_m'=>$this->root_m->_MDL_TEST_ANSWER,
            'test_attempt_m'=>$this->root_m->_MDL_TEST_ATTEMPT,
            'paper_m'=>$this->root_m->_MDL_PAPER,
            'paper_question_m'=>$this->root_m->_MDL_PAPER_QUESTION,
            'paper_answer_m'=>$this->root_m->_MDL_PAPER_ANSWER,
            'paper_attempt_m'=>$this->root_m->_MDL_PAPER_ATTEMPT,
            'assignment_m'=>$this->root_m->_MDL_ASSIGNMENT,
            'assignment_answer_m'=>$this->root_m->_MDL_ASSIGNMENT_ANSWER,
            'homework_m'=>$this->root_m->_MDL_HOMEWORK,
            'homework_answer_m'=>$this->root_m->_MDL_HOMEWORK_ANSWER,
            'download_m'=>$this->root_m->_MDL_DOWNLOAD,
            'paper_doc_m'=>$this->root_m->_MDL_PAPER_DOC,
            'student_login_m'=>$this->root_m->_MDL_STUDENT_LOGIN,
            'staff_login_m'=>$this->root_m->_MDL_STAFF_LOGIN,
            'user_login_m'=>$this->root_m->_MDL_USER_LOGIN,
            'class_link_m'=>$this->root_m->_MDL_CLASS_LINK,
            'datesheet_m'=>$this->root_m->_MDL_DATESHEET,
            'syllabus_m'=>$this->root_m->_MDL_SYLLABUS,
            'timetable_m'=>$this->root_m->_MDL_TIMETABLE,
        );

        //load all models in above array
        foreach($models as $mdl=>$tbl){
            $this->load->model('common_m',$mdl);
            $this->$mdl->init(array('table'=>$tbl));
        }
        // INIT CONSTANTS
        $this->LIB_CONT_ROOT = $this->APP_ROOT . 'staffboard/';
        $this->LIB_VIEW_DIR = 'staffboard/';

        $this->load->database();
        $this->SETTINGS=$this->system_setting_m->get_settings_array();
        ///////////////////////////CHECK FOR SETTINGS/////////////////////////////////
        if(isset($this->SETTINGS[$this->system_setting_m->_WS_TIMEZONE]) && !empty($this->SETTINGS[$this->system_setting_m->_WS_TIMEZONE])){date_default_timezone_set($this->SETTINGS[$this->system_setting_m->_WS_TIMEZONE]);}
        //development/maintenance is in progress
        if(isset($this->SETTINGS[$this->system_setting_m->_MAINTENANCE_MODE]) && strtolower($this->SETTINGS[$this->system_setting_m->_MAINTENANCE_MODE])=='on'){$this->IS_DEV_MODE_ENABLE= true;}
        if(isset($this->SETTINGS[$this->system_setting_m->_BG_THEME])){$this->BG_THEME=$this->SETTINGS[$this->system_setting_m->_BG_THEME];}
        //////////////////////////////////////////////////////////////////////////
        /*         * ***********************************************************************
         * SESSION VALIDATION
         * ACCESS TO VALID SESSION ONLY
         * *********************************************************************** */

        $login_id = '';
        $redir_url = $this->APP_ROOT . 'auth/logout';
        $exception_uris = array();
        if (in_array(uri_string(), $exception_uris) == FALSE) {
            if ($this->staff_m->loggedin() == FALSE) {
                $this->session->set_flashdata('error', 'Login Expired! Please Login Again');
                redirect($redir_url, 'refresh');
                exit(1);
            }
            //is valid user logged in
            $login_id = decode64($this->session->userdata('login_id'));
        }

        //session filter passed  
        $this->LOGIN_FLAG=true;
        $this->LOGIN_ID = decode64($this->session->userdata('login_id'));
        $this->LOGIN_USER = $this->staff_m->get_by_primary($this->LOGIN_ID);
        $this->data['LOGIN_USER'] = $this->LOGIN_USER;
        $this->data['LIB_CONT_ROOT'] = $this->LIB_CONT_ROOT;
        $this->data['LIB_VIEW_DIR'] = $this->LIB_VIEW_DIR;
        ////////////////////////////////////////////////////////////////////
        ///////////////////////CHECK FOR DEVELOPMENT MODE///////////////////
        if($this->IS_DEV_MODE_ENABLE){
            redirect($this->APP_ROOT.'', 'refresh');
            exit();
        }
    }

}

class Student_Controller extends MY_Controller {

    public $LIB_CONT_ROOT = '';
    public $LIB_VIEW_DIR = '';
    public $LOGIN_ID = '';
    public $LOGIN_USER = '';
    public $LOGIN_USER_FILTER = array();

    /**
     * ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     * ***************************************** CONTSTRUCTOR FOR INIT ADMIN APP **************************************
     * ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     */
    function __construct() {
        parent::__construct();
        /////////load all general models for application ////////////////////
        $models = array(
            'log_m'=>$this->root_m->_MDL_LOG,
            'news_m'=>$this->root_m->_MDL_NEWS,
            'chat_m'=>$this->root_m->_MDL_CHAT,
            'chat_message_m'=>$this->root_m->_MDL_CHAT_MESSAGE,
            'chat_group_m'=>$this->root_m->_MDL_CHAT_GROUP,
            'chat_group_message_m'=>$this->root_m->_MDL_CHAT_GROUP_MESSAGE,
            'class_m'=>$this->root_m->_MDL_CLASS,
            'group_m'=>$this->root_m->_MDL_GROUP,
            'section_m'=>$this->root_m->_MDL_SECTION,
            'staff_log_m'=>$this->root_m->_MDL_STAFF_LOG,
            'staff_subject_m'=>$this->root_m->_MDL_STAFF_SUBJECT,
            'student_log_m'=>$this->root_m->_MDL_STUDENT_LOG,
            'student_time_log_m'=>$this->root_m->_MDL_STUDENT_TIME_LOG,
            'subject_m'=>$this->root_m->_MDL_STUBJECT,
            'subject_group_m'=>$this->root_m->_MDL_STUBJECT_GROUP,
            'lesson_m'=>$this->root_m->_MDL_STUBJECT_LESSON,
            'lesson_attendance_m'=>$this->root_m->_MDL_STUBJECT_LESSON_ATTENDANCE,
            'qbank_m'=>$this->root_m->_MDL_QBANK,
            'quiz_m'=>$this->root_m->_MDL_QUIZ,
            'quiz_question_m'=>$this->root_m->_MDL_QUIZ_QUESTION,
            'quiz_answer_m'=>$this->root_m->_MDL_QUIZ_ANSWER,
            'quiz_attempt_m'=>$this->root_m->_MDL_QUIZ_ATTEMPT,
            'test_m'=>$this->root_m->_MDL_TEST,
            'test_question_m'=>$this->root_m->_MDL_TEST_QUESTION,
            'test_answer_m'=>$this->root_m->_MDL_TEST_ANSWER,
            'test_attempt_m'=>$this->root_m->_MDL_TEST_ATTEMPT,
            'paper_m'=>$this->root_m->_MDL_PAPER,
            'paper_question_m'=>$this->root_m->_MDL_PAPER_QUESTION,
            'paper_answer_m'=>$this->root_m->_MDL_PAPER_ANSWER,
            'paper_attempt_m'=>$this->root_m->_MDL_PAPER_ATTEMPT,
            'assignment_m'=>$this->root_m->_MDL_ASSIGNMENT,
            'assignment_answer_m'=>$this->root_m->_MDL_ASSIGNMENT_ANSWER,
            'homework_m'=>$this->root_m->_MDL_HOMEWORK,
            'homework_answer_m'=>$this->root_m->_MDL_HOMEWORK_ANSWER,
            'download_m'=>$this->root_m->_MDL_DOWNLOAD,
            'paper_doc_m'=>$this->root_m->_MDL_PAPER_DOC,
            'student_login_m'=>$this->root_m->_MDL_STUDENT_LOGIN,
            'staff_login_m'=>$this->root_m->_MDL_STAFF_LOGIN,
            'user_login_m'=>$this->root_m->_MDL_USER_LOGIN,
            'class_link_m'=>$this->root_m->_MDL_CLASS_LINK,
            'datesheet_m'=>$this->root_m->_MDL_DATESHEET,
            'syllabus_m'=>$this->root_m->_MDL_SYLLABUS,
            'timetable_m'=>$this->root_m->_MDL_TIMETABLE,
        );
        //load all models in above array
        foreach($models as $mdl=>$tbl){
            $this->load->model('common_m',$mdl);
            $this->$mdl->init(array('table'=>$tbl));
        }
        // INIT CONSTANTS
        $this->LIB_CONT_ROOT = $this->APP_ROOT . 'dashboard/';
        $this->LIB_VIEW_DIR = 'dashboard/';

        $this->load->database();
        $this->SETTINGS=$this->system_setting_m->get_settings_array();
        ///////////////////////////CHECK FOR SETTINGS/////////////////////////////////
        if(isset($this->SETTINGS[$this->system_setting_m->_WS_TIMEZONE]) && !empty($this->SETTINGS[$this->system_setting_m->_WS_TIMEZONE])){date_default_timezone_set($this->SETTINGS[$this->system_setting_m->_WS_TIMEZONE]);}
        //development/maintenance is in progress
        if(isset($this->SETTINGS[$this->system_setting_m->_MAINTENANCE_MODE]) && strtolower($this->SETTINGS[$this->system_setting_m->_MAINTENANCE_MODE])=='on'){$this->IS_DEV_MODE_ENABLE= true;}
        if(isset($this->SETTINGS[$this->system_setting_m->_BG_THEME])){$this->BG_THEME=$this->SETTINGS[$this->system_setting_m->_BG_THEME];}

        //////////////////////////////////////////////////////////////////////////
        /*         * ***********************************************************************
         * SESSION VALIDATION
         * ACCESS TO VALID SESSION ONLY
         * *********************************************************************** */

        $login_id = '';
        $redir_url = $this->APP_ROOT . 'auth/logout';
        $exception_uris = array();
        if (in_array(uri_string(), $exception_uris) == FALSE) {
            if ($this->student_m->loggedin() == FALSE) {
                $this->session->set_flashdata('error', 'Login Expired! Please Login Again');
                redirect($redir_url, 'refresh');
                exit(1);
            }
            //is valid user logged in
            $login_id = decode64($this->session->userdata('login_id'));
        }

        //session filter passed  
        $this->LOGIN_FLAG=true;
        $this->LOGIN_ID = decode64($this->session->userdata('login_id'));
        $this->LOGIN_USER = $this->student_m->get_by_primary($this->LOGIN_ID);
        $this->data['LOGIN_USER'] = $this->LOGIN_USER;
        $this->data['LIB_CONT_ROOT'] = $this->LIB_CONT_ROOT;
        $this->data['LIB_VIEW_DIR'] = $this->LIB_VIEW_DIR;
        ////////////////////////////////////////////////////////////////////
        ///////////////////////CHECK FOR DEVELOPMENT MODE///////////////////
        if($this->IS_DEV_MODE_ENABLE){
            redirect($this->APP_ROOT.'', 'refresh');
            exit();
        }
    }

}

class Admin_Controller extends MY_Controller {

    public $LIB_CONT_ROOT = '';
    public $LIB_VIEW_DIR = '';
    public $LOGIN_ID = '';
    public $LOGIN_USER = '';
    public $IS_SUPER_ADMIN = false;
    public $LOGIN_USER_FILTER = array();

    /**
     * ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     * ***************************************** CONTSTRUCTOR FOR INIT ADMIN APP **************************************
     * ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
     */
    function __construct() {
        parent::__construct();
        /////////load all general models for application ////////////////////
        $models = array(
            'log_m'=>$this->root_m->_MDL_LOG,
            'news_m'=>$this->root_m->_MDL_NEWS,
            'chat_m'=>$this->root_m->_MDL_CHAT,
            'chat_message_m'=>$this->root_m->_MDL_CHAT_MESSAGE,
            'chat_group_m'=>$this->root_m->_MDL_CHAT_GROUP,
            'chat_group_message_m'=>$this->root_m->_MDL_CHAT_GROUP_MESSAGE,
            'class_m'=>$this->root_m->_MDL_CLASS,
            'group_m'=>$this->root_m->_MDL_GROUP,
            'section_m'=>$this->root_m->_MDL_SECTION,
            'staff_log_m'=>$this->root_m->_MDL_STAFF_LOG,
            'staff_subject_m'=>$this->root_m->_MDL_STAFF_SUBJECT,
            'student_log_m'=>$this->root_m->_MDL_STUDENT_LOG,
            'student_time_log_m'=>$this->root_m->_MDL_STUDENT_TIME_LOG,
            'subject_m'=>$this->root_m->_MDL_STUBJECT,
            'subject_group_m'=>$this->root_m->_MDL_STUBJECT_GROUP,
            'lesson_m'=>$this->root_m->_MDL_STUBJECT_LESSON,
            'lesson_attendance_m'=>$this->root_m->_MDL_STUBJECT_LESSON_ATTENDANCE,
            'qbank_m'=>$this->root_m->_MDL_QBANK,
            'quiz_m'=>$this->root_m->_MDL_QUIZ,
            'quiz_question_m'=>$this->root_m->_MDL_QUIZ_QUESTION,
            'quiz_answer_m'=>$this->root_m->_MDL_QUIZ_ANSWER,
            'quiz_attempt_m'=>$this->root_m->_MDL_QUIZ_ATTEMPT,
            'test_m'=>$this->root_m->_MDL_TEST,
            'test_question_m'=>$this->root_m->_MDL_TEST_QUESTION,
            'test_answer_m'=>$this->root_m->_MDL_TEST_ANSWER,
            'test_attempt_m'=>$this->root_m->_MDL_TEST_ATTEMPT,
            'paper_m'=>$this->root_m->_MDL_PAPER,
            'paper_question_m'=>$this->root_m->_MDL_PAPER_QUESTION,
            'paper_answer_m'=>$this->root_m->_MDL_PAPER_ANSWER,
            'paper_attempt_m'=>$this->root_m->_MDL_PAPER_ATTEMPT,
            'assignment_m'=>$this->root_m->_MDL_ASSIGNMENT,
            'assignment_answer_m'=>$this->root_m->_MDL_ASSIGNMENT_ANSWER,
            'homework_m'=>$this->root_m->_MDL_HOMEWORK,
            'homework_answer_m'=>$this->root_m->_MDL_HOMEWORK_ANSWER,
            'download_m'=>$this->root_m->_MDL_DOWNLOAD,
            'paper_doc_m'=>$this->root_m->_MDL_PAPER_DOC,
            'student_login_m'=>$this->root_m->_MDL_STUDENT_LOGIN,
            'staff_login_m'=>$this->root_m->_MDL_STAFF_LOGIN,
            'user_login_m'=>$this->root_m->_MDL_USER_LOGIN,
            'class_link_m'=>$this->root_m->_MDL_CLASS_LINK,
            'datesheet_m'=>$this->root_m->_MDL_DATESHEET,
            'syllabus_m'=>$this->root_m->_MDL_SYLLABUS,
            'timetable_m'=>$this->root_m->_MDL_TIMETABLE,
        );
        //load all models in above array
        foreach($models as $mdl=>$tbl){
            $this->load->model('common_m',$mdl);
            $this->$mdl->init(array('table'=>$tbl));
        }
        // INIT CONSTANTS
        $this->LIB_CONT_ROOT = $this->APP_ROOT . 'admin/';
        $this->LIB_VIEW_DIR = 'admin/';

        $this->load->database();
        $this->SETTINGS=$this->system_setting_m->get_settings_array();
        ///////////////////////////CHECK FOR SETTINGS/////////////////////////////////
        if(isset($this->SETTINGS[$this->system_setting_m->_WS_TIMEZONE]) && !empty($this->SETTINGS[$this->system_setting_m->_WS_TIMEZONE])){date_default_timezone_set($this->SETTINGS[$this->system_setting_m->_WS_TIMEZONE]);}
        //development/maintenance is in progress
        if(isset($this->SETTINGS[$this->system_setting_m->_MAINTENANCE_MODE]) && strtolower($this->SETTINGS[$this->system_setting_m->_MAINTENANCE_MODE])=='on'){$this->IS_DEV_MODE_ENABLE= true;}
        if(isset($this->SETTINGS[$this->system_setting_m->_BG_THEME])){$this->BG_THEME=$this->SETTINGS[$this->system_setting_m->_BG_THEME];}

        //////////////////////////////////////////////////////////////////////////
        /*         * ***********************************************************************
         * SESSION VALIDATION
         * ACCESS TO VALID SESSION ONLY
         * *********************************************************************** */

        $login_id = '';
        $redir_url = $this->APP_ROOT . 'auth/logout';
        $exception_uris = array();
        if (in_array(uri_string(), $exception_uris) == FALSE) {
            if ($this->user_m->loggedin() == FALSE) {
                $this->session->set_flashdata('error', 'Login Expired! Please Login Again');
                redirect($redir_url, 'refresh');
                exit(1);
            }
            //is valid user logged in
            $login_id = decode64($this->session->userdata('login_id'));
        }

        //session filter passed  
        $this->LOGIN_FLAG=true;
        $this->LOGIN_ID = decode64($this->session->userdata('login_id'));
        $this->LOGIN_USER = $this->user_m->get_by_primary($this->LOGIN_ID);
        $this->data['LOGIN_USER'] = $this->LOGIN_USER;
        $this->data['LIB_CONT_ROOT'] = $this->LIB_CONT_ROOT;
        $this->data['LIB_VIEW_DIR'] = $this->LIB_VIEW_DIR;
        ////////////////////////////////////////////////////////////////////
        ///////////////////////CHECK FOR DEVELOPMENT MODE///////////////////
        if($this->IS_DEV_MODE_ENABLE){
            redirect($this->APP_ROOT.'', 'refresh');
            exit();
        }
    }

}

