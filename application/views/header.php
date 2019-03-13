<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Rodrigo Borges" />
	<meta name="keywords" content="PHP, CodeIgniter, HTML, CSS" />
	<title><?php echo $titulo;  ?></title>
	<style>
		#page_title {
			text-align: center;
			width: 100%;
		}
		#nav_bar {
			width: 100%;
			text-align: center;
		}
		.nav_bar {
			display: inline-block;
			padding-left: 5px;
			padding-right: 5px;
		}
		#container{
		  text-align: center;
		}
		#container_ler{
		  text-align: center;
		  display:inline-grid;
		  width: 100%;
		}

		.select_container {
		  display: inline-flex;
		  margin:20px;

		}

		.display_box, .select{
		  display: inline-block;
		  width: 50%;
		  height: 250px;
		}
	</style>
</head>
<body>
