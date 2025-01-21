@include('CRM.header')
@include('CRM.sidebar')
<title>AccueilDEV</title>

<!--**********************************
        Content body start
***********************************-->
<style>
    .kanban-column {
        background-color: rgba(227, 227, 227, 0.929);
        border-radius: 8px;
        min-width: 250px;
        padding: 15px;
        margin-right: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        flex-shrink: 0;
        text-align: center;
    }

    .kanban-column h5 {
        font-size: 18px;
        margin-bottom: 10px;
        color: white;
    }

    .kanban-column span {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
    }

    .kanban-column button {
        margin-top: 10px;
    }

    .kanban-card {
        margin-top: 15px;
    }

    .card {
        background-color: #ffffff;
        color: #333;
        border: none;
        border-radius: 8px;
    }

    .card-body {
        text-align: left;
    }

    .card-time {
        font-size: 12px;
        color: gray;
    }

    .card-title {
        font-size: 16px;
        font-weight: bold;
    }

    body {
        background: linear-gradient(135deg, #e09, #d0e);
        color: white;
        font-family: Arial, sans-serif;
    }

    .kanban-board {
        display: flex;
        overflow-x: auto;
        padding: 20px;
    }



    .kanban-header {
        background-color: #00aaff;
        padding: 10px;
        color: black;
        text-align: center;
        position: relative;
        display: inline-block;
        margin: 0;
        font-size: 18px;
        font-weight: bold;
        border-radius: 20px 0 0 20px;
        width: 200px;
        /* Largeur fixe pour chaque entête */
    }

    .kanban-header:after {
        content: '';
        position: absolute;
        right: -20px;
        top: 0;
        width: 0;
        height: 0;
        border-top: 25px solid transparent;
        border-bottom: 25px solid transparent;
        border-left: 20px solid #00aaff;
    }


    .kanban-header:nth-child(2) {
        background-color: #00bfff;
    }

    .kanban-header:nth-child(3) {
        background-color: #00cccc;
    }

    .kanban-header:nth-child(4) {
        background-color: #00ddaa;
    }

    .kanban-header:nth-child(5) {
        background-color: #00ff88;
    }

    .texte {
        color: black;
    }

    #suggestionsListSaison {
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

    #suggestionsListStyle {
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

    #suggestionsListEmploye {
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

    #suggestionsListStade {
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
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('DEV.headerDEV')
        <div class="row">

            <div class="card col-12">
                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">PLANNING </h3>
                </div>

                <form action="{{ route('DEV.recherchePlanning') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-1">
                            <div class="input-group">
                                <input type="text" id="nomSaison" name="nomSaison" class="form-control"
                                    placeholder="Saison" value="{{ $nomSaison }}">
                                <input type="hidden" id="idSaison" name="idSaison" value="{{ $idSaison }}">
                                <ul id="suggestionsListSaison" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="modele" name="modele" class="form-control"
                                    placeholder="Modele" value="{{ $modele }}">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="nomTiers" name="nomTiers" class="form-control"
                                    placeholder="Nom Client" value="{{ $nomTiers }}">
                                <input type="hidden" id="idTiers" name="idTiers" value="{{ $idTiers }}">
                                <ul id="suggestionsListTiers" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="input-group">
                                <input type="text" id="nomStyle" name="nomStyle" class="form-control"
                                    placeholder="Style" value="{{ $nomStyle }}">
                                <input type="hidden" id="idStyle" name="idStyle" value="{{ $idStyle }}">
                                <ul id="suggestionsListStyle" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="nomEmploye" name="nomEmploye" class="form-control"
                                    placeholder="Patronier" value="{{ $nomEmploye }}">
                                <input type="hidden" id="idEmploye" name="patronier" value="{{ $patronier }}">
                                <ul id="suggestionsListEmploye" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="input-group">
                                <input type="text" id="nomStade" name="nomStade" class="form-control"
                                    placeholder="Stade" value="{{ $nomStade }}">
                                <input type="hidden" id="idStade" name="idStade" value="{{ $idStade }}">
                                <ul id="suggestionsListStade" class="list-group mt-2" style="display: none;">
                                </ul>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="dateDebut"
                                    value="{{ $dateDebut }}">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="dateFin"
                                    value="{{ $dateFin }}">
                            </div>
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-9">
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-success" style="width: 100px">Filtrer</button>
                        </div>
                    </div>

                </form>
                <div class="kanban-board">

                    <div class="kanban-column">
                        <h5 class="kanban-header"> Bureau d'étude</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 1)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatBureauEtude = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatBureauEtude = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatBureauEtude = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: {{ $etatBureauEtude }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            @if ($demande[$i]->etat == 0)
                                                <a href="{{ route('DEV.formAjoutBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id, 'deadline' => $demande[$i]->deadlinedemandeclient]) }}"
                                                    class="btn btn-primary btn-add btn-sm mt-1" style="width: 50px;">
                                                    <i class="fas fa-play"></i></a>
                                            @elseif ($demande[$i]->etat == 1)
                                                <a href="#" class="btn btn-primary btn-add btn-sm mt-1"
                                                    style="width: 50px;"> <i class="fas fa-play"></i></a>
                                            @endif


                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#choixEtapeModal" data-id="{{ $demande[$i]->id }}"
                                                    disabled>
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#choixEtapeModal" data-id="{{ $demande[$i]->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">Patronage</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 2)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatPatronage = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatPatronage = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatPatronage = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color:{{ $etatPatronage }}; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->client_date_entree)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutPatronage" data-id="{{ $demande[$i]->id }}"
                                                    data-dateentree="{{ $demande[$i]->client_date_entree }}"
                                                    data-deadline="{{ $demande[$i]->deadlinedemandeclient }}">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutPatronage" data-id="{{ $demande[$i]->id }}"
                                                    data-dateentree="{{ $demande[$i]->client_date_entree }}"
                                                    data-deadline="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    disabled>
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @endif

                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-success btn-finish btn-sm  mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#acheverPatronage" data-id="{{ $demande[$i]->id }}"
                                                    disabled>
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-success btn-finish btn-sm  mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#acheverPatronage" data-id="{{ $demande[$i]->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif

                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endfor

                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">Placement</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 3)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatPlacement = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatPlacement = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatPlacement = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: {{ $etatPlacement }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutPlacement" data-id="{{ $demande[$i]->id }}"
                                                    data-iddemandeclient="{{ $demande[$i]->id_demande_client }}"
                                                    data-dateentreeplacement="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlineplacement="{{ $demande[$i]->deadlinedemandeclient }}">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutPlacement" data-id="{{ $demande[$i]->id }}"
                                                    data-iddemandeclient="{{ $demande[$i]->id_demande_client }}"
                                                    data-dateentreeplacement="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlineplacement="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    disabled>
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @endif



                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($demande[$i]->etat == 0)
                                                <a href="#" class="btn btn-primary btn-success btn-sm mt-1"
                                                    style="width: 50px;">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            @elseif ($demande[$i]->etat == 1)
                                                <a href="{{ route('DEV.formFinPlacement', ['idDemande' => $demande[$i]->id_demande_client, 'idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                    class="btn btn-primary btn-success btn-sm mt-1"
                                                    style="width: 50px;">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>


                    <div class="kanban-column">
                        <h5 class="kanban-header">Contrôle Patronage</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 4)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatControlePatronage = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatControlePatronage = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatControlePatronage = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn mt-1"
                                                style="background-color: {{ $etatControlePatronage }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutControlePatronage"
                                                    data-idcontrolepatronage="{{ $demande[$i]->id }}"
                                                    data-dateentreecontrolepatronage="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlinecontrolepatronage="{{ $demande[$i]->deadlinedemandeclient }}">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutControlePatronage"
                                                    data-idcontrolepatronage="{{ $demande[$i]->id }}"
                                                    data-dateentreecontrolepatronage="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlinecontrolepatronage="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    disabled>
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @endif


                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#acheverControlePatronage"
                                                    data-id="{{ $demande[$i]->id }}" disabled>
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#acheverControlePatronage"
                                                    data-id="{{ $demande[$i]->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                     <div class="kanban-column">
                        <h5 class="kanban-header">Attente</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 5)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatControlePatronage = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatControlePatronage = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatControlePatronage = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn mt-1"
                                                style="background-color: {{ $etatControlePatronage }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>

                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>


                                                <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#acheverAttente"
                                                    data-id="{{ $demande[$i]->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>




                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>





                    <div class="kanban-column">
                        <h5 class="kanban-header">Coupe</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 6)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatCoupe = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatCoupe = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatCoupe = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: {{ $etatCoupe }}; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            @if ($demande[$i]->etat == 0 && $demande[$i]->id_stade != 1)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutEtapeIntermediaire"
                                                    data-idinter="{{ $demande[$i]->id }}"
                                                    data-dateentreeinter="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlineinter="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    data-etapedevinter="{{ $demande[$i]->id_etape_dev }}">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1 || $demande[$i]->id_stade == 1)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutEtapeIntermediaire"
                                                    data-idinter="{{ $demande[$i]->id }}"
                                                    data-dateentreeinter="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlineinter="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    data-etapedevinter="{{ $demande[$i]->id_etape_dev }}" disabled>
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @endif



                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal" data-target="#finInter"
                                                    data-id="{{ $demande[$i]->id }}" disabled>
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal" data-target="#finInter"
                                                    data-id="{{ $demande[$i]->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">Brod main</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 7)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatCoupe = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatCoupe = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatCoupe = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: {{ $etatCoupe }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutEtapeIntermediaire"
                                                    data-idinter="{{ $demande[$i]->id }}"
                                                    data-dateentreeinter="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlineinter="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    data-etapedevinter="{{ $demande[$i]->id_etape_dev }}">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutEtapeIntermediaire"
                                                    data-idinter="{{ $demande[$i]->id }}"
                                                    data-dateentreeinter="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlineinter="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    data-etapedevinter="{{ $demande[$i]->id_etape_dev }}" disabled>
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @endif

                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal" data-target="#finInter"
                                                    data-id="{{ $demande[$i]->id }}" disabled>
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal" data-target="#finInter"
                                                    data-id="{{ $demande[$i]->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">Brod machine</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 8)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatCoupe = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatCoupe = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatCoupe = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: {{ $etatCoupe }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutEtapeIntermediaire"
                                                    data-idinter="{{ $demande[$i]->id }}"
                                                    data-dateentreeinter="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlineinter="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    data-etapedevinter="{{ $demande[$i]->id_etape_dev }}">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutEtapeIntermediaire"
                                                    data-idinter="{{ $demande[$i]->id }}"
                                                    data-dateentreeinter="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlineinter="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    data-etapedevinter="{{ $demande[$i]->id_etape_dev }}" disabled>
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @endif

                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal" data-target="#finInter"
                                                    data-id="{{ $demande[$i]->id }}" disabled>
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal" data-target="#finInter"
                                                    data-id="{{ $demande[$i]->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">Print</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 9)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatCoupe = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatCoupe = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatCoupe = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: {{ $etatCoupe }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutEtapeIntermediaire"
                                                    data-idinter="{{ $demande[$i]->id }}"
                                                    data-dateentreeinter="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlineinter="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    data-etapedevinter="{{ $demande[$i]->id_etape_dev }}">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutEtapeIntermediaire"
                                                    data-idinter="{{ $demande[$i]->id }}"
                                                    data-dateentreeinter="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlineinter="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    data-etapedevinter="{{ $demande[$i]->id_etape_dev }}" disabled>
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @endif

                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal" data-target="#finInter"
                                                    data-id="{{ $demande[$i]->id }}" disabled>
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal" data-target="#finInter"
                                                    data-id="{{ $demande[$i]->id }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">Teinture</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 10)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatCoupe = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatCoupe = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatCoupe = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: {{ $etatCoupe }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutEtapeIntermediaire"
                                                    data-idinter="{{ $demande[$i]->id }}"
                                                    data-dateentreeinter="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlineinter="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    data-etapedevinter="{{ $demande[$i]->id_etape_dev }}">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutEtapeIntermediaire"
                                                    data-idinter="{{ $demande[$i]->id }}"
                                                    data-dateentreeinter="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlineinter="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    data-etapedevinter="{{ $demande[$i]->id_etape_dev }}" disabled>
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @endif



                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                style="width: 50px;" data-toggle="modal" data-target="#finInter"
                                                data-id="{{ $demande[$i]->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">Montage</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 11)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatCoupe = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatCoupe = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatCoupe = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: {{ $etatCoupe }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif

                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutMontage"
                                                    data-idmontage="{{ $demande[$i]->id }}"
                                                    data-dateentreemontage="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlinemontage="{{ $demande[$i]->deadlinedemandeclient }}">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutMontage"
                                                    data-idmontage="{{ $demande[$i]->id }}"
                                                    data-dateentreemontage="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlinemontage="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    disabled>
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @endif



                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                style="width: 50px;" data-toggle="modal" data-target="#finMontage"
                                                data-id="{{ $demande[$i]->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>

                                            <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                style="width: 50px;" data-toggle="modal"
                                                data-target="#finControleFinal" data-id="{{ $demande[$i]->id }}">
                                                <i class="fas fa-clipboard-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                      <div class="kanban-column">
                        <h5 class="kanban-header">Finition</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 12)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatPatronage = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatPatronage = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatPatronage = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: {{ $etatPatronage }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutRapportFinition"
                                                    data-idfinal="{{ $demande[$i]->id }}"
                                                    data-dateentreefinal="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlinefinal="{{ $demande[$i]->deadlinedemandeclient }}">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutRapportFinition"
                                                    data-idfinal="{{ $demande[$i]->id }}"
                                                    data-dateentreefinal="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlinefinal="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    disabled>
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @endif

                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <button type="button" class="btn btn-success  btn-sm mt-1"
                                                style="width: 50px;" data-toggle="modal" data-target="#finFinition"
                                                data-id="{{ $demande[$i]->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">Contrôle final</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 13)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatCoupe = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatCoupe = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatCoupe = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: {{ $etatCoupe }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            @if ($demande[$i]->etat == 0)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutControlFinal"
                                                    data-idfinal="{{ $demande[$i]->id }}"
                                                    data-dateentreefinal="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlinefinal="{{ $demande[$i]->deadlinedemandeclient }}">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @elseif ($demande[$i]->etat == 1)
                                                <button type="button" class="btn btn-primary btn-finish btn-sm mt-1"
                                                    style="width: 50px;" data-toggle="modal"
                                                    data-target="#debutControlFinal"
                                                    data-idfinal="{{ $demande[$i]->id }}"
                                                    data-dateentreefinal="{{ $demande[$i]->date_entree_demande }}"
                                                    data-deadlinefinal="{{ $demande[$i]->deadlinedemandeclient }}"
                                                    disabled>
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @endif



                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <button type="button" class="btn btn-success btn-finish btn-sm mt-1"
                                                style="width: 50px;" data-toggle="modal"
                                                data-target="#finControleFinal" data-id="{{ $demande[$i]->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>

                                            <button type="button" class="btn btn-secondary  btn-sm mt-1"
                                                style="width: 50px;" data-toggle="modal" data-target="#finFinition"
                                                data-id="{{ $demande[$i]->id }}">
                                                <i class="fas fa-clipboard-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>



                    <div class="kanban-column">
                        <h5 class="kanban-header">Transmission</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 14)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatPatronage = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatPatronage = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatPatronage = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: {{ $etatPatronage }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->sommeqteclient }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#transmission"
                                                data-id="{{ $demande[$i]->id }}"
                                                data-qte="{{ $demande[$i]->sommeqteclient }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>


                    <div class="kanban-column">
                        <h5 class="kanban-header">Envoie merch</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 15)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatPatronage = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatPatronage = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatPatronage = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: {{ $etatPatronage }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->sommeqteclient }} pcs</b>
                                            <p class="card-time"> </p>
                                            @if ($demande[$i]->deadlinedemandeclient > $now)
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demande[$i]->deadlinedemandeclient)->format('d/m/y') }}
                                                </a>
                                            @endif

                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal"
                                                data-target="#transmissionClient" data-id="{{ $demande[$i]->id }}"
                                                data-qte="{{ $demande[$i]->sommeqteclient }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>


                    <div class="kanban-column">
                        <h5 class="kanban-header">Envoie client</h5>
                        @for ($i = 0; $i < count($demande); $i++)
                            @if ($demande[$i]->id_etape_dev == 16)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $etatPatronage = 'white';
                                                if ($demande[$i]->etat == 0) {
                                                    $etatPatronage = 'yellow';
                                                } elseif ($demande[$i]->etat == 1) {
                                                    $etatPatronage = 'green';
                                                }
                                            @endphp
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: {{ $etatPatronage }}; color: black;"
                                                disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demande[$i]->date_entree_demande)->format('d/m/y') }}
                                            </button>
                                            &nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demande[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demande[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->stadesdc))
                                                <b>{{ $demande[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demande[$i]->type_stade }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demande[$i]->dernierdt))
                                                <a href="#"
                                                    onclick="openPdfInNewTab('{{ $demande[$i]->dernierdt }}', event)"
                                                    style="color: rgb(59, 33, 164);">
                                                    <b> DT</b>
                                                </a>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="{{ route('DEV.formUpdateBureauEtude', ['idDCSDCEtapeDev' => $demande[$i]->id]) }}"
                                                style="color: rgb(59, 33, 164);">
                                                <b> BE</b>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demande[$i]->quantitesdc }} pcs</b>
                                            <p class="card-time"> </p>
                                            <a href="{{ route('DEV.detailDemandeClient', ['idDemande' => $demande[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                </div>

            </div>

        </div>


        <!-- Modal achever bureau etude -->
        <div class="modal fade" id="choixEtapeModal" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Choix de l'étape suivante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.acheverBureauEtude') }}" method="POST">
                            @csrf
                            <!-- Choix d'étape -->
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <input type="hidden" id="etapeId" name="idDCSdcEtapeDev">
                                    <label class="col-form-label texte">Choix etape suivante</label>
                                </div>
                                <div class="col-12">
                                    <select class="form-control" name="etapeDEV" required>
                                        @for ($et = 0; $et < count($etapeDev); $et++)
                                            <option value="{{ $etapeDev[$et]->id }}">{{ $etapeDev[$et]->etape }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="row no-gutters mt-3">
                                <div class="col-12">
                                    <label class="col-form-label texte">Commentaire</label>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                                </div>
                            </div>

                            <!-- Boutons Annuler et Achever -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Achever</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal debut patronage -->
        <div class="modal fade" id="debutPatronage" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Débuter l'étape patronage</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.debutPatronage') }}" method="POST">
                            @csrf
                            <!-- Choix d'étape -->
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <input type="hidden" id="etapeIdPatronage" name="idDCSdcEtapeDev">
                                    <input type="hidden" id="dateEntreePatronage" name="dateEntreePatronage">
                                    <input type="hidden" id="deadlinePatronage" name="deadlinePatronage">
                                    <label class="col-form-label texte">Voulez-vous vraiment débuter</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Débuter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal achever patronage -->
        <div class="modal fade" id="acheverPatronage" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Choix de l'étape suivante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.acheverSuiviPatronage') }}" method="POST">
                            @csrf
                            <!-- Choix d'étape -->
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <input type="hidden" id="etapeIdPatronage" name="idDCSdcEtapeDevPatronage">
                                    <label class="col-form-label texte">Choix etape suivante</label>
                                </div>
                                <div class="col-12">
                                    <select class="form-control" name="etapeDEVPatronage" required>
                                        @for ($et = 0; $et < count($etapeDev); $et++)
                                            <option value="{{ $etapeDev[$et]->id }}">{{ $etapeDev[$et]->etape }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="row no-gutters mt-3">
                                <div class="col-12">
                                    <label class="col-form-label texte">Commentaire</label>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" id="commentaire" name="commentairePatronage" rows="3"></textarea>
                                </div>
                            </div>

                            <!-- Boutons Annuler et Achever -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Achever</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal debut controle patronage -->
        <div class="modal fade" id="debutControlePatronage" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Début contrôle patronage</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.debutControlePatronage') }}" method="POST">
                            @csrf
                            <!-- Choix d'étape -->
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <input type="hidden" id="etapeIdControlePatronage"
                                        name="idDCSdcEtapeDevPatronage">
                                    <input type="hidden" id="dateEntreeControlePatronage"
                                        name="dateEntreeControlePatronage">
                                    <input type="hidden" id="deadlineControlePatronage"
                                        name="deadlineControlePatronage">
                                    <label class="col-form-label texte">Voulez-vous vraiment débuter</label>
                                </div>
                            </div>
                            <!-- Boutons Annuler et Achever -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Débuter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal achever controle patronage -->
        <div class="modal fade" id="acheverControlePatronage" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Choix de l'étape suivante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.acheverControlePatronage') }}" method="POST">
                            @csrf

                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte">Occurence</label>
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" name="occurence" value="1">
                                </div>
                            </div>

                            <div class="row no-gutters mt-3">
                                <div class="col-12">
                                    <label class="col-form-label texte">Type occurence</label>
                                </div>
                                <div class="col-12">
                                    <select class="form-control" name="typeOccurence" required>
                                        @for ($typeOcc = 0; $typeOcc < count($typeOccurence); $typeOcc++)
                                            <option value="{{ $typeOccurence[$typeOcc]->id }}">
                                                {{ $typeOccurence[$typeOcc]->occurence }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <input type="hidden" id="etapeIdControlePatronage"
                                        name="idDCSdcEtapeDevControlePatronage">
                                    <label class="col-form-label texte">Choix etape suivante</label>
                                </div>
                                <div class="col-12">
                                    <select class="form-control" name="etapeDEVControlePatronage" required>
                                        @for ($et = 0; $et < count($etapeDev); $et++)
                                            <option value="{{ $etapeDev[$et]->id }}">{{ $etapeDev[$et]->etape }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="row no-gutters mt-3">
                                <div class="col-12">
                                    <label class="col-form-label texte">Commentaire</label>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" id="commentaire" name="commentaireControlePatronage" rows="3"></textarea>
                                </div>
                            </div>

                            <!-- Boutons Annuler et Achever -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Achever</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

         <!-- Modal achever attente -->
        <div class="modal fade" id="acheverAttente" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Choix de l'étape suivante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.acheverAttente') }}" method="POST">
                            @csrf

                            <div class="row no-gutters">
                                <div class="col-12">
                                    <input type="hidden" id="etapeIdAttente"
                                        name="idDCSdcEtapeDevAttente">
                                        <label class="col-form-label texte">Sélection de l'étape de déplacement suivante</label>
                                </div>
                                <div class="col-12">
                                    <select class="form-control" name="etapeDEVControlePatronage" required>
                                        @for ($et = 0; $et < count($etapeDev); $et++)
                                            <option value="{{ $etapeDev[$et]->id }}">{{ $etapeDev[$et]->etape }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <!-- Boutons Annuler et Achever -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Deplacer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal debut placement -->
        <div class="modal fade" id="debutPlacement" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Début placement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.debutPlacement') }}" method="POST">
                            @csrf
                            <!-- Choix d'étape -->
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <input type="hidden" id="idDCDSCEtapeDev" name="idDCDSCEtapeDevPlacement">
                                    <input type="hidden" id="dateEntreePlacement" name="dateEntreePlacement">
                                    <input type="hidden" id="deadlinePlacement" name="deadlinePlacement">
                                    <input type="hidden" id="idDemandeClientPlacement"
                                        name="idDemandeClientPlacement">
                                </div>
                            </div>

                            <div class="row no-gutters mt-3">
                                <div class="col-12">
                                    <label class="col-form-label texte">Nom du placeur</label>
                                </div>
                                <div class="col-12">
                                    <select class="form-control" name="placeur" required>
                                        @for ($pl = 0; $pl < count($placeur); $pl++)
                                            <option value="{{ $placeur[$pl]->id }}">
                                                {{ $placeur[$pl]->nom }} {{ $placeur[$pl]->prenom }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Debuter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal debut intermediaire -->
        <div class="modal fade" id="debutEtapeIntermediaire" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Débuter l'étape coupe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.debutIntermediaire') }}" method="POST">
                            @csrf
                            <!-- Choix d'étape -->
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <input type="hidden" id="etapeIdInter" name="idDCSdcEtapeDevInter">
                                    <input type="hidden" id="dateEntreeInter" name="dateEntreeInter">
                                    <input type="hidden" id="deadlineInter" name="deadlineInter">
                                    <input type="hidden" id="etapeDevInter" name="etapeDevInter">
                                    <label class="col-form-label texte">Voulez-vous vraiment débuter</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Débuter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal achever intermediaire -->
        <div class="modal fade" id="finInter" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Choix de l'étape suivante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.acheverIntermediaire') }}" method="POST">
                            @csrf
                            <!-- Choix d'étape -->
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <input type="hidden" id="etapeIdInter" name="idDCSdcEtapeDev">
                                    <label class="col-form-label texte">Choix etape suivante</label>
                                </div>
                                <div class="col-12">
                                    <select class="form-control" name="etapeDEV" required>
                                        @for ($et = 0; $et < count($etapeDev); $et++)
                                            <option value="{{ $etapeDev[$et]->id }}">{{ $etapeDev[$et]->etape }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="row no-gutters mt-3">
                                <div class="col-12">
                                    <label class="col-form-label texte">Commentaire</label>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                                </div>
                            </div>

                            <!-- Boutons Annuler et Achever -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Achever</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal debut montage -->
        <div class="modal fade" id="debutMontage" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Débuter l'étape montage</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.debutMontage') }}" method="POST">
                            @csrf
                            <!-- Choix d'étape -->
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <input type="hidden" id="etapeIdMontage" name="etapeIdMontage">
                                    <input type="hidden" id="dateEntreeMontage" name="dateEntreeMontage">
                                    <input type="hidden" id="deadlineMontage" name="deadlineMontage">
                                    <label class="col-form-label texte">Voulez-vous vraiment débuter</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Débuter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal achever montage -->
        <div class="modal fade" id="finMontage" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Choix de l'étape suivante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.acheverMontage') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <input type="hidden" id="etapeIdMontage" name="idDCSdcEtapeDev">
                                            <label class="col-form-label texte">Date fin</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="datetime-local" name="dateFin" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Multiplicateur</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="multiplicateur" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Quantité produite </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="qteProduite" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row no-gutters mt-3">
                                <div class="col-12">
                                    <label class="col-form-label texte">Commentaire</label>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte">Employé</label>
                                </div>
                                <div class="col-8 mr-2">
                                    <select name="employe[]" class="form-control" required>
                                        @for ($empMont = 0; $empMont < count($employeMontage); $empMont++)
                                            <option value="{{ $employeMontage[$empMont]->id }}">
                                                {{ $employeMontage[$empMont]->nom }}
                                                {{ $employeMontage[$empMont]->prenom }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-success"
                                        onclick="addSelect()">+</button>
                                </div>
                            </div>

                            <div id="select-container"></div>

                            <!-- Boutons Annuler et Achever -->
                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Achever</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal debut controle final -->
        <div class="modal fade" id="debutControlFinal" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Débuter le contrôle final</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.debutControleFinal') }}" method="POST">
                            @csrf
                            <!-- Choix d'étape -->
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <input type="hidden" id="etapeIdFinal" name="etapeIdFinal">
                                    <input type="hidden" id="dateEntreeFinal" name="dateEntreeFinal">
                                    <input type="hidden" id="deadlineFinal" name="deadlineFinal">
                                    <label class="col-form-label texte">Voulez-vous vraiment débuter</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Débuter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal achever controle final -->
        <div class="modal fade" id="finControleFinal" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Contrôle final</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.acheverControleFinal') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <input type="hidden" id="etapeIdControleFinal"
                                                name="idDCSdcEtapeDev">
                                            <label class="col-form-label texte">Date fin</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="datetime-local" name="dateFin" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label ">Retouche</label>
                                        </div>
                                        <div class="col-12">
                                            <label class="col-form-label mr-3 texte">Retouche</label>
                                            <input type="checkbox" name="retouche" value="1">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Type retouche </label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="typeRetouche" required>
                                                @for ($re = 0; $re < count($retouche); $re++)
                                                    <option value="{{ $retouche[$re]->id }}">
                                                        {{ $retouche[$re]->typeretouche }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Quantité contrôlé</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="qteControle" class="form-control"
                                                value="0" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Quantité retouche</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="qteRetouche" class="form-control"
                                                value="0" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Quantité rejet </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="qteRejet" class="form-control"
                                                value="0" required>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row no-gutters mt-3">
                                <div class="col-12">
                                    <label class="col-form-label texte">Commentaire</label>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                                </div>
                            </div>

                            <!-- Boutons Annuler et Achever -->
                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Achever</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal achever rapport finition-->
        <div class="modal fade" id="finFinition" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Rapport finition</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.acheverFinition') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <input type="hidden" id="etapeIdFinition" name="idDCSdcEtapeDev">
                                            <label class="col-form-label texte">Date fin</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="datetime-local" name="dateFin" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label ">Quantité finition</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="qte" class="form-control"
                                                value="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Finisseur(euse) </label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="finisseur" required>
                                                @for ($emp = 0; $emp < count($employeDev); $emp++)
                                                    <option value="{{ $employeDev[$emp]->id }}">
                                                        {{ $employeDev[$emp]->nom }} {{ $employeDev[$emp]->prenom }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row no-gutters mt-3">
                                <div class="col-12">
                                    <label class="col-form-label texte">Commentaire</label>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Achever</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal debut rapport finition -->
        <div class="modal fade" id="debutRapportFinition" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Débuter le rapport finition</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.debutRapportFinition') }}" method="POST">
                            @csrf
                            <!-- Choix d'étape -->
                            <div class="row no-gutters">
                                <div class="col-12">
                                    <input type="hidden" id="etapeIdFinal" name="etapeIdFinal">
                                    <input type="hidden" id="dateEntreeFinal" name="dateEntreeFinal">
                                    <input type="hidden" id="deadlineFinal" name="deadlineFinal">
                                    <label class="col-form-label texte">Voulez-vous vraiment débuter</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Débuter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal transmission -->
        <div class="modal fade" id="transmission" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Transmission du demande au merch</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.transmission') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <input type="hidden" id="etapeIdTransmission" name="idDCSdcEtapeDev">
                                            <label class="col-form-label texte">Date envoie au merch</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="datetime-local" name="dateEnvoie" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label ">Quantité envoyé</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="qte" id="qteTransmission"
                                                class="form-control" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row no-gutters">
                                <div class="col-12">
                                    <label class="col-form-label texte">Commentaire</label>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal transmission client -->
        <div class="modal fade" id="transmissionClient" tabindex="-1" role="dialog"
            aria-labelledby="choixEtapeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Transmission du demande au client</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('DEV.transmissionClient') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <input type="hidden" id="etapeIdTransmissionClient"
                                                name="idDCSdcEtapeDev">
                                            <label class="col-form-label texte">Date envoie au merch</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="datetime-local" name="dateEnvoie" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Quantité envoyé</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="qte" id="qteTransmissionClient"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Lieu</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="lieu" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Mode d'envoie</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="modeEnvoie" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">AWB</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="awb" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Commentaire</label>
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!--**********************************
        modal start
***********************************-->




<!--**********************************
        javascript start
***********************************-->
<script>
    document.getElementById('linkToDisable').classList.add('disabled-link');
</script>

{{--  modal achever bureau etude  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#choixEtapeModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');

            var modal = $(this);
            modal.find('#etapeId').val(etapeId);
        });
    });
</script>

{{--  debut patronage  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#debutPatronage').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');
            var dateEntree = button.data('dateentree');
            var deadline = button.data('deadline');
            console.log(dateEntree);
            var modal = $(this);
            modal.find('#etapeIdPatronage').val(etapeId);
            modal.find('#dateEntreePatronage').val(dateEntree);
            modal.find('#deadlinePatronage').val(deadline);
        });
    });
