<?php
// multi branch feature added
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_2p3 extends CI_Migration {

    public function up(){
    	$this->load->dbforge();
    	//configurations for migration class.
    	$_primary_key='mid';
    	$_data_primary_field=array('type' => 'INT','unsigned' => TRUE,'auto_increment' => TRUE, 'null'=>false);
        $_data_primary_big_field=array('type' => 'BIGINT','unsigned' => TRUE,'auto_increment' => TRUE, 'null'=>false);
    	$_data_int_field=array('type' => 'INT','unsigned' => TRUE, 'null'=>false);
        $_data_int_unique_field=array('type' => 'INT','unsigned' => TRUE, 'unique' =>true, 'null'=>false);
    	$_data_tinyint_field=array('type' => 'TINYINT','unsigned' => TRUE, 'null'=>false);
        $_data_tinyint_unique_field=array('type' => 'TINYINT','unsigned' => TRUE, 'unique' =>true);
    	$_data_smallint_field=array('type' => 'SMALLINT','unsigned' => TRUE, 'null'=>false);
        $_data_smallint_unique_field=array('type' => 'SMALLINT','unsigned' => TRUE, 'unique' =>true, 'null'=>false);
    	$_data_bigint_field=array('type' => 'BIGINT','unsigned' => TRUE, 'null'=>false);
        $_data_bigint_unique_field=array('type' => 'BIGINT','unsigned' => TRUE, 'unique' =>true, 'null'=>false);
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

        /////modify table (Error fixed - found in the 20200901163655)
        if (!$this->db->field_exists('group_id', 'subjects')){
            $fields=array(
                'group_id' => $_data_int_field,
            );
            $this->dbforge->add_column('subjects', $fields);
        }

        ///modify table
        if (!$this->db->field_exists('section_id', 'class_links')){
            $fields=array(
                'section_id' => $_data_int_field,
            );
            $this->dbforge->add_column('class_links', $fields);
        }

        ///modify table
        if (!$this->db->field_exists('group_id', 'class_links')){
            $fields=array(
                'group_id' => $_data_int_field,
            );
            $this->dbforge->add_column('class_links', $fields);
        }

        ///modify table
        if (!$this->db->field_exists('teacher_id', 'class_links')){
            $fields=array(
                'teacher_id' => $_data_int_field,
            );
            $this->dbforge->add_column('class_links', $fields);
        }

        ///modify table
        if (!$this->db->field_exists('teacher_id', 'class_links')){
            $fields=array(
                'teacher_id' => $_data_int_field,
            );
            $this->dbforge->add_column('class_links', $fields);
        }
        ///modify table
        if (!$this->db->field_exists('teacher_name', 'class_links')){
            $fields=array(
                'teacher_name' => $_data_text_field,
            );
            $this->dbforge->add_column('class_links', $fields);
        }


        ///modify table
        if (!$this->db->field_exists('section_id', 'homework')){
            $fields=array(
                'section_id' => $_data_int_field,
            );
            $this->dbforge->add_column('homework', $fields);
        }

        ///modify table
        if (!$this->db->field_exists('file', 'homework')){
            $fields=array(
                'file' => $_data_text_field,
            );
            $this->dbforge->add_column('homework', $fields);
        }

        //create new table
        if (!$this->db->table_exists('subject_groups')){
            /////create table
            $this->dbforge->add_field(array(
                $_primary_key => $_data_primary_field,
                'subject_id' => $_data_int_field,
                'group_id' => $_data_int_field,
                'created' => $_data_int_field,
                'updated' => $_data_int_field,
            ));
            $this->dbforge->add_key($_primary_key, TRUE);
            $this->dbforge->create_table('subject_groups',TRUE,$_table_attributes);
        }
        //create new table
        // if (!$this->db->table_exists('staff_subjects_sections')){
        //     /////create table
        //     $this->dbforge->add_field(array(
        //         $_primary_key => $_data_primary_field,
        //         'subject_id' => $_data_int_field,
        //         'section_id' => $_data_int_field,
        //         'class_id' => $_data_int_field,
        //         'created' => $_data_int_field,
        //         'updated' => $_data_int_field,
        //     ));
        //     $this->dbforge->add_key($_primary_key, TRUE);
        //     $this->dbforge->create_table('staff_subjects_sections',TRUE,$_table_attributes);
        // }
        /////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////
        // below fields are due to error adjustment in previous version. 
        // remove these in next version
        if (!$this->db->table_exists('test_attempts')){
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
        }
        /////modify table
        if (!$this->db->field_exists('section_id', 'paper')){
            $fields=array(
                'section_id' => $_data_int_field,
            );
            $this->dbforge->add_column('paper', $fields);
        }
        /////modify table
        if (!$this->db->field_exists('section_id', 'quiz')){
            $fields=array(
                'section_id' => $_data_int_field,
            );
            $this->dbforge->add_column('quiz', $fields);
        }


        ////////////////////////////////////////////////////////////////////////
        ////////////////////ADD FOREIGN KEYS ///////////////////////////////////
        ////////////////////////////////////////////////////////////////////////
    }

    public function down(){
    }
}