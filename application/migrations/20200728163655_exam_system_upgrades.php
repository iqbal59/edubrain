<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Exam_system_upgrades extends CI_Migration {

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
        if (!$this->db->field_exists('chapters', 'subjects')){
            $fields=array(
                'chapters' => $_data_int_field,
            );
            $this->dbforge->add_column('subjects', $fields);
        }

        /////modify table
        if (!$this->db->field_exists('topic', 'question_bank')){
            $fields=array(
                'topic' => $_data_text_field,
            );
            $this->dbforge->add_column('question_bank', $fields);
        }

        /////modify table
        if (!$this->db->field_exists('solution', 'question_bank')){
            $fields=array(
                'solution' => $_data_text_field,
            );
            $this->dbforge->add_column('question_bank', $fields);
        }

        /////modify table
        if (!$this->db->field_exists('solution', 'paper_questions')){
            $fields=array(
                'solution' => $_data_text_field,
            );
            $this->dbforge->add_column('paper_questions', $fields);
        }

        /////modify table
        if (!$this->db->field_exists('solution', 'quiz_questions')){
            $fields=array(
                'solution' => $_data_text_field,
            );
            $this->dbforge->add_column('quiz_questions', $fields);
        }


        ////////////////////////////////////////////////////////////////////////
        ////////////////////ADD FOREIGN KEYS ///////////////////////////////////
        ////////////////////////////////////////////////////////////////////////
    }

    public function down(){
    }
}