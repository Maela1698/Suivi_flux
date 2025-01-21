@include('CRM.header')
@include('CRM.sidebar')
<title>UpdateFDCAccy</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .form-control {
        border: 1px solid #b5b5b5;
    }

    label {
        color: #767575;
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
<style>
    .custom-tooltip .tooltip-inner {
        background-color: #f8d7da;
        /* Couleur de fond */
        color: #721c24;
        /* Couleur du texte */
        font-size: 16px;
        /* Taille du texte */
        padding: 10px;
        /* Espacement */
    }

    .custom-tooltip .arrow::before {
        border-top-color: #f8d7da;
        /* Couleur de la flèche */
    }

    .checkbox {
        display: grid;
        grid-template-columns: repeat(20, auto);
        /* 10 colonnes */
        gap: 10px;
        /* Espace entre les checkboxes */
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        /* Aligne les éléments au centre verticalement */
        font-size: 12px;
        /* Ajustez la taille de la police si nécessaire */
    }

    .checkbox input {
        margin-right: 5px;
        /* Espace entre la case à cocher et le texte */
    }
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="row">
            <div class="card col-12">
                <div class="card-header d-flex justify-content-between align-items-center entete">
                    <h3 class="entete">MODIFICATION CONSO ACCESSOIRE</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('CRM.modifConsoAccy') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <input type="hidden" name="idAccessoire" value="{{ $accessoire[0]->id }}">

                        <div class="form-group">
                            <!-- Bouton Tout sélectionner -->
                            <button type="button" id="select-all" class="btn btn-primary btn-sm">Tout
                                sélectionner</button>
                            <button type="button" id="deselect-all" class="btn btn-secondary btn-sm">Tout
                                désélectionner</button>
                        </div>

                        <div class="checkbox">
                            @for ($d = 0; $d < count($detailTaille); $d++)
                                <label class="checkbox-label">
                                    <input type="checkbox" name="taille[]"
                                        value="{{ $detailTaille[$d]->id_unite_taille }}">
                                    <span class="texte">{{ $detailTaille[$d]->unite_taille }}</span>
                                </label>
                            @endfor
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="couleur" class="col-form-label">Conso</label>
                                    <input type="text" class="form-control" id="couleur" name="conso">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="utilisation" class="col-form-label">Unite Mesure</label>
                                    <input type="text" class="form-control"
                                        value="{{ $accessoire[0]->unite_mesure }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="utilisation" class="col-form-label">Accessoire</label>
                                    <input type="text" class="form-control"
                                        value="{{ $accessoire[0]->type_accessoire }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="couleur" class="col-form-label">Famille</label>
                                    <input type="text" class="form-control"
                                        value="{{ $accessoire[0]->famille_accessoire }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-6">
                                <button type="submit" class="btn btn-success btn-block">
                                    Modifier
                                </button>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('CRM.formAjoutFDC') }}" class="btn btn-info mr-3">Retour</a>
                            </div>

                        </div>
                    </form>

                    <!-- Script JavaScript pour gérer la sélection/désélection de toutes les cases à cocher -->
                    <script>
                        document.getElementById('select-all').addEventListener('click', function() {
                            let checkboxes = document.querySelectorAll('input[name="taille[]"]');
                            checkboxes.forEach((checkbox) => {
                                checkbox.checked = true;
                            });
                        });

                        document.getElementById('deselect-all').addEventListener('click', function() {
                            let checkboxes = document.querySelectorAll('input[name="taille[]"]');
                            checkboxes.forEach((checkbox) => {
                                checkbox.checked = false;
                            });
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>


<!--**********************************
        modal start
***********************************-->


@include('CRM.parametre')


<!--**********************************
        javascript start
***********************************-->

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
