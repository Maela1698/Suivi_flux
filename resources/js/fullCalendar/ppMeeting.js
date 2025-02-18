import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import frLocale from '@fullcalendar/core/locales/fr';


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    let currentMeetingId = null;
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
            eventClassNames: function(arg) {
                var event = arg.event;
    
                // Vérifiez la propriété details_meeting_etat et retournez un tableau de classes
                if (event.extendedProps.details_meeting_etat) {
                    return ['fini-back-ground-color','fini-text-color'];
                }
                return ['a-venir-back-ground-color','a-venir-color'];
            },
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
                        currentMeetingId = data.id_details_ppmeeting;

                        let termineIcon = data.details_meeting_etat
                        ? '<i class="fas fa-check-circle"></i>'
                        : '<input type="checkbox" class="form-check-input" name="checkbox">';

                        let modalContent = `
                            <p><strong>Modèle :</strong> ${data.nom_modele}</p>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Date PPM</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" value=${data.dateppm} name="dateppm">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Horraire</label>
                                <div class="col-sm-10">
                                    <input type="time" class="form-control" value=${data.heure_debut} name="heure_debut">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">chaine</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" value=${data.id_chaine} name="id_chaine">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Entree Chaine</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" value=${data.date_entree_chaine} name="date_entree_chaine">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Entree Coupe</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" value=${data.date_entree_coupe} name="date_entree_coupe">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Entree Finition</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" value=${data.date_entree_finition} name="date_entree_finition">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Effectif reel</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" value=${data.effectif_reel} name="effectif_reel">
                                </div>
                            </div>
                            <input type="hidden" value="${data.id_meeting}" name="id_meeting">
                            <input type="hidden" value="${data.id_demande}" name="id_demande">
                            <p><strong>Effectif prevu :</strong> --</p>
                        `;

                        // Insérer le contenu dans le modal
                        document.getElementById('cin_details').innerHTML = modalContent;

                        // Mettre à jour l'icône ou la case à cocher
                        document.querySelector('.modal-header .form-check').innerHTML = termineIcon + ' <label class="form-check-label">Terminé</label>';

                        // Mettre à jour l'image si disponible
                        if (data.photo_commande) {
                            document.getElementById('modalImage').src = data.photo_commande;
                        } else {
                            document.getElementById('modalImage').src = "default.jpg"; // Image par défaut si pas de photo
                        }

                        // Mettre à jour le footer du modal
                        let modalFooter = document.querySelector('.modal-footer');
                        if (data.details_meeting_etat) {
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

        let initialMonth = new Date().getFullYear() + '-' + String(new Date().getMonth() + 1).padStart(2, '0');
        updateNbPPM(initialMonth);
    }
    document.querySelector('.modal-footer').addEventListener('click', function(event) {
        if (event.target && event.target.id === 'enregistrerBtn') {
            let form = document.getElementById('updateStatusForm');
            if (currentMeetingId) {
                form.action = `/meeting-update/${currentMeetingId}`;
                form.submit();
            } else {
                alert("Erreur : ID du meeting manquant !");
            }
        }
    });
});

function updateNbPPM(month) {
    console.log("Mois envoyé à l'API :", month);
    fetch(`/api/getNbPPM?month=${month}`)
        .then(response => response.json())
        .then(data => {
            document.querySelector('.nb-ppm').textContent = `${data.nbppm}`;
            document.querySelector('.taux-achevement').textContent = `${(data.taux_achevement * 100).toFixed(2)}%`;
            document.querySelector('.taux-retard').textContent = `${(data.taux_retard * 100).toFixed(2)}%`;
        })
        .catch(error => console.error('Erreur:', error));
}