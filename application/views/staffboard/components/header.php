<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">    
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, shrink-to-fit=9">
  <meta name="description" content="Online LMS">
  <meta name="author" content="Mozzine">
  <title><?php print ucwords($this->config->item('app_name'));?> |  Staff Dashboard</title>
  
  <!-- Favicon Icon -->
  <link rel="icon" type="image/png" href="<?php print $this->UPLOADS_ROOT;?>images/logo/favicon.png">
  
  <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
  <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3.0.1/es5/tex-mml-chtml.js"></script>
  <!-- Stylesheets -->
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
  <link href='<?php print $this->RES_ROOT;?>vendor/unicons-2.0.1/css/unicons.css<?php print $this->FILE_VERSION;?>' rel='stylesheet'>

  <?php if(empty($this->BG_THEME)){ ?>
  <link href="<?php print $this->RES_ROOT;?>css/vertical-responsive-menu.min.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <link href="<?php print $this->RES_ROOT;?>css/instructor-dashboard.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <link href="<?php print $this->RES_ROOT;?>css/style.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <?php }else{ ?>
  <link href="<?php print $this->RES_ROOT;?>css/themes/<?php print $this->BG_THEME;?>/vertical-responsive-menu.min.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <link href="<?php print $this->RES_ROOT;?>css/themes/<?php print $this->BG_THEME;?>/instructor-dashboard.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <link href="<?php print $this->RES_ROOT;?>css/themes/<?php print $this->BG_THEME;?>/style.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <?php } ?>
  
  <link href="<?php print $this->RES_ROOT;?>css/instructor-responsive.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <link href="<?php print $this->RES_ROOT;?>css/responsive.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <link href="<?php print $this->RES_ROOT;?>css/night-mode.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <link href="<?php print $this->RES_ROOT;?>css/datepicker.min.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  
  <!-- Vendor Stylesheets -->
  <link href="<?php print $this->RES_ROOT;?>vendor/fontawesome-free/css/all.min.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <link href="<?php print $this->RES_ROOT;?>vendor/OwlCarousel/assets/owl.carousel.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <link href="<?php print $this->RES_ROOT;?>vendor/OwlCarousel/assets/owl.theme.default.min.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <link href="<?php print $this->RES_ROOT;?>vendor/bootstrap/css/bootstrap.min.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php print $this->RES_ROOT;?>vendor/semantic/semantic.min.css<?php print $this->FILE_VERSION;?>"> 

  <?php if(empty($this->BG_THEME)){ ?>
  <link href="<?php print $this->RES_ROOT;?>css/custom-admin.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <?php }else{ ?>
  <link href="<?php print $this->RES_ROOT;?>css/themes/<?php print $this->BG_THEME;?>/custom-admin.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
  <?php } ?>
  <script src="<?php print $this->RES_ROOT;?>js/tinymce.min.js<?php print $this->FILE_VERSION;?>"></script>
  
  <?php if(count($this->THEME_INC)>0){foreach ($this->THEME_INC as $inc){?>
  <link href="<?php print $this->RES_ROOT;?><?php print $inc;?><?php print $this->FILE_VERSION;?>"/>
  <?php }} ?>

  <?php if(count($this->HEADER_INC)>0){foreach ($this->HEADER_INC as $inc){?>
  <link href="<?php print $this->RES_ROOT;?><?php print $inc;?><?php print $this->FILE_VERSION;?>"/>
  <?php }} ?>
  <!-- /theme JS files -->

  <!-- angular js files -->  
  <?php  if(count($this->ANGULAR_INC)>0){?>
  <script type="text/javascript" src="<?php print $this->ANGULAR_ROOT;?>libs/pubnub.min.js<?php print $this->FILE_VERSION;?>"></script>
  <script type="text/javascript" src="<?php print $this->ANGULAR_ROOT;?>angular.min.js<?php print $this->FILE_VERSION;?>"></script>
  <script type="text/javascript" src="<?php print $this->ANGULAR_ROOT;?>libs/pubnub-angular.min.js<?php print $this->FILE_VERSION;?>"></script>
  <script type="text/javascript" src="<?php print $this->ANGULAR_ROOT;?>hotkeys.min.js<?php print $this->FILE_VERSION;?>"></script>
  <script type="text/javascript" src="<?php print $this->ANGULAR_ROOT;?>staffboard/app_module.js<?php print $this->FILE_VERSION;?>"></script>
  <?php  foreach($this->ANGULAR_INC as $inc){?>
  <script type="text/javascript" src="<?php print $this->ANGULAR_ROOT;?>staffboard/<?php print $inc;?>.js<?php print $this->FILE_VERSION;?><?php print mt_rand(100,999999);?>"></script>
  <?php }} ?>
  <!-- /angular js files -->

  <style type="text/css">
    .tox-notifications-container{display:none;}
  </style>
</head>
<body ng-app="mozzApp">