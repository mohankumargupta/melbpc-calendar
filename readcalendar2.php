<?php
use Sabre\VObject;

include 'vendor/autoload.php';

$iCalendar = VObject\Reader::read(
   file_get_contents('wordpress.ics'), VObject\Reader::OPTION_FORGIVING
);

$latestCalendar = $iCalendar->expand(new DateTimeImmutable('2015-01-01'), new DateTimeImmutable('2020-01-01'));
$events = $latestCalendar->getBaseComponents('VEVENT');

foreach($events as $event) {
//$eventdetails = $event->JsonSerialize()[1];
$eventdtstart = $event->dtstart->getValue();
$eventdtend = $event->dtend->getValue();
$eventdescription = $event->description->getValue();
$eventlocation = $event->location->getValue();
$eventstatus = $event->status->getValue();
$eventsummary = $event->summary->getValue();
echo("Event:$eventsummary Start: $eventdtstart End: $eventdtend <br>");
}
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
