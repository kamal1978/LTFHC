<?php
require_once("include/config.php");
session_start();

if(isset($_REQUEST['logout'])=="true")
{
	foreach($_SESSION as $key=>$val)
	{
		if (strpos($key, APPLICATION_ID.'_') !== false)
		{
			//echo $key."<br>";
			unset($_SESSION[$key]);
		}
	}
}

if(isset($_SESSION[APPLICATION_ID.'_login_id']))
	header("Location: ".$_SESSION[APPLICATION_ID.'_auth_path']);
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
		border: 5px solid #f3f3f3;
		border-radius: 50%;
		border-top: 5px solid blue;
		border-right: 5px solid green;
		border-bottom: 5px solid red;
		border-left: 5px solid pink;
		-webkit-animation: spin 2s linear infinite;
		animation: spin 2s linear infinite;
		
		width: 30px;
		height: 30px;
		position:absolute;
		top:15%;
		left:48%;
		display:none;
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
	$(document).ready(function(){
		$("#btn-login").click(function(){
			if($("#login_id").val()=="")
			{
				alert("Please enter login id");
				return false;
			}
			if($("#password").val()=="")
			{
				alert("Please enter password");
				return false;
			}
			var form_detail=$("#form_login").serialize();
			$("#form_login :input").prop("disabled", true);
			$(".loader").show();
			$.ajax({
				type: "POST",
				url: "ajax_pages/login.php",
				data: form_detail,
				success: function(response) {
					var result=JSON.parse(response);
					if(result.status==1)
						window.location.href=result.location;
					else
					if(result.status==0)
					{
						$(".loader").hide();
						alert(result.msg);
						$("#form_login :input").prop("disabled", false);
					}
					else
						alert(response);
				},
				error: function(response) {
					alert(response);
				}
			});
			return false;
		});
	});
	
	
	</script>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top hidden-xs">
	<div class="container-fluid">
		<div class="navbar-header">
			<strong><a class="navbar-brand" href="#"><big>LTFHC</big></a></strong>
		</div>
		<div class="collapse navbar-collapse">
			<!--<ul class="nav navbar-nav navbar-right">
				<li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>-->
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
			<!--<ul class="nav navbar-nav">
				<li class="active"><a href="#">Home</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Projects</a></li>
				<li><a href="#">Contact</a></li>
			</ul>-->
			<!--
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>-->
		</div>
	</div>
</nav>
<div class="container-fluid text-left">
	<div class="row content" style="margin-top:50px">
		<div class="col-sm-8 text-center hidden-xs" style="margin-top:20px">
			<!--<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="#section1">Dashboard</a></li>
				<li><a href="#section2">Age</a></li>
				<li><a href="#section3">Gender</a></li>
				<li><a href="#section3">Geo</a></li>
			</ul><br>-->
			<img src="images/whp_logo_lg.jpg">
		</div><br>
		<div class="col-sm-4 text-left">
			<div class="well">
				<h2>Login</h2>
				<!--<div class="alert alert-danger"></div>-->
				<form role="form" id="form_login">
					<div class="form-group">
						<label for="login_id">Login Id:</label>
						<input type="text" class="form-control" name="login_id" id="login_id" placeholder="Enter login id">
					</div>
					<div class="form-group">
						<label for="pwd">Password:</label>
						<input type="password" class="form-control" name="password" id="pwd" placeholder="Enter password">
					</div>
					<button class="btn btn-danger" id="btn-login">Submit</button>
					<div class="loader"></div>
				</form>
			</div>
		</div>
	</div>
</div>

<footer class="container-fluid text-center">
	<h4>Designed & Developed By "<strong>World Health Partners</strong>"</h4>
</footer>

</body>
</html>




