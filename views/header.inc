<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
     
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>CAS</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

        <meta name="description" content=" ">
        <meta name="keywords" content=" ">
        <meta name="author" content="605">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <base href="http://localhost/cas/">
        <link rel="stylesheet" href="css/styles.css" type="text/css">

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/settings.css" media="screen" />
        <link rel="stylesheet" href="css/ddlevelsmenu-base.css">
        <link rel="stylesheet" href="css/ddlevelsmenu-topbar.css">
        <link rel="stylesheet" href="css/prettyPhoto.css">
        <link rel="stylesheet" href="css/slider.css">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

        <link rel="shortcut icon" href="#">

        <script src="js/jquery.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
		<script src="js/jquery.themepunch.tools.min.js"></script>
		<script src="js/jquery.themepunch.revolution.min.js"></script>
		<!-- prettyPhoto -->
		<script src="js/jquery.prettyPhoto.js"></script>
		<!-- isotope -->
		<script src="js/jquery.isotope.js"></script>
		<!-- Navigation menu -->
		<script src="js/ddlevelsmenu.js"></script>
		<!-- jQuery cSlider / Extra script for cslider -->
		<script src="js/jquery.cslider.js"></script>
		<script src="js/modernizr.custom.69985.js"></script>
		<!-- Support -->
		<script src="js/filter.js"></script>
		<!-- Respond JS for IE8 -->
		<script src="js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="js/html5shiv.js"></script>
		<!-- Custom JS -->
		<script src="js/custom.js"></script>
        <!-- QTIP -->
        <script type="text/javascript" src="js/jquery.qtip.js"></script>
        <link type="text/css" href="css/jquery.qtip.css">
		
		<!-- TIMEPICKER -->
        <script type="text/javascript" src="js/jquery.timepicker.js"></script>
        <link type="text/css" href="css/jquery.timepicker.css">


        <!-- FULLCALENDAR JQUERY PLUGIN -->
        <link type="text/css" rel="stylesheet" href="css/fullcalendar.css">

        <!-- Don't change the order of the scripts -->
        <script type="text/javascript" src="js/fullcalendar/moment.min.js"></script>
        <script type="text/javascript" src="js/fullcalendar/fullcalendar.js"></script>
        <script type="text/javascript" src="js/fullcalendar/locale/fr.js"></script>
        <script type="text/javascript" src="js/fullcalendar/locale/de.js"></script>
        <script type="text/javascript" src="js/fullcalendar/locale/en-gb.js"></script>

        <!-- DATATABLES -->

        <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>


    </head>
	<body>

    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="logo">
                        <div class="logo-image">
                            <a href="index.html"><i class="fa fa-photo blue"></i></a>
                        </div>
                        <div class="logo-text">
                            <h1><a href="home">CA<span class="lightblue">S</span></a></h1>
                            <div class="logo-meta">SWISS ALPINE CLUB</div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="col-md-9 col-sm-8">
                    <div class="navi pull-right">
                        <div id="ddtopmenubar" class="mattblackmenu">
                            <ul>

                                <li><a href="login" class="bblue"> <i class="fa fa-lock"></i>   <?php if(isset($_SESSION['user']))
                                {
                                    echo $_SESSION['user']->getFirstname();
                                    echo ' ';
                                    echo $_SESSION['user']->getLastname();
                                    echo '<br>';
                                    echo 'Déconnection';}
                                    else{echo 'Connection';};?>    </a></li>
                                <li><a href="proximite" class="bblue"> <i class="fa fa-map-marker"></i>A proximité</a></li>
                                <li><a href="sorties" class="bblue"> <i class="fa fa-calendar"></i> Sorties</a></li>
                                <li><a href="contact" class="bblue"> <i class="fa fa-envelope-o"></i> Contact</a></li>
                                <li><a  class="bblue"><img src ="./img/French_Flag_Small_Icon.jpg"><img src ="./img/English_Flag_Small_Icon.png"></a></li>
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
                    <h2 class="pull-left"></i id ="pageTitle"> <?php  if(isset($pageTitle)){ echo $pageTitle;}; ?></h2>
                    <div class="pull-right heading-meta"><?php  if(isset($pageMessage)){ echo $pageMessage; }; ?></div>
                </div>
            </div>
        </div>
    </div>





