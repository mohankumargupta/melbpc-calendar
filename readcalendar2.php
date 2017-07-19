<?php
include 'vendor/autoload.php';

use Sabre\VObject;
date_default_timezone_set('Australia/Melbourne');
$ics = file_get_contents('http://mohankumargupta.com/melbpcwordpressmultisite/?plugin=all-in-one-event-calendar&controller=ai1ec_exporter_controller&action=export_events&no_html=true');
//$ics = file_get_contents('timelyeventcalendar.ics');
//echo "$ics<br>";
$iCalendar = VObject\Reader::read(
   $ics, VObject\Reader::OPTION_FORGIVING
);

$latestCalendar = $iCalendar->expand(new \DateTime('2017-07-01'), new \DateTime('2017-07-31'));
if (!$latestCalendar->VEVENT) {
	echo "no calendars found";
	return;
}

foreach ($latestCalendar->VEVENT as $event){
	//$eventdetails = $event->JsonSerialize()[1];
	$eventdtstart = ($event->dtstart)? $event->dtstart->getValue(): "";
	$eventdtend = ($event->dtend)? $event->dtend->getValue(): "";
	$eventdescription = ($event->description)? $event->description->getValue(): "";
    $eventlocation=($event->location)? $event->location->getValue(): "";
	$eventstatus =  ($event->status)? $event->status->getValue() : "";
	$eventsummary = ($event->summary)? $event->summary->getValue() : "";
	$eventurl = ($event->url)? $event->url->getValue(): "";
	echo("Event:$eventsummary Description: $eventdescription Start: $eventdtstart End: $eventdtend Location: $eventlocation  <br>");
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
