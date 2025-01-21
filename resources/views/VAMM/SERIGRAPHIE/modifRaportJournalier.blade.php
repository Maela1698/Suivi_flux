@include('CRM.header')
@include('CRM.sidebar')
<title>ListerapportJournalier</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .table th {
        color: #000000;
        /* Couleur noire intense */
        font-weight: bold;
        /* Optionnel : Rend le texte plus épais */
    }

    .table td {
        color: #828282;
        /* Couleur noire intense */
        font-weight: bold;
        /* Optionnel : Rend le texte plus épais */
    }
</style>


<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('VAMM.headerVAMM')

        <div class="row">
            <div class="card col-12">

                <div class=" justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">MODIFICATION RAPPORT JOURNALIER SERIGRAPHIE</h3>
                </div>
                <form action="SERIGRAPHIE.updateRapportJournalier" method="POST"
                autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-12 mt-1">
                        <div class="row no-gutters">
                            <div class="col-12">
                                <label class="col-form-label texte">Date de prod</label>
                            </div>
                            <div class="col-6">
                                <input type="hidden" name="id" value="{{ $rapport[0]->id }}">
                                <input type="datetime-local" name="dateProd" class="form-control" value="{{ $rapport[0]->date_pro }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row no-gutters mt-3">
                            <div class="col-5 mr-2">
                                <label class="texte">Taux retouche(%)</label><br>
                                <input type="text" class="form-control" name="retouche" value="{{ $rapport[0]->taux_retouche }}" required>
                            </div>
                            <div class="col-5 ">
                                <label class="texte">Taux rejet(%)</label><br>
                                <input type="text" name="rejet" class="form-control" value="{{ $rapport[0]->taux_rejet }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row no-gutters mt-3">
                            <div class="col-5 mr-2">
                                <label class="texte">Produit chimique(g)</label><br>
                                <input type="text" class="form-control" name="chimique" value="{{ $rapport[0]->produit_chmique }}">
                            </div>
                            <div class="col-5">
                                <label class="texte">Valeur(Euro)</label><br>
                                <input type="text" name="valeur" class="form-control" value="{{ $rapport[0]->valeur }}"  required>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row no-gutters mt-3">
                            <div class="col-5 mr-2">
                                <label class="texte">Electricité </label><br>
                                <input type="text" class="form-control" value="{{ $rapport[0]->electricite }}" name="electricite">
                            </div>
                            <div class="col-5">
                                <label class="texte">Reclam loading</label><br>
                                <input type="text" name="reclam" class="form-control" value="{{ $rapport[0]->reclam_loading }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row no-gutters mt-3">
                            <div class="col-5 mr-2">
                                <label class="texte">NC traités </label><br>
                                <input type="text" class="form-control" name="ncTraite" value="{{ $rapport[0]->nc_traite }}">
                            </div>
                            <div class="col-5">
                                <label class="texte">Absentéisme</label><br>
                                <input type="text" name="absenteisme" class="form-control" value="{{ $rapport[0]->absenteisme }}" >
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row no-gutters mt-3">
                            <div class="col-5 mr-2">
                                <label class="texte">Commentaire</label><br>
                                <input type="text" class="form-control" name="commentaire" value="{{ $rapport[0]->commentaire }}">
                            </div>
                            <div class="col-5">
                                <label class="texte">Nb opérateur</label><br>
                                <input type="text" name="nbOperateur" class="form-control" value="{{ $rapport[0]->nb_operateur }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div id="formContainer">
                            <div class="row no-gutters mt-3 form-row">
                                <div class="col-4 mr-1">
                                    <label class="texte">Heure</label><br>
                                    <input type="text" class="form-control" name="heure[]"
                                           value="{{ $detailRapport[count($detailRapport)-1]->heure + 1 }}" readonly>
                                </div>
                                <div class="col-4 mr-1">
                                    <label class="texte">Quantite</label><br>
                                    <input type="text" class="form-control" name="qte[]" value="0">
                                </div>
                                <div class="col-1">
                                    <label style="color: transparent">Quantite</label><br>
                                    <button class="btn btn-success add-btn" type="button">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    @for ($i = 0; $i < count($detailRapport); $i++)
                    <div class="col-12">
                        <div class="row no-gutters mt-3 form-row">
                            <div class="col-4 mr-1">
                                <label class="texte">Heure</label><br>
                                <input type="number" class="form-control" name="heures[]"
                                       value="{{ $detailRapport[$i]->heure }}" readonly>
                            </div>
                            <div class="col-4 mr-1">
                                <label class="texte">Quantite</label><br>
                                <input type="number" class="form-control" name="qtes[]"
                                       value="{{ $detailRapport[$i]->qte }}">
                            </div>
                        </div>
                    </div>
                    @endfor



                </div>

                <div class="modal-footer mt-3">
                    <a href="{{ route('SERIGRAPHIE.listeRapportJournalier') }}" class="btn btn-secondary mr-3">Retour</a>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </form>


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
        let formContainer = document.getElementById('formContainer');
        let lastHeure = {{ count($detailRapport) > 0 ? $detailRapport[count($detailRapport)-1]->heure : 0 }}; // La dernière heure confirmée ou 0 si vide
        let heureValue = lastHeure + 1; // Commence à la dernière heure + 1 ou 1 si vide

        // Fonction pour ajuster les heures après ajout ou suppression
        function adjustHeureValues() {
            const formRows = formContainer.querySelectorAll('.form-row');
            formRows.forEach((row, index) => {
                const heureInput = row.querySelector('input[name="heure[]"]');
                heureInput.value = index + lastHeure + 1; // Réajuster la valeur de l'heure en fonction de l'index et lastHeure
            });
            heureValue = formRows.length + lastHeure; // Mettre à jour heureValue avec le nombre total de lignes actuelles
        }

        // Fonction pour ajouter une nouvelle ligne
        function addNewRow() {
            heureValue++; // Incrémenter la valeur de l'heure
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'no-gutters', 'mt-3', 'form-row');
            newRow.innerHTML = `
                <div class="col-4 mr-1">
                    <label class="texte">Heure</label><br>
                    <input type="number" class="form-control" name="heure[]" value="${heureValue}" readonly>
                </div>
                <div class="col-4 mr-1">
                    <label class="texte">Quantite</label><br>
                    <input type="number" class="form-control" name="qte[]" value="0">
                </div>
                <div class="col-2">
                </div>
            `;

            formContainer.appendChild(newRow);

            // Attacher l'événement pour supprimer la ligne
            const removeButton = newRow.querySelector('.remove-btn');
            removeButton.addEventListener('click', function() {
                formContainer.removeChild(newRow);
                adjustHeureValues(); // Réajuster les heures après suppression
            });
        }

        // Attacher l'événement pour ajouter une nouvelle ligne lors du clic sur le bouton "plus"
        document.querySelector('.add-btn').addEventListener('click', function(e) {
            e.preventDefault(); // Empêche la soumission du formulaire
            addNewRow();
        });
    });
</script>
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
