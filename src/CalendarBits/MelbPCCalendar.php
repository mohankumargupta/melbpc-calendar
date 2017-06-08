<?php
namespace CalendarBits;

require_once '/vendor/autoload.php';

//use Twig\Twig_Loader_Filesystem;

class MelbPCCalendar {
	function __construct($month, $year) {
	  //print("constructor<br>");
	  $this->month = $month;
	  $this->year = $year;
	} 
	
	function getCalendarData() {
		
	}
	
	function render() {
		$loader = new \Twig_Loader_Filesystem('/');
		$twig = new \Twig_Environment($loader);
		
		$boo[0] = new \stdClass();
		$boo[0]->heading = "Legend";
		$boo[0]->content = array(
		                         ["SIG meeting at MelbPC", "header1"],
                       		     ["PC HQ, Moorabbin.","header1"],
		                         ["Non-Moorabbin meeting.", "header2"],
		                         ["Cancelled Meeting", "header3"],
		                         ["Changed Meeting","header4"],
		                         ["To be confirmed","header5"]
								);
								
				
        $boo[1] = new \stdClass();
		$boo[1]->heading = "Changes";
		$boo[1]->content = array(
                           ["Please advise", "header2"],
                           ["changes to", "header2"],
                           ["<a href=\"mailto:calendar-admin@melbpc.org.au\">calendar-admin@melbpc.org.au</a>", "header3"],						   
						   );
				
		$firstofmonth =  new \DateTime("first day of {$this->month} {$this->year}");
        $firstofmonth = $firstofmonth->format('N');
		echo $firstofmonth;
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
		
		//print_r($boo);
		echo $twig->render('/calendar.html',array('calendardata'=>$boo));
	}
}


