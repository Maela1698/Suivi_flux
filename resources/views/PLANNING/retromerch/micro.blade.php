@include('CRM.header')
@include('CRM.sidebar')
<!--**********************************
            Content body start
        ***********************************-->
<style>
    .highlight-realisation {
        background-color: rgb(144, 238, 144);
        /* Vert pâle pour les lignes avec une réalisation */
    }
    .highlight-past-date {
        background-color: rgb(255, 139, 139);
        /* Couleur de fond pour la date passée */
    }

    .highlight-border {
        border-top: 5px solid rgb(0, 72, 255);
        /* Ajoutez la couleur et l'épaisseur souhaitées */
    }

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
        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 1050;
    }

    .texte {
        color: black;
    }

    .content-body {
        background-color: #0C275E;
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
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('PLANNING.headerPlan')

        <div class="row" style="display: flex; justify-content: space-between; flex-wrap: nowrap;">
            <div>
                <div class="card gradient-1 card-small"
                    style="border-radius: 28px 3px 28px 3px; background: linear-gradient(to right, #3a7bd5, #3a6073); width: 260px;">
                    <div class="card-body mb-5" style="margin-top: -10px; margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">CAPACITE</h3>
                        <div class="d-inline-block mb-5">
                            <h2 class="text-white">{{ number_format($capacite, 0, ' ', ' ') }}</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-database" style="color: white;"></i></span>

                    </div>
                </div>
            </div>

            <div>
                <div class="card gradient-2 card-small"
               style="border-radius: 28px 3px 28px 3px; background: linear-gradient(to right, #f87d2b, #276a87);width: 260px;">
                    <div class="card-body mb-5" style="margin-top: -10px; margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">PLANNING</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ number_format($total, 0, ' ', ' ') }}</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-calendar-alt" style="color: white;"></i></span>

                    </div>
                </div>
            </div>

            <div>
                <div class="card card-small"
                style="border-radius: 28px 3px 28px 3px; background: linear-gradient(to right, #e13a4e, #556770);width: 260px;">
                    <div class="card-body mb-5" style="margin-top: -10px; margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">%CHARGE</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ number_format($charge, 2, ',', ' ') }}%</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-tasks" style="color: white;"></i></span>

                    </div>
                </div>
            </div>

            <div>
                <div class="card gradient-4 card-small"
                    style="border-radius: 28px 3px 28px 3px; background: linear-gradient(to right, #16a085, #f4d03f);width: 260px;">
                    <div class="card-body mb-5" style="margin-top: -10px; margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">REEL PRODUITE</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ number_format($totalreelle, 0, ' ', ' ') }}</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-industry" style="color: white;"></i></span>

                    </div>
                </div>
            </div>

            <div>
                <div class="card card-small" style="border-radius: 28px 3px 28px 3px; background: linear-gradient(135deg, #B48EAD 0%, #5E81AC 100%); width: 260px;">
                    <div class="card-body mb-5" style="margin-top: -10px; margin-left: 10px;">
                        <h3 class="card-title text-white" style="margin-bottom: 5px;">CHARGE REEL</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ number_format($chargereel, 2, ',', ' ') }}%</h2>
                        </div>
                        <span class="float-right display-5" style="margin-top: -10px;"><i class="fas fa-balance-scale" style="color: white;"></i></span>

                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-2 mb-2" style="float: right; position: relative; margin-right: -155px; margin-top: -20px;">
            <div>
                <button class="btn btn-secondary" type="button"
                    style="border-radius: 50%; width: 35px; height: 35px; padding: 0; display: flex; align-items: center; justify-content: center;"
                    data-toggle="modal" data-target="#settingsModal">
                    <i class="fa fa-cog"></i>
                </button>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card" style="border-radius: 10px;width: 105%;margin-left: -31.5px;">
                <div class="card-header text-center" style="display: flex; justify-content: space-between;">
                    <h3 class="entete">MICRO MERCH</h3>
                    <form action="{{ route('PLANNING.microrealiser') }}" method="get">
                        @csrf
                        <button class="btn btn-primary">Liste Achevé</button>
                    </form>
                </div>
                <div class="card-body" style="margin-top: -15px;">
                    <form action="{{ route('PLANNING.micro') }}">
                    @csrf
                    <div class="row">
                        <div class="col-auto my-1">
                            <label class="mr-sm-2" for="inlineFormInput" style="color: rgb(82, 82, 82);">Semaine</label>
                            <div class="input-group" id="date-range">
                                <input type="number" class="form-control" style="width: 70px;" placeholder="S:" name="startsemaine">
                                <span class="input-group-addon b-0 text-white" style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="number" class="form-control" style="width: 70px;" placeholder="S:" name="endsemaine">
                            </div>
                        </div>
                        <div class="col-auto my-1" style="flex-grow: 1;">
                            <label class="mr-sm-2" for="inlineFormInput" style="color: rgb(82, 82, 82);">Année</label>
                            <input type="number" style="width: 100px;" class="form-control mr-sm-2" id="inlineFormInput" placeholder="Année" name="annee" value="{{ date('Y') }}">
                        </div>
                        <div class="col-auto my-1">
                            <label class="mr-sm-2" for="inlineFormInput" style="color: rgb(82, 82, 82);">Deadline</label>
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="startdeadline">
                                <span class="input-group-addon b-0 text-white" style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="enddeadline">
                            </div>
                        </div>
                        <div class="col-auto my-1">
                            <label class="mr-sm-2" for="inlineFormInput" style="color: rgb(82, 82, 82);">Date de Réalisation</label>
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="startrealisation">
                                <span class="input-group-addon b-0 text-white" style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="endrealisation">
                            </div>
                        </div>
                        <div class="col-auto my-1" style="flex-grow: 1;">
                            <label class="mr-sm-2" for="inlineFormInput" style="color: rgb(82, 82, 82);">Search</label>
                            <input type="text" class="form-control mr-sm-2" id="inlineFormInput" placeholder="Entrer un preference" name="search">
                        </div>
                        <div class="col-auto my-1" style="flex-grow: 1;">
                            <label class="mr-sm-2" for="inlineFormInput" style="color: transparent;">Search</label>
                            <input type="submit" style="background-color: rgb(51, 208, 51);" class="form-control mr-sm-2" id="inlineFormInput" value="Filtrer">
                        </div>
                    </div>
                    </form>

                    <br>
                    <br>
                    <div class="table-responsive">
                        <table class="table student-data-table m-t-20">
                            <thead>
                                <tr>
                                    <th>Semaine</th>
                                    <th>Saison</th>
                                    <th>Date Réception</th>
                                    <th>Client</th>
                                    <th>Modèle</th>
                                    <th>Thème</th>
                                    <th>Style</th>
                                    {{-- <th>Stade</th> --}}
                                    <th>Qte à Monter</th>
                                    <th>Etape à Effectuée</th>
                                    <th>Deadline</th>
                                    <th>Date Réalisation</th>
                                    <th>Commentaire</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @php
                                    $previousIdDemandeClient = null;
                                @endphp

                                @foreach ($demandes as $d)
                                <tr style="cursor: pointer;" class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $today > $d->datecalcul ? 'highlight-past-date' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : '' }}" >
                                        <td style="color: rgb(78, 76, 76);"  class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : ($today > $d->datecalcul ? 'highlight-past-date' : '') }}" onclick="affichemodal('{{ $d->nomtier }}', '{{ $d->nom_modele }}', '{{ $d->etape_designation }}', '{{ $d->etape_stade }}', '{{ $d->id_etape }}', '{{ $d->demande_id }}','{{ $d->micro_realisation }}','{{ $d->datecalcul }}','{{ $d->micro_commentaires }}','{{ $d->resultat_id }}')">S:{{ $d->semaine }}</td>
                                        <td style="color: rgb(78, 76, 76);"  class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : ($today > $d->datecalcul ? 'highlight-past-date' : '') }}" onclick="affichemodal('{{ $d->nomtier }}', '{{ $d->nom_modele }}', '{{ $d->etape_designation }}', '{{ $d->etape_stade }}', '{{ $d->id_etape }}', '{{ $d->demande_id }}','{{ $d->micro_realisation }}','{{ $d->datecalcul }}','{{ $d->micro_commentaires }}','{{ $d->resultat_id }}')">{{ $d->type_saison }}</td>
                                        <td style="color: rgb(78, 76, 76);"  class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : ($today > $d->datecalcul ? 'highlight-past-date' : '') }}" onclick="affichemodal('{{ $d->nomtier }}', '{{ $d->nom_modele }}', '{{ $d->etape_designation }}', '{{ $d->etape_stade }}', '{{ $d->id_etape }}', '{{ $d->demande_id }}','{{ $d->micro_realisation }}','{{ $d->datecalcul }}','{{ $d->micro_commentaires }}','{{ $d->resultat_id }}')">{{ \Carbon\Carbon::parse($d->demande_date_entree)->format('d/m/Y') }}</td>
                                        <td style="color: rgb(78, 76, 76);"  class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : ($today > $d->datecalcul ? 'highlight-past-date' : '') }}" onclick="affichemodal('{{ $d->nomtier }}', '{{ $d->nom_modele }}', '{{ $d->etape_designation }}', '{{ $d->etape_stade }}', '{{ $d->id_etape }}', '{{ $d->demande_id }}','{{ $d->micro_realisation }}','{{ $d->datecalcul }}','{{ $d->micro_commentaires }}','{{ $d->resultat_id }}')">{{ $d->nomtier }}</td>
                                        <td style="color: rgb(78, 76, 76);"  class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : ($today > $d->datecalcul ? 'highlight-past-date' : '') }}" onclick="affichemodal('{{ $d->nomtier }}', '{{ $d->nom_modele }}', '{{ $d->etape_designation }}', '{{ $d->etape_stade }}', '{{ $d->id_etape }}', '{{ $d->demande_id }}','{{ $d->micro_realisation }}','{{ $d->datecalcul }}','{{ $d->micro_commentaires }}','{{ $d->resultat_id }}')">{{ $d->nom_modele }}</td>
                                        <td style="color: rgb(78, 76, 76);"  class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : ($today > $d->datecalcul ? 'highlight-past-date' : '') }}" onclick="affichemodal('{{ $d->nomtier }}', '{{ $d->nom_modele }}', '{{ $d->etape_designation }}', '{{ $d->etape_stade }}', '{{ $d->id_etape }}', '{{ $d->demande_id }}','{{ $d->micro_realisation }}','{{ $d->datecalcul }}','{{ $d->micro_commentaires }}','{{ $d->resultat_id }}')">{{ $d->theme }}</td>
                                        <td style="color: rgb(78, 76, 76);"  class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : ($today > $d->datecalcul ? 'highlight-past-date' : '') }}" onclick="affichemodal('{{ $d->nomtier }}', '{{ $d->nom_modele }}', '{{ $d->etape_designation }}', '{{ $d->etape_stade }}', '{{ $d->id_etape }}', '{{ $d->demande_id }}','{{ $d->micro_realisation }}','{{ $d->datecalcul }}','{{ $d->micro_commentaires }}','{{ $d->resultat_id }}')">{{ $d->nom_style }}</td>
                                        {{-- <td>{{ $d->type_stade }}</td> --}}
                                        @if (!empty($d->total_qte_detailsdc))
                                            <td style="color: rgb(78, 76, 76);"  class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : ($today > $d->datecalcul ? 'highlight-past-date' : '') }}" onclick="affichemodal('{{ $d->nomtier }}', '{{ $d->nom_modele }}', '{{ $d->etape_designation }}', '{{ $d->etape_stade }}', '{{ $d->id_etape }}', '{{ $d->demande_id }}','{{ $d->micro_realisation }}','{{ $d->datecalcul }}','{{ $d->micro_commentaires }}','{{ $d->resultat_id }}')">{{ $d->total_qte_detailsdc }}</td>
                                        @endif
                                        @if (empty($d->total_qte_detailsdc))
                                            <td style="color: rgb(78, 76, 76);"  class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : ($today > $d->datecalcul ? 'highlight-past-date' : '') }}" onclick="affichemodal('{{ $d->nomtier }}', '{{ $d->nom_modele }}', '{{ $d->etape_designation }}', '{{ $d->etape_stade }}', '{{ $d->id_etape }}', '{{ $d->demande_id }}','{{ $d->micro_realisation }}','{{ $d->datecalcul }}','{{ $d->micro_commentaires }}','{{ $d->resultat_id }}')">{{ $d->etape_quantite }}</td>
                                        @endif
                                        <td style="color: rgb(78, 76, 76);"  class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : ($today > $d->datecalcul ? 'highlight-past-date' : '') }}" onclick="affichemodal('{{ $d->nomtier }}', '{{ $d->nom_modele }}', '{{ $d->etape_designation }}', '{{ $d->etape_stade }}', '{{ $d->id_etape }}', '{{ $d->demande_id }}','{{ $d->micro_realisation }}','{{ $d->datecalcul }}','{{ $d->micro_commentaires }}','{{ $d->resultat_id }}')">{{ $d->etape_designation }}/{{ $d->etape_stade }}</td>

                                        <td style="color: rgb(78, 76, 76);" class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : ($today > $d->datecalcul ? 'highlight-past-date' : '') }}" onclick="modifedate('{{ $d->nomtier }}', '{{ $d->nom_modele }}' ,'{{ $d->etape_designation }}', '{{ $d->etape_stade }}','{{ $d->id_etape }}', '{{ $d->demande_id }}','{{ \Carbon\Carbon::parse($d->datecalcul)->format('d/m/Y') }}','{{ $d->resultat_id }}')" ><input type="text" name="datecalcule" style="border: none;width:120px;text-align:center;border-radius:5px;cursor: pointer;" value="{{ \Carbon\Carbon::parse($d->datecalcul)->format('d/m/Y') }}"></td>

                                        <td style="color: rgb(78, 76, 76);"  class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : ($today > $d->datecalcul ? 'highlight-past-date' : '') }}" onclick="affichemodal('{{ $d->nomtier }}', '{{ $d->nom_modele }}', '{{ $d->etape_designation }}', '{{ $d->etape_stade }}', '{{ $d->id_etape }}', '{{ $d->demande_id }}','{{ $d->micro_realisation }}','{{ $d->datecalcul }}','{{ $d->micro_commentaires }}','{{ $d->resultat_id }}')">{{ !empty($d->micro_realisation) ? \Carbon\Carbon::parse($d->micro_realisation)->format('d/m/y') : '' }}</td>
                                        <td style="color: rgb(78, 76, 76);"  class="{{ $d->id_demande_client != $previousIdDemandeClient ? 'highlight-border' : '' }} {{ $d->micro_realisation ? 'highlight-realisation' : ($today > $d->datecalcul ? 'highlight-past-date' : '') }}" onclick="affichemodal('{{ $d->nomtier }}', '{{ $d->nom_modele }}', '{{ $d->etape_designation }}', '{{ $d->etape_stade }}', '{{ $d->id_etape }}', '{{ $d->demande_id }}','{{ $d->micro_realisation }}','{{ $d->datecalcul }}','{{ $d->micro_commentaires }}','{{ $d->resultat_id }}')">{{ $d->micro_commentaires }}</td>
                                    </tr>

                                    @php
                                        $previousIdDemandeClient = $d->id_demande_client;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>




                        <!-- Modal -->
                        <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Détails Micro</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Affichage des données récupérées -->
                                        <p><strong style="color: rgb(168, 168, 168);">Client :</strong> <span
                                                style="color: rgb(83, 83, 83);" id="modalNomTier"></span></p>
                                        <p><strong style="color: rgb(168, 168, 168);">Modèle :</strong> <span
                                                style="color: rgb(83, 83, 83);" id="modalNomModele"></span></p>
                                        <p><strong style="color: rgb(168, 168, 168);">Étape :</strong> <span
                                                style="color: rgb(83, 83, 83);" id="modalEtape"></span></p>
                                        <p><strong style="color: rgb(168, 168, 168);">Stade Étape :</strong> <span
                                                style="color: rgb(83, 83, 83);" id="modalStade"></span></p>

                                        <!-- Formulaire dans le modal -->
                                        <form id="modalForm" action="{{ route('PLANNING.microRealisation') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" id="modalId" name="idEtape">
                                            <input type="hidden" id="modalIdDemandeClient" name="idDemande">
                                            <input type="hidden" id="resultat_id" name="resultat_id">
                                            <div class="mb-3">
                                                <label for="inputDate" class="form-label"
                                                    style="color:rgb(168, 168, 168);">Date</label>
                                                <input type="date" class="form-control" id="micro_realisation" name="realisation">
                                            </div>
                                            <div class="mb-3">
                                                <label for="textArea" class="form-label"
                                                    style="color: rgb(168, 168, 168);">Commentaire</label>
                                                <textarea class="form-control" id="textArea" name="commentaires" rows="3"></textarea>
                                            </div>
                                            <!-- Boutons Soumettre et Annuler -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-success me-2">Soumettre</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                     style="margin-left: 10px;">Annuler</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--- modif date--->
                        <div class="modal fade" id="modifModal" tabindex="-1" aria-labelledby="modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Modification Deadline</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Affichage des données récupérées -->
                                        <p><strong style="color: rgb(168, 168, 168);">Client :</strong> <span
                                            style="color: rgb(83, 83, 83);" id="NomTier"></span></p>
                                        <p><strong style="color: rgb(168, 168, 168);">Modèle :</strong> <span
                                                style="color: rgb(83, 83, 83);" id="modele"></span></p>
                                        <p><strong style="color: rgb(168, 168, 168);">Étape :</strong> <span
                                                style="color: rgb(83, 83, 83);" id="Etape"></span></p>
                                        <p><strong style="color: rgb(168, 168, 168);">Stade Étape :</strong> <span
                                                style="color: rgb(83, 83, 83);" id="Stade"></span></p>
                                        <p><strong style="color: rgb(168, 168, 168);">Date à Modifié :</strong> <span
                                                style="color: rgb(83, 83, 83);" id="date_calcul"></span></p>

                                        <!-- Formulaire dans le modal -->
                                        <form id="modalForm" action="{{ route('PLANNING.modifierDateDeadline') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" id="Id_Etape" name="idEtape">
                                            <input type="hidden" id="Id_Demande_Client" name="idDemande">
                                            <input type="hidden" id="modifdateresultat_id" name="idresultat">
                                            <div class="mb-3">
                                                <label for="inputDate" class="form-label"
                                                    style="color:rgb(168, 168, 168);">Nouvelle Date: </label>
                                                <input type="date" class="form-control" name="deadlinemodifier">
                                            </div>
                                            <!-- Boutons Soumettre et Annuler -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-success me-2">Soumettre</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                     style="margin-left: 10px;">Annuler</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Parametre -->
                        <div class="modal fade" id="settingsModal" tabindex="-1"
                            aria-labelledby="settingsModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="settingsModalLabel">PARAMETRES</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="modalForm">
                                            <div class="mb-3">
                                                <label for="inputDate" class="form-label"
                                                    style="color:rgb(168, 168, 168);">Semaine</label>
                                                <input type="number" class="form-control" id="inputDate"
                                                    name="inputDate" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="textArea" class="form-label"
                                                    style="color: rgb(168, 168, 168);">Nb jour</label>
                                                <input type="number" class="form-control" id="inputDate"
                                                    name="inputDate" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="textArea" class="form-label"
                                                    style="color: rgb(168, 168, 168);">Effectif</label>
                                                <input type="number" class="form-control" id="inputDate"
                                                    name="inputDate" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="textArea" class="form-label"
                                                    style="color: rgb(168, 168, 168);">Heure Sup</label>
                                                <input type="number" class="form-control" id="inputDate"
                                                    name="inputDate" required>
                                            </div>
                                            <!-- Boutons Soumettre et Annuler -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-success me-2">Soumettre</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                    style="margin-left: 10px;">Annuler</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<!--**********************************
            Content body end
        ***********************************-->

