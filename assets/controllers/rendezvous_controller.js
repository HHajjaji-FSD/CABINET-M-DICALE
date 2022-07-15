import {Controller} from "@hotwired/stimulus";
import {Calendar} from "@fullcalendar/core";
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import frLocale from "@fullcalendar/core/locales/fr"

export default class extends Controller {
    static targets = [
        "calendar"
    ]

    connect() {
        //this.calendarTarget.innerHTML = "<h1>Hello</h1>"
        this.connectCalender()
    }

    connectCalender() {
        const evClick = this.evClick.bind(this)
        const calendar = new Calendar(this.calendarTarget, {
            plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
            themeSystem: 'bootstrap',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            locale: frLocale,
            events: "/api/renduVousDate",
            //dayHeaders: false,
            eventClick: evClick
        });
        calendar.render();
    }

    evClick(info) {
        const id = info.event.id;
        if (id === "block") {
            alert("Periode Blocked");
        } else {
            this.nextStepPatient(id);
        }
    }

    nextStepPatient(id) {
        console.log(id);
        window.location.href = "/admin/rendezvous/new?periode="+id
    }
}