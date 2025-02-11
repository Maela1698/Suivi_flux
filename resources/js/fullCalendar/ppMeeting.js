import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        var calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin],
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '/api/meetings',
            editable: false,
            eventOverlap: false,

            datesSet: function(info) {
                let currentMonth = info.view.currentStart.getFullYear() + '-' + String(info.view.currentStart.getMonth() + 1).padStart(2, '0');
                updateNbPPM(currentMonth);
            }
        });
        calendar.render();

        let initialMonth = new Date().getFullYear() + '-' + String(new Date().getMonth() + 1).padStart(2, '0');
        updateNbPPM(initialMonth);
    }
});

function updateNbPPM(month) {
    console.log("Mois envoyé à l'API :", month);
    fetch(`/api/getNbPPM?month=${month}`)
        .then(response => response.json())
        .then(data => {
            document.querySelector('.nb-ppm').textContent = `nb ppm : ${data.nbppm}`;
        })
        .catch(error => console.error('Erreur:', error));
}