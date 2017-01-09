<?php
require_once("../include/config.php");
require_once("../include/".PAGE6.".php");

error_reporting(E_ALL ^ E_NOTICE);
session_start();

$login_id=$_SESSION[APPLICATION_ID.'_login_id'];
$login_name=$_SESSION[APPLICATION_ID.'_login_name'];
$login_type=$_SESSION[APPLICATION_ID.'_login_type'];
$login_sub_type=$_SESSION[APPLICATION_ID.'_login_sub_type'];
$login_session_path=LOGIN_SESSION_PATH."$login_type/";
$login_session_time=LOGIN_SESSION_TIME;
 
if(!$login_id || $_REQUEST['logout']=="true")
	header("Location: ../".PAGE1.".php?logout=true");

$date=date("Y-m-d");

$page=$_GET['page'] ? $_GET['page'] : "welcome";
$$page="active";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>LTFHC</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	<!-----------------------------------Calendar : Start-------------------------------->
	<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
	<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
	<!-----------------------------------Calendar : End-------------------------------->
	<style>
	/* Remove the navbar's default margin-bottom and rounded borders */ 
	.navbar {
		margin-bottom: 0;
		border-radius: 0;
    }
    
	.navbar-default {
		background-color: #555;
	}
	
	.navbar-default .navbar-brand {
		color:#FFF;
	}
	.navbar-default .navbar-brand:hover,
	.navbar-default .navbar-brand:focus{
		color:#FFF;
	}
	
	.navbar-default .navbar-nav > li > a {
		color:#FFF;
	}
	
	.navbar-default .navbar-nav > li > a:hover {
		color:#FFF;
	}
	
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
		padding-top: 20px;
		background-color: #f1f1f1;
		height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
		background-color: #555;
		color: white;
		padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
		.sidenav {
			height: auto;
			padding: 15px;
		}
		.row.content {height:auto;} 
    }
	
	/************************Loader : Start************************/
	.loader {
		border: 16px solid #f3f3f3;
		border-radius: 50%;
		border-top: 16 solid blue;
		border-right: 16px solid green;
		border-bottom: 16px solid red;
		border-left: 16px solid pink;
		-webkit-animation: spin 2s linear infinite;
		animation: spin 2s linear infinite;
		
		width: 100px;
		height: 100px;
		position:absolute;
		top:10%;
		left:47%;
	}

	@-webkit-keyframes spin {
		0% { -webkit-transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
	/************************Loader : End************************/
	</style>
	
	<script>
	</script>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top hidden-xs">
	<div class="container-fluid">
		<div class="navbar-header">
			<!--<img src="../images/logo.png" width="50">-->
			<strong><a class="navbar-brand" href="#">
				<big>LTFHC</big></a>
			</strong>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="<?php echo $welcome; ?>"><a href="?page=welcome">Home</a></li>
				<li class="<?php echo $screen; ?>"><a href="?page=screen&action=add">Screen</a></li>
				<li class="<?php echo $layout; ?>"><a href="?page=layout&action=add">Layout</a></li>
				<li class="<?php echo $component; ?>"><a href="?page=component&action=add">Component</a></li>
				<!--<li class="<?php echo $report; ?>"><a href="?page=report&action=view">Report</a></li>-->
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="?logout=true"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>
		</div>
	</div>
</nav>

<nav class="navbar navbar-default navbar-fixed-top visible-xs">
	<div class="container-fluid">
		<div class="navbar-header">
			<strong><a class="navbar-brand" href="#"><big>LTFHC</big></a></strong>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li class="<?php echo $welcome; ?>"><a href="?page=welcome">Home</a></li>
				<li class="<?php echo $screen; ?>"><a href="?page=screen&action=add">Screen</a></li>
				<li class="<?php echo $layout; ?>"><a href="?page=layout&action=add">Layout</a></li>
				<li class="<?php echo $component; ?>"><a href="?page=component&action=add">Component</a></li>
				<!--<li class="<?php echo $report; ?>"><a href="?page=report&action=view">Report</a></li>-->
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="?logout=true"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>
		</div>
	</div>
</nav>
<div class="container-fluid text-left">
	<div class="row content" style="margin-top:50px">
		<div class="col-sm-12 text-left" id="content" style="margin-top:20px">
			<?php include("include/content/$page.php"); ?>
		</div>
	</div>
</div>
<footer class="container-fluid text-center">
	<h4>Designed & Developed By "<strong>World Health Partners</strong>"</h4>
</footer>

</body>
</html>

<div id="myModal" class="modal fade" role="dialog">
	<div class="loader"></div>
</div>