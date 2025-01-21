@include('CRM.header')
@include('CRM.sidebar')
<title>ListeDemandeBroadMain</title>

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

                <div class="d-flex justify-content-between align-items-center entete">
                    <h3 class="entete mt-3">CONSO FIL</h3>

                    <div class="ml-auto d-flex mr-5">
                        <form action="{{ route('BRODMAIN.formModifConsoFil') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-finish mt-1 btn-sm mr-2"
                                style="width: 90px;">
                                <i class="fas fa-edit"></i> Modifier
                            </button>
                        </form>
                        <form action="{{ route('BRODMAIN.formAjoutConsoFil') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success btn-finish mt-1 btn-sm" style="width: 80px;"
                                data-toggle="modal">
                                <i class="fas fa-plus"></i> Ajouter
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">

                    <div class="card-body" style="background-color: rgb(239, 238, 238); border-radius: 10px;">
                        <center>
                            <h2>{{ $demande[0]->type_saison }}</h2>
                        </center>
                        <div class="row mt-3" style="display: flex; align-items: center;">
                            <div class="col-md-2 mt-1">
                                <center>
                                    <img src="data:image/png;base64,{{ $demande[0]->photo_commande }}"
                                        class="img-fluid rounded-start mb-5" alt="Logo" width="120px"
                                        height="120px">
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

                    @if (count($conso) != 0)
                        <div class="table-responsive mt-4" style="margin-top: -15px;">
                            <p>Nombre heure:<b>{{ $conso[0]->nb_heure }}</b></p>
                            <p>Prix:<b>{{ $conso[0]->prix }} {{ $conso[0]->unite }}</b></p>
                            <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                                <thead>
                                    <tr>
                                        <th>Couleur</th>
                                        <th>Conso</th>
                                    </tr>
                                </thead>
                                <tbody style="cursor: pointer;">
                                    @for ($i = 0; $i < count($conso); $i++)
                                        <tr>
                                            <td>{{ $conso[$i]->couleur }}</td>
                                            <td>{{ $conso[$i]->conso }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>Nous vous informons que les consommations de fil n'ont pas encore été ajoutées à ce stade.
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



@include('VAMM.BROAD_MAIN.parametreBrodMain')

<!--**********************************
        javascript start
***********************************-->

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
