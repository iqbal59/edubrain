<?php
class User_M extends MY_Model
{

    protected $_model_name='User_M.php';
    protected $_table_name = 'users';
    private $_required=array('email','name','password');
	
    public $STATUS_ACTIVE='active';         
    public $STATUS_INACTIVE='inactive';     
    public $TYPE_ADMIN='admin';            
    public $TYPE_USER='user'; 
    public $KEY_SESS_ADMIN='domino';        
    public $KEY_SESS_USER='rsubodie';  
    public $LOGIN_FLAG_FOR_SESSION='mozlogjcs';
    public $ROLE_STUDENT='student'; 
    public $ROLE_TEACHER='teacher'; 

	function __construct (){
		parent::__construct();
	}

    //add new row in db table 
    public function add_row($vals){
        //GET ALL THE FIELDS IN ARRAY  
        $db_row=$this->grab_row($vals);        
        //PERFROM DIFFERENCT CHECKS BEFORE DATA INSERTION (OPTIONAL)
        ////////////////////////////////////////////////////////////////////////
        if(empty($db_row['type'])){$db_row['type']=$this->TYPE_ADMIN;}
        $db_row['password']=$this->hash($db_row['password']);
        $db_row['status']=$this->STATUS_ACTIVE;
        $db_row['image']='default.png';
        $db_row['date']=$this->date;
        $db_row['created']=time();
        $db_row['updated']=time();
        
        //SAVE DATA INTO DATABASE
        return $this->save_db_row($db_row,$this->_required);
    }   
	

    //get user balance
    public function get_balance($rid){
        $usr=$this->get_by_primary($rid);
        $balance=$usr->balance;
        //get cost of today sent messages.
        $balance-=$this->sms_history_m->get_user_today_spending($rid);
        return $balance;
    }  
    //////////////////////////////////////////////////////////////////////////////
    ////////////////////////////// SESSION FUNCTIONS /////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    
    //check if password is valid
    public function is_valid_password($email,$password){
        $filter=array();
        $filter['email']=$email;
        $filter['password']=$password;
        if($this->get_rows($filter,'',true)>0){return true;}
        return false;
    }  
    //user login method
    public function login ($filter=array()){
        $local_filter=array();
        $local_filter['email']=$filter['email'];
        $local_filter['password']=$filter['password'];
        if($this->get_rows($filter,'',true)>0){
            $user=$this->get_by($local_filter, TRUE);
            // Log in user
            $_pk=$this->_primary_key;
            $user_rid=$user->$_pk;
            $admin_data='';
            $user_data='';
            if($user->type==$this->TYPE_ADMIN){
                $admin_data=$this->get_session_value($this->TYPE_ADMIN);
                $user_data=$this->get_session_value($this->TYPE_USER);
            }
            if($user->type==$this->TYPE_USER){
                $user_data=$this->get_session_value($this->TYPE_USER);
            }
            //role is for campus distinction in tool library
            $data=array('login_id' => encode64($user_rid),'is_admin'=>1);
            $data[$this->LOGIN_FLAG_FOR_SESSION]=$this->get_session_value();            
            $data[$this->KEY_SESS_ADMIN]=$admin_data;            
            $data[$this->KEY_SESS_USER]=$user_data;            
            $data['timestamp']=time();                   
            $this->session->set_userdata($data);     
            return $user_rid;                
        }
        // If we get to here then login did not succeed
        return false;
    }
    
    
    //return session value for role
    public function get_session_value($role=''){
        switch ($role) {
            case $this->TYPE_ADMIN:
                return encode64($this->KEY_SESS_ADMIN);
            break;
            case $this->TYPE_USER:
                return encode64($this->KEY_SESS_ADMIN);
            break;
        }
        return encode64($this->LOGIN_FLAG_FOR_SESSION);;
    } 
    ///check if loggedin
    public function loggedin (){
        return $this->session->userdata($this->LOGIN_FLAG_FOR_SESSION)==$this->get_session_value() ? true : false;
    }
    //check if user is loggedin
    public function is_loggedin($user_id){
        $status=false;
        $usr=$this->get_by_primary($user_id);
        if(empty($usr->type)) { return false;}
        $status=$this->is_role_loggedin($usr->type);
        if($status){return $this->loggedin();}
        return false;
	}
    //check if role is loggedin
    public function is_role_loggedin($role){ 
        $status=false;       
        switch ($role) {
            case $this->TYPE_ADMIN:{                
                $this->session->userdata($this->KEY_SESS_ADMIN)==$this->get_session_value($this->TYPE_ADMIN) ? $status=true : '';
            }
            break;
            case $this->TYPE_USER:{
                $this->session->userdata($this->KEY_SESS_USER)==$this->get_session_value($this->TYPE_USER) ? $status=true : '';
            }
            break;
        }
        return $status;
    }
	    
    //logout the user
    public function logout(){
        $this->session->sess_destroy();                
	}



//////////////////////////////////////////////// END OF CLASS /////////////////////
}