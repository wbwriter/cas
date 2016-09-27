<?php include_once ROOT_DIR . 'views/header.inc'; ?>

<h1>Planning</h1>

<div class="content">
    <div class="container">
        <div id="calendar" class="fc fc-unthemed fc-ltr col-md-offset-1 col-md-10"></div>
    </div>
</div>

<div class="content col-lg-12">
    <div class="container">
        <table id="datatable"></table>
    </div>
</div>


<script>

    var event_type_color = ["#fa3031", "#52b9e9"];

    var event_type_textcolor = 'white';

    $(document).ready(function(){
        initCalendar('fr')
        initDataTable();
    });

    function initCalendar(locale) {
        var today = new Date();
        var today_d = today.getDate();
        var today_m = today.getMonth() + 1;
        var today_y = today.getYear() + 1900;

        var today_string = today_y + '-' + today_m + '-' + today_d;
        console.log("Today : " + today_string);


        $('#calendar').fullCalendar({
            locale: locale,
            contentHeight: 400,
            header: {
                left: 'prev,next,today',
                center: 'title',
                right: 'month,listYear'
            },
            defaultDate: today_string,
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            editable: true,
            events: [
                {
                    title: 'Pêche au barrage de Moiry',
                    start: '2016-09-11',
                    constraint: 'businessHours',
                    color: event_type_color[0],
                    textcolor: event_type_textcolor,
                    allDay: true
                },
                {
                    title: 'Randonnée XY',
                    start: '2016-09-01',
                    constraint: 'availableForMeeting', // defined below
                    color: event_type_color[1],
                    textcolor: event_type_textcolor
                },
            ]
        });
    }

    function initDataTable()
    {
            $('#datatable').DataTable({
                paging : true,
                scrollY : 300
            });
    }

</script>