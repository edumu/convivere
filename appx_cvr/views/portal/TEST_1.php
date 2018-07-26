<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo doctype('html5');

echo '<html>';
echo ' <head> <meta charset="utf-8" />  ';

echo script_tag(array('src' => 'style/js/jquery-1.11.3.min.js'));

echo link_tag  ( array('href'=> 'style/css/fullcalendar.css'      , 'rel' => 'stylesheet') );
echo link_tag  ( array('href'=> 'style/css/fullcalendar.print.css', 'rel' => 'stylesheet', "media"=>'print') );

echo script_tag( array('src' => 'js/moment.min.js'  ));    
echo script_tag( array('src' => 'js/fullcalendar.js'));
echo script_tag( array('src' => 'js/locale-all.js'  ));

?>

<!--<script src='http://localhost/convivere/style/js/jquery-1.11.3.min.js'></script>

<link href='http://localhost/convivere/style/css/fullcalendar.css' rel='stylesheet' />

<link href='http://localhost/convivere/style/css/fullcalendar.print.css' rel='stylesheet' media='print' />

<script src='http://localhost/convivere/js/moment.min.js'></script>
<script src='http://localhost/convivere/js/fullcalendar.js'></script>
<script src='http://localhost/convivere/js/locale-all.js'></script>
-->
<script>

  $(document).ready(function() {
   var initialLocaleCode = 'es';
   var today    = new Date();

    $('#calendar').fullCalendar({
      header	 : { left  : 'prev,next today', center: 'title', right : 'month, agendaWeek, agendaDay, listMonth' },
      defaultDate: today,
      locale	 : initialLocaleCode,
      buttonIcons: true, 
      weekNumbers: true,
      navLinks   : true, 
      editable   : true,
      eventLimit : true, 
      events: [
            {
              title: 'All Day Event',
              start: '2018-06-01'
            },
            {
              title: 'Long Event',
              start: '2018-06-07',
              end: '2018-06-10'
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: '2018-06-09T16:00:00'
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: '2018-06-16T16:00:00'
            },
            {
              title: 'Conference',
              start: '2018-06-11',
              end: '2018-06-13'
            },
            {
              title: 'Meeting',
              start: '2018-06-12T10:30:00',
              end: '2018-06-12T12:30:00'
            },
            {
              title: 'Lunch',
              start: '2018-06-12T12:00:00'
            },
            {
              title: 'Meeting',
              start: '2018-06-12T14:30:00'
            },
            {
              title: 'Happy Hour',
              start: '2018-06-12T17:30:00'
            },
            {
              title: 'Dinner',
              start: '2018-06-12T20:00:00'
            },
            {
              title: 'Birthday Party',
              start: '2018-03-13T07:00:00'
            },
            {
              title: 'Click for Google',
              url: 'http://google.com/',
              start: '2018-06-28'
            }
          ]
    });

    });    

</script>
<style>
    

  #calendar {
    max-width: 900px;
    margin: 40px auto;
    padding: 0 10px;
  }

</style>
</head>
<body>

 

  <div id='calendar'></div>

</body>
</html>