<?php

//// CAUTION:-   DO NOT CHANGE ANY VARIABLE IN THIS FILE. IT MAY CRASH THE WHOLE SYSTEM.   
//// THIS CLASS ACTS AS ROOT MODEL FOR APPLICATION..   
///////////////////////////////////////////////////////////////////////////
class MY_Model extends CI_Model {

    //////////////////////////// CONTANTS //////////////////////////////////////////
    protected $_allowed_tags = "<p><b><img><a><br><strong><i><span><div><h1><h2><h3><h4><h5><h6><em><q><blockquote><ul><ol><li>";
    public $_primary_key = 'mid';
    protected $_model_name = 'MY_Model.php';
    protected $_table_name = '';
    protected $_primary_filter = 'intval';
    protected $_order_by = '';
    protected $_SAVE_ERROR_LOG = TRUE;
    public $day;
    public $month;
    public $year;
    public $date;
    public $time;
    public $todayjd;

    //constructor
    function __construct() {
        parent::__construct();
        //////////////////////////////////////
        if(file_exists("./timezone.txt") ){
            $myfile = fopen("./timezone.txt", "r") or die("Unable to open timezone file!");
            $timezone=fread($myfile,filesize("./timezone.txt"));
            fclose($myfile);   
            date_default_timezone_set($timezone);         
        }
        /////////////////////////////////////

        $this->day = date('d');
        $this->month = date('m');
        $this->year = date('Y');
        $this->date = date('d-M-Y');
        $this->time = date('h:i:s');
        $this->datetime = date('d-M-Y h:i:s A');
        $this->todayjd = juliantojd($this->month, $this->day, $this->year);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////    
    //GET DATA FROM DATABASE
    public function get($id = NULL, $single = TRUE, $select = '') {
        $this->db->select($select);
        if ($id != NULL) {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->where($this->_primary_key, $id);
            $method = 'row';
        } elseif ($single == TRUE) {
            $method = 'row';
        } else {
            $method = 'result';
        }
        ////////////////////////////////

        $query=$this->db->get($this->_table_name);
        if($method=='result'){
            $data=array();
            if($query !== FALSE && $query->num_rows()>0){
                $data=$query->$method();
            }else{
                return $this->get_new();
            }
            if(count($data)>0){
                $i=0;
                foreach($data as $field){
                    $arr_field= (array) $field;
                    foreach($arr_field as $key=>$var){
                        $data[$i]->$key=$var;                    
                    }
                    //------------------------
                    $i++;
                }                
            }
            return $data;
        }else{
            $data=array();
            if($query !== FALSE && $query->num_rows()>0){
                $data=$query->$method();
            }
            return $data;            
        }
    }
    //GET DATA FROM DATABASE BY PROVIDING CONDITIONS
    public function get_by($where = array(), $single = TRUE, $select = '') {
        $this->db->where($where);
        return $this->get(NULL, $single,$select);
    }
    //INSERT/UPDATE DATA INTO DATABASE
    public function save($data, $where=NULL, $insert=false){
        // Insert
        if ($where === NULL && $insert==true) {
            $this->db->set($data);
            $this->db->insert($this->_table_name);
            return $this->db->insert_id();
        }else{
            $data['updated']=time();
            // Update save_where
            if(is_array($where) && count($where)>0){
                $this->db->where($where);
                $this->db->set($this->validate_save_data($data));
                $this->db->update($this->_table_name);
                return $this->db->affected_rows();
            }else{
                //update with primary key
                $filter = $this->_primary_filter;
                $id = $filter($where);
                $this->db->set($this->validate_save_data($data));
                $this->db->where($this->_primary_key, $id);
                $this->db->update($this->_table_name);
                return $this->db->affected_rows();                
            }
        }
    }
    //INSERT/UPDATE DATA INTO DATABASE USING BATCH OPERATIONS
    public function save_batch($data, $batch_size=100, $update=false, $key=NULL, $escape=NULL){
        // Insert
        if ($key === NULL && $update==false) {
            return $this->db->insert_batch($this->_table_name, $data,$escape,$batch_size);
        }else{
            return $this->db->update_batch($this->_table_name, $data, $key);
        }
    }
    //SAVE DATA IN NEW DATABASE ROW AFTER VALIDATING ALL DATA   
    public function save_db_row($data,$required=array()) {
        //SAVE DATA INTO DATABASE
        if ($this->is_valid_data($data,$required) == true){
            $insert_id = $this->save($data, NULL, true);
            if($insert_id<1){
                return false;
            }else{
                return $insert_id;
            }
        } else {
            //operation failed. Log the error
            if ($this->_SAVE_ERROR_LOG) {
                $msg = "Invalid data provided in Function(add_row), Model($this->_model_name)";
                log_message('error', $msg.json_encode($data));
            }
            return false;
        }
    }
    //DELETE A ROW FROM
    public function delete($rid = NULL, $where=array(),$truncate=false) {
        if($rid===NULL && count($where)>0){
            //delete_where
            $this->db->where($where);
            return $this->db->delete($this->_table_name);
        }elseif($rid===NULL && count($where)<1 && $truncate==true){
            //empty complete table
            return $this->db->truncate($this->_table_name);
        }else{
            //single row delete
            $filter = $this->_primary_filter;
            $id = $filter($rid);
            if (!$id) {return FALSE;}
            $this->db->where($this->_primary_key, $id);
            $this->db->limit(1);            
            return $this->db->delete($this->_table_name);
            
        }
    }
    //DELETE ROWS FROM MULTIPLE TABLES
    public function xdelete($tables = array(), $where=array(), $limit=NULL) {
        if(count($tables) >0 && count($where)>0){
            //delete_where
            return $this->db->delete($tables,$where,$limit);
        }
        return false;
    }
    //GET RESULTS OF A CUSTOM QUERY
    public function query($statement, $single = FALSE) {
        $query= $this->db->query($statement);
        if ($single == TRUE) {
            $method = 'row';
        } else {
            $method = 'result';
        }
        return $query->$method();
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
   
    //This function will remove all keys which do not belong to any column
    public function validate_save_data($data) {
        $db_row = array();
        $fields = $this->db->list_fields($this->_table_name);
        foreach ($fields as $field) {
            if (array_key_exists($field, $data) ){$db_row[$field] = $data[$field];}//process only provided values
        }
        return $db_row;
    }
    //This function will assign the given values to their colums and return array of row values
    public function grab_row($data) {
        $db_row = array();
        $fields = $this->db->list_fields($this->_table_name);
        foreach ($fields as $field) {
            if (empty($data[$field])) {$data[$field] = '';} //process only provided values
            $db_row[$field] = $data[$field];
        }
        return $db_row;
    }

    //validate data before saving new record
    public function is_valid_data($data,$required=array()){
        if(is_array($required) && count($required)>0){
            if(has_string_keys($required)){
              foreach($required as $key=>$val){
                  if($key=='int'){
                      if(intval($data[$val])<1){return false;}
                  }else{
                      if(empty($data[$val]) ){return false;}                    
                  }
              }                
            }else{
              foreach($required as $val){
                  if(empty($data[$val]) ){return false;} 
              }              
              
            }      
        }
        ///////////// data is valid to insert or update
        return true;        
    }   
    //This update column numbers value
    //specifically for amount increment and decrement
    public function update_column_value($rid, $col, $value, $opt = ''){
        $current_value= $this->get_by_primary($rid,$col)->$col;
        switch ($opt) {
            case 'subtract':{
                return $this->save(array($col=>$current_value-$value),$rid);
            }
            break; 
            case 'minus':{
                return $this->save(array($col=>$current_value-$value),$rid);
            }
            break;           
            default:{
                //default is plus
                return $this->save(array($col=>$current_value+$value),$rid);
            }
            break;
        }
    }
    //This function will return filtered rows in the table
    public function get_rows($filter = array(), $params=array() ,$num_rows=false,$join=array()) {
        if(is_array($join) && count($join)>0){            
            $_PK="tbl.".$this->_primary_key;
            $this->db->from($this->_table_name." tbl"); //default table alias
            foreach($join as $table){
                if(array_key_exists('table', $table) && array_key_exists('condition', $table)){
                    $type='';
                    if(array_key_exists('type', $table) ){$type=$table['type'];}
                    $this->db->join($table['table'], $table['condition'], $type);
                }
            }
        }else{
            $_PK=$this->_primary_key;
            $this->db->from($this->_table_name);
        }
        $this->db->where($filter);
        if(is_array($params)){
            $distinct=false;
            //if needs only distinct values
            if(array_key_exists('distinct', $params)){if($params['distinct']==true){$this->db->distinct();$distinct=true;}}
            //for specific columns
            if(array_key_exists('select', $params)){
                if(empty($params['select'])){
                    if(!$distinct){$this->db->select($_PK);}
                }else{                    
                    if(!$distinct){$this->db->select($_PK);}//necessary fields if not distinct value
                    $this->db->select($params['select']);
                }
            }else{
                if(!$distinct){$this->db->select($_PK);}
            }
            //for order_by
            if(array_key_exists('orderby', $params)){
                $orderby_array=explode(" ", $params['orderby']);
                if(count($orderby_array)>1 && strtolower($orderby_array[1])=='random'){
                    $this->db->order_by(explode(" ", $params['orderby'])[0],"RANDOM");
                }else{                   
                    $this->db->order_by($params['orderby']);
                }
            }else{
                $this->db->order_by($_PK,'DESC');
            }
            //for limit
            if(array_key_exists('limit', $params)){
                if(array_key_exists('offset', $params)){                
                    $this->db->limit($params['limit'],$params['offset']);
                }else{
                    $this->db->limit($params['limit']);
                }
            }
            //for like
            if(array_key_exists('like', $params)){if(is_array($params['like']) && count($params['like'])>0){ 
                $like_str="(";
                $number=count($params['like']);
                $i=0;
                foreach ($params['like'] as $key => $value) {
                    $i++;
                    $like_str.=" ".$key." LIKE '%".$value."%' ";   
                    if($i<$number){$like_str.=" OR ";}         
                }
                $like_str.=")";
                $this->db->where($like_str,NULL,false);
            }}
            //for or_where // 1 where is necessary for this to work properly!
            if(array_key_exists('or_where', $params)){if(is_array($params['or_where']) && count($params['or_where'])>0){         
                foreach ($params['or_where'] as $key => $value) {
                    if(!empty($key) && !empty($value)){$this->db->or_where($key,$value);}
                }
            }}

            //for where_in //
            if(array_key_exists('where_in', $params)){if(is_array($params['where_in']) && count($params['where_in'])>0){         
                foreach ($params['where_in'] as $key => $value) {
                    //values must be an array E.g array('name',array('name1','name2','name3'))
                    if(!empty($key) && is_array($value) && count($value)>0){
                        $this->db->where_in($key,$value);
                    }
                }
            }}

            //for or_where_in // 1 where_in is necessary for this to work properly!
            if(array_key_exists('or_where_in', $params)){if(is_array($params['or_where_in']) && count($params['or_where_in'])>0){         
                foreach ($params['or_where_in'] as $key => $value) {
                    // values must be an array E.g array('name',array('name1','name2','name3'))
                    if(!empty($key) && is_array($value) && count($value)>0){
                        $this->db->or_where_in($key,$value);
                    }
                }
            }}

            //for where_not_in // 
            if(array_key_exists('where_not_in', $params)){if(is_array($params['where_not_in']) && count($params['where_not_in'])>0){         
                foreach ($params['where_not_in'] as $key => $value) {
                    // values must be an array E.g array('name',array('name1','name2','name3'))
                    if(!empty($key) && is_array($value) && count($value)>0){
                        $this->db->where_not_in($key,$value);
                    }
                }
            }}
        }
        /////////////////////////////////////////////////////////
        $query=$this->db->get();
        // print_r($query);
        if($num_rows==true){
            return $query->num_rows();
        }else{
            $data=array();
            if($query !== FALSE && $query->num_rows()>0){
                $data=$query->result_array();
            }
            if(count($data)>0){
                $i=0;
                foreach($data as $field){
                    foreach($field as $key=>$var){
                        $data[$i][$key]=$var;                    
                    }
                    //------------------------
                    $i++;
                }
            }
            return $data;
        }
    }

    //This function will return the rows in the table based on join and filter values
    public function get_join_rows($join = array(), $filter = array(), $params=array() ,$num_rows=false ) {
        if(is_array($params)){
            //for specific columns
            if(array_key_exists('select', $params)){$this->db->select($params['select']);}
            //if needs only distinct values
            if(array_key_exists('distinct', $params)){if($params['distinct']==true){$this->db->distinct();}}
            //for order_by
            if(array_key_exists('orderby', $params)){$this->db->order_by($params['orderby']);}
            //for order_by
            if(array_key_exists('limit', $params)){
                if(array_key_exists('offset', $params)){                
                    $this->db->limit($params['limit'],$params['offset']);
                }else{
                    $this->db->limit($params['limit']);
                }
            }
            //for like
            if(array_key_exists('like', $params)){if(is_array($params['like']) && count($params['like']>0)){            
                $this->db->like($params['like']);
            }}
            //for or like
            if(array_key_exists('or_like', $params)){if(is_array($params['or_like']) && count($params['or_like']>0)){            
                $this->db->or_like($params['or_like']);
            }}
            //for not like
            if(array_key_exists('not_like', $params)){if(is_array($params['not_like']) && count($params['not_like']>0)){            
                $this->db->not_like($params['not_like']);
            }}
        }
        /////////////////////////////////////////////////////////
        foreach($join as $table){
            if(array_key_exists('table', $table) && array_key_exists('condition', $table)){
                $type='';
                if(array_key_exists('type', $table) ){$type=$table['type'];}
                $this->db->join($table['table'], $table['condition'], $type);
            }
        }
        $this->db->where($filter);
        /////////////////////////////////////////////////////////
        $query=$this->db->get($this->_table_name);
        if($num_rows==true){
            return $query->num_rows();
        }else{
            $data=array();
            if($query !== FALSE && $query->num_rows()>0){
                $data=$query->result_array();
            }
            if(count($data)>0){
                $i=0;
                foreach($data as $field){
                    foreach($field as $key=>$var){
                        $data[$i][$key]=$var;                    
                    }
                    //------------------------
                    $i++;
                }
            }
            return $data;
        }
    }

    //This function will return the aggregate reuslt of a comumn
    public function get_column_result($column = '', $filter = array(), $method='sum') {
        $this->db->select($column); //select only only required colums instead of whole table
        switch (strtolower($method)) {
            case 'avg' : $this->db->select_avg($column);
                break;
            case 'min' : $this->db->select_min($column);
                break;
            case 'max' : $this->db->select_max($column);
                break;
            case 'sum' : $this->db->select_sum($column);
                break;
            default :$this->db->select_sum($column);
                break;
        }
        $this->db->where($filter);
        return $this->db->get($this->_table_name)->row()->$column;
    }

    //This function will return an array with first value as index and second as value with filtered values 
    public function get_values_array($index = '', $field = '', $filter = array(), $orderby='', $distinct=false,$or_where=array()) {
        if (empty($index)) {$index = $this->_primary_key;}
        $this->db->select("$index, $field"); //select only only required colums instead of whole table
        $this->db->where($filter);
        $this->db->or_where($or_where);
        if(!empty($orderby)){
            if(strtolower(explode(" ", $orderby)[1])=='random'){
                $this->db->order_by(explode(" ", $orderby)[0],"RANDOM");
            }else{                   
                $this->db->order_by($orderby);
            }
        }else{
            $this->db->order_by($index,'ASC');
        }
        if($distinct==true){$this->db->distinct();}//for order_by
        $data=array();
        foreach($this->db->get($this->_table_name)->result_array() as $row){$data[$row[$index]] = $row[$field];}
        return $data;
    }

    //This function will return an array with all values of a column as value with filtered values
    public function get_column_array($column, $filter = array(), $sort='', $distinct=false) {
        $this->db->select($column); //select only only required colums instead of whole table
        $this->db->where($filter);
        if(!empty($sort)){              
            $this->db->order_by($sort);
        }
        if($distinct==true){$this->db->distinct();}//for order_by
        $data=array();
        foreach($this->db->get($this->_table_name)->result_array() as $row){array_push($data, $row[$column]);}
        return $data;
    }

    //This function will return true if value will exist in given field(colum)
    public function is_valid_field($field, $value) {
        if($this->get_rows(array($field => $value),'',true)>0){return true;}
        return FALSE;
    }

    //This function will return the single row if primary key mathced. NULL object otherwise
    public function get_by_primary($rid, $select = '') {
        if ($this->is_valid_field($this->_primary_key, $rid)) {
            return $this->get($rid, TRUE, $select);
        } else {
            return $this->get_new();
        }
    }

    //generate unique key for table column
    public function get_unique_col_value($col,$value='',$length=6){
        if(empty($value)){$value=get_random_string($length);}
        if($this->is_valid_field($col, $value)){
            $result=$value.mt_rand(1,9).mt_rand(1,9);
            if($this->is_valid_field($col, $result)){
                return $this->get_unique_col_value($col,$value,$length);
            }else{
                return $result;
            }
        }else{
            return $value;
        }
    }

    //This function will return the table fields as an object with NULL
    public function get_new() {
        $prop = new stdClass();
        $flds = $this->db->list_fields($this->_table_name);
        foreach ($flds as $fld) {
            $prop->$fld = NULL;
        }
        return $prop;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    // GET HASH OF A STRING
    public function hash($string) {
        return hash(('sha512'),(hash('sha512', $string . config_item('encryption_key'))));
    }

    /**
     * ///////////////////////////////////////////////////////////////////////////////////////
     * ***************************** END OF CLASS ********************************************
     * ///////////////////////////////////////////////////////////////////////////////////////
     */
}