</script>

{{--  achever patronage  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#acheverPatronage').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');

            var modal = $(this);
            modal.find('#etapeIdPatronage').val(etapeId);
        });
    });
</script>

{{--  debut controle patronage  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#debutControlePatronage').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('idcontrolepatronage');
            var dateEntree = button.data('dateentreecontrolepatronage');
            var deadline = button.data('deadlinecontrolepatronage');
            console.log(dateEntree);
            var modal = $(this);
            modal.find('#etapeIdControlePatronage').val(etapeId);
            modal.find('#dateEntreeControlePatronage').val(dateEntree);
            modal.find('#deadlineControlePatronage').val(deadline);
        });
    });
</script>

{{--  achever controle patronage  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#acheverControlePatronage').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');

            var modal = $(this);
            modal.find('#etapeIdControlePatronage').val(etapeId);
        });
    });
</script>

{{--  achever attente  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#acheverAttente').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');

            var modal = $(this);
            modal.find('#etapeIdAttente').val(etapeId);
        });
    });
</script>


{{--  debut placement  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#debutPlacement').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');
            var etapeIdDC = button.data('iddemandeclient');
            var dateEntree = button.data('dateentreeplacement');
            var deadline = button.data('deadlineplacement');
            console.log(etapeIdDC);
            var modal = $(this);
            modal.find('#idDCDSCEtapeDev').val(etapeId);
            modal.find('#idDemandeClientPlacement').val(etapeIdDC);
            modal.find('#dateEntreePlacement').val(dateEntree);
            modal.find('#deadlinePlacement').val(deadline);
        });
    });
