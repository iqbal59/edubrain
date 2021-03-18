<?php
class System_history_M extends MY_Model
{

	protected $_model_name='System_history_M.php';
	protected $_table_name = 'system_history';
    private $_required=array('message');

    function __construct (){
        parent::__construct();
    }

    public function init($args=''){ }
    //add new row in db table 
    public function add_row($vals){
        //GET ALL THE FIELDS IN ARRAY
        $db_row=  $this->grab_row($vals);        
        //PERFROM DIFFERENCT CHECKS BEFORE DATA INSERTION (OPTIONAL)
        ////////////////////////////////////////////////////////////////////////
        $db_row['date']=$this->datetime;
        $db_row['created']=time();
        $db_row['updated']=time();
        
        //SAVE DATA INTO DATABASE
        return $this->save_db_row($db_row,$this->_required);
    }

}