<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_2p2 extends CI_Migration {

    public function up(){
    	$this->load->dbforge();
    	//configurations for migration class.
    	$_primary_key='mid';
    	$_data_primary_field=array('type' => 'INT','unsigned' => TRUE,'auto_increment' => TRUE);
        $_data_primary_big_field=array('type' => 'BIGINT','unsigned' => TRUE,'auto_increment' => TRUE);
    	$_data_int_field=array('type' => 'INT','unsigned' => TRUE);
        $_data_int_unique_field=array('type' => 'INT','unsigned' => TRUE, 'unique' =>true);
    	$_data_tinyint_field=array('type' => 'TINYINT','unsigned' => TRUE);
        $_data_tinyint_unique_field=array('type' => 'TINYINT','unsigned' => TRUE, 'unique' =>true);
    	$_data_smallint_field=array('type' => 'SMALLINT','unsigned' => TRUE);
        $_data_smallint_unique_field=array('type' => 'SMALLINT','unsigned' => TRUE, 'unique' =>true);
    	$_data_bigint_field=array('type' => 'BIGINT','unsigned' => TRUE);
        $_data_bigint_unique_field=array('type' => 'BIGINT','unsigned' => TRUE, 'unique' =>true);
    	$_data_float_field=array('type' => 'FLOAT','constraint' => '10,2');
    	$_data_varchar_field=array('type' => 'VARCHAR','constraint' => '255');
        $_data_varchar_unique_field=array('type' => 'VARCHAR','constraint' => '255', 'unique' =>true);
        $_data_long_varchar_field=array('type' => 'VARCHAR','constraint' => '5100');
        $_data_long_varchar_unique_field=array('type' => 'VARCHAR','constraint' => '5100', 'unique' =>true);
    	$_data_text_field=array('type' => 'TEXT','null' => TRUE);
    	$_data_longtext_field=array('type' => 'LONGTEXT','null' => TRUE);
    	$_table_attributes=array('ENGINE' => 'InnoDB');

    	/////////////////////////////////////////////////////////////////
    	/////////////////////////////////////////////////////////////////


        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'class_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'student_id' => $_data_int_field,
            'chapter' => $_data_smallint_field,
            'name' => $_data_text_field,
            'marks' => $_data_smallint_field,
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('test',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'test_id' => $_data_int_field,
            'class_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'chapter' => $_data_smallint_field,
            'question' => $_data_text_field,
            'detail' => $_data_text_field,
            'hint' => $_data_text_field,
            'type' => $_data_text_field,    //
            'option1' => $_data_text_field,
            'option2' => $_data_text_field,
            'option3' => $_data_text_field,
            'option4' => $_data_text_field,
            'solution' => $_data_text_field,
            'answer' => $_data_varchar_field,
            'marks' => $_data_smallint_field,
            'dbq_id' => $_data_int_field,
            'sorting' => $_data_smallint_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('test_questions',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'test_id' => $_data_int_field,
            'question_id' => $_data_int_field,
            'student_id' => $_data_int_field,
            'class_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'answer' => $_data_text_field,
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('test_answers',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'test_id' => $_data_int_field,
            'student_id' => $_data_int_field,
            'start_time' => $_data_smallint_field,
            'end_time' => $_data_smallint_field,
            'is_ended' => $_data_tinyint_field,
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('test_attempts',TRUE,$_table_attributes);


        /////modify table
        // if (!$this->db->field_exists('reset_password', 'students')){
        //     $fields=array(
        //         'reset_password' => $_data_tinyint_field,
        //     );
        //     $this->dbforge->add_column('students', $fields);
        // }

        // /////modify table
        // if (!$this->db->field_exists('reset_password', 'staff')){
        //     $fields=array(
        //         'reset_password' => $_data_tinyint_field,
        //     );
        //     $this->dbforge->add_column('staff', $fields);
        // }

        ////////////////////////////////////////////////////////////////////////
        ////////////////////ADD FOREIGN KEYS ///////////////////////////////////
        ////////////////////////////////////////////////////////////////////////
    }

    public function down(){
    }
}