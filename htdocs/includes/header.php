<?php

$devMode = ($_SERVER['HTTP_HOST'] == 'localhost' ? true : false);

if ($devMode) {
	$rooturl='localhost';
	$filepath='D:\Sync\Work\XES\danhughes.me';
	$rootpath='/';
}
else {
	$rooturl='danhughes.me';
	$filepath='/home/linweb29/x/xes.io/user/htdocs';
	$rootpath='/';
}

if (!$devMode) {
	$cache_time = 5; // Time in seconds to keep a page cached
	$cache_folder = $filepath.$rootpath.'includes/cache/file'; // Folder to store cached files (no trailing slash)
	$cache_filename = $cache_folder.md5($_SERVER['REQUEST_URI']); // Location to lookup or store cached file
	//Check to see if this file has already been cached
	// If it has get and store the file creation time
	$cache_created  = (file_exists($cache_filename)) ? filemtime($cache_filename) : 0;

	if ((time() - $cache_created) < $cache_time) {
		readfile($cache_filename); // The cached copy is still valid, read it into the output buffer
		die();
	}

}

ob_start();
	
function externalFile($url, $file) {
	global $rootpath, $devMode;
	if ($devMode) {
		return $rootpath.'includes/external/'.$file;
	}
	else {
		return '//'.$url.$file;
	}
}
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Dan Hughes">
		<meta name="description" content="Home of a web developer and musician.">

		<link rel="stylesheet" type="text/css" href="<?php echo externalFile('cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/', 'normalize.min.css');?>"><?php
		
		if ($devMode) {echo "\n\n\t\t<link href='$rootpath"."includes/style.css' rel='stylesheet' type='text/css' />";}
		else {
			$cssFile = fopen("includes/style.css", "r");
			$css = '';
			while ($line = fgets($cssFile)) {
				$css .= $line;
			}
			
			$css = str_replace(': ', ':', $css);
			$css = str_replace(array("\r\n", "\r", "\n", "\t"), '', $css);
			
			echo "\n\t\t<style type='text/css'>$css</style>\n";
			fclose($cssFile);
		}
		
		
		?><link href='//fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>

		<link href="<?php echo $rootpath;?>includes/fonts/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
		
		<link rel="apple-touch-icon" href="<?php echo $rootpath;?>images/logo.jpg" />

		<link rel="author" href="https://plus.google.com/100101734729968276703/"/>

		<meta property="og:image" content="<?php echo "http://".$rooturl.$rootpath."images/logo.jpg";?>">
		<meta property="og:title" content="Dan Hughes">
		<meta property="og:description" content="Dan Hughes is a Reading based web developer.">
		<meta property="og:url" content="<?php $pageURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; echo $pageURL?>"/>
		
		<title>Dan Hughes</title>
	</head>
	<body>