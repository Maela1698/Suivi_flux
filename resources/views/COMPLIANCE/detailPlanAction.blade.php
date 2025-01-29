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

@include('CRM.header')
<title>DetailPlanAction</title>
@include('CRM.sidebar')

<!--**********************************
        Content body start
***********************************-->

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('COMPLIANCE.headerCompliance')


        <div class="col-md-12">
            <div class="card col-12 carte">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="entete">DETAIL PLAN ACTION</h3>
                    @if (!empty($planAction[0]->datebudget))
                    <button type="button" data-toggle="modal" data-target="#budget" class="btn btn-primary">Modifier Budget</button>
                    @endif

                </div>
                <div class="card-body">
                    <div class="row g-0" style="background-color: rgb(239, 238, 238); border-radius: 10px;">
                        <div class="col-md-2 mt-3">
                            <center>
                                <p class="texte" style="font-size: 20px"><b>CONSTAT</b>
                            </center>
                            <p class="texte"><b>Description:</b> {{ $planAction[0]->constat }}</p>
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <center>
                                    <p class="texte" style="font-size: 20px"><b>PLAN ACTION</b>
                                </center>
                                <p class="texte"><b>Date :</b>
                                    {{ \Carbon\Carbon::parse($planAction[0]->datedebut)->format('d/m/y') }}</p>
                                <p class="texte"><b>Numero :</b> {{ $planAction[0]->numero }}</p>
                                <p class="texte"><b>Priorite :</b>
                                    @if ($planAction[0]->priorite == 1)
                                        Faible
                                    @elseif ($planAction[0]->priorite == 2)
                                        Moyenne
                                    @elseif ($planAction[0]->priorite == 3)
                                        Elevée
                                    @endif
                                </p>
                                <p class="texte"><b>Deadline :</b>
                                    {{ \Carbon\Carbon::parse($planAction[0]->deadline)->format('d/m/y') }}</p>
                                <p class="texte"><b>Commentaires :</b>{{ $planAction[0]->commentaires }}</p>
                                @if (!empty($planAction[0]->datebudget))
                                    <p class="texte"><b>Date budget :</b>
                                        {{ \Carbon\Carbon::parse($planAction[0]->datebudget)->format('d/m/y') }}</p>
                                @endif
                                @if (!empty($planAction[0]->budgetprevisionnel))
                                    <p class="texte"><b>Budget previsionnel
                                            :</b>{{ $planAction[0]->budgetprevisionnel }}</p>
                                @endif
                                @if (!empty($planAction[0]->budgetreel))
                                    <p class="texte"><b>Budget reel :</b>{{ $planAction[0]->budgetreel }}</p>
                                @endif
                                <div class="table-responsive mt-3" style="margin-top: -15px;">
                                    <table class="table mt-3" style="color: black" style="border: 1">
                                        <thead>
                                            <tr>
                                                <th>Moyens</th>
                                                <th>DateOperation</th>
                                                <th>Avancement</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($p = 0; $p < count($planAction); $p++)
                                                <tr>
                                                    <td>{{ $planAction[$p]->moyens }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($planAction[0]->dateavancement)->format('d/m/y') }}
                                                    </td>

                                                    <td>
                                                        @if ($planAction[$p]->avancement != 0)
                                                            {{ $planAction[$p]->avancement }}%
                                                        @else
                                                            0%
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                            <form action="{{ url()->previous() }}" method="GET">
                                <button type="submit" class="btn btn-info mr-3">Voir liste</button>
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
        modal end
***********************************-->







    <!--**********************************
        javascript start
***********************************-->



    <!--**********************************
        Content body end
***********************************-->
    @include('CRM.footer')
