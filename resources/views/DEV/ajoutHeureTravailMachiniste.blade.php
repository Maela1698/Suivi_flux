@include('CRM.header')
@include('CRM.sidebar')
<title>AjoutHeureTravailMachiniste</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .card {
        color: black;
    }
</style>
<style>
    .entete {
        color: #7571f9;
        /* Ajuster la couleur du texte si nécessaire */
        background-color: white;
    }

    .carte {
        color: white;
        /* Ajuster la couleur du texte si nécessaire */
        background-color: white;
    }

    .texte {
        color: black;
    }

    .table {
        color: black;
    }

    .qte {
        height: 50px;
        width: 100px;
    }

    .checkbox-container {
        display: flex;
        flex-wrap: wrap;
    }

    .checkbox-item {
        flex: 0 0 10%;
        /* Répartir en quatre colonnes */
        margin: 1%;
        /* Espacement entre les checkboxes */
        box-sizing: border-box;
        /* Inclure les marges dans la taille totale */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        display: flex;
        align-items: center;
        color: black;
    }

    .checkbox-item input[type="checkbox"] {
        margin-right: 10px;
        /* Espacement entre le checkbox et le texte */
    }

    .checkbox-item label {
        margin: 0;
        /* Réinitialiser les marges du label */
    }

    .checkbox-item:hover {
        background-color: #e6f7ff;
        border-color: #007bff;
    }

    .requete {
        height: 100px;
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('DEV.headerDEV')
        <div class="row">
            <div class="card col-12">
                <div class="mb-5">
                    <div class="justify-content-center align-items-center entete">
                        <h3 class="entete mt-3">Saisie des Heures de Travail des Machiniste </h3>

                    </div>
                    <form action="{{ route('DEV.ajoutHeureTravailMachiniste') }}" method="POST">
                        @csrf
                        <div class="form-group mt-4">
                            <!-- Bouton Tout sélectionner -->
                            <button type="button" id="select-all" class="btn btn-primary btn-sm">
                                <i class="fas fa-check-square"></i> Tout sélectionner
                            </button>
                            <!-- Bouton Tout désélectionner -->
                            <button type="button" id="deselect-all" class="btn btn-secondary btn-sm">
                                <i class="fas fa-square"></i> Tout désélectionner
                            </button>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <label class="col-form-label" style="font-size: 20px">Nom machiniste </label>
                            </div>
                            <div class="checkbox col-12">
                                @for ($e = 0; $e < count($employeMach); $e++)
                                    <label class="checkbox-label d-block" style="margin-bottom: 10px;">
                                        <input type="checkbox" name="employe[]"
                                            value="{{ $employeMach[$e]->id }}">
                                        <span class="texte" style="margin-left: 8px; font-weight: bold;">
                                            {{ $employeMach[$e]->nom }} {{ $employeMach[$e]->prenom }}
                                        </span>
                                    </label>
                                @endfor
                            </div>

                        </div>


                        <div class="form-group row">
                            <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                <a href="{{ route('DEV.listeHeureTravailMachiniste') }}" class="btn btn-info mr-3">Retour</a>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>


        @if (session('error'))
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog"
            aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel">Présence déjà fait</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="texte">{{ session('error') }}</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    </div>
</div>


<!--**********************************
        modal start
***********************************-->




<!--**********************************
        javascript start
***********************************-->
<!-- Script JavaScript pour gérer la sélection/désélection de toutes les cases à cocher -->
<script>
    document.getElementById('select-all').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('input[name="employe[]"]');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = true;
        });
    });

    document.getElementById('deselect-all').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('input[name="employe[]"]');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = false;
        });
    });
</script>

<script>
    // Afficher automatiquement le modal si une erreur est présente
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            $('#errorModal').modal('show');
        @endif
    });
</script>
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
