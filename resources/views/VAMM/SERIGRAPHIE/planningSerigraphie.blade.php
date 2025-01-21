@include('CRM.header')
@include('CRM.sidebar')
<title>PlanningSerigraphie</title>

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
        width: 300px;
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
        @include('VAMM.headerVAMM')
        {{--  <div class="row" style="margin-bottom: -20px;margin-top: -10px;">
            <div class="col-lg-4 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #3a7bd5, #3a6073);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Nbr Commande</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $nombre }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-list"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #4568dc, #b06ab3);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Quantite commande</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $qte }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-handshake"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #43cea2, #185a9d);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                Nego</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $nego }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-check-circle"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>

        </div>  --}}
{{--
        <div class="row" style="margin-top: 0;">
            <div class="col-lg-3 col-sm-4">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #ff6e7f, #556770);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                PROTO</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $proto }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-cogs"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #16a085, #f4d03f);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                TDS</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $tds }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-file-alt"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #82a382, #000c40);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                PPS</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $pps }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-box"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-small"
                    style="border-radius: 15px 3px 15px 3px; height: 50px; background: linear-gradient(to right, #667eea, #764ba2);">
                    <div class="card-body d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div>
                            <h3 class="card-title text-white" style="margin-bottom: 5px; font-size: calc(0.1em + 1vw);">
                                PROD</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white" style="font-size: calc(0.5em + 1vw);">{{ $prod }}</h2>
                            </div>
                        </div>
                        <span class="display-5" style="font-size: calc(1em + 1vw);"><i class="fa fa-industry"
                                style="color: white;"></i></span>
                    </div>
                </div>
            </div>
        </div>  --}}
        <div class="row">

            <div class="card col-12">
                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">PLANNING SERIGRAPHIE</h3>
                </div>

                <form action="{{ route('SERIGRAPHIE.planningSerigraphie') }}" method="post" autocomplete="off">
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

                            <select class="form-control" name="etatDemande">
                                @if (!empty($etatDemande))
                                    <option value="{{ $etatDemande }}">{{ $etatDemande }}</option>
                                @endif
                                <option value="">Etat</option>

                                @foreach ($etat as $et)
                                    <option value="{{ $et->type_etat }}">
                                        {{ $et->type_etat }}
                                    </option>
                                @endforeach
                            </select>

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

                <div class="kanban-board mt-4">

                    <div class="kanban-column">
                        <h5 class="kanban-header">ACHAT ENCRE ECHANTILLON</h5>
                        @for ($i = 0; $i < count($demandeSer); $i++)
                            @if ($demandeSer[$i]->etat_achat_encre_echan == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeSer[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demandeSer[$i]->stadesdc))
                                                <b>{{ $demandeSer[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demandeSer[$i]->stade_demande }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(0)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(0)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(0)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client,'id' => $demandeSer[$i]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeSer[$i]->id }}" data-idetape="1"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(0)}}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">PAO</h5>
                        @for ($i = 0; $i < count($demandeSer); $i++)
                            @if ($demandeSer[$i]->etat_pao == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeSer[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demandeSer[$i]->stadesdc))
                                                <b>{{ $demandeSer[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demandeSer[$i]->stade_demande }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(1)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(1)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(1)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client,'id' => $demandeSer[$i]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeSer[$i]->id }}" data-idetape="2"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(1) }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">PRI</h5>
                        @for ($i = 0; $i < count($demandeSer); $i++)
                            @if ($demandeSer[$i]->etat_pri == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeSer[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demandeSer[$i]->stadesdc))
                                                <b>{{ $demandeSer[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demandeSer[$i]->stade_demande }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(2)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(2)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(2)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client,'id' => $demandeSer[$i]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeSer[$i]->id }}" data-idetape="3"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(2) }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>


                    <div class="kanban-column">
                        <h5 class="kanban-header">IMPRESSION DESSIN</h5>
                        @for ($i = 0; $i < count($demandeSer); $i++)
                            @if ($demandeSer[$i]->etat_impression_dession == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeSer[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demandeSer[$i]->stadesdc))
                                                <b>{{ $demandeSer[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demandeSer[$i]->stade_demande }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(1)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(1)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDay()->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client,'id' => $demandeSer[$i]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeSer[$i]->id }}" data-idetape="4"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDay() }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endfor

                        @for ($j = 0; $j < count($demandeChangeStade); $j++)
                            @if ($demandeChangeStade[$j]->etat_impression_dession == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeChangeStade[$j]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeChangeStade[$j]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeChangeStade[$j]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demandeChangeStade[$j]->stadesdc }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(0)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(0)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(0)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeChangeStade[$j]->id_demande_client,'id' => $demandeChangeStade[$j]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeChangeStade[$j]->id }}" data-idetape="4"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(0) }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header"><i class="fas fa-search"></i>
                            COLORIS ET VALIDAT°</h5>
                        @for ($i = 0; $i < count($demandeSer); $i++)
                            @if ($demandeSer[$i]->etat_recher_coloris_validaint == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeSer[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demandeSer[$i]->stadesdc))
                                                <b>{{ $demandeSer[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demandeSer[$i]->stade_demande }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(3)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(3)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(3)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client,'id' => $demandeSer[$i]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeSer[$i]->id }}" data-idetape="5"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(3) }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor

                        @for ($j = 0; $j < count($demandeChangeStade); $j++)
                            @if ($demandeChangeStade[$j]->etat_recher_coloris_validaint == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeChangeStade[$j]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeChangeStade[$j]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeChangeStade[$j]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demandeChangeStade[$j]->stadesdc }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(1)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(1)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(1)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeChangeStade[$j]->id_demande_client,'id' => $demandeChangeStade[$j]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeChangeStade[$j]->id }}" data-idetape="5"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(1) }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">INSOLATION CADRE</h5>
                        @for ($i = 0; $i < count($demandeSer); $i++)
                            @if ($demandeSer[$i]->etat_insolacadre == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeSer[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demandeSer[$i]->stadesdc))
                                                <b>{{ $demandeSer[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demandeSer[$i]->stade_demande }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(3)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(3)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(3)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeSer[$i]->id }}" data-idetape="6"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(3)}}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor

                        @for ($j = 0; $j < count($demandeChangeStade); $j++)
                            @if ($demandeChangeStade[$j]->etat_insolacadre == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeChangeStade[$j]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeChangeStade[$j]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeChangeStade[$j]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demandeChangeStade[$j]->stadesdc }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(1)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(1)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(1)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeChangeStade[$j]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeChangeStade[$j]->id }}" data-idetape="6"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(1) }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">RACLAGE</h5>
                        @for ($i = 0; $i < count($demandeSer); $i++)
                            @if ($demandeSer[$i]->etat_raclage == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeSer[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeSer[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demandeSer[$i]->stadesdc))
                                                <b>{{ $demandeSer[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demandeSer[$i]->stade_demande }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(5)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(5)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(5)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeSer[$i]->id }}" data-idetape="7"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeSer[$i]->date_entree)->addDays(5) }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor

                        @for ($j = 0; $j < count($demandeChangeStade); $j++)
                            @if ($demandeChangeStade[$j]->etat_raclage == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeChangeStade[$j]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeChangeStade[$j]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeChangeStade[$j]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demandeChangeStade[$j]->stadesdc }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(2)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(2)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(2)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeChangeStade[$j]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeChangeStade[$j]->id }}" data-idetape="7"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(2)}}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">ACHAT ENCRE PROD</h5>
                        @for ($j = 0; $j < count($demandeChangeStade); $j++)
                            @if ($demandeChangeStade[$j]->etat_achat_encre_prod == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeChangeStade[$j]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeChangeStade[$j]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeChangeStade[$j]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demandeChangeStade[$j]->stadesdc }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(0)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(0)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(0)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeChangeStade[$j]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeChangeStade[$j]->id }}" data-idetape="8"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->addDays(0) }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor

                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">GABARITS</h5>
                        @for ($p = 0; $p < count($demandeProd); $p++)
                            @if ($demandeProd[$p]->etat_gabarits == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeProd[$p]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeProd[$p]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeProd[$p]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeProd[$p]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demandeProd[$p]->stadesdc }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeProd[$p]->date_entree)->addDays(1)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeProd[$p]->date_entree)->addDays(1)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeProd[$p]->date_entree)->addDays(1)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeProd[$p]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeProd[$p]->id }}" data-idetape="9"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeProd[$p]->date_entree)->addDays(1)}}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">PREPARATION TABLE</h5>
                        @for ($p = 0; $p < count($demandeProd); $p++)
                            @if ($demandeProd[$p]->etat_prepa_table == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeProd[$p]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeProd[$p]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeProd[$p]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeProd[$p]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demandeProd[$p]->stadesdc }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeProd[$p]->date_entree)->addDays(2)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeProd[$p]->date_entree)->addDays(2)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeProd[$p]->date_entree)->addDays(2)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeProd[$p]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeProd[$p]->id }}" data-idetape="10"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeProd[$p]->date_entree)->addDays(2) }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">PREPARATION ENCRE PROD</h5>
                        @for ($p = 0; $p < count($demandeProd); $p++)
                            @if ($demandeProd[$p]->etat_prepa_encre_prod == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandeProd[$p]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeProd[$p]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandeProd[$p]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandeProd[$p]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <b>{{ $demandeProd[$p]->stadesdc }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandeProd[$p]->date_entree)->addDays(1)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeProd[$p]->date_entree)->addDays(1)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandeProd[$p]->date_entree)->addDays(1)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeProd[$p]->id_demande_client,'id' => $demandeProd[$p]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandeProd[$p]->id }}" data-idetape="11"
                                                data-deadline="{{ \Carbon\Carbon::parse($demandeProd[$p]->date_entree)->addDays(1) }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                </div>

            </div>

        </div>


        <!-- Modal fin etape  -->
        <div class="modal fade" id="finEtape" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Confirmation de finalisation de tâche</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('SERIGRAPHIE.finEtapePlanning') }}" method="POST"
                            autocomplete="off">
                            @csrf
                            <div class="row no-gutters mt-2">
                                <div class="col-12">
                                    <input type="hidden" id="idDemandeSer" name="idDemandeSer">
                                    <input type="hidden" id="deadlineSer" name="deadlineSer">
                                    <input type="hidden" id="idEtape" name="idEtape">
                                    <label class="col-form-label texte">Êtes-vous certain de vouloir finaliser cette
                                        tâche ? Cette action est irréversible.</label>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte"><b>Commentaire </b></label>
                                        </div>
                                        <div class="col-12">
                                            <textarea name="commentaire" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Terminer</button>
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
{{--  modal achever montage  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#finEtape').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var iddemandeser = button.data('id');
            var idetape = button.data('idetape');
            var deadline = button.data('deadline');

            var modal = $(this);
            modal.find('#idDemandeSer').val(iddemandeser);
            modal.find('#idEtape').val(idetape);
            modal.find('#deadlineSer').val(deadline);
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
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
