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
                    <h3 class="entete">LBT PLANNING</h3>
                </div>

                <table class="table table-bordered" style="text-align: center; background-color: white">
                    <thead class="thead" style="background-color: rgb(208, 208, 208);color: black;">
                        <tr>
                            @foreach ($dates as $date)
                                <th scope="col"
                                    class="date-header"
                                    id="th-charge-{{ $loop->index }}"
                                    data-info="Détails pour {{ $date }}"
                                    onclick="showModalForCharge(this)">
                                    100%
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <thead class="thead-dark">
                        <tr>
                            @foreach ($dates as $date)
                                <th scope="col" style="cursor: pointer;" class="date-header">
                                    {{ $date }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($dates as $date)
                                <td class="kanban-column" id="column-{{ $loop->index }}">
                                    <div class="kanban-item" id="item2"
                                        style="background-color: rgb(234, 234, 234); max-height: 80px; height: 80px;"
                                        draggable="true" ondragstart="drag(event)" onclick="showModalForQuantite(this)">
                                        <div class="kanban-header"
                                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: -5px; background-color: transparent; padding: 10px; border-radius: 5px; margin-top:-10px;">
                                            <div style="display: flex; align-items: center;">
                                                <i class="fas fa-user" style="margin-right: 5px; color: #ffc107;"></i>
                                                <div>nom_client_01</div>
                                            </div>
                                            <div style="display: flex; align-items: center;">
                                                <i class="fas fa-calendar"
                                                    style="margin-right: 5px; color: #28a745;"></i>
                                                <div>outline_01</div>
                                            </div>
                                        </div>
                                        <div class="kanban-body"
                                            style="display: flex; justify-content: space-between; align-items: center; background-color: transparent; padding: 10px; border-radius: 5px;">
                                            <div style="display: flex; align-items: center;">
                                                <i class="fas fa-clock" style="margin-right: 5px; color: #007bff;"></i>
                                                <div>heure_01</div>
                                            </div>
                                            <div style="display: flex; align-items: center;">
                                                <i class="fas fa-tag" style="margin-right: 5px; color: #17a2b8;"></i>
                                                <div>nom_modele_01</div>
                                            </div>
                                            <div style="display: flex; align-items: center;">
                                                <i class="fas fa-coins" style="margin-right: 5px; color: #dc3545;"></i>
                                                <div>quantite_01</div>
                                            </div>
                                        </div>
                                    </div>
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
                <h5 class="modal-title">Details Demande</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color: black">
                test
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
                charge
            </div>
        </div>
    </div>
</div>
@include('PLANNING.parametre');
@include('CRM.footer');

<!-- Include Sortable.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const columns = document.querySelectorAll('.kanban-column');
        columns.forEach(column => {
            new Sortable(column, {
                group: 'kanban',
                animation: 150,
                onStart: function (evt) {
                    evt.item.classList.add('dragging');
                },
                onEnd: function (evt) {
                    evt.item.classList.remove('dragging');

                    // Check if the number of items exceeds the limit
                    const itemsInColumn = evt.from.querySelectorAll('.kanban-item');
                    if (itemsInColumn.length > 3000) {
                        alert("Cette colonne ne peut contenir que 3 éléments.");
                        evt.from.appendChild(evt.item); // Return item to original position
                    } else {
                        // If the item is moved to a new column, check that column's item count
                        const targetColumnItems = evt.to.querySelectorAll('.kanban-item');
                        if (targetColumnItems.length > 3000) {
                            alert("Cette colonne ne peut contenir que 3 éléments.");
                            evt.from.appendChild(evt.item); // Return item to original position
                        }
                    }
                }
            });
        });
    });

    function drag(event) {
        event.dataTransfer.setData("text/plain", event.target.id); // Using "text/plain" for better compatibility
    }

    function drop(event) {
        event.preventDefault();
        const data = event.dataTransfer.getData("text/plain");
        const draggedElement = document.getElementById(data);

        // Ensure that the dragged element is valid
        if (!draggedElement) return;

        // Append the dragged element to the target column
        const targetColumn = event.target.closest('.kanban-column');
        if (targetColumn) {
            targetColumn.appendChild(draggedElement);
        }
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
    modalBody.innerHTML = `<p>${info}</p>`;

    // Affiche le modal
    $('#kanbanCharge').modal('show');
}

</script>
