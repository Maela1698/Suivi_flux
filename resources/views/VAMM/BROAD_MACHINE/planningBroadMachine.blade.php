@include('CRM.header')
@include('CRM.sidebar')
<title>PlanningBroadMachine</title>

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
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('VAMM.headerVAMM')

        <div class="row">
            <div class="card col-12">
                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">PLANNING BRODERIE MACHINE</h3>
                </div>

                <form action="{{ route('BRODMACHINE.planningBrodMachine') }}" method="post" autocomplete="off">
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
                <div class="kanban-board">

                    <div class="kanban-column">
                        <h5 class="kanban-header">PAO</h5>
                        @for ($i = 0; $i < count($demandePremier); $i++)
                            @if ($demandePremier[$i]->etat_pao == 0)
                                <div class="kanban-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <button id="inactiveButton" class="btn btn"
                                                style="background-color: yellow; color: black;" disabled>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->format('d/m/y') }}
                                            </button>
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandePremier[$i]->nomtier }}</b>
                                            </button>

                                            &nbsp;&nbsp;&nbsp;
                                            <button id="inactiveButton" class="btn btn-secondary"
                                                style="background-color: transparent; color: black; border: none;"
                                                disabled>
                                                <b>{{ $demandePremier[$i]->type_saison }}</b>
                                            </button>

                                            <br>
                                            <br>
                                            <b>{{ $demandePremier[$i]->nom_modele }}</b>
                                            &nbsp;&nbsp;&nbsp;
                                            @if (!empty($demandePremier[$i]->stadesdc))
                                                <b>{{ $demandePremier[$i]->stadesdc }}</b>
                                            @else
                                                <b>{{ $demandePremier[$i]->stade_demandePremier }}</b>
                                            @endif
                                            &nbsp;&nbsp;&nbsp;
                                            <p class="card-time"> </p>
                                            @if (\Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(2)->gt(\Carbon\Carbon::today()))
                                                <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(2)->format('d/m/y') }}
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                                    id="linkToDisable">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(2)->format('d/m/y') }}
                                                </a>
                                            @endif
                                            <a href="#" class="btn btn-primary btn-info btn-sm mt-1"
                                                style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                                style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                                data-id="{{ $demandePremier[$i]->id }}" data-idetape="1">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endfor

                        @for ($j = 0; $j < count($demandeChangeStade); $j++)
                        @if ($demandeChangeStade[$j]->etat_pao==0)
                        <div class="kanban-card">
                            <div class="card">
                                <div class="card-body">
                                    <button id="inactiveButton" class="btn btn"
                                        style="background-color: yellow; color: black;" disabled>
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->date_entree)->format('d/m/y') }}
                                    </button>
                                    <button id="inactiveButton" class="btn btn-secondary"
                                        style="background-color: transparent; color: black; border: none;" disabled>
                                        <b>{{ $demandeChangeStade[$j]->nomtier }}</b>
                                    </button>

                                    &nbsp;&nbsp;&nbsp;
                                    <button id="inactiveButton" class="btn btn-secondary"
                                        style="background-color: transparent; color: black; border: none;" disabled>
                                        <b>{{ $demandeChangeStade[$j]->type_saison }}</b>
                                    </button>

                                    <br>
                                    <br>
                                    <b>{{ $demandeChangeStade[$j]->nom_modele }}</b>
                                    &nbsp;&nbsp;&nbsp;
                                    @if (!empty($demandeChangeStade[$j]->stadesdc))
                                        <b>{{ $demandeChangeStade[$j]->stadesdc }}</b>
                                    @else
                                        <b>{{ $demandeChangeStade[$j]->stade_demandeChangeStade }}</b>
                                    @endif
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
                                    <a href="#" class="btn btn-primary btn-info btn-sm mt-1"
                                        style="width: 50px;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                        style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                        data-id="{{ $demandeChangeStade[$j]->id }}" data-idetape="1">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @endfor


                        @for ($t = 0; $t < count($demandeProd); $t++)
                        @if ($demandeProd[$t]->etat_pao==0)
                        <div class="kanban-card">
                            <div class="card">
                                <div class="card-body">
                                    <button id="inactiveButton" class="btn btn"
                                        style="background-color: yellow; color: black;" disabled>
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($demandeProd[$t]->date_entree)->format('d/m/y') }}
                                    </button>
                                    <button id="inactiveButton" class="btn btn-secondary"
                                        style="background-color: transparent; color: black; border: none;" disabled>
                                        <b>{{ $demandeProd[$t]->nomtier }}</b>
                                    </button>

                                    &nbsp;&nbsp;&nbsp;
                                    <button id="inactiveButton" class="btn btn-secondary"
                                        style="background-color: transparent; color: black; border: none;" disabled>
                                        <b>{{ $demandeProd[$t]->type_saison }}</b>
                                    </button>

                                    <br>
                                    <br>
                                    <b>{{ $demandeProd[$t]->nom_modele }}</b>
                                    &nbsp;&nbsp;&nbsp;
                                    @if (!empty($demandeProd[$t]->stadesdc))
                                        <b>{{ $demandeProd[$t]->stadesdc }}</b>
                                    @else
                                        <b>{{ $demandeProd[$t]->stade_demandeProd }}</b>
                                    @endif
                                    &nbsp;&nbsp;&nbsp;
                                    <p class="card-time"> </p>
                                    @if (\Carbon\Carbon::parse($demandeProd[$t]->date_entree)->addDays(2)->gt(\Carbon\Carbon::today()))
                                        <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                            id="linkToDisable">
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($demandeProd[$t]->date_entree)->addDays(2)->format('d/m/y') }}
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                            id="linkToDisable">
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($demandeProd[$t]->date_entree)->addDays(2)->format('d/m/y') }}
                                        </a>
                                    @endif
                                    <a href="#" class="btn btn-primary btn-info btn-sm mt-1"
                                        style="width: 50px;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                        style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                        data-id="{{ $demandeProd[$t]->id }}" data-idetape="1">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @endfor

                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">ESSAI SUR PNX</h5>
                        @for ($i = 0; $i < count($demandePremier); $i++)
                        @if ($demandePremier[$i]->etat_essai_pnx==0)
                        <div class="kanban-card">
                            <div class="card">
                                <div class="card-body">
                                    <button id="inactiveButton" class="btn btn"
                                        style="background-color: yellow; color: black;" disabled>
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->format('d/m/y') }}
                                    </button>
                                    <button id="inactiveButton" class="btn btn-secondary"
                                        style="background-color: transparent; color: black; border: none;"
                                        disabled>
                                        <b>{{ $demandePremier[$i]->nomtier }}</b>
                                    </button>

                                    &nbsp;&nbsp;&nbsp;
                                    <button id="inactiveButton" class="btn btn-secondary"
                                        style="background-color: transparent; color: black; border: none;"
                                        disabled>
                                        <b>{{ $demandePremier[$i]->type_saison }}</b>
                                    </button>

                                    <br>
                                    <br>
                                    <b>{{ $demandePremier[$i]->nom_modele }}</b>
                                    &nbsp;&nbsp;&nbsp;
                                    @if (!empty($demandePremier[$i]->stadesdc))
                                        <b>{{ $demandePremier[$i]->stadesdc }}</b>
                                    @else
                                        <b>{{ $demandePremier[$i]->stade_demandePremier }}</b>
                                    @endif
                                    &nbsp;&nbsp;&nbsp;
                                    <p class="card-time"> </p>
                                    @if (\Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(3)->gt(\Carbon\Carbon::today()))
                                        <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                            id="linkToDisable">
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(3)->format('d/m/y') }}
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                            id="linkToDisable">
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(3)->format('d/m/y') }}
                                        </a>
                                    @endif
                                    <a href="#" class="btn btn-primary btn-info btn-sm mt-1"
                                        style="width: 50px;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                        style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                        data-id="{{ $demandePremier[$i]->id }}" data-idetape="2">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">COTATION</h5>
                        @for ($i = 0; $i < count($demandePremier); $i++)
                        @if ($demandePremier[$i]->etat_cotation==0)
                        <div class="kanban-card">
                            <div class="card">
                                <div class="card-body">
                                    <button id="inactiveButton" class="btn btn"
                                        style="background-color: yellow; color: black;" disabled>
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->format('d/m/y') }}
                                    </button>
                                    <button id="inactiveButton" class="btn btn-secondary"
                                        style="background-color: transparent; color: black; border: none;"
                                        disabled>
                                        <b>{{ $demandePremier[$i]->nomtier }}</b>
                                    </button>

                                    &nbsp;&nbsp;&nbsp;
                                    <button id="inactiveButton" class="btn btn-secondary"
                                        style="background-color: transparent; color: black; border: none;"
                                        disabled>
                                        <b>{{ $demandePremier[$i]->type_saison }}</b>
                                    </button>

                                    <br>
                                    <br>
                                    <b>{{ $demandePremier[$i]->nom_modele }}</b>
                                    &nbsp;&nbsp;&nbsp;
                                    @if (!empty($demandePremier[$i]->stadesdc))
                                        <b>{{ $demandePremier[$i]->stadesdc }}</b>
                                    @else
                                        <b>{{ $demandePremier[$i]->stade_demandePremier }}</b>
                                    @endif
                                    &nbsp;&nbsp;&nbsp;
                                    <p class="card-time"> </p>
                                    @if (\Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(3)->gt(\Carbon\Carbon::today()))
                                        <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                            id="linkToDisable">
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(3)->format('d/m/y') }}
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                            id="linkToDisable">
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(3)->format('d/m/y') }}
                                        </a>
                                    @endif
                                    <a href="#" class="btn btn-primary btn-info btn-sm mt-1"
                                        style="width: 50px;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                        style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                        data-id="{{ $demandePremier[$i]->id }}" data-idetape="3">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @endfor

                        @for ($j = 0; $j < count($demandeChangeStade); $j++)
                        @if ($demandeChangeStade[$j]->etat_cotation==0)
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
                                    @if (!empty($demandeChangeStade[$j]->stadesdc))
                                        <b>{{ $demandeChangeStade[$j]->stadesdc }}</b>
                                    @else
                                        <b>{{ $demandeChangeStade[$j]->stade_demandeChangeStade }}</b>
                                    @endif
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
                                    <a href="#" class="btn btn-primary btn-info btn-sm mt-1"
                                        style="width: 50px;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                        style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                        data-id="{{ $demandeChangeStade[$j]->id }}" data-idetape="3">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @endfor
                    </div>


                    <div class="kanban-column">
                        <h5 class="kanban-header">DEMANDE ACHAT MP</h5>
                        @for ($i = 0; $i < count($demandePremier); $i++)
                        @if ($demandePremier[$i]->etat_demande_achat_mp==0)
                        <div class="kanban-card">
                            <div class="card">
                                <div class="card-body">
                                    <button id="inactiveButton" class="btn btn"
                                        style="background-color: yellow; color: black;" disabled>
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->format('d/m/y') }}
                                    </button>
                                    <button id="inactiveButton" class="btn btn-secondary"
                                        style="background-color: transparent; color: black; border: none;"
                                        disabled>
                                        <b>{{ $demandePremier[$i]->nomtier }}</b>
                                    </button>

                                    &nbsp;&nbsp;&nbsp;
                                    <button id="inactiveButton" class="btn btn-secondary"
                                        style="background-color: transparent; color: black; border: none;"
                                        disabled>
                                        <b>{{ $demandePremier[$i]->type_saison }}</b>
                                    </button>

                                    <br>
                                    <br>
                                    <b>{{ $demandePremier[$i]->nom_modele }}</b>
                                    &nbsp;&nbsp;&nbsp;
                                    @if (!empty($demandePremier[$i]->stadesdc))
                                        <b>{{ $demandePremier[$i]->stadesdc }}</b>
                                    @else
                                        <b>{{ $demandePremier[$i]->stade_demandePremier }}</b>
                                    @endif
                                    &nbsp;&nbsp;&nbsp;
                                    <p class="card-time"> </p>
                                    @if (\Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(1)->gt(\Carbon\Carbon::today()))
                                        <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                            id="linkToDisable">
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(1)->format('d/m/y') }}
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                            id="linkToDisable">
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(1)->format('d/m/y') }}
                                        </a>
                                    @endif
                                    <a href="#" class="btn btn-primary btn-info btn-sm mt-1"
                                        style="width: 50px;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                        style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                        data-id="{{ $demandePremier[$i]->id }}" data-idetape="4">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">BRODER SUR MACHINE</h5>
                        @for ($i = 0; $i < count($demandePremier); $i++)
                        @if ($demandePremier[$i]->etat_broder_machine==0)
                        <div class="kanban-card">
                            <div class="card">
                                <div class="card-body">
                                    <button id="inactiveButton" class="btn btn"
                                        style="background-color: yellow; color: black;" disabled>
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->format('d/m/y') }}
                                    </button>
                                    <button id="inactiveButton" class="btn btn-secondary"
                                        style="background-color: transparent; color: black; border: none;"
                                        disabled>
                                        <b>{{ $demandePremier[$i]->nomtier }}</b>
                                    </button>

                                    &nbsp;&nbsp;&nbsp;
                                    <button id="inactiveButton" class="btn btn-secondary"
                                        style="background-color: transparent; color: black; border: none;"
                                        disabled>
                                        <b>{{ $demandePremier[$i]->type_saison }}</b>
                                    </button>

                                    <br>
                                    <br>
                                    <b>{{ $demandePremier[$i]->nom_modele }}</b>
                                    &nbsp;&nbsp;&nbsp;
                                    @if (!empty($demandePremier[$i]->stadesdc))
                                        <b>{{ $demandePremier[$i]->stadesdc }}</b>
                                    @else
                                        <b>{{ $demandePremier[$i]->stade_demandePremier }}</b>
                                    @endif
                                    &nbsp;&nbsp;&nbsp;
                                    <p class="card-time"> </p>
                                    @if (\Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(2)->gt(\Carbon\Carbon::today()))
                                        <a href="#" class="btn btn-warning btn-add btn-sm mt-1"
                                            id="linkToDisable">
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(2)->format('d/m/y') }}
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-danger btn-add btn-sm mt-1"
                                            id="linkToDisable">
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($demandePremier[$i]->date_entree)->addDays(2)->format('d/m/y') }}
                                        </a>
                                    @endif
                                    <a href="#" class="btn btn-primary btn-info btn-sm mt-1"
                                        style="width: 50px;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                        style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                        data-id="{{ $demandePremier[$i]->id }}" data-idetape="5">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif

                        @endfor

                        @for ($j = 0; $j < count($demandeChangeStade); $j++)
                        @if ($demandeChangeStade[$j]->etat_broder_machine==0)
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
                                    @if (!empty($demandeChangeStade[$j]->stadesdc))
                                        <b>{{ $demandeChangeStade[$j]->stadesdc }}</b>
                                    @else
                                        <b>{{ $demandeChangeStade[$j]->stade_demandeChangeStade }}</b>
                                    @endif
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
                                    <a href="#" class="btn btn-primary btn-info btn-sm mt-1"
                                        style="width: 50px;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <button type="button" class="btn btn-success btn-finish mt-1 btn-sm"
                                        style="width: 50px;" data-toggle="modal" data-target="#finEtape"
                                        data-id="{{ $demandeChangeStade[$j]->id }}" data-idetape="5">
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
                        <form action="{{ route('BRODMACHINE.finEtapePlanningBrodMachine') }}" method="POST"
                            autocomplete="off">
                            @csrf
                            <div class="row no-gutters mt-4">
                                <div class="col-12">
                                    <input type="hidden" id="iddemandePremier" name="idDemandeBrodMachine">
                                    <input type="hidden" id="idEtape" name="idEtape">
                                    <label class="col-form-label texte">Êtes-vous certain de vouloir finaliser cette
                                        tâche ? Cette action est irréversible.</label>
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
            var iddemandePremier = button.data('id');
            var idetape = button.data('idetape');

            var modal = $(this);
            modal.find('#iddemandePremier').val(iddemandePremier);
            modal.find('#idEtape').val(idetape);
        });
    });
</script>
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
