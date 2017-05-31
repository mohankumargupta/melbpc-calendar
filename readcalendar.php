<?php
use Sabre\VObject;

include 'vendor/autoload.php';

$vcalendar = VObject\Reader::read(
    fopen('AustraliaHolidays.ics','r'), VObject\Reader::OPTION_FORGIVING
);

foreach($vcalendar->VEVENT as $event) {
	echo "Event:{$event->SUMMARY} Start:{$event->DTSTART} End:{$event->DTEND} Rule:{$event->RRULE} <br>";
}