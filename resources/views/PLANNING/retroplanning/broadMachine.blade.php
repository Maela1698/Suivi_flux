@include('CRM.header')
@include('CRM.sidebar')

<style>
    /* Styles pour les éléments Kanban */
    .kanban-item {
        background-color: white;
        padding: 10px;
        border-radius: 5px;
        border: solid 1px lightgray;
        min-width: 350px;
        margin-bottom: 10px;
        position: relative;
        cursor: grab;
    }

    .kanban-item:active {
        cursor: grabbing;
    }

    .drag-over {
        border: 2px dashed #007bff;
    }

    .kanban-column {
        padding: 10px;
        border: 1px solid #ddd;
        min-height: 150px;
        background-color: #f9f9f9;
    }

    body,
    html {
        overflow-x: hidden;
        overflow-y: auto;
    }

    strong {
        color: rgb(173, 170, 170);
    }

    span {
        color: rgb(49, 48, 48);
    }

    .kanban-column.drag-over {
        border: 2px dashed #007bff;
        background-color: #e9ecef;
    }
</style>

<div class="content-body">
    <div class="container-fluid">
        @include('PLANNING.headerPlan')
        <div class="col-lg-12">
            <div class="card" id="kanban-container"
                style="border-radius: 10px;width: 105%;margin-left: -31.5px;overflow-y: auto;overflow-x: auto; white-space: nowrap;  max-width: 105%;">
                <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                    <h3 class="entete">BROADERIE MACHINE PLANNING</h3>
                </div>

                <table class="table table-bordered" style="text-align: center; background-color: white">
                    <thead class="thead-dark">
                        <tr>
                            @foreach ($dates as $date)
                                <th scope="col" style="cursor: pointer;" class="date-header">
                                    {{ $date }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <thead class="thead" style="background-color: rgb(208, 208, 208);color: black;">
                        <tr>
                            @foreach ($charge as $c)
                                <th scope="col" class="date-header" id="th-charge-{{ $loop->index }}"
                                    onclick="showModalForCharge(this)">
                                    {{ $c }}%
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($dates as $date)
                                @php
                                    $datePart = preg_replace('/^[a-zA-Z]+ : /', '', $date);
                                    $formattedDate = \Carbon\Carbon::createFromFormat('d-m-Y', $datePart)->format(
                                        'Y-m-d',
                                    );
                                    $found = false;
                                @endphp
                                <td class="kanban-column" id="column-{{ $loop->index }}"
                                    data-column-id="{{ $loop->index }}" data-date="{{ $formattedDate }}">
                                    @foreach ($donne as $index => $d)
                                        @if ($d->inlinechacun == $formattedDate)
                                            <div class="kanban-item" id="item-{{ $d->bmc_id }}"
                                                style="background-color: rgb(234, 234, 234); max-height: 80px; height: 80px;"
                                                draggable="true" onclick="showModalForQuantite(this)"
                                                data-id="{{ $d->bmc_id }}" data-nomtier="{{ $d->nomtier }}"
                                                data-outline="{{ $d->outline }}" data-jourprod="{{ $d->jourprod }}"
                                                data-nom-modele="{{ $d->nom_modele }}"
                                                data-qtereel="{{ $d->qtereel }}">
                                                <div class="kanban-header"
                                                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: -5px; background-color: transparent; padding: 10px; border-radius: 5px; margin-top: -10px;">
                                                    <div style="display: flex; align-items: center;">
                                                        <i class="fas fa-user"
                                                            style="margin-right: 5px; color: #ffc107;"></i>
                                                        <div>{{ $d->nomtier }}</div>
                                                    </div>
                                                    <div style="display: flex; align-items: center;">
                                                        <i class="fas fa-calendar"
                                                            style="margin-right: 5px; color: #28a745;"></i>
                                                        <div>{{ $d->outline }}</div>
                                                    </div>
                                                </div>
                                                <div class="kanban-body"
                                                    style="display: flex; justify-content: space-between; align-items: center; background-color: transparent; padding: 10px; border-radius: 5px;">
                                                    <div style="display: flex; align-items: center;">
                                                        <i class="fas fa-clock"
                                                            style="margin-right: 5px; color: #007bff;"></i>
                                                        <div>{{ $d->jourprod }} jour</div>
                                                    </div>
                                                    <div style="display: flex; align-items: center;">
                                                        <i class="fas fa-tag"
                                                            style="margin-right: 5px; color: #17a2b8;"></i>
                                                        <div>{{ $d->nom_modele }}</div>
                                                    </div>
                                                    <div style="display: flex; align-items: center;">
                                                        <i class="fas fa-coins"
                                                            style="margin-right: 5px; color: #dc3545;"></i>
                                                        <div>{{ $d->qtereel }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal details -->
<div class="modal fade" id="kanbanModal" tabindex="-1" role="dialog" aria-labelledby="kanbanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Capacité</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color: black">
                <form>
                    <div class="form-group">
                        <label for="input1">Capacité théorique</label>
                        <input type="text" class="form-control" id="input1">
                    </div>
                    <div class="form-group">
                        <label for="input2">Capacité réel</label>
                        <input type="text" class="form-control" id="input2">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal details -->
<div class="modal fade" id="kanbanCharge" tabindex="-1" role="dialog" aria-labelledby="kanbanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Details charge</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color: black">
            </div>
        </div>
    </div>
</div>
@include('PLANNING.parametre');
@include('CRM.footer');

<!-- Include Sortable.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const columns = document.querySelectorAll('.kanban-column');

        columns.forEach(column => {
            new Sortable(column, {
                group: 'kanban',
                animation: 150,
                onEnd: function(evt) {
                    const draggedItem = evt.item; // Élément déplacé
                    const itemId = draggedItem.dataset.id; // ID de l'élément
                    const targetColumn = evt.to; // Colonne cible

                    if (!itemId) {
                        console.error('Erreur : ID de l\'élément introuvable.');
                        return;
                    }

                    if (targetColumn && targetColumn.classList.contains('kanban-column')) {
                        const targetDate = targetColumn.dataset.date;


                        if (!targetDate) {
                            console.error('Erreur : Date de la colonne cible introuvable.');
                            alert('Erreur : Date de la colonne non définie.');
                            return;
                        }

                        console.log('ID:', itemId);
                        console.log('Target Date:', targetDate);

                        // Envoyer la date et l'ID via AJAX
                        updateDateInDatabase(itemId, targetDate);
                    } else {
                        console.error('Colonne cible introuvable ou invalide.');
                    }
                }
            });
        });
    });

    function updateDateInDatabase(id, date) {
        fetch('/update-date', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    id,
                    date
                })
            })
            .then(response => response.ok ? response.json() : Promise.reject('Erreur lors de la mise à jour.'))
            .then(data => {
                console.log('Mise à jour réussie :', data);
                // Ajout d'un léger rechargement pour actualiser les données
                setTimeout(() => {
                    location.reload(); // Recharge la page
                }, 200); // Délai de 200 ms pour une transition fluide
            })
            .catch(error => {
                console.error('Erreur AJAX :', error);
                alert('Une erreur est survenue lors de la mise à jour.');
            });
    }
</script>

<script>
    function showModalForQuantite(element) {
        $('#kanbanModal').modal('show');
    }
</script>

<script>
    function showModalForCharge(element) {
        const thId = element.id;
        const info = element.getAttribute('data-info'); // Récupère les détails
        const modalBody = document.querySelector('#kanbanCharge .modal-body');

        // Injecte les détails dans le modal
        modalBody.innerHTML = `<p>${info}</p>
                <form>
                    <div class="form-group">
                        <label for="input1">Capacité théorique</label>
                        <input type="text" class="form-control" id="input1" value="4000000">
                    </div>
                </form>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>`;

        // Affiche le modal
        $('#kanbanCharge').modal('show');
    }
</script>
