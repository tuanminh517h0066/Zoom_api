<?php 
namespace App\Helpers;

class Helper
{
    public static function getLinkGooleCalendar($eventItem)
    {
        $start_date = str_replace('-', '', $eventItem->start_date);
	    if($eventItem->end_date) {
	    	$end_date = str_replace('-', '', $eventItem->end_date);
    	} else {
    		$end_date = $start_date;
		}

	    $link_google_event  = 'http://www.google.com/calendar/event?';
	    $link_google_event .= "action="    ."TEMPLATE";
	    $link_google_event .= "&text="     . urlencode($eventItem->title);
	    $link_google_event .= "&location=" . urlencode($eventItem->location);

	    if($start_date == $end_date) {
	        if($eventItem->start_time && $eventItem->end_time) {
	            $link_google_event .= "&dates=". $start_date . 'T' . str_replace(':', '', $eventItem->start_time);
	            $link_google_event .= "/". $end_date . 'T' . str_replace(':', '', $eventItem->end_time);
	        } else if($eventItem->start_time) {
	            $link_google_event .= "&dates=". $start_date . 'T' . trim($eventItem->start_time);
	        } else {
	            $link_google_event .= "&dates=". $start_date ."/". $end_date;
	        }
	    } else {
	        if($eventItem->start_time && $eventItem->end_time) {
	            $link_google_event .= "&dates=". $start_date . 'T' . str_replace(':', '', $eventItem->start_time);
	            $link_google_event .= "/". $end_date . 'T' . str_replace(':', '', $eventItem->end_time);
	        } else if($eventItem->start_time) {
	            $link_google_event .= "&dates=". $start_date . 'T' . str_replace(':', '', $eventItem->start_time);
	            $link_google_event .= "/". $end_date . 'T' . '230000';
	        } else {
	            $link_google_event .= "&dates="    . $start_date ."/". $end_date;
	        }
	    }

	    return $link_google_event;
    }

    public static function getLinkGooleCalendarEventNote($eventItem)
    {
        $dateArr = explode(' ', $eventItem->start_date);
        $date = str_replace('-', '', $dateArr[0]);
        $time = str_replace(':', '', $dateArr[1]);
	    
	    $link_google_event  = 'http://www.google.com/calendar/event?';
	    $link_google_event .= "action="    ."TEMPLATE";
	    $link_google_event .= "&text="     . urlencode($eventItem->title);
        $link_google_event .= "&date=". $date . 'T' . $time;

	    return $link_google_event;
    }
}