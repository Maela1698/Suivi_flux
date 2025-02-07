{{-- <script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/styleSwitcher.js') }}"></script>
<script src="{{ asset('vendor/jqueryui/js/jquery-ui.min.js')  }}"></script>
<script src="{{ asset('vendor/moment/moment.min.js')  }}"></script>
<script src="{{ asset('vendor/fullcalendar/js/fullcalendar.min.js')  }}"></script>
<script src="{{ asset('js/plugins-init/fullcalendar-init.js')  }}"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction/main.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'dayGrid', 'timeGrid', 'interaction' ],
            initialView: 'timeGridWeek', // Vue par défaut
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '{{ url('/api/meetings') }}', // Correction URL
            editable: false,
            eventOverlap: false,
            eventClassNames: function(info) {
                // info.event représente l'événement récupéré depuis l'API
                const meeting = info.event.extendedProps;  // Tu accèdes ici aux données de ton événement

                // Ajouter les classes CSS dynamiquement
                return [
                    meeting['text-color-class'],  // Classe pour la couleur du texte
                    meeting['background-color-class']  // Classe pour la couleur de fond
                ];
            }
        });

        calendar.render();
    });
</script>