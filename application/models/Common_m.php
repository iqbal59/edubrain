<?php
class Common_M extends MY_Model{

    protected $_model_name='Common_M.php';
    protected $_table_name = '';

    
    function __construct (){
    	parent::__construct();
    }
    public function init($args){if(isset($args['table'])){$this->_table_name=$args['table'];}     }

    //add new row in db table 
    public function add_row($vals,$required=array()){
        //GET ALL THE FIELDS IN ARRAY
        $db_row= $this->grab_row($vals);        
        //PERFROM DIFFERENCT CHECKS BEFORE DATA INSERTION (OPTIONAL)
        ////////////////////////////////////////////////////////////////////////
        if(array_key_exists('day', $db_row)){if(empty($db_row['day'])){$db_row['day']=$this->day;}}
        if(array_key_exists('month', $db_row)){if(empty($db_row['month'])){$db_row['month']=$this->month;}}
        if(array_key_exists('year', $db_row)){if(empty($db_row['year'])){$db_row['year']=$this->year;}}
        if(array_key_exists('date', $db_row)){if(empty($db_row['date'])){$db_row['date']=$this->date;}}
        if(array_key_exists('jd', $db_row)){if(empty($db_row['jd'])){$db_row['jd']=$this->todayjd;}}
        $db_row['created']=time();
        $db_row['updated']=time();
        
        //SAVE DATA INTO DATABASE
        return $this->save_db_row($db_row,$required);
    }

    //////////////////////////////////////////////////
    ////////////////GETTER FUNCTIONS//////////////////
    //////////////////////////////////////////////////

//////////////////////////////////////////////// END OF CLASS /////////////////////
}