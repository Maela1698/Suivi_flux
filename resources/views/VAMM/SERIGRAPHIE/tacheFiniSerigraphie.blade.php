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
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('VAMM.headerVAMM')
        <div class="row">

            <div class="card col-12">
                <div class="justify-content-center align-items-center entete">
                    <h3 class="entete mt-3">LISTE DES TACHES FINI SERIGRAPHIE</h3>
                </div>
                <form action="{{ route('SERIGRAPHIE.tacheFiniSerigraphie') }}" method="post" autocomplete="off">
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
                            @if ($demandeSer[$i]->etat_achat_encre_echan == 1)
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

                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeSer[$i]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeSer[$i]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1
                                                   {{ $fin->gt($deadline) ? 'btn-danger' : ($deadline->eq($fin) ? 'btn-danger' : 'btn-warning') }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-exclamation' : 'fa-clock' }}"></i>
                                                {{ $fin->gt($deadline) ? 'En retard' : ($deadline->eq($fin) ? 'Pas encore' : $deadline->format('d/m/y')) }}
                                            </a>

                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client, 'id' => $demandeSer[$i]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->fin)->format('d/m/y') }}
                                            </a>



                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">PAO</h5>
                        @for ($i = 0; $i < count($demandeSer); $i++)
                            @if ($demandeSer[$i]->etat_pao == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeSer[$i]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeSer[$i]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>


                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client, 'id' => $demandeSer[$i]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->fin)->format('d/m/y') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">PRI</h5>
                        @for ($i = 0; $i < count($demandeSer); $i++)
                            @if ($demandeSer[$i]->etat_pri == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeSer[$i]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeSer[$i]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>

                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client, 'id' => $demandeSer[$i]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->fin)->format('d/m/y') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>


                    <div class="kanban-column">
                        <h5 class="kanban-header">IMPRESSION DESSIN</h5>
                        @for ($i = 0; $i < count($demandeSer); $i++)
                            @if ($demandeSer[$i]->etat_impression_dession == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeSer[$i]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeSer[$i]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>

                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client, 'id' => $demandeSer[$i]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->fin)->format('d/m/y') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endfor

                        @for ($j = 0; $j < count($demandeChangeStade); $j++)
                            @if ($demandeChangeStade[$j]->etat_impression_dession == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeChangeStade[$j]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeChangeStade[$j]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>

                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeChangeStade[$j]->id_demande_client, 'id' => $demandeChangeStade[$j]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->fin)->format('d/m/y') }}
                                            </a>
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
                            @if ($demandeSer[$i]->etat_recher_coloris_validaint == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeSer[$i]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeSer[$i]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>

                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client, 'id' => $demandeSer[$i]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->fin)->format('d/m/y') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor

                        @for ($j = 0; $j < count($demandeChangeStade); $j++)
                            @if ($demandeChangeStade[$j]->etat_recher_coloris_validaint == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeChangeStade[$j]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeChangeStade[$j]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>

                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeChangeStade[$j]->id_demande_client, 'id' => $demandeChangeStade[$j]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->fin)->format('d/m/y') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">INSOLATION CADRE</h5>
                        @for ($i = 0; $i < count($demandeSer); $i++)
                            @if ($demandeSer[$i]->etat_insolacadre == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeSer[$i]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeSer[$i]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>

                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client, 'id' => $demandeSer[$i]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->fin)->format('d/m/y') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor

                        @for ($j = 0; $j < count($demandeChangeStade); $j++)
                            @if ($demandeChangeStade[$j]->etat_insolacadre == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeChangeStade[$j]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeChangeStade[$j]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>

                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeChangeStade[$j]->id_demande_client, 'id' => $demandeChangeStade[$j]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->fin)->format('d/m/y') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">RACLAGE</h5>
                        @for ($i = 0; $i < count($demandeSer); $i++)
                            @if ($demandeSer[$i]->etat_raclage == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeSer[$i]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeSer[$i]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>

                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeSer[$i]->id_demande_client, 'id' => $demandeSer[$i]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeSer[$i]->fin)->format('d/m/y') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor

                        @for ($j = 0; $j < count($demandeChangeStade); $j++)
                            @if ($demandeChangeStade[$j]->etat_raclage == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeChangeStade[$j]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeChangeStade[$j]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>

                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeChangeStade[$j]->id_demande_client, 'id' => $demandeChangeStade[$j]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->fin)->format('d/m/y') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">ACHAT ENCRE PROD</h5>
                        @for ($j = 0; $j < count($demandeChangeStade); $j++)
                            @if ($demandeChangeStade[$j]->etat_achat_encre_prod == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeChangeStade[$j]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeChangeStade[$j]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>

                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeChangeStade[$j]->id_demande_client, 'id' => $demandeChangeStade[$j]->id]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeChangeStade[$j]->fin)->format('d/m/y') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor

                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">GABARITS</h5>
                        @for ($p = 0; $p < count($demandeProd); $p++)
                            @if ($demandeProd[$p]->etat_gabarits == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeProd[$p]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeProd[$p]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>


                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeProd[$p]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeProd[$p]->fin)->format('d/m/y') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">PREPARATION TABLE</h5>
                        @for ($p = 0; $p < count($demandeProd); $p++)
                            @if ($demandeProd[$p]->etat_prepa_table == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeProd[$p]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeProd[$p]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>

                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeProd[$p]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeProd[$p]->fin)->format('d/m/y') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="kanban-column">
                        <h5 class="kanban-header">PREPARATION ENCRE PROD</h5>
                        @for ($p = 0; $p < count($demandeProd); $p++)
                            @if ($demandeProd[$p]->etat_prepa_encre_prod == 1)
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
                                            @php
                                                $deadline = \Carbon\Carbon::parse($demandeProd[$p]->deadline);
                                                $fin = \Carbon\Carbon::parse($demandeProd[$p]->fin);
                                            @endphp

                                            <a href="#"
                                                class="btn btn-sm mt-1 {{ $fin->gt($deadline) ? 'btn-danger' : 'btn-warning' }}">
                                                <i
                                                    class="fas {{ $fin->gt($deadline) ? 'fa-clock' : 'fa-clock' }}"></i>
                                                {{ $deadline->gt($fin) ? $deadline->format('d/m/y') : $deadline->format('d/m/y') }}
                                            </a>

                                            <a href="{{ route('SERIGRAPHIE.detailDemandeSerigraphie', ['idDemande' => $demandeProd[$p]->id_demande_client]) }}"
                                                class="btn btn-primary btn-info btn-sm mt-1" style="width: 50px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success btn-sm mt-1" id="linkToDisable">
                                                <i class="fas fa-check"></i> <!-- Icône indiquant la fin -->
                                                {{ \Carbon\Carbon::parse($demandeProd[$p]->fin)->format('d/m/y') }}
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
                            <div class="row no-gutters mt-4">
                                <div class="col-12">
                                    <input type="hidden" id="idDemandeSer" name="idDemandeSer">
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
            var iddemandeser = button.data('id');
            var idetape = button.data('idetape');

            var modal = $(this);
            modal.find('#idDemandeSer').val(iddemandeser);
            modal.find('#idEtape').val(idetape);
        });
    });
</script>
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
