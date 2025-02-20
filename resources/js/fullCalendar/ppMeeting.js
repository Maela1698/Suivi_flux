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
                else if(!event.extendedProps.details_meeting_etat && event.extendedProps.isretard){
                    return ['retard-back-ground-color','a-venir-color'];
                }
                return ['a-venir-back-ground-color','a-venir-color'];
            },
            editable: false,
            eventOverlap: false,

            datesSet: function(dateInfo) {
                let currentMonth = dateInfo.view.currentStart.getFullYear() + '-' + String(dateInfo.view.currentStart.getMonth() + 1).padStart(2, '0');
                if (dateInfo.view.type === 'dayGridMonth') {
                    updateStat(currentMonth);
                }
                if (dateInfo.view.type === 'timeGridWeek') {
                    let startDate = dateInfo.startStr.split('T')[0];
                    let endDate = dateInfo.endStr.split('T')[0];
                    updateStatWeek(startDate,endDate);
                }
            },

            eventClick: function(info) {
                // Empêche le redirection par défaut si c'est un lien
                info.jsEvent.preventDefault();

                let eventIdDemande = info.event.extendedProps.id_demande;

                document.getElementById('cin_details').innerHTML = "<p>Chargement...</p>";

                fetch(`/api/meeting/${eventIdDemande}`)
                    .then(response => response.json())
                    .then(data => {
                        currentMeetingId = data.id_details_ppmeeting;

                        let termineIcon = data.details_meeting_etat
                            ? '<i class="fas fa-check-circle"></i>'
                            : '<input type="checkbox" class="form-check-input" name="checkbox" id="terminateCheckbox">';

                        // Récupérer les chaînes
                        fetchChaines().then(chaines => {
                            let chaineOptions = chaines.map(chaine => `<option value="${chaine.id_chaine}" ${chaine.id_chaine === data.id_chaine ? 'selected' : ''}>${chaine.designation}</option>`).join('');

                            let modalContent = `
                                <p><strong>Modèle :</strong> ${data.nom_modele}</p>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Date PPM</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" value="${data.dateppm}" name="dateppm">
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Horraire</label>
                                    <div class="col-sm-10">
                                        <input type="time" class="form-control" value="${data.heure_debut}" name="heure_debut">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Chaîne</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="id_chaine">
                                            ${chaineOptions}
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Entree Chaine</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" value="${data.date_entree_chaine}" name="date_entree_chaine">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Entree Coupe</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" value="${data.date_entree_coupe}" name="date_entree_coupe">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Entree Finition</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" value="${data.date_entree_finition}" name="date_entree_finition">
                                    </div>
                                </div>
                                <p><strong>Effectif prevu : </strong>${data.effectif_prevu}</p>
                                <div class="form-group row" id="effectifReelDiv">
                                    <label class="col-sm-2 col-form-label">Effectif reel</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" value="${data.effectif_reel}" id="inputEffectifReel">
                                    </div>
                                </div>
                                <input type="hidden" value="${data.id_meeting}" name="id_meeting">
                                <input type="hidden" value="${data.id_demande}" name="id_demande">
                                <input type="hidden" value="${data.effectif_prevu}" name="effectif_prevu">

                            `;

                            // Insérer le contenu dans le modal
                            document.getElementById('cin_details').innerHTML = modalContent;

                            // Mettre à jour l'icône ou la case à cocher
                            document.querySelector('.modal-header .form-check').innerHTML = termineIcon + ' <label class="form-check-label">Terminé</label>';
                          
                            let terminateCheckbox = document.getElementById('terminateCheckbox');
                            if (terminateCheckbox) {
                                terminateCheckbox.addEventListener('change', function() {
                                    let effectifReelDiv = document.getElementById('effectifReelDiv');
                                    if (this.checked) {
                                        effectifReelDiv.style.display = 'flex';
                                    } else {
                                        effectifReelDiv.style.display = 'none';
                                    }
                                });
                            
                                // Initialiser l'affichage en fonction de l'état initial de la case à cocher
                                if (terminateCheckbox.checked) {
                                    document.getElementById('effectifReelDiv').style.display = 'flex';
                                } else {
                                    document.getElementById('effectifReelDiv').style.display = 'none';
                                }
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
                        });
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
        updateStat(initialMonth);
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

function updateStat(month) {
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

function fetchChaines() {
    return fetch('/api/chaines')
        .then(response => response.json())
        .then(chaines => {
            return chaines;
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des chaînes:', error);
            return [];
        });
}

function updateStatWeek(startDate,endDate) {
    console.log('Dates de début et de fin de la semaine :', startDate, endDate)
    fetch(`/api/getStatWeekPPM?startDate=${startDate}&endDate=${endDate}`)
        .then(response => response.json())
        .then(data => {
            document.querySelector('.nb-ppm').textContent = `${data.nbppm}`;
            document.querySelector('.taux-achevement').textContent = `${(data.taux_fini * 100).toFixed(2)}%`;
            document.querySelector('.taux-retard').textContent = `${(data.taux_retard * 100).toFixed(2)}%`;
        })
        .catch(error => console.error('Erreur:', error));
}