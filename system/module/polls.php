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
 * sending check
**/
	## prepare sql
	$sqls = "SELECT
					`id`
			FROM
				`".PFX."polls`
			WHERE
				`status` = '1'
			";
			
	## send query
	$send = ms($sqls);
	
	## check result
	if($send[0] > 0) {
		
		echo '<p class="w">Achtung: Es läut aktuell noch eine Versendung! Bitte nehmen Sie aktuelle keine Änderungen vor!!</p>';
		
	}



/**
 * listing
**/
	if(!isset($_GET['a'])) {
		
		## prepare sql
		$sqls = "SELECT
					`id`,
					`title`,
					`datetime`,
					`senddatetime`,
					`status`
				FROM
					`".PFX.$sic."`
				ORDER BY
					`datetime`
				DESC
				";
				
		## send query
		$send = ms($sqls);
		
		## total lines
		$tl = $send[0];
		
		## check if data lines exists
		if($tl > 0) {
			
			## preparing data
			$data = $send[1];
			
			## preparing vars
			$lc = 0;
			
			## process data
			foreach($data as $d) {
				
				## linecounter
				$lc++;
				
				## prepare vars
				$id = $d['id'];
				$datetime = date("d.m.Y", strtotime($d['datetime']));
				$senddatetime = ($d['senddatetime'] !== "0000-00-00 00:00:00") ? date("d.m.Y H:i", strtotime($d['senddatetime'])).' Uhr' : "";
				$title = $d['title'];
				
				## output
				include($MP."list.html5");
				
			}
			
		} else {
			
			## output nolines template
			include($MP."list-nolines.html5");
			
		}
		
	}



/**
 * adding
**/
	if(isset($_GET['a']) && $_GET['a'] == "a") {
		
		## set vars
		$errmsg = "";
		
		## form check
		if(isset($_POST['save'.$sic]) && $_POST['save'.$sic] == "yes") {
			
			## set status field
			$sf = 200;
			
			## check subject
			if($_POST['title'] == "" || !ctype_print($_POST['title'])) {
				
				$errmsg = '<p class="e">Der Titel ist leer oder enthält nicht erlaubte Zeichen!</p>';
				$sf = 400;
				
			## check message
			} elseif($_POST['editor'] == "") {
				
				$errmsg = '<p class="e">Bitte geben Sie eine Umfrage ein!</p>';
				$sf = 400;
			
			## saving poll
			} else {
				
				## prepare vars
				$stitle = trim($_POST['title']);
				$seditor = trim($_POST['editor']);
				
				## check status
				if($sf == 200) {
					
					## prepare sql
					$sqls = "INSERT INTO
								`".PFX.$sic."`
							VALUES (
								'',
								'".mres($stitle)."',
								'".mres($seditor)."',
								'".date("Y-m-d H:i:s")."',
								'0000-00-00 00:00:00',
								'0'
							)";
							
					## send query
					$send = mi($sqls);
					
					## check query
					if($send[0] == 1) {
						
						$errmsg = '<p class="o">Die Umfrage wurde erfolgreich angelegt.</p>';
						unset($_POST);
						
					} else {
						
						$errmsg = '<p class="e">Beim Speichern der Umfrage ist ein Fehler aufgetreten!</p>';
						
					}
					
				}
				
			}
			
		}
		
		
		## prepare values
		$ptitle = (isset($_POST['title'])) ? trim($_POST['title']) : "";
		$peditor = (isset($_POST['editor'])) ? trim($_POST['editor']) : "";
		
		## show adding form
		include($MP."add.html5");
		
	}
?>