<?php
// Jobs Portal All Rights Reserved
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
?><?php
if(!defined('IN_SCRIPT')) die("");
?>
<?php

$arrJobTypes = array
	(
		array(0,$M_EITHER),
		array(1,$M_CONTRACT_TEMP),
		array(2,$M_PERMANENT)
	);

$arrResumeLanguages = 
	array
	(
				array(1,"English"),
				array(2,"Chinese"),
				array(3,"Chinese"),
				array(4,"Danish"),
				array(5,"Dutch"),
				array(6,"Finnish"),
				array(7,"French"),
				array(8,"German"),
				array(9,"Greek"),
				array(10,"Italian"),
				array(11,"Japanese"),
				array(22,"Korean"),
				array(23,"Norwegian"),
				array(24,"Polish"),
				array(25,"Portuguese"),
				array(26,"Swedish")
	);
	
$arrProficiencies = 
	array
	(
		array("1",$M_BASIC),
		array("2",$M_INTERMEDIATE),
		array("3",$M_FLUENT)
	);
	
$arrEducationLevels = 
	array
	(
		array("1",$M_HIGH_SCHOOL),
		array("2",$M_ASSOCIATES),
		array("3",$M_BA_SCIENCE),
		array("4",$M_BA_BUSINESS_ADMINISTRATION),
		array("5",$M_BA_ARTS),
		array("6",$M_J_DOCTORATE),
		array("7",$M_MASTER_SCIENCE),
		array("8",$M_MA_ARTS),
		array("9",$M_MEDICAL_DOCTOR),
		array("10",$M_MBA),
		array("11",$M_MFA),
		array("12",$M_PHD),
		array("13",$M_OTHER)
	);	
	
?>
