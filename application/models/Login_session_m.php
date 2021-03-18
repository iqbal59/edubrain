<?php
class Login_session_M extends MY_Model
{

    protected $_model_name='Login_session_M.php';
    protected $_table_name = 'login_session';  
    private $_required=array('ipaddress');  


	function __construct (){
		parent::__construct();               
	}

    //add new row in db table 
    public function add_row($vals){
        //GET ALL THE FIELDS IN ARRAY  
        $db_row=  $this->grab_row($vals);        
        //PERFROM DIFFERENCT CHECKS BEFORE DATA INSERTION (OPTIONAL)
        ////////////////////////////////////////////////////////////////////////
        $db_row['date']=  $this->date;
        $db_row['jd']=  $this->todayjd;
        $db_row['time']=  time();
        $db_row['created']=time();
        $db_row['updated']=time();
        //SAVE DATA INTO DATABASE
        return $this->save_db_row($db_row,$this->_required);
    }

//////////////////////////////////////////////// END OF CLASS /////////////////////
}