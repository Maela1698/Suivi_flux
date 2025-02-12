import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import frLocale from '@fullcalendar/core/locales/fr';


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        var calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin],
            locale: 'fr',
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
            },

            eventClick: function(info) {
                // Empêche le redirection par défaut si c'est un lien
                info.jsEvent.preventDefault();

                let eventIdDemande = info.event.extendedProps.id_demande;

                document.getElementById('cin_details').innerHTML = "<p>Chargement...</p>";
                document.getElementById('modalImage').src = "";

                fetch(`/api/meeting/${eventIdDemande}`)
                    .then(response => response.json())
                    .then(data => {
                        let modalContent = `
                            <p><strong>Modèle :</strong> ${data.nom_modele}</p>
                            <p><strong>Date :</strong> ${data.dateppm}</p>
                            <p><strong>Heure :</strong> ${data.heure_debut}</p>
                            <p><strong>Effectif prevu :</strong> --</p>
                        `;

                        // Insérer le contenu dans le modal
                        document.getElementById('cin_details').innerHTML = modalContent;

                        // Mettre à jour l'image si disponible
                        if (data.photo_commande) {
                            document.getElementById('modalImage').src = data.photo_commande;
                        } else {
                            document.getElementById('modalImage').src = "default.jpg"; // Image par défaut si pas de photo
                        }
                    })
                    .catch(error => {
                        console.error('Erreur AJAX:', error);
                        document.getElementById('cin_details').innerHTML = "<p>Erreur lors du chargement.</p>";
                    });

                // Afficher le modal sans remplir de données
                let eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                eventModal.show();
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
            document.querySelector('.nb-ppm').textContent = `${data.nbppm}`;
        })
        .catch(error => console.error('Erreur:', error));
}