<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Acaronlex\LaravelCalendar\Event;
use App\Models\EventCalendar;

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
        $events_full_day = [];
        $eventsCalendar = EventCalendar::where('user_id', Auth::user()->id)->get();
        // dd($eventsCalendar);

        foreach ($eventsCalendar as $key => $ec) {
            if($ec->all_day == 0){
                $events[] = \Calendar::event(
                    $ec->title,
                    floatval($ec->all_day),
                    new \DateTime($ec->start),
                    new \DateTime($ec->end),
                    $ec->id,
                );
            }elseif($ec->all_day == 1){
                $events_full_day[] = \Calendar::event(
                    $ec->title,
                    floatval($ec->all_day),
                    new \DateTime($ec->start),
                    new \DateTime($ec->end),
                    $ec->id,
                );
            }

        }


        // $events[] = \Calendar::event(
        //     "Valentine's Day", //event title
        //     floatval("1"), //full day event?
        //     new \DateTime('2021-08-05 12:00'), //start time (you can also use Carbon instead of DateTime)
        //     new \DateTime('2021-08-05 12:00'), //end time (you can also use Carbon instead of DateTime)
        //     1 //optionally, you can specify an event ID
        // );


        $calendar = \Calendar::addEvents($events)
        ->addEvents($events_full_day, [ 'color' => '#00b34a'])
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
                ])
                ->setCallbacks([
                    'eventClick' => 'function(event){
                        window.currentDateId = event.id;
                        deleteEvents(event.id);
                    }',
                ]);

        return view('admin.calendar.index', compact('calendar'));

    }

    public function store(Request $request){
        // dd($request->all());
        if($request){
            $event = EventCalendar::create([
                'start'     => $request['start'].$request['time'],
                'end'       => $request['end'].$request['time'],
                'title'     => $request['title'],
                'all_day'   => $request['fullDay'],
                'user_id'   => $request['user_id'],
            ]);
            return response(array('status' => 200, 'title' => 'Evento creado' ,'message' => 'Creaste el evento', 'space' => ' ','name' => $request->title, 'icon' => "success"));
        }
    }
}
