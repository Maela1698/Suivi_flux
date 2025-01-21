@include('CRM.header')
@include('CRM.sidebar')

<style>
    .kanban-item {
        background-color: white;
        padding: 10px;
        border-radius: 5px;
        border: solid 1px lightgray;
        min-width: 350px;
        margin-bottom: 10px;
        position: relative;
        cursor: grab;
        /* Ajoutez un curseur pour indiquer que l'élément est draggable */
    }

    .kanban-item:active {
        cursor: grabbing;
        /* Curseur pendant le drag */
    }

    .drag-over {
        border: 2px dashed #007bff;
    }

    .kanban-column {
        padding: 10px;
        border: 1px solid #ddd;
        min-height: 150px;
        background-color: #f9f9f9;
        /* Couleur d'arrière-plan pour les colonnes */
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
</style>

<div class="content-body">
    <div class="container-fluid">
        @include('PLANNING.headerPlan')
        <div class="col-lg-12">
            <div class="card" id="kanban-container"
                style="border-radius: 10px;width: 105%;margin-left: -31.5px;overflow-y: auto;overflow-x: auto; white-space: nowrap;  max-width: 105%;">
                <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                    <h3 class="entete">RETRO PLANNING</h3>
                </div>

                <table class="table table-bordered" style="text-align: center; background-color: white">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Chaine</th>
                            @foreach ($dates as $date)
                                <th scope="col" style="cursor: pointer;" class="date-header" data-date="{{ $date }}">
                                    {{ $date }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <thead class="thead" style="background-color: rgb(208, 208, 208);color: black;">
                        <tr>
                            <th scope="col"></th>
                            @foreach ($charges as $charge)
                                <th scope="col"
                                    class="charge-header">
                                    {{ $charge }}%
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chaines as $c)
                            <tr>
                                <td>
                                    <div class="kanban-item"
                                        style="max-height: 80px; height: 80px; display: flex; justify-content: center; align-items: center; text-align: center;">
                                        {{ $c->designation }}
                                    </div>
                                </td>
                                @foreach ($dates as $date)
                                    @php
                                        $datePart = preg_replace('/^[a-zA-Z]+ : /', '', $date);
                                        $formattedDate = \Carbon\Carbon::createFromFormat('d-m-Y', $datePart)->format(
                                            'Y-m-d',
                                        );
                                        $found = false;
                                    @endphp
                                    @foreach ($donne as $index => $d)
                                        @if ($d->inlinechacun == $formattedDate && $d->id_chaine == $c->id_chaine)
                                            @php
                                                // Check if this is the last item of the current iddemandeclient group
                                                $isLastInGroup =
                                                    !isset($donne[$index + 1]) ||
                                                    $donne[$index + 1]->iddemandeclient != $d->iddemandeclient;
                                                $efficience = $d->efficiencereel !=0;
                                            @endphp
                                            <td class="kanban-column " ondragover="event.preventDefault();"
                                                ondrop="handleDrop(event)"
                                                style="{{ $isLastInGroup ? 'border-right: 3px solid #007bff;' : '' }}">
                                                <div class="kanban-item" draggable="true"
                                                    ondragstart="handleDragStart(event)" onclick="showKanbanModal(this)"
                                                    data-nom-modele="{{ $d->nom_modele }}"
                                                    data-id="{{ $d->iddemandeclient }}"
                                                    data-inline="{{ $d->inline }}" data-chaine="{{ $d->id_chaine }}"
                                                    data-jourprod="{{ $d->jourprod }}"
                                                    data-smv-prod="{{ $d->smv_prod }}"
                                                    data-smv-finition="{{ $d->smv_finition }}"
                                                    data-nom-client="{{ $d->nom_client }}"
                                                    data-qte="{{ $d->qte }}"
                                                    data-inline-chacun="{{ $d->inlinechacun }}"
                                                    data-capacite="{{ $d->capacite }}"
                                                    data-etd-revise="{{ $d->etdrevise }}"
                                                    data-etd-initial="{{ $d->etdinitial }}"
                                                    data-tissus-max="{{ $d->tissu_max }}"
                                                    data-tissus-prev="{{ $d->date_bc_tissu_prev }}"
                                                    data-tissus-reelle="{{ $d->date_bc_tissu_reelle }}"
                                                    data-accessoire-max="{{ $d->accy_max }}"
                                                    data-accessoire-prev="{{ $d->date_bc_accy_prev }}"
                                                    data-accessoire-reelle="{{ $d->date_bc_accy_reelle }}"
                                                    data-ok-prod="{{ $d->ok_prod }}"
                                                    data-efficience="{{ $d->efficience }}"
                                                    data-efficience-reel="{{ $d->efficiencereel }}"
                                                    data-effectif="{{ $d->effectif }}"
                                                    data-heuretravail="{{ $d->heuretravail }}"
                                                    data-capacitereel="{{ $d->capacitereel }}"
                                                    data-idchaine="{{ $d->id_chaine }}"
                                                    data-iddataprod="{{ $d->id_data_prod }}"
                                                    data-qtereel="{{ $d->qtereel }}"
                                                    style="background-color: rgb(234, 234, 234); max-height: 80px; height: 80px;color:rgb(104, 104, 104);{{ $efficience ? 'background-color: lightblue;' : '' }}">

                                                    <div class="kanban-header"
                                                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: -5px; background-color: transparent; padding: 10px; border-radius: 5px; margin-top:-10px;">
                                                        <div style="display: flex; align-items: center;">
                                                            <i class="fas fa-user"
                                                                style="margin-right: 5px; color: #ffc107;"></i>
                                                            <div>{{ $d->nom_client }}</div>
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
                                            </td>
                                            @php
                                                $found = true; // Set flag to true if we found an entry
                                            @endphp
                                        @endif
                                    @endforeach

                                    @if (!$found)
                                        <td class="kanban-column" ondragover="event.preventDefault();"
                                            ondrop="handleDrop(event)"></td>
                                        <!-- Add an empty cell only if no entries were found -->
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
<!-- Modal -->
<div class="modal" id="dateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Date Sélectionnée</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('PLANNING.insertDateNonTravail') }}" method="post">
                    @csrf
                    <input type="text" id="selectedDate" name="dateSelection">
                    <div>
                        <button type="button" id="selectAll" class="btn btn-primary">Sélectionner Tous</button>
                        <button type="button" id="deselectAll" class="btn btn-secondary">Désélectionner
                            Tous</button>

                        @foreach ($chaines as $chaine)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="chaine{{ $chaine->id_chaine }}"
                                    name="chaines[]" value="{{ $chaine->id_chaine }}">
                                <label class="form-check-label" for="chaine{{ $chaine->id_chaine }}">
                                    {{ $chaine->designation }}
                                </label>
                            </div>
                        @endforeach

                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal details -->
<div class="modal fade" id="kanbanModal" tabindex="-1" role="dialog" aria-labelledby="kanbanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Details Demande</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid" style="border-bottom: solid 2px rgb(171, 171, 171)">
                    <div class="row">
                        <!-- Left Column: 10 items -->
                        <div class="col-6">
                            <div class="mb-3"><strong>Nom du modèle:</strong> <span id="nomModele"></span></div>
                            <div class="mb-3"><strong>Inline:</strong> <span id="inline"></span></div>
                            <div class="mb-3"><strong>Chaine:</strong> <span id="chaine"></span></div>
                            <div class="mb-3"><strong>Jour Production:</strong> <span id="jourProd"></span></div>
                            <div class="mb-3"><strong>SMV Production:</strong> <span id="smvProd"></span></div>
                            <div class="mb-3"><strong>Nom Client:</strong> <span id="nomClient"></span></div>
                            <div class="mb-3"><strong>Quantité:</strong> <span id="qte"></span></div>
                            <div class="mb-3"><strong>Capacité:</strong> <span id="capacite"></span></div>
                            <div class="mb-3"><strong>Efficience:</strong> <span id="efficience"></span></div>
                        </div>

                        <!-- Right Column: 9 items -->
                        <div class="col-6">
                            <div class="mb-3"><strong>ETD Révisé:</strong> <span id="etdRevise"></span></div>
                            <div class="mb-3"><strong>ETD Initial:</strong> <span id="etdInitial"></span></div>
                            <div class="mb-3"><strong>Tissus Max:</strong> <span id="tissusMax"></span></div>
                            <div class="mb-3"><strong>Tissus Prévu:</strong> <span id="tissusPrev"></span></div>
                            <div class="mb-3"><strong>Tissus Réel:</strong> <span id="tissusReelle"></span></div>
                            <div class="mb-3"><strong>Accessoires Max:</strong> <span id="accessoireMax"></span>
                            </div>
                            <div class="mb-3"><strong>Accessoires Prévu:</strong> <span id="accessoirePrev"></span>
                            </div>
                            <div class="mb-3"><strong>Accessoires Réel:</strong> <span id="accessoireReelle"></span>
                            </div>
                            <div class="mb-3"><strong>OK Production:</strong> <span id="okProd"></span></div>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="container-fluid mt-4">
                    <h5>Formulaire</h5>
                    <form action="{{ route('PLANNING.ajoutDonne') }}" method="post">
                        @csrf
                        <input type="hidden" name="inlinechacun" id="inlinechacun">
                        <input type="hidden" name="id_demande" id="iddemande">
                        <input type="hidden" name="smv_prod" id="smvprods">
                        <input type="hidden" name="smv_finition" id="smvfinitions">
                        <input type="hidden" name="idchaine" id="id_chaine">
                        <input type="hidden" name="id_data_prod" id="id_data_prod">
                        <input type="hidden" name="quantite" id="qtereel">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ht">HT:</label>
                                    <input type="text" class="form-control" id="heuretravail" name="heuretravail"
                                        placeholder="Heure Travail...">
                                </div>
                                <div class="form-group">
                                    <label for="efficience">Efficience:</label>
                                    <input type="text" class="form-control" id="efficiences" name="efficience"
                                        placeholder="Efficience...">
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="effectif">Effectif:</label>
                                    <input type="text" class="form-control" id="effectif" name="effectif"
                                        placeholder="Effectif...">
                                </div>
                                <div class="form-group">
                                    <label for="effectif">Efficience Reel:</label>
                                    <input type="text" class="form-control" id="efficiencereel"
                                        readonly>
                                </div>
                                <div class="text-right mt-3">
                                <button type="submit" class="btn btn-info mt-3">Ajout Donne</button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <form action="{{ route('PLANNING.ajoutCapaciteReel') }}" method="post">
                        @csrf
                        <input type="hidden" name="inlinechacun" id="inlinechacuns">
                        <input type="hidden" name="id_demande" id="iddemandes">
                        <input type="hidden" name="smv_prod" id="smvprodss">
                        <input type="hidden" name="smv_finition" id="smvfinitionss">
                        <input type="hidden" name="idchaine" id="id_chaines">
                        <input type="hidden" name="id_data_prod" id="id_data_prods">
                        <input type="hidden" name="quantite" id="qtereels">
                        <input type="hidden"  name="heuretravail" id="heuretravails">
                        <input type="hidden" name="effectif" id="effectifs">
                        <input type="hidden" name="efficience"  id="efficiencess">
                        <div class="form-group">
                            <label for="capaciteReel">Capacité Réel:</label>
                            <input type="text" class="form-control" id="capacitereel" name="capacitereel" style="width: 550px;"
                                placeholder="Capacité Réel...">
                        </div>
                        <div class="text-right mt-3">
                            <button type="button" class="btn btn-primary mt-3" data-dismiss="modal">Retour</button>
                            <button type="submit" class="btn btn-success mt-3">Ajout Capacite</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

</div>
<!-- Modal de confirmation -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmer le déplacement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Voulez-vous vraiment déplacer cet élément ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <form id="exchangeForm" action="{{ route('PLANNING.echangeRetroPlanning') }}" method="POST">
                    @csrf
                    <input type="hidden" name="dragged_name" id="dragged_name">
                    <input type="hidden" name="dragged_inline" id="dragged_inline">
                    <input type="hidden" name="dragged_nom_modele" id="dragged_nom_modele">
                    <input type="hidden" name="dragged_quantity" id="dragged_quantity">
                    <input type="hidden" name="dragged_id" id="dragged_id">
                    <input type="hidden" name="dragged_idchaine" id="dragged_idchaine">
                    <input type="hidden" name="dragged_jourprod" id="dragged_jourprod">
                    <input type="hidden" name="target_name" id="target_name">
                    <input type="hidden" name="target_inline" id="target_inline">
                    <input type="hidden" name="target_nom_modele" id="target_nom_modele">
                    <input type="hidden" name="target_quantity" id="target_quantity">
                    <input type="hidden" name="target_id" id="target_id">
                    <input type="hidden" name="target_idchaine" id="target_idchaine">
                    <input type="hidden" name="target_jourprod" id="target_jourprod">
                    <input type="hidden" name="target_column_name" id="target_column_name">
                    <input type="hidden" name="chain_id" id="chain_id">
                    <button type="button" class="btn btn-warning" onclick="submitExchangeForm()" style="display: none">Echanger</button>
                </form>
                <form id="addForm" action="{{ route('PLANNING.ajoutRetroPlanning') }}" method="POST">
                    @csrf
                    <input type="hidden" name="dragged_name" id="dragged_names">
                    <input type="hidden" name="dragged_inline" id="dragged_inlines">
                    <input type="hidden" name="dragged_nom_modele" id="dragged_nom_modeles">
                    <input type="hidden" name="dragged_quantity" id="dragged_quantitys">
                    <input type="hidden" name="dragged_id" id="dragged_ids">
                    <input type="hidden" name="dragged_idchaine" id="dragged_idchaines">
                    <input type="hidden" name="dragged_jourprod" id="dragged_jourprods">
                    <input type="hidden" name="target_name" id="target_names">
                    <input type="hidden" name="target_inline" id="target_inlines">
                    <input type="hidden" name="target_nom_modele" id="target_nom_modeles">
                    <input type="hidden" name="target_quantity" id="target_quantitys">
                    <input type="hidden" name="target_id" id="target_ids">
                    <input type="hidden" name="target_idchaine" id="target_idchaines">
                    <input type="hidden" name="target_jourprod" id="target_jourprods">
                    <input type="hidden" name="target_column_name" id="target_column_names">
                    <input type="hidden" name="chaine_id" id="chain_ids">
                    <button type="button" class="btn btn-info" onclick="submitAddForm()">Ajouter</button>
                </form>
            </div>

        </div>
    </div>
</div>

@include('CRM.footer');

<script>
    let draggedItem = null;
    let dropTarget = null;

    function handleDragStart(event) {
        draggedItem = event.target;
    }

    function handleDrop(event) {
        event.preventDefault();
        dropTarget = event.target;

        // Check if the dropTarget is a valid kanban column
        if (!dropTarget.classList.contains('kanban-column')) {
            dropTarget = dropTarget.closest('.kanban-column');
        }

        // Exit if no valid drop target is found
        if (!dropTarget) {
            return;
        }

        // Retrieve dragged item data
        const draggedData = {
            name: draggedItem.querySelector('.kanban-header div:nth-child(1)').innerText,
            model: draggedItem.querySelector('.kanban-body div:nth-child(2)').innerText,
            quantity: draggedItem.querySelector('.kanban-body div:nth-child(3)').innerText,
            id: draggedItem.getAttribute('data-id'),
            inline: draggedItem.getAttribute('data-inline'),
            nomModele: draggedItem.getAttribute('data-nom-modele'),
            idchaine: draggedItem.getAttribute('data-chaine'),
            jourprod: draggedItem.getAttribute('data-jourprod')
        };

        // Retrieve target data with checks for children
        const targetItem = dropTarget.querySelector('.kanban-item');
        const targetData = targetItem ? {
            name: targetItem.querySelector('.kanban-header div:nth-child(1)').innerText,
            model: targetItem.querySelector('.kanban-body div:nth-child(2)').innerText,
            quantity: targetItem.querySelector('.kanban-body div:nth-child(3)').innerText,
            id: targetItem.getAttribute('data-id'),
            inline: targetItem.getAttribute('data-inline'),
            nomModele: targetItem.getAttribute('data-nom-modele'),
            idchaine: targetItem.getAttribute('data-chaine'),
            jourprod: targetItem.getAttribute('data-jourprod')
        } : {
            name: "",
            model: "",
            quantity: "",
            id: "",
            inline: "",
            nomModele: "",
            idchaine: "",
            jourprod: ""
        };
        if (draggedData.id === targetData.id) {
            alert('Vous ne pouvez pas déplacer un élément avec le même modele.');
            return; // Cancel the drop action
        }
        // Populate the hidden fields with the data
        document.getElementById('dragged_name').value = draggedData.name;
        document.getElementById('dragged_inline').value = draggedData.inline;
        document.getElementById('dragged_nom_modele').value = draggedData.nomModele;
        document.getElementById('dragged_quantity').value = draggedData.quantity;
        document.getElementById('dragged_id').value = draggedData.id;
        document.getElementById('dragged_idchaine').value = draggedData.idchaine;
        document.getElementById('dragged_jourprod').value = draggedData.jourprod;
        document.getElementById('target_name').value = targetData.name;
        document.getElementById('target_inline').value = targetData.inline;
        document.getElementById('target_nom_modele').value = targetData.nomModele;
        document.getElementById('target_quantity').value = targetData.quantity;
        document.getElementById('target_id').value = targetData.id;
        document.getElementById('target_idchaine').value = targetData.idchaine;
        document.getElementById('target_jourprod').value = targetData.jourprod;
        document.getElementById('target_column_name').value = dropTarget.closest('table').querySelector(
            'th:nth-child(' + (Array.from(dropTarget.parentNode.children).indexOf(dropTarget) + 1) + ')').innerText;
        document.getElementById('chain_id').value = dropTarget.closest('tr').querySelector('td:first-child').innerText;
        //ajout
        document.getElementById('dragged_names').value = draggedData.name;
        document.getElementById('dragged_inlines').value = draggedData.inline;
        document.getElementById('dragged_nom_modeles').value = draggedData.nomModele;
        document.getElementById('dragged_quantitys').value = draggedData.quantity;
        document.getElementById('dragged_ids').value = draggedData.id;
        document.getElementById('dragged_idchaines').value = draggedData.idchaine;
        document.getElementById('dragged_jourprods').value = draggedData.jourprod;
        document.getElementById('target_names').value = targetData.name;
        document.getElementById('target_inlines').value = targetData.inline;
        document.getElementById('target_nom_modeles').value = targetData.nomModele;
        document.getElementById('target_quantitys').value = targetData.quantity;
        document.getElementById('target_ids').value = targetData.id;
        document.getElementById('target_idchaines').value = targetData.idchaine;
        document.getElementById('target_jourprods').value = targetData.jourprod;
        document.getElementById('target_column_names').value = dropTarget.closest('table').querySelector(
            'th:nth-child(' + (Array.from(dropTarget.parentNode.children).indexOf(dropTarget) + 1) + ')').innerText;
        document.getElementById('chain_ids').value = dropTarget.closest('tr').querySelector('td:first-child').innerText;

        // Show the confirmation modal
        $('#confirmModal').modal('show');
    }

    function submitExchangeForm() {
        document.getElementById('exchangeForm').submit();
    }

    function submitAddForm() {
        document.getElementById('addForm').submit();
    }



    // Attachez les événements aux éléments kanban
    document.querySelectorAll('.kanban-item').forEach(item => {
        item.addEventListener('dragstart', handleDragStart);
    });

    document.querySelectorAll('.kanban-column').forEach(column => {
        column.addEventListener('dragover', event => event.preventDefault());
        column.addEventListener('drop', handleDrop);
    });
</script>

<script>
    function showKanbanModal(element) {
        var capacite;

        // Map data attributes to modal fields
        document.getElementById("nomModele").innerText = element.getAttribute("data-nom-modele");
        document.getElementById("inline").innerText = element.getAttribute("data-inline");
        document.getElementById("chaine").innerText = element.getAttribute("data-chaine");
        document.getElementById("jourProd").innerText = element.getAttribute("data-jourprod");
        document.getElementById("smvProd").innerText = element.getAttribute("data-smv-prod");
        document.getElementById("nomClient").innerText = element.getAttribute("data-nom-client");
        document.getElementById("qte").innerText = element.getAttribute("data-qte");
        document.getElementById("iddemande").innerText = element.getAttribute("data-id");
        document.getElementById("efficience").innerText = element.getAttribute("data-efficience");
        document.getElementById("effectif").innerText = element.getAttribute("data-effectif");
        document.getElementById("etdRevise").innerText = element.getAttribute("data-etd-revise");
        document.getElementById("etdInitial").innerText = element.getAttribute("data-etd-initial");
        document.getElementById("tissusMax").innerText = element.getAttribute("data-tissus-max");
        document.getElementById("tissusPrev").innerText = element.getAttribute("data-tissus-prev");
        document.getElementById("tissusReelle").innerText = element.getAttribute("data-tissus-reelle");
        document.getElementById("accessoireMax").innerText = element.getAttribute("data-accessoire-max");
        document.getElementById("accessoirePrev").innerText = element.getAttribute("data-accessoire-prev");
        document.getElementById("accessoireReelle").innerText = element.getAttribute("data-accessoire-reelle");
        document.getElementById("inlinechacun").innerText = element.getAttribute("data-inline-chacun");
        document.getElementById("okProd").innerText = element.getAttribute("data-ok-prod");

        // Show modal
        $('#inlinechacun').val(element.getAttribute("data-inline-chacun"));
        $('#iddemande').val(element.getAttribute("data-id"));
        $('#efficiences').val(element.getAttribute("data-efficience"));
        $('#efficiencereel').val(element.getAttribute("data-efficience-reel"));
        $('#effectif').val(element.getAttribute("data-effectif"));
        $('#heuretravail').val(element.getAttribute("data-heuretravail"));
        $('#capacitereel').val(element.getAttribute("data-capacitereel"));
        $('#smvprods').val(element.getAttribute("data-smv-prod"));
        $('#smvfinitions').val(element.getAttribute("data-smv-finition"));
        $('#id_chaine').val(element.getAttribute("data-idchaine"));
        $('#id_data_prod').val(element.getAttribute("data-iddataprod"));
        $('#qtereel').val(element.getAttribute("data-qtereel"));
        // Show modal
        $('#inlinechacuns').val(element.getAttribute("data-inline-chacun"));
        $('#iddemandes').val(element.getAttribute("data-id"));
        $('#efficiencess').val(element.getAttribute("data-efficience"));
        $('#effectifs').val(element.getAttribute("data-effectif"));
        $('#heuretravails').val(element.getAttribute("data-heuretravail"));
        $('#capacitereels').val(element.getAttribute("data-capacitereel"));
        $('#smvprodss').val(element.getAttribute("data-smv-prod"));
        $('#smvfinitionss').val(element.getAttribute("data-smv-finition"));
        $('#id_chaines').val(element.getAttribute("data-idchaine"));
        $('#id_data_prods').val(element.getAttribute("data-iddataprod"));
        $('#qtereels').val(element.getAttribute("data-qtereel"));

        // Calculate capacity
        var efficience = parseFloat($('#efficiences').val()) || 0; // Convert to float, default to 0
        var effectif = parseFloat($('#effectif').val()) || 0; // Convert to float, default to 0
        var heureTravail = parseFloat($('#heuretravail').val()) || 0; // Convert to float, default to 0
        var smvprod = parseFloat(element.getAttribute("data-smv-prod")) || 0; // Convert to float, default to 0
        var smvfinition = parseFloat(element.getAttribute("data-smv-finition")) || 0; // Convert to float, default to 0
        if (smvprod + smvfinition !== 0) {
            capacite = ((efficience/100) * effectif * heureTravail * 60) / (smvprod + smvfinition); // Calculate capacity
        } else {
            capacite = 0;
        }
        capacite = capacite.toFixed(2);
        // Update the capacity display in the modal
        document.getElementById("capacite").innerText = capacite; // Display capacity

        // Show the modal
        $('#kanbanModal').modal('show');

    }
</script>

<script>
    var datenontravail = @json($datenontravail);
</script>

<script>
    $(document).ready(function() {
        // Lorsque le modal est fermé
        $('#dateModal').on('hidden.bs.modal', function() {
            // Réinitialiser la valeur du champ de la date
            $('#selectedDate').val('');

            // Décochez toutes les cases à cocher
            $('input[name="chaines[]"]').prop('checked', false);

            // Réinitialiser le message de statut
            $('#statusMessage').text('');
        });

        $('.date-header').on('click', function() {
            var fullDate = $(this).text().trim();
            var dateOnly = fullDate.split(': ')[1];

            if (dateOnly) {
                // Formater la date comme YYYY-MM-DD
                var dateParts = dateOnly.split('-');
                var formattedDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];

                $('#selectedDate').val(formattedDate); // Définir la date dans l'input
                $('#dateModal').modal('show'); // Afficher la modal

                // Comparer selectedDate avec les dates non travaillées
                var selectedDate = new Date(formattedDate);

                // Convertir selectedDate en format YYYY-MM-DD
                var selectedDateFormatted = selectedDate.toISOString().split('T')[
                0]; // Format YYYY-MM-DD

                // Boucle pour comparer chaque date dans datenontravail et associer les id_chaine
                var isMatchingDate = false;
                var matchingIds = [];
                datenontravail.forEach(function(entry) {
                    // Comparer les dates en format YYYY-MM-DD
                    if (selectedDateFormatted === entry.date_non_travail) {
                        isMatchingDate = true; // Si une correspondance est trouvée
                        matchingIds.push(entry.id_chaine); // Ajouter l'id_chaine correspondant
                    }
                });

                if (isMatchingDate) {
                    // Si la date est égale à une date non travaillée, coche les checkboxes correspondantes
                    matchingIds.forEach(function(idChaine) {
                        // Cocher la checkbox correspondant à cet id_chaine
                        $('input[name="chaines[]"][value="' + idChaine + '"]').prop('checked',
                            true);
                    });

                    // Afficher "Terminé"
                    $('#statusMessage').text('Terminé').css('color', 'green');
                } else {
                    // Si la date ne correspond pas, coche le checkbox à la position 4 (exemple)
                    {{--  $('input[name="chaines[]"]').eq(4).prop('checked', true);  --}}

                    // Afficher "Retard"
                    $('#statusMessage').text('Retard').css('color', 'red');
                }
            }
        });

        // Sélectionner tous les checkboxes
        $('#selectAll').on('click', function() {
            $('input[name="chaines[]"]').prop('checked', true); // Coche tous les checkboxes
        });

        // Désélectionner tous les checkboxes
        $('#deselectAll').on('click', function() {
            $('input[name="chaines[]"]').prop('checked', false); // Décoche tous les checkboxes
        });
    });
</script>
