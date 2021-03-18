<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Dashboard_result_upgrades extends CI_Migration {

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


        /////modify table
        if (!$this->db->field_exists('show_result', 'paper')){
            $fields=array(
                'show_result' => $_data_tinyint_field,
                'result_date' => $_data_text_field,
            );
            $this->dbforge->add_column('paper', $fields);
        }


        /////modify table
        if (!$this->db->field_exists('chapter', 'subject_lessons')){
            $fields=array(
                'chapter' => $_data_int_field,
            );
            $this->dbforge->add_column('subject_lessons', $fields);
        }


        /////create table
        if (!$this->db->table_exists('paper_docs')){
            $this->dbforge->add_field(array(
                $_primary_key => $_data_primary_field,
                'paper_id' => $_data_int_field,
                'question_id' => $_data_int_field,
                'student_id' => $_data_int_field,
                'class_id' => $_data_int_field,
                'subject_id' => $_data_int_field,
                'file_name' => $_data_text_field,
                'date' => $_data_varchar_field,
                'jd' => $_data_int_field,
                'created' => $_data_int_field,
                'updated' => $_data_int_field,
            ));
            $this->dbforge->add_key($_primary_key, TRUE);
            $this->dbforge->create_table('paper_docs',TRUE,$_table_attributes);
        }
        /////create table
        if (!$this->db->table_exists('student_login')){
            $this->dbforge->add_field(array(
                $_primary_key => $_data_primary_field,
                'student_id' => $_data_int_field,
                'class_id' => $_data_int_field,
                'ip_address' => $_data_varchar_field,
                'date' => $_data_varchar_field,
                'jd' => $_data_int_field,
                'created' => $_data_int_field,
                'updated' => $_data_int_field,
            ));
            $this->dbforge->add_key($_primary_key, TRUE);
            $this->dbforge->create_table('student_login',TRUE,$_table_attributes);
        }

        /////create table
        if (!$this->db->table_exists('staff_login')){
            $this->dbforge->add_field(array(
                $_primary_key => $_data_primary_field,
                'staff_id' => $_data_int_field,
                'ip_address' => $_data_varchar_field,
                'date' => $_data_varchar_field,
                'jd' => $_data_int_field,
                'created' => $_data_int_field,
                'updated' => $_data_int_field,
            ));
            $this->dbforge->add_key($_primary_key, TRUE);
            $this->dbforge->create_table('staff_login',TRUE,$_table_attributes);
        }

        /////create table
        if (!$this->db->table_exists('user_login')){
            $this->dbforge->add_field(array(
                $_primary_key => $_data_primary_field,
                'user_id' => $_data_int_field,
                'ip_address' => $_data_varchar_field,
                'date' => $_data_varchar_field,
                'jd' => $_data_int_field,
                'created' => $_data_int_field,
                'updated' => $_data_int_field,
            ));
            $this->dbforge->add_key($_primary_key, TRUE);
            $this->dbforge->create_table('user_login',TRUE,$_table_attributes);
        }



        ////////////////////////////////////////////////////////////////////////
        ////////////////////ADD FOREIGN KEYS ///////////////////////////////////
        ////////////////////////////////////////////////////////////////////////
    }

    public function down(){
    }
}