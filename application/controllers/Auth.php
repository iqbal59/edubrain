<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//validate user before going to admin panel
class Auth extends Frontend_Controller {

    //global variables
    public $CONT_ROOT; //REFERENCE TO THIS CONTROLLER

    function __construct() {
        parent::__construct();
        //global vars
        $this->LIB_VIEW_DIR ='authorization/';
        $this->CONT_ROOT = $this->LIB_CONT_ROOT . 'auth/';
        $this->load->database();
        $this->SETTINGS=$this->system_setting_m->get_settings_array();
        $this->load->model(array());
    }

    //default function
    public function index() {
        // Redirect a user to login function
        redirect($this->CONT_ROOT . 'login');
    }
    // switch login for mobile application
    public function switcher() {
        if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']==1){
            //admin already logged in
            redirect($this->LIB_CONT_ROOT.'admin', 'refresh');
        }
        if(isset($_SESSION['is_staff']) && $_SESSION['is_staff']==1){
            //staff already logged in
            redirect($this->LIB_CONT_ROOT.'staffboard', 'refresh');
        }
        if(isset($_SESSION['is_student']) && $_SESSION['is_student']==1){
            $id = decode64($this->session->userdata('login_id'));
            $user = $this->student_m->get_by_primary($id);
            if($user->status=='inactive'){
                $this->session->set_flashdata('error', 'Account disabled. Please contact in office!!!!');
                redirect($this->logout(), 'refresh');   
            }
            //staff already logged in
            redirect($this->LIB_CONT_ROOT.'dashboard', 'refresh');
        }
        // Redirect a user if he's already logged in
        $this->data['main_content']='auth_login';
        $this->data['menu']='auth'; 
        ///ems development/maintenance is in progress
        if($this->IS_DEV_MODE_ENABLE){
        $this->data['main_content']='system_maintenance';   
        } 
        //load theme directory & module
        $this->load->view($this->LIB_VIEW_DIR . 'master', $this->data);
    }
    // login
    public function login($module='') {

        // Redirect a user if he's already logged in
        $this->data['main_content']='auth_login';
        $this->data['menu']='auth'; 
        if(strtolower($module)=='staff'){$this->data['main_content']='auth_login_staff';}
        if(strtolower($module)=='admin'){$this->data['main_content']='auth_login_admin';}
        ///ems development/maintenance is in progress
        if($this->IS_DEV_MODE_ENABLE){
        $this->data['main_content']='system_maintenance';   
        } 
        //load theme directory & module
        $this->load->view($this->LIB_VIEW_DIR . 'master', $this->data);
    }



    // forget password
    public function forget() { 
        // Redirect a user if he's already logged in
        $this->data['main_content'] = 'auth_forget';
        $this->data['menu'] = 'auth';
        $this->load->view($this->LIB_VIEW_DIR . 'master', $this->data);
    }

    // update password from emails
    public function verify($code='',$email=''){        

        // Redirect a user if he's already logged in
        $this->data['code'] = $code;  
        $this->data['email'] = $email;  
        $this->data['main_content'] = 'auth_verify';
        $this->data['menu'] = 'auth';
        $this->load->view($this->LIB_VIEW_DIR . 'master', $this->data);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////
    ///handle already login situation
    public function handle_login() {
        $db=$this->APP_ROOT;
        if($this->LOGIN_FLAG==TRUE){
            if($this->LOGIN_USER->type==$this->user_m->ROLE_ADMIN){$db='admin';}
            redirect($db);
        }   
    }

    //handle brute force attack
    private function validate_ip($redir) {
        $day_limit = 15; //block account for 15 wrong request in a day
        $min_60_limit = 10; //block account for 1 hour after 10 wrong requests
        $min_15_limit = 5; //block account for 15 min after 5 wrong requests
        $ipaddress = $this->input->server('REMOTE_ADDR');
        $this_time = time();
        $filter = array('ipaddress' => $ipaddress, 'jd' => $this->login_session_m->todayjd);
        if ($this->login_session_m->get_rows($filter,'',true) >= $day_limit) {
            $this->session->set_flashdata('error', 'Access revoked for today. Please try tomorrow!');
            redirect($redir, 'refresh');
        }
        $filter['time >'] = $this_time - (60 * 60);
        if ($this->login_session_m->get_rows($filter,'',true) >= $min_60_limit) {
            $this->session->set_flashdata('error', 'Access revoked due to invalid attempts. Try after 1 hour.');
            redirect($redir, 'refresh');
        }
        $filter['time >'] = $this_time - (60 * 15);
        if ($this->login_session_m->get_rows($filter,'',true) >= $min_15_limit) {
            $db_time = $this->login_session_m->get_rows($filter,array('select'=>'time'));
            $last_time = intval($db_time[0]['time']);
            $remaining_time = round(15 - (($this_time - $last_time) / 60), 0);
            $this->session->set_flashdata('error', 'Access revoked due to invalid attempts. Try after ' . $remaining_time . ' min.');
            redirect($redir, 'refresh');
        }
        return $ipaddress;
    }

        
    //handle admin login
    public function signin() {
            ////////////////////////////////////////////////////////////////////
            //handle brute force attack.
            $redir=$this->CONT_ROOT.'login';
            $ipaddress=$this->validate_ip($redir);
            $redirect=$this->session->userdata('redir');    //redirecect to the location after login process
            
            // populate form                
            $form=$this->input->safe_post_get(array('user_id','password'));
            $password=$this->user_m->hash($form['password']);
            $login_filter=array('student_id'=>$form['user_id'],'password'=>$password);
            if(empty($form['user_id']) || empty($form['password'])){
                $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));   
                $this->session->set_flashdata('error', 'Student ID and Password are required!');
                redirect($redir, 'refresh');
            }elseif($this->student_m->is_valid_password($form['user_id'],$password)==FALSE){                
                $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));   
                $this->session->set_flashdata('error', 'Incorrect Student ID or Password!!');
                redirect($redir, 'refresh');   
            }else{
                
                $user=$this->student_m->get_by($login_filter,true);                
                //check if user has active account status
                if($user->status!=$this->user_m->STATUS_ACTIVE){
                 $this->session->set_flashdata('error', 'Account Suspended. Contact office for more info!!!');
                 redirect($redir, 'refresh');   
                 exit();
                }     
                //user id and password has been verified. continue to login
                $login_id=$this->student_m->login($login_filter);
                if($login_id==FALSE){
                    $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));
                    $this->session->set_flashdata('error', 'Incorrect Student ID or Password!!!!');
                    redirect($redir, 'refresh');   
                }elseif($user->status=='inactive'){
                    $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));
                    $this->session->set_flashdata('error', 'Account disabled. Please contact in office!!!!');
                    redirect($redir, 'refresh');   
                }else{
                    $db='dashboard/home';   
                    $login_data=array('student_id'=>$user->mid,'class_id'=>$user->class_id,'date'=>$this->user_m->datetime,'jd'=>$this->user_m->todayjd);
                    $login_data['ip_address']=$this->input->ip_address();
                    $this->student_login_m->add_row($login_data);
                    //notify user through via sms or email for successful login                    
                    if(empty($redirecect)){                    
                    redirect($this->APP_ROOT.$db, 'refresh');   
                    }else{     
                    //redirect to the value added to session(redir)
                    redirect($redirecect, 'refresh');   
                    }
                }
                
            }
    }  

    //handle admin login
    public function signin_staff() {
            ////////////////////////////////////////////////////////////////////
            //handle brute force attack.
            $redir=$this->CONT_ROOT.'login/staff';
            $ipaddress=$this->validate_ip($redir);
            $redirect=$this->session->userdata('redir');    //redirecect to the location after login process
            
            // populate form                
            $form=$this->input->safe_post_get(array('user_id','password'));
            $password=$this->user_m->hash($form['password']);
            $login_filter=array('staff_id'=>$form['user_id'],'password'=>$password);
            if(empty($form['user_id']) || empty($form['password'])){
                $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));   
                $this->session->set_flashdata('error', 'Staff ID and Password are required!');
                redirect($redir, 'refresh');
            }elseif($this->staff_m->is_valid_password($form['user_id'],$password)==FALSE){                
                $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));   
                $this->session->set_flashdata('error', 'Incorrect Staff ID or Password!!');
                redirect($redir, 'refresh');   
            }else{
                
                $user=$this->staff_m->get_by($login_filter,true);  
                //user id and password has been verified. continue to login
                $login_id=$this->staff_m->login($login_filter);
                if($login_id==FALSE){
                    $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));
                    $this->session->set_flashdata('error', 'Incorrect Staff ID or Password!!!!');
                    redirect($redir, 'refresh');   
                }else{
                    $login_data=array('staff_id'=>$user->mid,'date'=>$this->user_m->datetime,'jd'=>$this->user_m->todayjd);
                    $login_data['ip_address']=$this->input->ip_address();
                    $this->staff_login_m->add_row($login_data);
                    $db='staffboard';   
                    //notify user through via sms or email for successful login                    
                    if(empty($redirecect)){                    
                    redirect($this->APP_ROOT.$db, 'refresh');   
                    }else{     
                    //redirect to the value added to session(redir)
                    redirect($redirecect, 'refresh');   
                    }
                }
                
            }
    }  

    //handle admin login
    public function signin_admin() {
            ////////////////////////////////////////////////////////////////////
            //handle brute force attack.
            $redir=$this->CONT_ROOT.'login/admin';
            $ipaddress=$this->validate_ip($redir);
            $redirect=$this->session->userdata('redir');    //redirecect to the location after login process
            
            // populate form                
            $form=$this->input->safe_post_get(array('email','password'));
            $password=$this->user_m->hash($form['password']);
            $login_filter=array('email'=>$form['email'],'password'=>$password);
            if(empty($form['email']) || empty($form['password'])){
                $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));   
                $this->session->set_flashdata('error', 'Email and Password are required!');
                redirect($redir, 'refresh');
            }elseif($this->user_m->is_valid_password($form['email'],$password)==FALSE){                
                $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));   
                $this->session->set_flashdata('error', 'Incorrect Email or Password!!');
                redirect($redir, 'refresh');   
            }else{
                
                $user=$this->user_m->get_by($login_filter,true);                
                //check if user has active account status
                if($user->status!=$this->user_m->STATUS_ACTIVE){
                 $this->session->set_flashdata('error', 'Account Suspended. Contact admin for more info!!!');
                 redirect($redir, 'refresh');   
                 exit();
                }     
                //user id and password has been verified. continue to login
                $login_id=$this->user_m->login($login_filter);
                if($login_id==FALSE){
                    $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));
                    $this->session->set_flashdata('error', 'Incorrect User ID or Password!!!!');
                    redirect($redir, 'refresh');   
                }else{
                    $login_data=array('user_id'=>$user->mid,'date'=>$this->user_m->datetime,'jd'=>$this->user_m->todayjd);
                    $login_data['ip_address']=$this->input->ip_address();
                    $this->user_login_m->add_row($login_data);
                    $db='admin';   
                    //notify user through via sms or email for successful login                    
                    if(empty($redirecect)){                    
                    redirect($this->APP_ROOT.$db, 'refresh');   
                    }else{     
                    //redirect to the value added to session(redir)
                    redirect($redirecect, 'refresh');   
                    }
                }
                
            }
    }  

    //handle reset password request
    public function reset() {
            ////////////////////////////////////////////////////////////////////
            //handle brute force attack.
            $redir=$this->CONT_ROOT.'forget';
            $ipaddress=$this->validate_ip($redir);
            $redirect=$this->session->userdata('redir');    //redirecect to the location after login process
            
            // populate form                
            $form=$this->input->safe_post_get(array('email'));
            if(empty($form['email'])){
                $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));   
                $this->session->set_flashdata('error', 'Please enter your registered email address!');
                redirect($redir, 'refresh');
            }elseif($this->user_m->get_rows(array('email'=>$form['email']),'',true)<1){                
                $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));   
                $this->session->set_flashdata('error', 'Email address not found!!');
                redirect($redir, 'refresh');   
            }else{
                
                $row=$this->user_m->get_by(array('email'=>$form['email']),true);
                $code= get_random_string(30, TRUE);
                $this->user_m->save(array('reset_code'=>$code),$row->mid);
                ////////send email//////////////////////////
                $root_url = rtrim($this->APP_ROOT, '/');
                $domain=str_replace('http://','', str_replace('https://','', str_replace('http://www','', str_replace('https:www//','', $root_url))));
                $url = $this->APP_ROOT . 'auth/verify/'.$code.'/'.encode64($row->email);
                $msg = "<strong> Reset Password</strong><br>"
                        . "Dear " . ucwords($row->name) . ", <br> You are receiving this email as per your request to reset your account password on <a href='$root_url' target='_blank'>$root_url</a>. Please click the button to reset your password. Alternatively, You can also copy and paste the given url in new tab  in order to continue.<br><a href='$url' target='_blank'>$url</a>";
                $this->load->library('emailtemp');
                $this->load->library('email');
                $config = array('mailtype' => 'html');
                $params = array();
                $from = 'support@'.$domain;
                $block_title='Mozzine EMS';
                $from_name = 'Security Team ';
                $title = 'Password Reset';
                $blocks = array();
                $blocks[] = array('type' => 'block', 'block_title' => $block_title,
                    'btn_url' => $url, 'block_text' => $msg, 'btn_text' => 'Password Reset');

                $data = array('title' => $title, 'from_footer_text' => $from_name);
                $data['blocks'] = $blocks;
                $page = $this->emailtemp->render_html($data);

                if (@$this->email->send_email($title, $page, $row->email, $from, $from_name, $params, $config)) {
                    $this->session->set_flashdata('success', 'An email with password reset instructions has been sent to your email address.');
                    redirect($redir, 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'We did not recognize your identity. Please try again later or contact support team.');
                    redirect($redir, 'refresh');
                }                
            }
    }  

    //handle update password
    public function updatepassword($role='') {
            ////////////////////////////////////////////////////////////////////
            //handle brute force attack.
            $form=$this->input->safe_post(array('email','password','code'));
            $redir=$this->CONT_ROOT.'verify/'.$form['code'].'/'.encode64($form['email']);
            $ipaddress=$this->validate_ip($redir);
            // populate form                
            $password=$this->user_m->hash($form['password']);
            $filter=array('email'=>$form['email'],'reset_code'=>$form['code']);
            if(empty($form['password'])){
                $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));   
                $this->session->set_flashdata('error', 'Please enter new password.');
                redirect($redir, 'refresh');
                exit();
            }
            if(empty($form['email']) || empty($form['code'])){
                $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));   
                $this->session->set_flashdata('error', 'Invalid email or access token expired!');
                redirect($redir, 'refresh');
                exit();
            }


            if($this->user_m->get_rows($filter,'',true)<1){
                $this->login_session_m->add_row(array('ipaddress'=>$ipaddress));   
                $this->session->set_flashdata('error', 'Invalid Email Address or Access Token!');
                redirect($redir, 'refresh');   
            }else{                            
                $row=$this->user_m->get_by($filter,true); 
                $this->user_m->save(array('reset_code'=>'500','password'=>$password),$row->mid);
                $this->session->set_flashdata('success', 'Password updated successfully. PLease login to continue.');               
                redirect($this->CONT_ROOT.'login', 'refresh');                        
            }
    }

    
    //////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    //logout the user
    public function logout($module='',$user_id=''){
        $this->session->sess_destroy(); 
        redirect($this->CONT_ROOT.'login/'.strtolower($module), 'refresh');
    }

    /**
     * ////////////////////////////////////////////////////////////////////////////////////
     * ********************************** END OF CLASS ************************************
     * ////////////////////////////////////////////////////////////////////////////////////
     */
}