</script>

{{--  debut intermedaire  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#debutEtapeIntermediaire').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('idinter');
            var dateEntree = button.data('dateentreeinter');
            var deadline = button.data('deadlineinter');
            var etapedev = button.data('etapedevinter');
            console.log(dateEntree);
            var modal = $(this);
            modal.find('#etapeIdInter').val(etapeId);
            modal.find('#dateEntreeInter').val(dateEntree);
            modal.find('#deadlineInter').val(deadline);
            modal.find('#etapeDevInter').val(etapedev);
        });
    });
</script>
{{--  modal achever inter  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#finInter').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');

            var modal = $(this);
            modal.find('#etapeIdInter').val(etapeId);
        });
    });
</script>

{{--  debut montage  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#debutMontage').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('idmontage');
            var dateEntree = button.data('dateentreemontage');
            var deadline = button.data('deadlinemontage');
            console.log(dateEntree);
            var modal = $(this);
            modal.find('#etapeIdMontage').val(etapeId);
            modal.find('#dateEntreeMontage').val(dateEntree);
            modal.find('#deadlineMontage').val(deadline);
        });
    });
</script>

{{--  ajout employe  --}}
<script>
    function addSelect() {
        // Créer un nouveau conteneur div pour la nouvelle sélection et le bouton supprimer
        var newDiv = document.createElement('div');
        newDiv.classList.add('row', 'no-gutters', 'mt-2');

        var newSelectDiv = document.createElement('div');
        newSelectDiv.classList.add('col-8', 'mr-2');

        // Créer une nouvelle liste déroulante
        var newSelect = document.createElement('select');
        newSelect.name = "employe[]";
        newSelect.classList.add('form-control');

        @for ($empMont = 0; $empMont < count($employeMontage); $empMont++)
            var option = document.createElement('option');
            option.value = "{{ $employeMontage[$empMont]->id }}";
            option.text = "{{ $employeMontage[$empMont]->nom }} {{ $employeMontage[$empMont]->prenom }}";
            newSelect.appendChild(option);
        @endfor

        newSelectDiv.appendChild(newSelect);

        var deleteButtonDiv = document.createElement('div');
        deleteButtonDiv.classList.add('col-2');


        var deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.classList.add('btn', 'btn-danger');
        deleteButton.textContent = '-';
        deleteButton.onclick = function() {
            newDiv.remove();
        };

        deleteButtonDiv.appendChild(deleteButton);


        newDiv.appendChild(newSelectDiv);
        newDiv.appendChild(deleteButtonDiv);


        document.getElementById('select-container').appendChild(newDiv);
    }