<script>
    function affichemodal(nomtier, nomModele, etape, stade, id, id_demande_client,micro_realisation,datecalcul,micro_commentaires,resultat_id) {
        // Injecter les données récupérées dans le modal
        $('#modalNomTier').text(nomtier);
        $('#modalNomModele').text(nomModele);
        $('#modalEtape').text(etape);
        $('#resultat_id').val(resultat_id);
        $('#modalStade').text(stade);
        // Injecter les valeurs des champs hidden
        $('#modalId').val(id); // ici, 'id' est passé lors du clic sur la ligne
        $('#modalIdDemandeClient').val(id_demande_client); // injecte id_demande_client dans le champ hidden
        if (micro_realisation) {
            $('#micro_realisation').val(micro_realisation); // Si date de réalisation existe, l'utiliser
        } else {
            $('#micro_realisation').val(datecalcul); // Sinon, utiliser la date d'entrée
        }
        $('#textArea').val(micro_commentaires);
 // injecte id_demande_client dans le champ hidden


        // Afficher le modal
        $('#infoModal').modal('show');
    }

    $('#modalForm').on('submit', function(event) {
        event.preventDefault();

        // Récupérer les données du formulaire
        var formData = {
            date: $('#inputDate').val(),
            commentaire: $('#textArea').val()
        };

        // Vous pouvez envoyer les données avec AJAX si nécessaire
        console.log('Données du formulaire:', formData);

        // Fermer le modal après la soumission
        $('#infoModal').modal('hide');
    });
</script>

<script>
function modifedate(nomtier,modele,etape,stade,id, id_demande_client, datecalcul,resultat_id) {
    // Update the text of the <span> elements
    $('#NomTier').text(nomtier);
    $('#Etape').text(etape);
    $('#modele').text(modele);
    $('#modifdateresultat_id').val(resultat_id);
    $('#Stade').text(stade);
    $('#Idetape').text(id); // Display id_etape
    $('#IdDemandeClient').text(id_demande_client); // Display id_demande_client
    $('#date_calcul').text(datecalcul); // Display datecalcul

    // Inject values into hidden inputs (if necessary)
    $('#Id_Etape').val(id); // id_etape for form submission
    $('#Id_Demande_Client').val(id_demande_client); // id_demande_client for form submission

    // Show the modal
    $('#modifModal').modal('show');
}

</script>


@include('CRM.footer')
