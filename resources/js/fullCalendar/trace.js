import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    let currentTraceId = null;
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
            events: '/api/trace',
            editable: false,
            eventOverlap: false,

            eventClick: function(info) {
                info.jsEvent.preventDefault();

                document.getElementById('cin_details').innerHTML = "<p>Chargement...</p>";
                document.getElementById('modalImage').src = "";

                let eventIdDemande = info.event.extendedProps.id_demande;

                fetch(`/api/trace/${eventIdDemande}`)
                    .then(response => response.json())
                    .then(data => {
                        currentTraceId = data.trace_id;
                        
                        let termineIcon = data.etat_trace === 1
                        ? '<i class="fas fa-check-circle"></i>'
                        : '<input type="checkbox" class="form-check-input" name="checkbox">';

                        let modalContent = `
                            <p><strong>Modèle :</strong> ${data.nom_modele}</p>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Date trace</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" value=${data.datetrace} name="datetrace">
                                </div>
                            </div>
                        `;

                        // Insérer le contenu dans le modal
                        document.getElementById('cin_details').innerHTML = modalContent;

                        // Mettre à jour l'icône ou la case à cocher
                        document.querySelector('.modal-header .form-check').innerHTML = termineIcon + ' <label class="form-check-label">Terminé</label>';
                    
                        // Mettre à jour le footer du modal
                        let modalFooter = document.querySelector('.modal-footer');
                        if (data.etat_trace === 1) {
                            modalFooter.innerHTML = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>';
                        } else {
                            modalFooter.innerHTML = `
                                <button type="submit" class="btn btn-primary" id="enregistrerBtn">Enregistrer</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            `;
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
    }

    document.querySelector('.modal-footer').addEventListener('click', function(event) {
        if (event.target && event.target.id === 'enregistrerBtn') {
            let form = document.getElementById('updateStatusForm');
            if (currentTraceId) {
                form.action = `/trace-update/${currentTraceId}`;
                form.submit();
            } else {
                alert("Erreur : ID du trace manquant !");
            }
        }
    });
});
