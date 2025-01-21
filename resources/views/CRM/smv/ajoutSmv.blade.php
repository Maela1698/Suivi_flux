<title>AjoutSmv</title>
<style>
    .entete {
        color: #7571f9;
        /* Ajuster la couleur du texte si n�cessaire */
        background-color: white;
    }

    .carte {
        color: white;
        /* Ajuster la couleur du texte si n�cessaire */
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
        flex: 0 0 19%;
        /* R�partir en quatre colonnes */
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
        /* R�initialiser les marges du label */
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
        /* Couleur de la fl�che */
    }
</style>

<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

@include('CRM.header')
@include('CRM.sidebar')


<div class="content-body">
    <div class="container-fluid mt-3">
        @include('CRM.headerCrm')
        <div class="row">

            <div class="card col-md-12" >
                <div class="card-header d-flex justify-content-between align-items-center entete">
                    <h3 class="entete">AJOUT SMV</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('CRM.insertSmv') }}" method="post">
                        @csrf
                        @if (count($smv) != 0)
                            <input type="hidden" name="idStadeDemandeClient" value="{{ $idStade }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="smvprod" class="col-form-label" style="color: black;">Demande
                                            client: {{ $demande[0]->nom_modele }}--{{ $demande[0]->type_stade }}</label>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="smvprod" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">SMV Prod(minutes)</label>
                                        <input type="text" class="form-control" id="smvprod" name="smvprod"
                                            value="{{ $smv[0]->smv_prod }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="smvfinition" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">SMV Finition(minutes)</label>
                                        <input type="text" class="form-control" id="smvfinition" name="smvfinition"
                                            value="{{ $smv[0]->smv_finition }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="smvfinition" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Heure Broad Main</label>
                                        <input type="text" class="form-control" id="smvfinition" name="broadMain"
                                            value="{{ $smv[0]->smv_brod_main }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="couleur" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Nombre des Points</label>
                                        <input type="text" class="form-control" id="couleur" name="nbPoints"
                                            value="{{ $smv[0]->nombre_points }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="couleur" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Prix Print</label>
                                        <input type="text" class="form-control" id="couleur" name="prix"
                                            value="{{ $smv[0]->prix_print }}">
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="utilisation" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Unite Monetaire</label>

                                        <select class="form-control" name="uniteMonetaire" required>
                                            @foreach ($unitemonetaire as $um)
                                                <option value="{{ $um->id }}">{{ $um->unite }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="utilisation" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Commentaire</label>
                                        <textarea name="commentaire" style="width: 100%; resize: both;">{{ $smv[0]->commentaire }}</textarea>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                    <a href="{{ route('CRM.smv') }}" class="btn btn-info mr-3">Retour</a>
                                    <button type="submit" class="btn btn-success mr-3">Ajouter</button>

                                </div>
                            </div>
                        @else
                            <input type="hidden" name="idStadeDemandeClient" value="{{ $idStade }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="smvprod" class="col-form-label" style="color: black;">Demande
                                            client:
                                            {{ $demande[0]->nom_modele }}--{{ $demande[0]->type_stade }}</label>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="smvprod" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">SMV Prod(minutes)</label>
                                        <input type="text" class="form-control" id="smvprod" name="smvprod"
                                            value="0">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="smvfinition" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">SMV Finition(minutes)</label>
                                        <input type="text" class="form-control" id="smvfinition"
                                            name="smvfinition" value="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="smvfinition" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Heure Broad Main</label>
                                        <input type="text" class="form-control" id="smvfinition" name="broadMain"
                                            value="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="couleur" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Nombre des Points</label>
                                        <input type="text" class="form-control" id="couleur" name="nbPoints"
                                            value="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="couleur" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Prix Print</label>
                                        <input type="text" class="form-control" id="couleur" name="prix"
                                            value="0">
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="utilisation" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Unite Monetaire</label>

                                        <select class="form-control" name="uniteMonetaire" required>
                                            @foreach ($unitemonetaire as $um)
                                                <option value="{{ $um->id }}">{{ $um->unite }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="utilisation" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Commentaire</label>
                                        <textarea name="commentaire" style="width: 100%; resize: both;"></textarea>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                    <a href="{{ route('CRM.smv') }}" class="btn btn-info mr-3">Retour</a>
                                    <button type="submit" class="btn btn-success mr-3">Ajouter</button>

                                </div>
                            </div>
                        @endif
                    </form>
                </div>


            </div>
        </div>
    </div>

    <!-- Modale de confirmation -->


</div>
</div>
<!-- #/ container -->
</div>

<script>
    document.getElementById('retourButton').addEventListener('click', function() {
        // Modifie la valeur du bouton pour "Retour"
        var form = document.querySelector('form');
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'action';
        input.value = 'retour';
        form.appendChild(input);

        // Soumet le formulaire
        form.submit();
    });
</script>


@include('CRM.footer')
