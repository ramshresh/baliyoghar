<?php
	include('nepali_calendar.php');
	$cal = new Nepali_Calendar();
	var_dump ($cal->eng_to_nep(2008,11,23));
	var_dump($cal->nep_to_eng(2065,8,8));
?>