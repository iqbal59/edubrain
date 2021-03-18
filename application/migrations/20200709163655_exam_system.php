<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Exam_system extends CI_Migration {

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
            'lesson_id' => $_data_int_field,
            'chapter' => $_data_smallint_field,
            'question' => $_data_text_field,
            'detail' => $_data_text_field,
            'hint' => $_data_text_field,
            'type' => $_data_text_field,
            'option1' => $_data_text_field,
            'option2' => $_data_text_field,
            'option3' => $_data_text_field,
            'option4' => $_data_text_field,
            'answer' => $_data_varchar_field,
            'marks' => $_data_smallint_field,
            'day' => $_data_smallint_field,
            'month' => $_data_smallint_field,
            'year' => $_data_smallint_field,
            'difficulty' => $_data_smallint_field,   //complexity level 1-100
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('question_bank',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'class_id' => $_data_int_field,
            'section_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'chapter' => $_data_smallint_field,
            'name' => $_data_text_field,
            'instructions' => $_data_text_field,
            'difficulty' => $_data_smallint_field,   //complexity level 1-100
            'marks' => $_data_smallint_field,
            'qbase_time' => $_data_tinyint_field,  //quiz based time
            'allowed_time' => $_data_smallint_field,  //minutes
            'start_time' => $_data_smallint_field,  //minutes or zero for at own time
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('quiz',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'quiz_id' => $_data_int_field,
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
            'answer' => $_data_varchar_field,
            'marks' => $_data_smallint_field,
            'difficulty' => $_data_smallint_field,   //complexity level 1-100
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('quiz_questions',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'quiz_id' => $_data_int_field,
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
        $this->dbforge->create_table('quiz_answers',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'quiz_id' => $_data_int_field,
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
        $this->dbforge->create_table('quiz_attempts',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'class_id' => $_data_int_field,
            'section_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'name' => $_data_text_field,
            'instructions' => $_data_text_field,
            'marks' => $_data_smallint_field,
            'difficulty' => $_data_smallint_field,   //complexity level 1-100
            'allowed_time' => $_data_smallint_field,  //in minutes
            'start_time' => $_data_smallint_field,  //minutes or zero for at own time
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('paper',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'paper_id' => $_data_int_field,
            'class_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'question' => $_data_text_field,
            'detail' => $_data_text_field,
            'hint' => $_data_text_field,
            'type' => $_data_text_field,    //mcq,tf,short,long
            'option1' => $_data_text_field,
            'option2' => $_data_text_field,
            'option3' => $_data_text_field,
            'option4' => $_data_text_field,
            'answer' => $_data_varchar_field,
            'marks' => $_data_smallint_field,
            'sorting' => $_data_tinyint_field,
            'difficulty' => $_data_smallint_field,   //complexity level 1-100
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('paper_questions',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'paper_id' => $_data_int_field,
            'question_id' => $_data_int_field,
            'student_id' => $_data_int_field,
            'class_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'answer' => $_data_text_field,
            'marks' => $_data_float_field,
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('paper_answers',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'paper_id' => $_data_int_field,
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
        $this->dbforge->create_table('paper_attempts',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'class_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'homework' => $_data_text_field,
            'instructions' => $_data_text_field,
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('homework',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'work_id' => $_data_int_field,
            'student_id' => $_data_int_field,
            'class_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'answer' => $_data_text_field,
            'file' => $_data_text_field,
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('homework_answers',TRUE,$_table_attributes);


        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'class_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'name' => $_data_text_field,
            'instructions' => $_data_text_field,
            'file' => $_data_text_field,
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'allowed_days' => $_data_tinyint_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('assignment',TRUE,$_table_attributes);

        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'assignment_id' => $_data_int_field,
            'student_id' => $_data_int_field,
            'class_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'answer' => $_data_text_field,
            'file' => $_data_text_field,
            'date' => $_data_varchar_field,
            'jd' => $_data_int_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('assignment_answers',TRUE,$_table_attributes);


        /////create table
        $this->dbforge->add_field(array(
            $_primary_key => $_data_primary_field,
            'class_id' => $_data_int_field,
            'subject_id' => $_data_int_field,
            'name' => $_data_text_field,
            'about' => $_data_text_field,
            'file' => $_data_text_field,
            'created' => $_data_int_field,
            'updated' => $_data_int_field,
        ));
        $this->dbforge->add_key($_primary_key, TRUE);
        $this->dbforge->create_table('downloads',TRUE,$_table_attributes);

        ////////////////////////////////////////////////////////////////////////
        ////////////////////ADD FOREIGN KEYS ///////////////////////////////////
        ////////////////////////////////////////////////////////////////////////
    }

    public function down(){
        $this->dbforge->drop_table('question_bank',TRUE);
        $this->dbforge->drop_table('quiz',TRUE);
        $this->dbforge->drop_table('quiz_questions',TRUE);
        $this->dbforge->drop_table('quiz_answers',TRUE);
        $this->dbforge->drop_table('paper',TRUE);
        $this->dbforge->drop_table('paper_questions',TRUE);
        $this->dbforge->drop_table('paper_answers',TRUE);
        $this->dbforge->drop_table('homework',TRUE);
        $this->dbforge->drop_table('homework_answers',TRUE);
        $this->dbforge->drop_table('assignment',TRUE);
        $this->dbforge->drop_table('assignment_answers',TRUE);
        $this->dbforge->drop_table('downloads',TRUE);
    }
}