</script>

{{--  modal achever montage  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#finMontage').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');

            var modal = $(this);
            modal.find('#etapeIdMontage').val(etapeId);
        });
    });
</script>

{{--  debut controle final  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#debutControlFinal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('idfinal');
            var dateEntree = button.data('dateentreefinal');
            var deadline = button.data('deadlinefinal');
            console.log(dateEntree);
            var modal = $(this);
            modal.find('#etapeIdFinal').val(etapeId);
            modal.find('#dateEntreeFinal').val(dateEntree);
            modal.find('#deadlineFinal').val(deadline);
        });
    });
</script>

{{--  fin control final  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#finControleFinal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');

            var modal = $(this);
            modal.find('#etapeIdControleFinal').val(etapeId);
        });
    });
</script>

{{--  fin finition  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#finFinition').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');
            console.log('heyyy');
            console.log(etapeId);
            var modal = $(this);
            modal.find('#etapeIdFinition').val(etapeId);
        });
    });
</script>

{{--  debut rapport finition  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#debutRapportFinition').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('idfinal');
            var dateEntree = button.data('dateentreefinal');
            var deadline = button.data('deadlinefinal');
            console.log(dateEntree);
            var modal = $(this);
            modal.find('#etapeIdFinal').val(etapeId);
            modal.find('#dateEntreeFinal').val(dateEntree);
            modal.find('#deadlineFinal').val(deadline);
        });
    });
