<?php
/**
 * eMailSurvey
 * @Creation: 09.04.2020
 * @author Marc Funk | marcfunk IT UG (hb.) | https://marc-funk.de
 * @version 0.1
 * @note This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
**/



/**
 * include system files
**/
	if(file_exists("../system.php")) {
	
		include("../system.php");
	
	}



/**
 * install queries
**/
	## table polls
	$sqls_polling = "CREATE TABLE IF NOT EXISTS
						`ems_polls`
					(
						`id` BIGINT NOT NULL AUTO_INCREMENT,
						`title` VARCHAR(250) NOT NULL,
						`question` TEXT NOT NULL,
						`datetime` DATETIME NOT NULL,
						`senddatetime` DATETIME NOT NULL,
						`status` INT(1) NOT NULL,
						PRIMARY KEY (`id`),
						INDEX `status` (`status`)
					) ENGINE = MyISAM";
	
	## table receiver
	$sqls_receiver = "CREATE TABLE IF NOT EXISTS
						`ems_receiver`
					(
						`id` bigint(20) NOT NULL AUTO_INCREMENT,
						`mail` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
						`salutation` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
						`firstname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
						`lastname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
						PRIMARY KEY (`id`),
						UNIQUE KEY `mail` (`mail`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";



/**
 * start installation
**/
	if(isset($_POST['start']) && $_POST['start'] == "install") {
		
		## create table polls
		$send = mi($sqls_polling);
		
		## create table receiver
		$send = mi($sqls_receiver);
		
		## create install file
		$of = fopen("../polls/install", "w+");
		fclose($of);
		
		## check file
		if(file_exists("../polls/install")) {
			
			header("LOCATION: index.html");
			
		}
		
	}



/**
 * install form
**/
	include("../system/html/install.html5");
?>