<?php
require_once 'vendor/autoload.php';

use CalendarBits\MelbPCCalendar;

$monthyear = $_POST['monthyear'];
$monthyear = explode(" ", $monthyear);
$calendar = new MelbPCCalendar($monthyear[0], $monthyear[1]);
//$calendar = new MelbPCCalendar('July', 2017);
$calendar->render(); 
//print_r($_POST);