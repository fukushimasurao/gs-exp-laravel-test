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
    timeZone: 'Asia/Tokyo',
    selectable: true,
    allDaySlot: true,
    select: function(info) {
        // alert('selected ' + info.startStr + ' to ' + info.endStr);
        const eventName = prompt("Enter a Title for the Event");
        if (eventName) {
            axios
                .post("/schedule-add", {
                    start_date: info.start.valueOf(),
                    end_date: info.end.valueOf(),
                    event_name: eventName,
                })
                .then(() => {
                    calendar.addEvent({
                        title: eventName,
                        start: info.start,
                        end: info.end,
                        // allDay: false,
                        // borderColor: 'red', // 境界線の色。自由に変えてね
                        // textColor: 'blue', // テキストの色。自由に変えてね
                        // backgroundColor: 'yellow', // 背景の色。自由に変えてね
                    });
                })
                .catch((error) => {
                    console.error("Error response:", error.response);
                    alert("登録に失敗しました");
                });
        }
    },
    events: function (info, successCallback, failureCallback) {
        axios
            .post("/schedule-get", {
                start_date: info.start.valueOf(),
                end_date: info.end.valueOf(),
            })
            .then((response) => {
                calendar.removeAllEvents();
                successCallback(response.data);
            })
            .catch(() => {
                alert("登録に失敗しました");
            });
    },
});
calendar.render();
