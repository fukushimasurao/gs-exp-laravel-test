import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

document.addEventListener("DOMContentLoaded", function () {
    if (window.location.pathname !== "/dashboard") {
        return;
    }

    let calendarEl = document.getElementById("calendar");
    let calendar = new Calendar(calendarEl, {
        plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin],
        initialView: "dayGridMonth",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth timeGridWeek",
        },
        locale: "ja",
        timeZone: "Asia/Tokyo",
        selectable: true,
        allDaySlot: true,
        select: function (info) {
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
                            // allDay: true,
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
                // schedule-getに対して開始日と終了日をpost
                .post("/schedule-get", {
                    start_date: info.start.valueOf(),
                    end_date: info.end.valueOf(),
                })
                .then((response) => {
                    // 問題なく帰ってきたら、今ブラウザに表示されているイベントを一旦全部消す
                    calendar.removeAllEvents();
                    // 取得したデータ（response.data）をFullCalendarに渡す。
                    // successCallback関数はFullCalendarが用意したもの。これで表示される。
                    successCallback(response.data);
                })
                .catch(() => {
                    alert("取得に失敗しました");
                });
        },
    });
    calendar.render();
});
