<!DOCTYPE html>
<html>
<head>
	<title>Business Plus</title>
	<link rel="stylesheet" type="text/css" href="<?= url_for('/assets/css/flexboxgrid.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?= url_for('/assets/css/font-awesome/css/font-awesome.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?= url_for('/assets/css/public.style.css'); ?>">
</head>
<body>
<section id="header">
	<div class="row end-sm end-md end-lg center-xs middle-xs middle-sm middle-md middle-lg">
		<div class="logo col-xs-2 col-sm-2 col-md-2 col-lg-2">
			<a href="<?= url_for('index.php'); ?>"><h1>Business<span>Plus</span></h1></a>
		</div>
		<div  class="col-xs-10 col-sm-10 col-md-10 col-lg-10 search">
			<i class="fa fa-search"></i><input type="text" name="search" placeholder="Search..">
		</div>
	</div>
</section>
	<div class="topnav" id="myTopnav">
		<a href="javascript:void(0);" class="icon" onclick="myFunction()">
	    <i class="fa fa-bars"></i>
	  	</a>
	  	<a href="#"> politics</a>
	    <a href="#">sports</a>
	    <a href="#">entertainment</a>
	    <a href="#">fashion</a>
	    <a href="#">lifestyle</a>
	    <a href="#">finance</a>
	    <a href="#" class="active">tech</a>	  
	</div>
<!-- <section id="navigation">
	<nav class="nav">
		<ul>
			<a href="javascript:void(0);" class="icon" onclick="myFunction()"> <i class="fa fa-bars"></i></a>
			<a href="#"> politics</a>
			<a href="#">sports</a>
			<a href="#">entertainment</a>
			<a href="#">fashion</a>
			<a href="#">lifestyle</a>
			<a href="#">finance</a>
			<a href="#">tech</a>
			
		</ul>
	</nav>
</section>
 -->