</script>


{{--  transmission  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#transmission').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');
            var qte = button.data('qte');
            console.log('heyyy');
            console.log(etapeId);
            var modal = $(this);
            modal.find('#etapeIdTransmission').val(etapeId);
            modal.find('#qteTransmission').val(qte);
        });
    });
</script>

{{--  transmission client  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#transmissionClient').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');
            var qte = button.data('qte');
            console.log('heyyy');
            console.log(etapeId);
            var modal = $(this);
            modal.find('#etapeIdTransmissionClient').val(etapeId);
            modal.find('#qteTransmissionClient').val(qte);
        });
    });
</script>

{{--  saison  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomSaison = document.getElementById('nomSaison');
        var idSaison = document.getElementById('idSaison');
        var suggestionsList = document.getElementById('suggestionsListSaison');

        nomSaison.addEventListener('input', function() {
            var query = nomSaison.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('recherche-saison') }}?nomSaison=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function(saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.type_saison;
                            li.addEventListener('click', function() {
                                nomSaison.value = saison.type_saison;
                                idSaison.value = saison.id;
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(li);
                        });
                        suggestionsList.style.display = 'block';
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                }
            };
            xhr.send();
        });

        document.addEventListener('click', function(event) {
            if (!nomSaison.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

{{--  tiers  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomTiers = document.getElementById('nomTiers');
        var idTiers = document.getElementById('idTiers');
        var suggestionsListTiers = document.getElementById('suggestionsListTiers');

        nomTiers.addEventListener('input', function() {
            var query = nomTiers.value;

            if (query.length < 1) {
                suggestionsListTiers.style.display = 'none';
                return;
            }

            var xhr1 = new XMLHttpRequest();
            xhr1.open('GET', '{{ route('recherche-tiers-demande') }}?nomTiers=' + encodeURIComponent(
                query), true);
            xhr1.onload = function() {
                if (xhr1.status === 200) {
                    var tiers = JSON.parse(xhr1.responseText);
                    suggestionsListTiers.innerHTML = '';
                    if (tiers.length > 0) {
                        tiers.forEach(function(tier) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = tier.nomtier;
                            li.addEventListener('click', function() {
                                nomTiers.value = tier.nomtier;
                                idTiers.value = tier.id;
                                suggestionsListTiers.style.display = 'none';
                            });
                            suggestionsListTiers.appendChild(li);
                        });
                        suggestionsListTiers.style.display = 'block';
                    } else {
                        suggestionsListTiers.style.display = 'none';
                    }
                }
            };
            xhr1.send();
        });

        document.addEventListener('click', function(event) {
            if (!nomTiers.contains(event.target) && !suggestionsListTiers.contains(event.target)) {
                suggestionsListTiers.style.display = 'none';
            }
        });
    });
</script>

{{--  employe  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('heeyyyy');
        var nomSaison = document.getElementById('nomEmploye');
        var idSaison = document.getElementById('idEmploye');
        var suggestionsList = document.getElementById('suggestionsListEmploye');

        nomSaison.addEventListener('input', function() {
            var query = nomSaison.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('DEV.recherchePatronier') }}?nom=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function(saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.nom + ' ' + saison.prenom;
                            li.addEventListener('click', function() {
                                nomSaison.value = saison.nom + ' ' + saison.prenom;
                                idSaison.value = saison.id;
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(li);
                        });
                        suggestionsList.style.display = 'block';
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                }
            };
            xhr.send();
        });

        document.addEventListener('click', function(event) {
            if (!nomSaison.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

{{--  style  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomSaison = document.getElementById('nomStyle');
        var idSaison = document.getElementById('idStyle');
        var suggestionsList = document.getElementById('suggestionsListStyle');

        nomSaison.addEventListener('input', function() {
            var query = nomSaison.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('recherche-style') }}?nomStyle=' + encodeURIComponent(query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function(saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.nom_style;
                            li.addEventListener('click', function() {
                                nomSaison.value = saison.nom_style;
                                idSaison.value = saison.id;
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(li);
                        });
                        suggestionsList.style.display = 'block';
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                }
            };
            xhr.send();
        });

        document.addEventListener('click', function(event) {
            if (!nomSaison.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

{{--  stade  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomSaison = document.getElementById('nomStade');
        var idSaison = document.getElementById('idStade');
        var suggestionsList = document.getElementById('suggestionsListStade');

        nomSaison.addEventListener('input', function() {
            var query = nomSaison.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('DEV.rechercheStade') }}?type_stade=' + encodeURIComponent(
                    query),
                true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var saisons = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (saisons.length > 0) {
                        saisons.forEach(function(saison) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = saison.type_stade;
                            li.addEventListener('click', function() {
                                nomSaison.value = saison.type_stade;
                                idSaison.value = saison.type_stade;
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(li);
                        });
                        suggestionsList.style.display = 'block';
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                }
            };
            xhr.send();
        });

        document.addEventListener('click', function(event) {
            if (!nomSaison.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
