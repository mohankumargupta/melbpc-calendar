<?php
require_once 'vendor/autoload.php';

use CalendarBits\MelbPCCalendar;

$calendar = new MelbPCCalendar('July', 2017);
$calendar->render(); 