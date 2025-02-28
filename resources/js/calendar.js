import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid"
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

let calendarEl = document.getElementById('calendar');
let calendar = new Calendar(calendarEl, {
    plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin],
    initialView: 'dayGridMonth',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listWeek'
    },
    locale: "ja",
    selectable: true,
    allDaySlot: true,
    select: function(info) {
        // alert('selected ' + info.startStr + ' to ' + info.endStr);
        const eventName = prompt("Enter a Title for the Event");
        if (eventName) {
            calendar.addEvent({
                title: eventName,
                start: info.start,
                end: info.end,
                allDay: true,
                // borderColor: 'red', // 境界線の色。自由に変えてね
                // textColor: 'blue', // テキストの色。自由に変えてね
                // backgroundColor: 'yellow', // 背景の色。自由に変えてね
            });
        }
    },


});
calendar.render();
