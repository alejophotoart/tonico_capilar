<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Acaronlex\LaravelCalendar\Event;
use Calendar;

class CalendarController extends Controller
{
    public function index()
    {
        return view('admin.calendar.index');
    }

    public function getEventOptions()
    {
        return [
            'color' => $this->background_color,
			//etc
        ];
    }

    public function addEvents(){
        $events = [];

        // $events[] = \Calendar::event(
        //     'Event One', //event title
        //     false, //full day event?
        //     '2021-08-05T0800', //start time (you can also use Carbon instead of DateTime)
        //     '2021-08-06T0800', //end time (you can also use Carbon instead of DateTime)
        //     0 //optionally, you can specify an event ID
        // );

        // $events[] = \Calendar::event(
        //     "Valentine's Day", //event title
        //     true, //full day event?
        //     new \DateTime('2021-08-05'), //start time (you can also use Carbon instead of DateTime)
        //     new \DateTime('2021-08-05'), //end time (you can also use Carbon instead of DateTime)
        //     'stringEventId' //optionally, you can specify an event ID
        // );


        $calendar = \Calendar::addEvents($events)
                ->setOptions([
                    'locale' => 'es',
                    'firstDay' => 1,
                    'displayEventTime' => true,
                    'selectable' => true,
                    'initialView' => 'dayGridMonth',
                    'headerToolbar' => [
                        'end' => 'dayGridMonth timeGridWeek timeGridDay',
                        'start' => 'prev,next today',
                        'center' => 'title'
                    ],
                ]);
                // $calendar->setId('1');
                // $calendar->setCallbacks([
                //     'select' => 'function(selectionInfo){}',
                //     'eventClick' => 'function(event){}'
                // ]);

        return view('admin.calendar.index', compact('calendar'));

    }
}
