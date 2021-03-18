<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_software extends CI_Migration {

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
            'name' => $_data_text_field,
            'incharge_id' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('classes',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'name' => $_data_text_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('groups',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'name' => $_data_text_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('sections',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'student_id' => $_data_varchar_unique_field,
            'name' => $_data_text_field,
            'mobile' => $_data_varchar_field,
            'image' => $_data_text_field,
            'password' => $_data_text_field,
            'father_name' => $_data_text_field,
            'dob' => $_data_text_field,
            'city' => $_data_text_field,
            'state' => $_data_text_field,
            'address' => $_data_text_field,
            'blood_group' => $_data_varchar_field,
            'religion' => $_data_text_field,
            'class_id' => $_data_int_field,
            'group_id' => $_data_int_field,
            'section_id' => $_data_int_field,
            'roll_number' => $_data_int_field,
            'status' => $_data_varchar_field,
            'date' => $_data_varchar_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('students',TRUE,$_table_attributes);


        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'student_id' => $_data_int_field,
            'message' => $_data_text_field,
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('student_activity_log',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'class_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'lesson_id' => $_data_int_field,
            'student_id' => $_data_int_field,
            'jd' => $_data_int_field,
            'day' => $_data_int_field,
            'month' => $_data_int_field,
            'year' => $_data_int_field,
            'date' => $_data_text_field,
            'start_time' => $_data_text_field,
            'end_time' => $_data_text_field,
            'start_timestamp' => $_data_int_field,
            'end_timestamp' => $_data_int_field,
            'total_time' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('student_time_log',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'staff_id' => $_data_varchar_unique_field,
            'name' => $_data_text_field,
            'mobile' => $_data_varchar_field,
            'image' => $_data_text_field,
            'password' => $_data_text_field,
            'father_name' => $_data_text_field,
            'dob' => $_data_text_field,
            'city' => $_data_text_field,
            'state' => $_data_text_field,
            'address' => $_data_text_field,
            'blood_group' => $_data_varchar_field,
            'religion' => $_data_text_field,
            'status' => $_data_varchar_field,
            'date' => $_data_varchar_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('staff',TRUE,$_table_attributes);


        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'staff_id' => $_data_int_field,
            'message' => $_data_text_field,
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('staff_activity_log',TRUE,$_table_attributes);


        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'staff_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'class_id' => $_data_int_field,
            'group_id' => $_data_int_field,
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('staff_subjects',TRUE,$_table_attributes);


        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'class_id' => $_data_int_field,
            'group_id' => $_data_int_field,
            'section_id' => $_data_int_field,
            'name' => $_data_text_field,
            'date' => $_data_text_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('chat_groups',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'chat_group_id' => $_data_int_field,
            'student_id' => $_data_int_field,
            'staff_id' => $_data_int_field,
            'message' => $_data_text_field,
            'image' => $_data_text_field,
            'file' => $_data_text_field,
            'day' => $_data_int_field,
            'month' => $_data_int_field,
            'year' => $_data_int_field,
            'date' => $_data_text_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('chat_groups_messages',TRUE,$_table_attributes);


        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'student_id' => $_data_int_field,
            'staff_id' => $_data_int_field,
            'name' => $_data_text_field,
            'date' => $_data_text_field,
            'stf_update' => $_data_tinyint_field,
            'std_update' => $_data_tinyint_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('chat_conversations',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'chat_id' => $_data_int_field,
            'student_id' => $_data_int_field,
            'staff_id' => $_data_int_field,
            'reply_of' => $_data_int_field,
            'message' => $_data_text_field,
            'image' => $_data_text_field,
            'file' => $_data_text_field,
            'day' => $_data_int_field,
            'month' => $_data_int_field,
            'year' => $_data_int_field,
            'date' => $_data_text_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('chat_conversations_messages',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'class_id' => $_data_int_field,
            'group_id' => $_data_int_field,
            'name' => $_data_text_field,
            'date' => $_data_text_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('subjects',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'class_id' => $_data_int_field,
            'group_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'name' => $_data_text_field,
            'about' => $_data_text_field,
            'host' => $_data_varchar_field,
            'video_link' => $_data_text_field,
            'lesson_no' => $_data_int_field,
            'views' => $_data_int_field,
            'likes' => $_data_int_field,
            'lesson_date' => $_data_text_field,
            'lesson_jd' => $_data_int_field,
            'duration' => $_data_int_field,
            'date' => $_data_text_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('subject_lessons',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'class_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'lesson_id' => $_data_int_field,
            'student_id' => $_data_int_field,
            'status' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'day' => $_data_int_field,
            'month' => $_data_int_field,
            'year' => $_data_int_field,
            'date' => $_data_text_field,
            'datetime' => $_data_text_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('subject_lesson_attendance',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'title' => $_data_text_field,
            'slug' => $_data_text_field,
            'content' => $_data_longtext_field,
            'views' => $_data_int_field,
            'date' => $_data_varchar_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('news',TRUE,$_table_attributes);


        /////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'ipaddress' => $_data_varchar_field,
            'time' => $_data_bigint_field,
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('login_session',TRUE,$_table_attributes);

    	/////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'user_id' => $_data_int_field,
            'message' => $_data_text_field,
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('system_history',TRUE,$_table_attributes);

    	/////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'name' => $_data_text_field,
            'value' => $_data_text_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('system_settings',TRUE,$_table_attributes);

    	/////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'campus_id' => $_data_int_field,
            'name' => $_data_text_field,
            'email' => $_data_varchar_unique_field,
            'mobile' => $_data_varchar_field,
            'image' => $_data_text_field,
            'password' => $_data_text_field,
            'father_name' => $_data_text_field,
            'state' => $_data_text_field,
            'address' => $_data_text_field,
            'reset_code' => $_data_text_field,
            'status' => $_data_varchar_field,
            'type' => $_data_varchar_field,
            'date' => $_data_varchar_field,
            '2fa_enabled' => $_data_tinyint_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('users',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'ipaddress' => $_data_text_field,
            'user_agent' => $_data_text_field,
            'date' => $_data_varchar_field,
            'day' => $_data_tinyint_field,
            'month' => $_data_tinyint_field,
            'year' => $_data_smallint_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('logs',TRUE,$_table_attributes);


        ////////////////////////////////////////////////////////////////////////
        ////////////////////ADD FOREIGN KEYS ///////////////////////////////////
        ////////////////////////////////////////////////////////////////////////
    }

    public function down(){
        $this->dbforge->drop_table('classes',TRUE);
        $this->dbforge->drop_table('groups',TRUE);
        $this->dbforge->drop_table('sections',TRUE);
        $this->dbforge->drop_table('students',TRUE);
        $this->dbforge->drop_table('student_activity_log',TRUE);
        $this->dbforge->drop_table('student_time_log',TRUE);
        $this->dbforge->drop_table('staff',TRUE);
        $this->dbforge->drop_table('staff_activity_log',TRUE);
        $this->dbforge->drop_table('chat_groups',TRUE);
        $this->dbforge->drop_table('chat_groups_messages',TRUE);
        $this->dbforge->drop_table('chat_conversations',TRUE);
        $this->dbforge->drop_table('chat_conversations_messages',TRUE);
        $this->dbforge->drop_table('subjects',TRUE);
        $this->dbforge->drop_table('subject_lessons',TRUE);
        $this->dbforge->drop_table('subject_lesson_attendance',TRUE);
        ////////////////////////////////////////////////////
        $this->dbforge->drop_table('login_session',TRUE);
        $this->dbforge->drop_table('system_history',TRUE);
        $this->dbforge->drop_table('system_settings',TRUE);
        $this->dbforge->drop_table('users',TRUE);
        $this->dbforge->drop_table('logs',TRUE);
        $this->dbforge->drop_table('migrations',TRUE);
    }
}