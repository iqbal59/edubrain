<?php
class Staff_M extends MY_Model
{

    protected $_model_name='Staff_M.php';
    protected $_table_name = 'staff';
    private $_required=array('mobile','name','password');
	
    public $STATUS_ACTIVE='active';         
    public $STATUS_INACTIVE='inactive';  
    public $LOGIN_FLAG_FOR_SESSION='mozlogstf';

	function __construct (){
		parent::__construct();
	}

    //add new row in db table 
    public function add_row($vals){
        //GET ALL THE FIELDS IN ARRAY  
        $db_row=$this->grab_row($vals);        
        //PERFROM DIFFERENCT CHECKS BEFORE DATA INSERTION (OPTIONAL)
        ////////////////////////////////////////////////////////////////////////
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
    public function is_valid_password($id,$password){
        $filter=array();
        $filter['staff_id']=$id;
        $filter['password']=$password;
        if($this->get_rows($filter,'',true)>0){return true;}
        return false;
    }  
    //user login method
    public function login ($filter=array()){
        $local_filter=array();
        $local_filter['staff_id']=$filter['staff_id'];
        $local_filter['password']=$filter['password'];
        if($this->get_rows($filter,'',true)>0){
            $user=$this->get_by($local_filter, TRUE);
            // Log in user
            $_pk=$this->_primary_key;
            $user_rid=$user->$_pk;
            //role is for campus distinction in tool library
            $data=array('login_id' => encode64($user_rid),'is_staff'=>1);
            $data[$this->LOGIN_FLAG_FOR_SESSION]=$this->get_session_value(); 
            $data['timestamp']=time();                   
            $this->session->set_userdata($data);     
            return $user_rid;                
        }
        // If we get to here then login did not succeed
        return false;
    }
    
    
    //return session value for role
    public function get_session_value($role=''){
        return encode64($this->LOGIN_FLAG_FOR_SESSION);;
    } 
    ///check if loggedin
    public function loggedin (){
        return $this->session->userdata($this->LOGIN_FLAG_FOR_SESSION)==$this->get_session_value() ? true : false;
    }
    //check if user is loggedin
    public function is_loggedin($user_id){
        return $this->loggedin();
	}
	    
    //logout the user
    public function logout(){
        $this->session->sess_destroy();                
	}



//////////////////////////////////////////////// END OF CLASS /////////////////////
}