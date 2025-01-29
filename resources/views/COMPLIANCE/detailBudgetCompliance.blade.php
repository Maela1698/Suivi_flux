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
<title>DetailBudgetCompliance</title>
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
                <div class="d-flex justify-content-between align-items-center entete">

                    <h3 class="entete mt-3">DETAILS BUDGET :{{ $budgetCompliance[0]->valeur }}
                        {{ $budgetCompliance[0]->annee }} </h3>

                </div>
                <div class="card-body">
                    <div class="row g-0" style="background-color: rgb(239, 238, 238); border-radius: 10px;">

                        <div class="col-md-10">
                            <div class="card-body">

                                <p class="texte" style="font-size: 16px"><b>Budget
                                        previsionnel:</b>{{ number_format($budgetCompliance[0]->budget_previsionnel, 2, '.', ' ') }}</p>
                                <div class="table-responsive mt-3" style="margin-top: -15px;">
                                    <table class="table mt-3" style="color: black" style="border: 1">
                                        <thead>
                                            <tr>
                                                <th>DateEntree</th>
                                                <th>Montant</th>
                                                <th>BudgetReel</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($budget) > 0)
                                                @for ($i = 0; $i < count($budget); $i++)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($budget[$i]->date_entree)->format('d/m/y') }}
                                                        </td>
                                                        <td>{{ number_format($budget[$i]->montant, 2, '.', ' ') }}</td>
                                                        <td>{{ number_format($budget[$i]->solde_du, 2, '.', ' ') }}</td>
                                                    </tr>
                                                @endfor

                                            @endif

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                            <button type="button" data-toggle="modal" data-target="#budget" data-id="1"
                                style="width: 100px; height: 35px" class="btn btn-warning mr-3">Modifier</button>
                            <form action="{{ route('COMPLIANCEBUDGET.listeBudgetCompliance') }}" method="GET">
                                <button type="submit" class="btn btn-info mr-3" style="width: 100px; height: 35px">Voir
                                    liste</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal modif budget -->
            <div class="modal fade" id="budget" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="choixEtapeModalLabel">Modification budget
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('COMPLIANCEBUDGET.modifBudgetReel') }}" method="POST" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mt-1">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <input type="hidden" name="annee" value="{{ $budgetCompliance[0]->annee }}">
                                                <input type="hidden" name="norme" value="{{ $budgetCompliance[0]->id_norme }}">
                                                <input type="hidden" name="budgetPrevisionnel" value="{{ $budgetCompliance[0]->budget_previsionnel }}">
                                                <label class="col-form-label texte">Date modification</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="date" class="form-control" name="dateEntree" required>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-12 mt-2">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label texte">Budget reel</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" class="form-control" name="budgetReel" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="modal-footer mt-3">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-success">Enregistrer</button>
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
        modal end
***********************************-->







    <!--**********************************
        javascript start
***********************************-->




    <!--**********************************
        Content body end
***********************************-->
    @include('CRM.footer')
