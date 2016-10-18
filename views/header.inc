<?php

$lang = $this->lang;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>cas</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

        <meta name="description" content=" ">
        <meta name="keywords" content=" ">
        <meta name="author" content="605">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="<?php echo URL_DIR;?>/css/styles.css" type="text/css">
        <link href="<?php echo URL_DIR;?>/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo URL_DIR;?>/css/settings.css" media="screen" />
        <link rel="stylesheet" href="<?php echo URL_DIR;?>/css/ddlevelsmenu-base.css">
        <link rel="stylesheet" href="<?php echo URL_DIR;?>/css/ddlevelsmenu-topbar.css">
        <link rel="stylesheet" href="<?php echo URL_DIR;?>/css/prettyPhoto.css">
        <link rel="stylesheet" href="<?php echo URL_DIR;?>/css/slider.css">
        <link href="<?php echo URL_DIR;?>/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo URL_DIR;?>/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo URL_DIR;?>/css/contact.css">
        <!-- FULLCALENDAR JQUERY PLUGIN -->
        <link type="text/css" rel="stylesheet" href="<?php echo URL_DIR;?>/css/fullcalendar.css">


        <link rel="shortcut icon" href="#">

        <script src="<?php echo URL_DIR;?>/js/jquery.js"></script>
		<!-- Bootstrap JS -->
		<script src="<?php echo URL_DIR;?>/js/bootstrap.min.js"></script>
		<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
		<script src="<?php echo URL_DIR;?>/js/jquery.themepunch.tools.min.js"></script>
		<script src="<?php echo URL_DIR;?>/js/jquery.themepunch.revolution.min.js"></script>
		<!-- prettyPhoto -->
		<script src="<?php echo URL_DIR;?>/js/jquery.prettyPhoto.js"></script>
		<!-- isotope -->
		<script src="<?php echo URL_DIR;?>/js/jquery.isotope.js"></script>
		<!-- Navigation menu -->
		<script src="<?php echo URL_DIR;?>/js/ddlevelsmenu.js"></script>
		<!-- jQuery cSlider / Extra script for cslider -->
		<script src="<?php echo URL_DIR;?>/js/jquery.cslider.js"></script>
		<script src="<?php echo URL_DIR;?>/js/modernizr.custom.69985.js"></script>
		<!-- Support -->
		<script src="<?php echo URL_DIR;?>/js/filter.js"></script>
		<!-- Respond JS for IE8 -->
		<script src="<?php echo URL_DIR;?>/js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="<?php echo URL_DIR;?>/js/html5shiv.js"></script>
		<!-- Custom JS -->

        <!-- Contact -->
        <script src="<?php echo URL_DIR;?>/js/MediaStreamRecorder.js"></script>

		<!-- TIMEPICKER -->
        <link rel="stylesheet" type="text/css" href="<?php echo URL_DIR;?>/css/jquery.datetimepicker.css">
		<script src="<?php echo URL_DIR;?>/js/jquery.datetimepicker.full.min.js"></script>

        <!-- FULLCALENDAR JQUERY PLUGIN -->
        <link type="text/css" rel="stylesheet" href="<?php echo URL_DIR;?>/css/fullcalendar.css">

        <!-- Don't change the order of the scripts -->
        <script type="text/javascript" src="<?php echo URL_DIR;?>/js/fullcalendar/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo URL_DIR;?>/js/fullcalendar/fullcalendar.js"></script>
        <script type="text/javascript" src="<?php echo URL_DIR;?>/js/fullcalendar/fullcalendar.js"></script>
        <script type="text/javascript" src="<?php echo URL_DIR;?>/js/fullcalendar/locale/fr.js"></script>
        <script type="text/javascript" src="<?php echo URL_DIR;?>/js/fullcalendar/locale/de.js"></script>
        <script type="text/javascript" src="<?php echo URL_DIR;?>/js/fullcalendar/locale/en-gb.js"></script>

        <!-- DATATABLES -->

        <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>

        <!-- ANNYANG -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.5.0/annyang.min.js"></script>

        <!-- NEWSLETTER -->
        <script type="text/javascript" src="js/newsletter.js"></script>

    </head>
	<body>

    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="logo">
                        <div class="logo-image">
                            <a href="<?php echo URL_DIR;?>/home"><i class="fa fa-photo blue"></i></a>
                        </div>
                        <div class="logo-text">
                            <h1><a href="<?php echo URL_DIR;?>/home">CA<span class="lightblue">S</span></a></h1>
                            <div class="logo-meta">SWISS ALPINE CLUB</div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="col-md-9 col-sm-8">
                    <div class="navi pull-right">
                        <div id="ddtopmenubar" class="mattblackmenu">
                            <ul>

                                <?php
                                if(isset($_SESSION['user'])) {
                                    ?>
                                    <li><a href="<?php echo URL_DIR;?>/login/welcome" rel="submenu" class="bblue"><i class="fa fa-lock"></i>
                                            <?php echo $_SESSION['user']->getFirstname() . ' ' . $_SESSION['user']->getLastname() . '<br>' . $lang['DISCONNECT_MENU_BUTTON'];?>
                                        </a>
                                        <ul id="submenu" class="ddsubmenustyle">
                                            <li><a href="<?php echo URL_DIR;?>/login"><?php echo 'Welcome';?></a></li>
                                            <li><a href="<?php echo URL_DIR . '/login/logout'; ?>"><?php echo $lang['DISCONNECT_MENU_BUTTON']; ?></a></li>
                                        </ul>
                                    </li>
                                <?php } else { ?>
                                    <li><a href="<?php echo URL_DIR;?>/login" class="bblue"><i class="fa fa-lock"></i><?php echo $lang['CONNECT_MENU_BUTTON'];?></a></li>
                                <?php } ?>
                                <li><a href="<?php echo URL_DIR;?>/proximite" class="bblue"> <i class="fa fa-map-marker"></i><?php echo $lang['PROXIMITY_MENU_BUTTON']; ?></a></li>
                                <li><a href="<?php echo URL_DIR;?>/sorties" class="bblue"> <i class="fa fa-calendar"></i><?php echo $lang['ACTIVITIES_MENU_BUTTON']; ?></a></li>
                                <li><a href="<?php echo URL_DIR;?>/contact" class="bblue"> <i class="fa fa-envelope-o"></i><?php echo $lang['CONTACT_MENU_BUTTON']; ?></a></li>
                                <li><a  class="bblue"><img src ="<?php echo URL_DIR;?>/img/French_Flag_Small_Icon.jpg"><img src ="<?php echo URL_DIR;?>/img/English_Flag_Small_Icon.png"></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="navis"></div>

                    <!-- Navbar ends -->

                    <div class="clearfix"></div>

                </div>

            </div>
        </div>
    </header>
    <div class="page-heading blightblue">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="pull-left"> <?php  if(isset($pageTitle)){ echo $pageTitle;}; ?></h2>
                    <div class="pull-right heading-meta"><?php  if(isset($pageMessage)){ echo $pageMessage; }; ?></div>
                </div>
            </div>
        </div>
    </div>

    <?php

// Si on met un $msg il s'affiche ici
if(isset($msg) && $msg!=""){
    ?>
    <div class="content">
        <div class="container">
            <div class="alert alert-info">
                <strong>Info!</strong> <?php echo $msg;?>
            </div>
        </div>
    </div>

<?php }





