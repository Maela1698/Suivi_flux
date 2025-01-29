@include('CRM.header')
@include('CRM.sidebar')
<title>ListeBudgetCompliance</title>

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
</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('COMPLIANCE.headerCompliance')


        <div class="row">
            <div class="card col-12">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="entete">LISTE BUDGET </h3>
                    <button type="button" data-toggle="modal" data-target="#budget"
                        class="btn btn-primary">Ajouter</button>
                </div>

                {{--  <form action="{{ route('COMPLIANCE.listeConstat') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-3">
                            <div class="input-group">
                               <input type="date" class="form-control" name="date" placeholder="Date" >
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="input-group">
                               <select class="form-control" name="section">
                                <option value="">Section</option>
                                @for ($s=0; $s<count($section);$s++)
                                <option value="{{ $section[$s]->designation }}">
                                    {{ $section[$s]->designation }}</option>
                                @endfor
                               </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <select class="form-control" name="priorite">
                                    <option value="">Priorite</option>
                                    <option value="1">Faible</option>
                                    <option value="2">Moyenne</option>
                                    <option value="3">Elevée</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-3">
                            <button class="btn btn-success" style="width: 100px">Filtrer</button>
                        </div>
                    </div>


                </form>  --}}

                <div class="table-responsive" style="margin-top: -15px;">

                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead>
                            <tr>
                                <th>Annee</th>
                                <th>Norme</th>
                                <th>BudgetPrevisionnel</th>
                                <th>BudgetReel</th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @for ($i = 0; $i < count($budget); $i++)
                            <tr onclick="window.location.href = '{{ route('COMPLIANCEBUDGET.detailBudgetNorme', ['norme' => $budget[$i]->id_norme,'annee' => $budget[$i]->annee]) }}';"
                                style="cursor: pointer;">
                                    <td>{{ $budget[$i]->annee }}</td>
                                    <td>{{ $budget[$i]->valeur }}</td>
                                    <td>{{ number_format($budget[$i]->budget_previsionnel, 2, '.', ' ') }}</td>
                                    <td>{{ number_format($budget[$i]->budget_reel, 2, '.', ' ') }}</td>
                                </tr>
                            @endfor


                        </tbody>
                    </table>
                </div>


            </div>
        </div>


        <!-- Modal ajout budget -->
        <div class="modal fade" id="budget" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Insertion budget
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('COMPLIANCEBUDGET.ajoutBudgetCompliance') }}" method="POST" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Date</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="datetime-local" class="form-control" name="dateOper">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-2">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Norme</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="norme">
                                                @for ($s = 0; $s < count($norme); $s++)
                                                    <option value="{{ $norme[$s]->id }}">
                                                        {{ $norme[$s]->valeur }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-2">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Budget réel</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="budgetReel" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-2">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Budget previsionnel</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="budgetPrevisionnel" required>
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

        @if (session('error'))
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel">⚠️Attention!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="texte" style="color: red">{{ session('error') }}</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    </div>
</div>


<!--**********************************
        modal start
***********************************-->




<!--**********************************
        javascript start
***********************************-->
<script>
    // Afficher automatiquement le modal si une erreur est présente
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            $('#errorModal').modal('show');
        @endif
    });
</script>
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
