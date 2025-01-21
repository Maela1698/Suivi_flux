<title>Update Pri</title>
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
        <div class="row" style="margin-left: 60px;">
            <div class="card col-md-12">
                <div class="card-header d-flex justify-content-between align-items-center entete">
                    <h3 class="entete">MODIFIER PRI</h3>
                </div>
                @if (count($pri) != 0)
                    <div class="card-body">
                        <form action="{{ route('CRM.modifPri') }}" method="post">
                            @csrf
                            <input type="hidden" name="idStadeDemandeClient" value="{{ $demande[0]->id_stade }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="couleur" class="col-form-label" style="color: black;">Demande
                                            client: {{ $demande[0]->nom_modele }}--{{ $demande[0]->type_stade }}
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-3">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="couleur" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Prix</label>
                                        <input type="text" class="form-control" id="couleur" name="prix"
                                            value="{{ $pri[0]->prix }}">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="utilisation" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Unite Monetaire</label>

                                        <select class="form-control" name="uniteMonetaire" required>
                                            <option value="{{ $pri[0]->id_unite_monetaire }}">{{ $pri[0]->unite }}</option>
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
                                        <textarea name="commentaire" style="width: 100%; resize: both;">{{ $pri[0]->commentaire }}</textarea>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                    <a href="{{ route('CRM.pri') }}" class="btn btn-info mr-3">Retour</a>
                                    <button type="submit" class="btn btn-success mr-3"
                                        style="height: 35px;">Modifier</button>

                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <p>Il n'y a pas de pri</p>
                    <form action="pri" method="get">
                        <button type="submit" class="btn btn-info">Retour</button>
                    </form>
                @endif

            </div>


        </div>

    </div>

    <!-- Modale de confirmation -->

</div>
</div>
<!-- #/ container -->
</div>

@include('CRM.footer')
