@include('CRM.header')
@include('CRM.sidebar')

<style>
    #suggestionsList {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }

    #suggestionsListTiers {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
        z-index: 5000;
        position: absolute;
        /* Permet de positionner l'élément par rapport à son conteneur */
        background-color: #fff;
        border: 1px solid #ccc;
        width: 100%;
        /* Assure que la largeur de la liste correspond à celle du champ */
        top: 100%;
        /* Place la liste juste en dessous du champ */
        left: 0;
        /* Aligne la liste avec le champ */
    }
</style>
<style>
    .entete {

        color: #7571f9;
        /* Ajuster la couleur du texte si n�cessaire */
    }

    .card-small {
        height: 110px;
        /* Ajustez cette valeur selon vos besoins */
        padding: 10px;
    }

    .card-small .card-title {
        font-size: 1.3rem;
        /* Taille de la police du titre */
    }

    .card-small h2 {
        font-size: 2rem;
        /* Taille de la police du chiffre */
    }

    .card-small .display-5 {
        font-size: 2.2rem;
        /* Taille de l'ic�ne */
        opacity: 0.5;
        /* Garder l'opacit� comme avant */
    }


    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        transform: translate3d(0, 0, 0);
        will-change: transform;
        display: none;
    }

    .texte {
        color: black;
    }
</style>

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

<style>
    /* Style par défaut du bouton */
    .custom-btn {
        transition: background-color 0.2s ease;
        /* Animation douce */
    }

    /* Style lorsque le bouton est survolé */
    .custom-btn:hover {
        background-color: #5b5b5b;
        /* Couleur light */
        color: #d9d9d9;
        /* Texte sombre pour contraster */
    }
</style>
<!--**********************************
            Content body start
    ***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerBc')
        <div class="col-lg-12">
            <center>
            <div class="card" style="border-radius: 10px;width: 90%;margin-left: -31.5px;">
                <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                    <h3 class="entete">HISTORIQUE DE RECLAMATION</h3>
                    <form action="/detailreclamation" method="get">
                        @csrf
                        <button class="btn btn-info" style="margin-right: 15px;">Retour</button>
                    </form>
                </div>
                <br>
                <div class="card-body" style="margin-top: -15px;">
                    <div class="table-responsive">
                        <table class="table table-hover" style="overflow-x: auto; display: block; white-space: nowrap;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Date envoie</th>
                                    <th>Date relance</th>
                                    <th>Raison</th>
                                    <th>Qte à réclamer</th>
                                    <th>Qte compensée</th>
                                    <th>Remarque</th>
                                    <th>Retour</th>
                                    <th>Note</th>
                                    <th>Unite</th>
                                    <th>Vlr réclamé</th>
                                    <th>Vlr compensé</th>
                                    <th>Rst à réclamé</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donnehistorique as $d)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($d->dateenvoie)->locale('fr')->translatedFormat('j/m/y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->daterelance)->locale('fr')->translatedFormat('j/m/y') }}</td>
                                    <td>{{ $d->raison }}</td>
                                    <td>{{ $d->quantite }}</td>
                                    <td>{{ $d->recompensation }}</td>
                                    <td>{{ $d->remarque }}</td>
                                    <td>{{ $d->retour }}</td>
                                    <td>{{ $d->note }}</td>
                                    <td>{{ $d->unite }}</td>
                                    <td>{{ $d->valeurreclame }}</td>
                                    <td>{{ $d->valeurcompense }}</td>
                                    <td>{{ $d->reste }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </center>
        </div>
    </div>
</div>
@include('CRM.footer')
