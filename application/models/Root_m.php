<?php
class Root_M extends MY_Model{

    protected $_model_name='Root_M.php';
    protected $_table_name = '';

    public $_LABEL_ACTIVE='active';
    public $_LABEL_DISABLE='disable';
    public $_LABEL_DRAFT='draft';
    public $_LABEL_PUBLISHED='published';
    public $_LABEL_UNPUBLISHED='unpublished';


    public $_MDL_NEWS='news';
    public $_MDL_LOG='logs';
    ///////////////////////////////
    public $_MDL_CHAT='chat_conversations';
    public $_MDL_CHAT_MESSAGE='chat_conversations_messages';
    public $_MDL_CHAT_GROUP='chat_groups';
    public $_MDL_CHAT_GROUP_MESSAGE='chat_groups_messages';
    public $_MDL_CLASS='classes';
    public $_MDL_GROUP='groups';
    public $_MDL_SECTION='sections';
    public $_MDL_STAFF='staff';
    public $_MDL_STAFF_LOG='staff_activity_log';
    public $_MDL_STAFF_LOGIN='staff_login';
    public $_MDL_STAFF_SUBJECT='staff_subjects';
    public $_MDL_STUDENT='students';
    public $_MDL_STUDENT_LOG='student_activity_log';
    public $_MDL_STUDENT_LOGIN='student_login';
    public $_MDL_STUDENT_TIME_LOG='student_time_log';
    public $_MDL_STUBJECT='subjects';
    public $_MDL_STUBJECT_GROUP='subject_groups';
    public $_MDL_STUBJECT_LESSON='subject_lessons';
    public $_MDL_STUBJECT_LESSON_ATTENDANCE='subject_lesson_attendance';
    public $_MDL_QBANK='question_bank';
    public $_MDL_QUIZ='quiz';
    public $_MDL_QUIZ_QUESTION='quiz_questions';
    public $_MDL_QUIZ_ANSWER='quiz_answers';
    public $_MDL_QUIZ_ATTEMPT='quiz_attempts';
    public $_MDL_PAPER='paper';
    public $_MDL_PAPER_QUESTION='paper_questions';
    public $_MDL_PAPER_ANSWER='paper_answers';
    public $_MDL_PAPER_ATTEMPT='paper_attempts';
    public $_MDL_PAPER_DOC='paper_docs';
    public $_MDL_ASSIGNMENT='assignment';
    public $_MDL_ASSIGNMENT_ANSWER='assignment_answers';
    public $_MDL_HOMEWORK='homework';
    public $_MDL_HOMEWORK_ANSWER='homework_answers';
    public $_MDL_DOWNLOAD='downloads';
    public $_MDL_USER_LOGIN='user_login';
    public $_MDL_CLASS_LINK='class_links';
    public $_MDL_TEST='test';
    public $_MDL_TEST_QUESTION='test_questions';
    public $_MDL_TEST_ANSWER='test_answers';
    public $_MDL_TEST_ATTEMPT='test_attempts';
    public $_MDL_DATESHEET='datesheet';
    public $_MDL_SYLLABUS='syllabus';
    public $_MDL_TIMETABLE='timetable';

    function __construct (){
    	parent::__construct();
    }

    //decode application labels
    public function decode_lablel($label, $show_badge=true){

        switch ($label) {
            case $this->_LABEL_ACTIVE:{
                return $show_badge==true ? '<span class="badge badge-pill badge-success">Active</span>' : 'Active';
            }
            break;
            case $this->_LABEL_DISABLE:{
                return $show_badge==true ? '<span class="badge badge-pill badge-danger">Disabled</span>' : 'Disabled';
            }
            break;
            case $this->_LABEL_DRAFT:{
                return $show_badge==true ? '<span class="badge badge-pill badge-info">Draft</span>' : 'Draft';
            }
            break;
            case $this->_LABEL_PUBLISHED:{
                return $show_badge==true ? '<span class="badge badge-pill badge-info">Published</span>' : 'Published';
            }
            break;
            case $this->_LABEL_UNPUBLISHED:{
                return $show_badge==true ? '<span class="badge badge-pill badge-danger">Un Published</span>' : 'Un Published';
            }
            break;  
            
            default:{
                return '';
            }
            break;

        }
    }
    //return supported video hosts
    public function get_hosts(){
        return array('youtube'=>'YouTube');
    }
//////////////////////////////////////////////// END OF CLASS //////////////////////
}