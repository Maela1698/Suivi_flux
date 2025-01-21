@include('CRM.header')
@include('CRM.sidebar')
<title>NombrePointsBrodMachine</title>

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
                    <h3 class="entete mt-3">NOMBRE POINTS BROD MACHINE</h3>

                    <div class="ml-auto d-flex mr-5">


                        <button type="button" class="btn btn-warning btn-finish mt-1 btn-sm mr-2" style="width: 90px;"
                            data-toggle="modal" data-target="#modifNombrePoints" data-id="" data-iddemande="1">
                            <i class="fas fa-edit"></i> Modifier
                        </button>


                        @if (count($nombrePoints) == 0)
                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm" style="width: 90px;"
                                data-toggle="modal" data-target="#nombrePoints" data-id="" data-iddemande="1">
                                <i class="fas fa-plus"></i> Ajouter
                            </button>
                        @else
                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm" style="width: 90px;"
                                data-toggle="modal" data-target="#nombrePoints" data-id="" data-iddemande="1"
                                disabled>
                                <i class="fas fa-plus"></i> Ajouter
                            </button>
                        @endif



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

                    @if (count($nombrePoints) != 0)
                        <div class="table-responsive mt-4" style="margin-top: -15px;">
                            <p>Temps machine: <b>{{ $nombrePoints[0]->temps_machine }}</b></p>
                            <p>Temps nettoyage: <b>{{ $nombrePoints[0]->temps_nettoyage }}</b></p>
                            <p>Temps garnissage: <b>{{ $nombrePoints[0]->temps_garnissage }}</b></p>
                            <p>Somme nombre points: <b>{{ $nombrePoints[0]->somme_nb_points }}</b></p>
                            <p>SMV BMC: <b>{{ $nombrePoints[0]->smv }}</b></p>
                            <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                                <thead>
                                    <tr>
                                        <th>Taille</th>
                                        <th>Quantite</th>
                                        <th>Nombre de points</th>
                                        <th>Total nombre de points</th>
                                    </tr>
                                </thead>
                                <tbody style="cursor: pointer;">
                                    @for ($i = 0; $i < count($detailNbPoints); $i++)
                                        <tr>
                                            <td>{{ $detailNbPoints[$i]->taille }}</td>
                                            <td>{{ $detailNbPoints[$i]->quantite }}</td>
                                            <td>{{ $detailNbPoints[$i]->nombre_points }}</td>
                                            <td>{{ $detailNbPoints[$i]->nombre_points * $detailNbPoints[$i]->quantite }}
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>Nous vous informons que les nombres de points pour cette demande n'est pas encore insérer.
                        </p>
                    @endif

                </div>



            </div>
        </div>


        <!-- Modal ajout nombre points -->
        <div class="modal fade" id="nombrePoints" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg-custom" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Insertion nombre points</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('BRODMACHINE.insertNombrePointsBrodMachine') }}" method="POST"
                            autocomplete="off">
                            @csrf
                            <div class="row">

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-12">
                                            <label class="texte">Temps machine</label><br>
                                            <input type="text" class="form-control" name="tempsMachine">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-12">
                                            <label class="texte">Temps nettoyage</label><br>
                                            <input type="text" name="tempsNettoyage" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters mt-3">
                                        <div class="col-12">
                                            <label class="texte">Temps garnissage</label><br>
                                            <input type="text" name="tempsGarnissage" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Taille</th>
                                                    <th>Quantité</th>
                                                    <th>Nombre points</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < count($tailles); $i++)
                                                    <tr>
                                                        <td><input type="text" class="form-control"
                                                                name="taille[]"
                                                                value="{{ $tailles[$i]->unite_taille }}" readonly>
                                                        </td>
                                                        <td><input type="text" class="form-control"
                                                                name="quantite[]"
                                                                value="{{ $tailles[$i]->quantite }}" readonly></td>
                                                        <td><input type="text" class="form-control"
                                                                name="nbPoints[]" value="0" required></td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal modif nombre points -->
        <div class="modal fade" id="modifNombrePoints" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg-custom" role="document">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Modification nombre points</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if (count($nombrePoints) != 0)
                            <form action="{{ route('BRODMACHINE.updateNombrePointsBrodMachine') }}" method="POST"
                                autocomplete="off">
                                @csrf
                                <div class="row">

                                    <div class="col-12">
                                        <div class="row no-gutters mt-3">
                                            <div class="col-12">
                                                <label class="texte">Temps machine</label><br>
                                                <input type="text" class="form-control" name="tempsMachine"
                                                    value="{{ $nombrePoints[0]->temps_machine }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row no-gutters mt-3">
                                            <div class="col-12">
                                                <label class="texte">Temps nettoyage</label><br>
                                                <input type="text" name="tempsNettoyage" class="form-control"
                                                    value="{{ $nombrePoints[0]->temps_nettoyage }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row no-gutters mt-3">
                                            <div class="col-12">
                                                <label class="texte">Temps garnissage</label><br>
                                                <input type="text" name="tempsGarnissage" class="form-control"
                                                    value="{{ $nombrePoints[0]->temps_garnissage }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="table-responsive mt-3">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Taille</th>
                                                        <th>Quantité</th>
                                                        <th>Nombre points</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 0; $i < count($detailNbPoints); $i++)
                                                        <tr>
                                                            <td><input type="text" class="form-control"
                                                                    name="taille[]"
                                                                    value="{{ $detailNbPoints[$i]->taille }}"
                                                                    readonly>
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="quantite[]"
                                                                    value="{{ $detailNbPoints[$i]->quantite }}"
                                                                    readonly></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="nbPoints[]"
                                                                    value="{{ $detailNbPoints[$i]->nombre_points }}"
                                                                    required></td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <div class="modal-footer mt-3">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                </div>
                            </form>
                        @else
                            <p>Nous vous informons que les nombres de points pour cette demande n'est pas encore
                                insérer.
                            </p>
                        @endif

                    </div>
                </div>
            </div>
        </div>


    </div>
</div>


<!--**********************************
        modal start
***********************************-->


@include('VAMM.BROAD_MACHINE.parametreBrodMachine')

<!--**********************************
        javascript start
***********************************-->

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
