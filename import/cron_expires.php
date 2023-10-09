<?php 
ini_set('memory_limit', '-1');
header('Content-Type: text/html; charset=UTF-8');
include('../config.php');

if (!isset($_SERVER['argv']) || count($_SERVER['argv']) == 0) exit();

$args = $_SERVER['argv'];
$str_ctrl = !empty($args[1]) ? $args[1]:"";
$echo_result = (!empty($args[2]) && $args[2]==true) ? true:false;

if("3roUApgZbigh" != $str_ctrl) exit("- Permission denied.\n\r");


$db = new PDO('mysql:dbname='.$DBName.';host='.$DBHost, $DBUser, $DBPass);

$time_start = mktime(0, 0, 0, date('m')-2, date('d'), date('Y'));

$db->query("delete from jobsportal_jobs WHERE `date` < '".$time_start."'");


?>