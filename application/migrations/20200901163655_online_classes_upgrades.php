<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Online_classes_upgrades extends CI_Migration {

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
        if (!$this->db->field_exists('group_id', 'staff_subjects')){
            $fields=array(
                'group_id' => $_data_int_field,
            );
            $this->dbforge->add_column('staff_subjects', $fields);
        }

        /////modify table
        if (!$this->db->field_exists('dbq_id', 'paper_questions')){
            $fields=array(
                'dbq_id' => $_data_int_field,
            );
            $this->dbforge->add_column('paper_questions', $fields);
        }

        /////modify table
        if (!$this->db->field_exists('dbq_id', 'quiz_questions')){
            $fields=array(
                'dbq_id' => $_data_int_field,
            );
            $this->dbforge->add_column('quiz_questions', $fields);
        }

        /////modify table
        if (!$this->db->field_exists('group_id', 'subjects')){
            $fields=array(
                'group_id' => $_data_int_field,
            );
            $this->dbforge->add_column('subjects', $fields);
        }

        /////create table
        if (!$this->db->table_exists('class_links')){
            $this->dbforge->add_field(array(
                $_primary_key => $_data_primary_field,
                'class_id' => $_data_int_field,
                'section_id' => $_data_int_field,
                'group_id' => $_data_int_field,
                'teacher_id' => $_data_int_field,
                'teacher_name' => $_data_text_field,
                'subject_id' => $_data_int_field,
                'subject' => $_data_text_field,
                'class_time' => $_data_text_field,
                'id_password' => $_data_text_field,
                'zoom_link' => $_data_text_field,
                'created' => $_data_int_field,
                'updated' => $_data_int_field,
            ));
            $this->dbforge->add_key($_primary_key, TRUE);
            $this->dbforge->create_table('class_links',TRUE,$_table_attributes);
        }


        ////////////////////////////////////////////////////////////////////////
        ////////////////////ADD FOREIGN KEYS ///////////////////////////////////
        ////////////////////////////////////////////////////////////////////////
    }

    public function down(){
    }
}