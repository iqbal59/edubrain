<?php

$COMP_DIR=$LIB_VIEW_DIR.'components/';

$this->load->view($COMP_DIR.'header');
$this->load->view($LIB_VIEW_DIR.$main_content);
$this->load->view($COMP_DIR.'footer');