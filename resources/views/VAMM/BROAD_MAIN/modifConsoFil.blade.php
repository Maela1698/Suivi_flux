@include('CRM.header')
@include('CRM.sidebar')
<title>ListeDemandeBroadMain</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .card-body {
        color: black;
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('VAMM.headerVAMM')

        <div class="row">
            <div class="card col-12">

                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">MODIFICATION CONSO FIL</h3>
                </div>
                <div class="card-body">
                    @if (count($conso) != 0)
                        <form action="{{ route('BRODMAIN.modifConsoFil') }}" method="post" autocomplete="off">
                            @csrf

                            <div class="row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Nombre heure </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="hidden" name="id" value="{{ $conso[0]->id_conso }}"
                                                class="form-control">
                                            <input type="text" name="nbHeure" value="{{ $conso[0]->nb_heure }}"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Prix </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="prix" class="form-control" value="{{ $conso[0]->prix }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Unité monétaire </label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="unite" required>
                                                <option value="{{ $conso[0]->id_unite_monetaire }}">{{ $conso[0]->unite }}</option>
                                                @for ($i = 0; $i < count($uniteMonetaire); $i++)
                                                    <option value="{{ $uniteMonetaire[$i]->id }}">
                                                        {{ $uniteMonetaire[$i]->unite }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div>
                                <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                                    <thead>
                                        <tr>
                                            <th>Couleur</th>
                                            <th>Conso(m)</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody style="cursor: pointer;">
                                        @foreach ($conso as $index => $item)
                                            <tr id="row-{{ $index }}">
                                                <td><input type="text" class="form-control" name="couleur[]" value="{{ $item->couleur }}" required></td>
                                                <td><input type="text" class="form-control" name="conso[]" value="{{ $item->conso }}" required></td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm" onclick="deleteRow({{ $index }})">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>



                            <div id="dynamic-form">
                                <div class="row mt-3">
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label">Couleur fil</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="couleur[]" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label">Conso(m)</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="conso[]" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label" style="color: transparent">Plus</label>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-success add-btn" type="button">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Modifier</button>
                            </div>
                        </form>
                    @else
                        <p>
                            Nous vous informons que les consommations de fil n'ont pas encore été ajoutées à ce stade.
                        </p>
                    @endif
                </div>


            </div>
        </div>
    </div>
</div>


<!--**********************************
        modal start
***********************************-->




<!--**********************************
        javascript start
***********************************-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dynamicForm = document.getElementById('dynamic-form');

        // Fonction pour ajouter une nouvelle ligne de formulaire
        function addRow() {
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mt-3');
            newRow.innerHTML = `
                <div class="col-4">
                    <div class="row no-gutters">
                        <div class="col-12">
                            <label class="col-form-label">Couleur fil</label>
                        </div>
                        <div class="col-12">
                            <input type="text" name="couleur[]" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="row no-gutters">
                        <div class="col-12">
                            <label class="col-form-label">Conso(m)</label>
                        </div>
                        <div class="col-12">
                            <input type="text" name="conso[]" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="row no-gutters">
                        <div class="col-12">
                            <label class="col-form-label" style="color: transparent">Supprimer</label>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-danger remove-btn" type="button">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            dynamicForm.appendChild(newRow);

            // Ajoute un écouteur d'événement pour le bouton "Supprimer"
            newRow.querySelector('.remove-btn').addEventListener('click', function() {
                dynamicForm.removeChild(newRow);
            });
        }

        // Ajoute un écouteur d'événement pour le bouton "Ajouter"
        document.querySelector('.add-btn').addEventListener('click', addRow);
    });
</script>

<script>
    function deleteRow(rowId) {
        // Sélectionner la ligne à supprimer
        var row = document.getElementById('row-' + rowId);

        // Vérifier si la ligne existe, puis la supprimer
        if (row) {
            row.remove();
        } else {
            console.error("La ligne n'a pas été trouvée : " + rowId);
        }

        // Si nécessaire, ajouter ici un appel AJAX pour supprimer l'élément du serveur
    }
</script>



<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
