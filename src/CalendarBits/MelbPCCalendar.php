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
	
	function getCalendarData() {
	  $ics = file_get_contents('http://mohankumargupta.com/melbpcwordpressmultisite/?plugin=all-in-one-event-calendar&controller=ai1ec_exporter_controller&action=export_events&no_html=true');
      $iCalendar = VObject\Reader::read(
        $ics, VObject\Reader::OPTION_FORGIVING
      );
      $latestCalendar = $iCalendar->expand(new \DateTime('2017-06-01'), new \DateTime('2017-12-01'));
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
	    //echo("Event:$eventsummary Description: $eventdescription Start: $eventdtstart End: $eventdtend Location: $eventlocation  <br>");
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
		
		$boo[0] = new \stdClass();
		$boo[0]->heading = "Legend";
		$boo[0]->content = array(
		                         ["SIG meeting at MelbPC", "header1"],
                       		     ["PC HQ, Moorabbin.","header1"],
		                         ["Non-Moorabbin meeting.", "header1"],
		                         ["Cancelled Meeting", "header1"],
		                         ["Changed Meeting","header1"],
		                         ["To be confirmed","header1"]
								);
								
				
        $boo[1] = new \stdClass();
		$boo[1]->heading = "Changes";
		$boo[1]->content = array(
                           ["Please advise", "header1"],
                           ["changes to", "header1"]					   
						   );
				
		$firstofmonth =  new \DateTime("first day of {$this->month} {$this->year}");
        $firstofmonth = $firstofmonth->format('N');
		//echo $firstofmonth;
		$monthindigit = new \DateTime("{$this->month} {$this->year}");
		$monthindigit = $monthindigit->format('n');
        $numberofdaysinmonth = cal_days_in_month(CAL_GREGORIAN, $monthindigit, $this->year);

        if ($firstofmonth >= 4 && $firstofmonth <=6) {
			foreach(range(1,$numberofdaysinmonth) as $i) {
			  $boo[3 + $i] = new \stdClass();
			  $boo[3 + $i]->heading = $i;
			}
		}
		
		else {
			
		}
		
		//echo $twig->render('/calendar.html',array('calendardata'=>$boo));
		$html = $twig->render('/calendar.html',array('calendardata'=>$boo));
	    $this->renderCalendar($html);
	}
}


