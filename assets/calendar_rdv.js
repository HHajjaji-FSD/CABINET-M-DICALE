const $ = require('jquery');
import {Calendar} from "@fullcalendar/core";
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import frLocale from "@fullcalendar/core/locales/fr"



$(document).ready(function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin, timeGridPlugin, listPlugin],
        locale: frLocale,
        themeSystem: 'bootstrap',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        dayMaxEvents: true, // allow "more" link when too many events
        events:'/api/rendezvous',
        eventClick:function(event)
        {
            let url = "admin/rendezvous/id"
            url = url.replace('id',event.id)
            $.ajax({
                url:url,
                type:"GET",
                success:function(response)
                {
                    let btn = document.getElementById('btn_show_rdv')
                    let patient = document.querySelector('#rendezvous_show_patient')
                    let date = document.querySelector('#rendezvous_show_date_rdv')
                    let btnAttend = document.querySelector('#rendezvous_show_btn_attend')
                    patient.value = response.rendezvous.patient.name;
                    date.value = response.rendezvous.dateRDV;
                    if(response.rendezvous.hasAttend){
                        btnAttend.href = "#";
                        btnAttend.innerText = "est dans la list d'attend!";
                    }
                    else{
                        let urlAttend = "/admin/attend/id/new"
                        urlAttend = urlAttend.replace('id',response.rendezvous.patient.id)
                        btnAttend.href = urlAttend;
                        btnAttend.innerText = "Ajouter a la list d'attend!";
                    }
                    btn.click()
                }
            })
        }
    });

    calendar.render();
});
