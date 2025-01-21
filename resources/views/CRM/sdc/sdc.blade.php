<style>
    .entete {
        color: #7571f9;
        background-color: white;
    }

    .carte {
        color: white;
        background-color: white;
    }

    .texte {
        color: black;
    }

    .table {
        color: black;
    }

    .button-group {
        display: flex;
        justify-content: space-around;
    }

    .button-group form {
        margin-right: 10px;
        /* Adjust spacing as needed */
    }

    .form-inline .form-group {
        margin-right: 5px;
        /* Reduce the margin between form fields */
    }

    .form-inline .form-control {
        padding-left: 5px;
        /* Adjust padding if needed */
        padding-right: 5px;
        /* Adjust padding if needed */
    }

    .form-group.mb-2,
    .form-group.mx-sm-1.mb-2 {
        margin-bottom: 0;
        /* Remove bottom margin to bring elements closer */
    }

    .form-inline .form-control-plaintext {
        margin-right: 5px;
        /* Reduce space after "Stade" label */
    }

    .form-inline select,
    .form-inline button {
        margin-left: 5px;
        /* Reduce space before select and button */
    }
</style>
@include('CRM.header')
@include('CRM.sidebar')

<div class="content-body">
    <div class="container-fluid mt-3">
        @include('CRM.headerCrm')
        <div class="card col-12 carte">
            <div class="justify-content-center align-items-center entete">
                <h3 class="entete mt-3">SAMPLE DEMANDE CLIENT </h3>

            </div>

            <div class="card-body" style="background-color: rgb(239, 238, 238); border-radius: 10px;">
                <center>  <h2>{{ $demande[0]->type_saison }}</h2></center>
                <div class="row mt-3" style="display: flex; align-items: center;">
                    <div class="col-md-2 mt-1">
                        <center>
                            <img src="data:image/png;base64,{{ $demande[0]->photo_commande }}"
                                class="img-fluid rounded-start mb-5" alt="Logo" width="120px" height="120px">
                        </center>
                    </div>
                    <div class="col-md-5">
                        <div class="card-body">
                            <p class="texte"><b>Date entrée :</b>
                                {{ \Carbon\Carbon::parse($demande[0]->date_entree)->format('d/m/y') }}</p>
                                <p class="texte"><b>Periode :</b> {{ $demande[0]->periode }}</p>
                            <p class="texte"><b>Client :</b> {{ $demande[0]->nomtier }}</p>
                            <p class="texte"><b>Modèle :</b>{{ $demande[0]->nom_modele }}</p>
                            <p class="texte"><b>Designation :</b>{{ $demande[0]->nom_style }}</p>
                            <p class="texte"><b>Thème :</b>{{ $demande[0]->theme }}</p>
                            <p class="texte"><b>Quantité prévisionnel
                                    :</b>{{ $demande[0]->qte_commande_provisoire }}</p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card-body">
                            <p class="texte">
                                <b>ETD:</b>{{ \Carbon\Carbon::parse($demande[0]->date_livraison)->format('d/m/y') }}
                            </p>
                            <p class="texte"><b>Stade :</b> {{ $demande[0]->type_stade }}</p>
                            <p class="texte"><b>Grille de taille
                                    :</b>{{ $demande[0]->taillemin }}--{{ $demande[0]->taillemax }}</p>
                            <p class="texte"><b>Taille de base :</b>{{ $demande[0]->taille_base }}</p>
                            <p class="texte"><b>Incontern :</b> {{ $demande[0]->type_incontern }}</p>
                            <p class="texte"><b>Phase :</b> {{ $demande[0]->type_phase }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="sdc" style="display: flex; align-items: center; justify-content: space-between;">
                    <div class="donne">
                        <form action="{{ route('CRM.ajoutSdc') }}" method="POST">
                            @csrf
                            <div class="champ" style="display: flex;align-items: center;">
                                <spant style="width:62px;"><input class="form-control" type="text" value="Stade"
                                        aria-label="Stade" style="border-color: black;" disabled readonly></spant>
                                <spant style="width:150px;">
                                    <select class="form-control" name="stade" style="border-color: black;" required>
                                        <option value="{{ $demande[0]->id_stade }}">{{ $demande[0]->type_stade }}</option>
                                        @foreach ($stades as $s)
                                            <option value="{{ $s->id }}">{{ $s->type_stade }}</option>
                                        @endforeach
                                    </select>
                                </spant>
                                <spant> <button type="submit" class="btn"
                                        style="background-color: #6c757d; color: #fff; border: none;">Ajout SDC</button>
                                </spant>
                            </div>
                        </form>
                    </div>
                    <div class="button-group">
                        <form action="{{ route('CRM.sdcApercue') }}" method="get">
                            <button type="submit" class="btn btn-info">Aperçue</button>
                        </form>
                        <form action='{{ route('CRM.updateSdc') }}' method='POST'>
                            @csrf
                            <button type="submit" class="btn btn-warning">Modifier</button>
                        </form>
                    </div>
                </div>
                <br>
                <br>
            </div>
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
@include('CRM.parametre')


<script>
    document.getElementById('settings-icon').addEventListener('mouseover', function() {
        document.getElementById('settings-menu').style.display = 'block';
    });

    document.getElementById('settings-menu').addEventListener('mouseleave', function() {
        document.getElementById('settings-menu').style.display = 'none';
    });
</script>


@include('CRM.footer')
