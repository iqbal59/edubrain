<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">		
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, shrink-to-fit=9">
	<meta name="description" content="Online LMS">
	<meta name="author" content="Mozzine">
	<title><?php print ucwords($this->config->item('app_name'));?> |  Member Authentication</title>
	
	<!-- Favicon Icon -->
	<link rel="icon" type="image/png" href="<?php print $this->RES_ROOT;?>images/fav.png">
	
	<!-- Stylesheets -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
	<link href='<?php print $this->RES_ROOT;?>vendor/unicons-2.0.1/css/unicons.css' rel='stylesheet'>
	<?php if(empty($this->BG_THEME)){ ?>
	<link href="<?php print $this->RES_ROOT;?>css/vertical-responsive-menu.min.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
	<link href="<?php print $this->RES_ROOT;?>css/style.css" rel="stylesheet">
	<?php }else{ ?>
	<link href="<?php print $this->RES_ROOT;?>css/themes/<?php print $this->BG_THEME;?>/vertical-responsive-menu.min.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
	<link href="<?php print $this->RES_ROOT;?>css/themes/<?php print $this->BG_THEME;?>/style.css" rel="stylesheet">
	<?php } ?>
	<link href="<?php print $this->RES_ROOT;?>css/responsive.css" rel="stylesheet">
	<link href="<?php print $this->RES_ROOT;?>css/night-mode.css" rel="stylesheet">
	
	<!-- Vendor Stylesheets -->
	<link href="<?php print $this->RES_ROOT;?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
	<link href="<?php print $this->RES_ROOT;?>vendor/OwlCarousel/assets/owl.carousel.css" rel="stylesheet">
	<link href="<?php print $this->RES_ROOT;?>vendor/OwlCarousel/assets/owl.theme.default.min.css" rel="stylesheet">
	<link href="<?php print $this->RES_ROOT;?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php print $this->RES_ROOT;?>vendor/semantic/semantic.min.css">

	<?php if(empty($this->BG_THEME)){ ?>
	<link href="<?php print $this->RES_ROOT;?>css/custom.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
	<?php }else{ ?>
	<link href="<?php print $this->RES_ROOT;?>css/themes/<?php print $this->BG_THEME;?>/custom.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
	<?php } ?>	

</head> 

<body>