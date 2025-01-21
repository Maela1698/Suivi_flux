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
                    <h3 class="entete mt-3">AJOUT CONSO FIL</h3>
                </div>
                <div class="card-body">
                    @if (count($smv) != 0)
                        <form action="{{ route('BRODMAIN.ajoutConsoFil') }}" method="post" autocomplete="off">
                            @csrf

                            <div class="row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Nombre heure </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="nbHeure" value="{{ $smv[0]->smv_brod_main }}"
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
                                            <input type="text" name="prix" class="form-control" required>
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
                                                @for ($i = 0; $i < count($uniteMonetaire); $i++)
                                                    <option value="{{ $uniteMonetaire[$i]->id }}">
                                                        {{ $uniteMonetaire[$i]->unite }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

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
                                <a href="{{ route('BRODMAIN.listeConsoFil') }}" class="btn btn-info mr-3">Retour</a>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                        </form>
                    @else
                        <p>Merci d'informer le merchandiser de bien vouloir compléter la SMV pour cette demande avant
                            tout.</p>
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

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
