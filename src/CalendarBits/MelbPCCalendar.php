<?php
namespace CalendarBits;

//require_once '/vendor/autoload.php';
use Dompdf\Dompdf;
use Sabre\VObject;



//use Twig\Twig_Loader_Filesystem;

class MelbPCCalendar {
	function __construct($month, $year) {
	  //print("constructor<br>");
	  date_default_timezone_set('Australia/Melbourne');
	  $this->month = $month;
	  $this->year = $year;
	} 
	
	function getCalendarData($data, $firstofmonth) {
	  $ics = file_get_contents('http://mohankumargupta.com/melbpcwordpressmultisite/?plugin=all-in-one-event-calendar&controller=ai1ec_exporter_controller&action=export_events&no_html=true');
      $iCalendar = VObject\Reader::read(
        $ics, VObject\Reader::OPTION_FORGIVING
      );
	  
	  $latestCalendar = $iCalendar->expand(new \DateTime("first day of {$this->month} {$this->year}"), new \DateTime("last day of {$this->month} {$this->year}"));
      //$latestCalendar = $iCalendar->expand(new \DateTime('2017-06-01'), new \DateTime('2017-12-01'));
      if (!$latestCalendar->VEVENT) {
	    //echo "no calendars found";
	    return $data;
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
		
		$daytime = new \DateTime($eventdtstart, new \DateTimeZone('UTC'));
		$daytime->setTimezone(new \DateTimeZone('Australia/Melbourne'));
		$day = $daytime->format('j');
        $eventstarttime = $daytime->format('gA -');
        
		$daytime = new \DateTime($eventdtend, new \DateTimeZone('UTC'));
		$daytime->setTimezone(new \DateTimeZone('Australia/Melbourne'));
        $eventendtime = $daytime->format(' gA');
	    $eventtime = "$eventstarttime $eventendtime";
		//echo "<div>{$eventdtstart} {$day} {$eventsummary}</div>";

        $data[$firstofmonth - 1 + $day]->content[] = array(
            [$eventsummary,"header9", $eventdescription], 
            [$eventlocation, "header2"],
            [$eventtime, "header3"]
        );

        /*
        $data[$firstofmonth - 1 + $day]->url = $eventdescription;
        */
        /*
		$data[$firstofmonth - 1 + $day]->content = array(
			[$eventsummary,"header9"], 
			[$eventlocation, "header2"],
			[$eventtime, "header3"]
		);
	    $data[$firstofmonth - 1 + $day]->url = $eventdescription;
	    */

        //echo("Event:$eventsummary Description: $eventdescription Start: $eventdtstart End: $eventdtend Location: $eventlocation  <br>");
      }	  
	  
	  return $data;
	}
	
    function setupLegend($firstofmonth, $numberofdaysinmonth, &$data) {

        $file = 'legend.json';
        $file = file_get_contents($file);
        $json = json_decode($file);
        foreach ($json as $entry) {
        	$pos = $entry->position - 1;
        	$data[$pos] = new \stdClass();
		    $data[$pos]->headingClass = "header1Legend";
		    $data[$pos]->heading = $entry->heading;
		    foreach ($entry->content as $nugget) {
		    	$text = $nugget->text;
		    	$css = $nugget->css;
		    	if ($css == "header8") {
		    		$link = $nugget->link;
		    	    $data[$pos]->content[] = array([$text, $css, $link]);	
		    	}

		    	else {
		    		$data[$pos]->content[] = array([$text, $css]);
		    	}
		    	
		    }
        }

    	for ($i=0; $i<$firstofmonth; $i++) {
    		if (!isset($data[$i]))
    			$data[$i] = new \stdClass();
    		$data[$i]->backgroundColor = "legendbackground";
    	}

    	for ($i = $firstofmonth + $numberofdaysinmonth; 
    		$i<42; $i++) {
              $data[$i] = new \stdClass();
    		  $data[$i]->backgroundColor = "legendbackground";   
    	}
    }

	function renderCalendar($html) {
		$dompdf = new Dompdf();
		$dompdf->set_option('chroot', '/calendarmelbpc');
		$dompdf->set_option('isRemoteEnabled', true);
		$dompdf->loadHtml($html);
		$dompdf->set_paper('A4', 'portrait');
        $dompdf->set_option('isHtml5ParserEnabled', TRUE);
		$dompdf->render();
		$dompdf->stream('document.pdf', array("Attachment" => false));		
	}
	
	function render() {
		$loader = new \Twig_Loader_Filesystem('/');
		$twig = new \Twig_Environment($loader);
				
		$firstofmonth =  new \DateTime("first day of {$this->month} {$this->year}");
        $firstofmonth = $firstofmonth->format('N');
		//echo $firstofmonth;
		$monthindigit = new \DateTime("{$this->month} {$this->year}");
		$monthindigit = $monthindigit->format('n');
        $numberofdaysinmonth = cal_days_in_month(CAL_GREGORIAN, $monthindigit, $this->year);

        if ($firstofmonth >= 4 && $firstofmonth <=6) {
            $this->setupLegend($firstofmonth, $numberofdaysinmonth, $boo);

			foreach(range(1,$numberofdaysinmonth) as $i) {
			  $boo[$firstofmonth - 1 + $i] = new \stdClass();
			  $boo[$firstofmonth - 1 + $i]->heading = $i;
			  $boo[$firstofmonth - 1 + $i]->headingClass = "header1";
			}
		}
		
		else {
			
		}
		
		$boo = $this->getCalendarData($boo, $firstofmonth);
		//echo '<pre>'. print_r($boo, true) . '</pre>';
		//echo $twig->render('/calendar.html',array('calendardata'=>$boo));
		$html = $twig->render('/calendar.html',array(
			      'calendardata'=>$boo,
			      'month' => $this->month,
			      'year' => $this->year
			));
		//echo $html;
	    $this->renderCalendar($html);
	}
}


