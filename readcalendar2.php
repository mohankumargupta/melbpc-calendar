<?php
include 'vendor/autoload.php';

use Sabre\VObject;
date_default_timezone_set('Australia/Melbourne');
$iCalendar = VObject\Reader::read(
   file_get_contents('recur.ics'), VObject\Reader::OPTION_FORGIVING
);

$latestCalendar = $iCalendar->expand(new \DateTime('2013-09-28'), new \DateTime('2014-09-11'));
if (!$latestCalendar->VEVENT) {
	echo "no calendars found";
	return;
}

foreach ($latestCalendar->VEVENT as $event){
	//$eventdetails = $event->JsonSerialize()[1];
	$eventdtstart = $event->dtstart->getValue();
	$eventdtend = $event->dtend->getValue();
	//$eventdescription = $event->description->getValue();
	//$eventlocation = $event->location->getValue();
	$eventstatus = $event->status->getValue();
	$eventsummary = $event->summary->getValue();
	echo("Event:$eventsummary Start: $eventdtstart End: $eventdtend <br>");
}

/*
foreach($events as $event) {
//$eventdetails = $event->JsonSerialize()[1];
$eventdtstart = $event->dtstart->getValue();
$eventdtend = $event->dtend->getValue();
$eventdescription = $event->description->getValue();
$eventlocation = $event->location->getValue();
$eventstatus = $event->status->getValue();
$eventsummary = $event->summary->getValue();
//echo("Event:$eventsummary Start: $eventdtstart End: $eventdtend <br>");
}
*/

//var_dump($event[0]->select('summary'));
//print("<pre>".print_r($event,true)."</pre>");
//$json = $latestCalendar->JsonSerialize();
//print_r($latestCalendar);
/*
$source = file_get_contents('AustraliaHolidays.ics');
$vobj = VObject\Reader::read($source);
$json = json_encode($vobj);

echo $json;
*/

/*
foreach($latestCalendar->children() as $obj) {
	print("<pre>".print_r($obj,true)."</pre>");
}
*/
//$json = json_encode($latestCalendar);
//echo($json);
//print("<pre>".print_r($latestCalendar->serialize(),true)."</pre>");



//print("<pre>".print_r($latestCalendar,true)."</pre>");

/*
foreach($latestCalendar->VEVENT as $event) {
	echo "Event:{$event->SUMMARY} Start:{$event->DTSTART} End:{$event->DTEND} Rule:{$event->RRULE} <br>";
}
*/
