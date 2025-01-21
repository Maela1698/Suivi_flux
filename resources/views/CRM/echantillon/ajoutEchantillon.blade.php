<title>AjoutEchantillon</title>
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
                    <h3 class="entete">AJOUT ECHANTILLON</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('CRM.insertEchantillon') }}" method="post" autocomplete="off">
                        @csrf
                        @if (count($echantillon) == 0)
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

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="envoie" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Date Envoie</label>
                                        <input type="date" class="form-control" id="envoie" name="dateEnvoie">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="quantite" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Quantite</label>
                                        <input type="number" class="form-control" id="quantite" name="quantite">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="lieu" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Lieu de Destination</label>
                                        <input type="text" class="form-control" id="lieu" name="lieu">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="modeEnvoie" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Mode d'envoie</label>
                                        <input type="text" class="form-control" id="modeEnvoie" name="modeEnvoie">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-5">
                                    <label for="utilisation" class="col-form-label"
                                        style="color: rgb(105, 102, 102);">AWB</label>
                                    <input type="text" name="awb" class="form-control">
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="utilisation" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Commentaire</label>
                                        <textarea name="commentaire" class="form-control" style="width: 100%; resize: both;"></textarea>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">

                                    <button type="submit" class="btn btn-success mr-3"
                                        style="height: 35px;">Ajouter</button>
                                    <a href="{{ route('CRM.echantillon') }}" class="btn btn-info mr-3">Retour</a>
                                </div>
                            </div>
                        @else
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

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="envoie" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Date Envoie</label>
                                        <input type="date" class="form-control" id="envoie" name="dateEnvoie"
                                            value="{{ $echantillon[0]->date_envoie }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="quantite" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Quantite</label>
                                        <input type="number" class="form-control" id="quantite" name="quantite"
                                            value="{{ $echantillon[0]->quantite }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="lieu" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Lieu de Destination</label>
                                        <input type="text" class="form-control" id="lieu" name="lieu"
                                            value="{{ $echantillon[0]->lieu_destination }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="modeEnvoie" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Mode d'envoie</label>
                                        <input type="text" class="form-control" id="modeEnvoie" name="modeEnvoie"
                                            value="{{ $echantillon[0]->mode_envoie }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-5">
                                    <label for="utilisation" class="col-form-label"
                                        style="color: rgb(105, 102, 102);">AWB</label>
                                    <input type="text" name="awb" class="form-control"
                                        value="{{ $echantillon[0]->awb }}">
                                </div>
                                <div class="col-7">
                                    <div class="form-group">
                                        <label for="utilisation" class="col-form-label"
                                            style="color: rgb(105, 102, 102);">Commentaire</label>
                                        <textarea name="commentaire" class="form-control" style="width: 100%; resize: both;">{{ $echantillon[0]->commentaire }}</textarea>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                    <a href="{{ route('CRM.echantillon') }}" class="btn btn-info mr-3">Retour</a>
                                    <button type="submit" class="btn btn-success mr-3"
                                        style="height: 35px;">Ajouter</button>

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

<style>
    .fixed-top-right {
        position: fixed;
        top: 0;
        right: 0;
        margin-top: 160px;
        /* Optionnel, pour donner un petit espace par rapport au bord */
        margin-right: 25px;
        z-index: 1000;
        /* Assure que le div reste au-dessus des autres éléments */
    }

    .settings-icon {
        font-size: 1.5rem;
        /* Taille de l'icône */
        cursor: pointer;
        /* Curseur pointeur au survol */
        color: #495057;
        /* Couleur de l'icône */
        transition: transform 0.5s ease-in-out;
        /* Transition pour la rotation */
    }

    .settings-icon:hover {
        transform: rotate(180deg);
        /* Rotation au survol */
    }

    .custom-card {
        background-color: #343a40;
        /* Couleur de fond foncée */
        border-radius: 8px;
        /* Bordure arrondie */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Ombre pour un effet de relief */
        display: none;
        /* Caché par défaut */
        margin-top: 10px;
        /* Espacement entre l'icône et le menu */
    }

    .custom-card .btn {
        width: 100%;
        /* Assure que les boutons prennent toute la largeur */
        text-align: left;
        /* Aligne le texte et l'icône à gauche */
        color: #fff;
        /* Couleur du texte blanche */
        background-color: #495057;
        /* Couleur de fond des boutons */
        border: none;
        /* Supprime la bordure */
        transition: background-color 0.3s;
        /* Transition douce pour le changement de couleur */
    }

    .custom-card .btn:hover {
        background-color: #6c757d;
        /* Changement de couleur au survol */
    }

    .custom-card i {
        margin-right: 8px;
        /* Espace entre l'icône et le texte */
    }
</style>

<script>
    document.getElementById('settings-icon').addEventListener('mouseover', function() {
        document.getElementById('settings-menu').style.display = 'block';
    });

    document.getElementById('settings-menu').addEventListener('mouseleave', function() {
        document.getElementById('settings-menu').style.display = 'none';
    });
</script>


@include('CRM.footer')
