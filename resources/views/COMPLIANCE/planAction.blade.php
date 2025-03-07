@include('CRM.header')
@include('CRM.sidebar')
@include('COMPLIANCE.STYLE.stylePlanAction')
<title>ListePlanAction</title>

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

</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('COMPLIANCE.headerCompliance')


        <div class="row">
            <div class="card col-12">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="entete">PLAN ACTION</h3>
                </div>

                <form action="{{ route('COMPLIANCE.listePlanAction') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-lg">
                            <div class="input-group">
                               <select class="form-control" name="id_section">
                                <option value="">Section</option>
                                @for ($s=0; $s<count($section);$s++)
                                    <option value="{{ $section[$s]->id }}"
                                        {{ request('id_section') == $section[$s]->id ? 'selected' : '' }}>
                                        {{ $section[$s]->designation }}
                                    </option>
                                @endfor
                               </select>
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="input-group">
                                <select class="form-control" name="priorite">
                                    <option value="">Priorite</option>
                                    <option value="1" {{ request('priorite') == 1 ? 'selected' : '' }}>Faible</option>
                                    <option value="2" {{ request('priorite') == 2 ? 'selected' : '' }}>Moyenne</option>
                                    <option value="3" {{ request('priorite') == 3 ? 'selected' : '' }}>Elevée</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg">
                            <input class="form-control" list="responsableListe" id="responsableInput" name="responsable" placeholder="Responsable" value="{{ request('responsable') }}">
                            <datalist id="responsableListe">
                                @foreach ($employees as $employe)
                                    <option data-id="{{ $employe->id }}" value="{{ $employe->nom }} {{ $employe->prenom }}"></option>
                                @endforeach
                            </datalist>
                            <input type="hidden" id="responsableId" name="responsable_id" value="{{ request('responsable_id') }}">
                        </div>
                        <div class="col-lg">
                            <input class="form-control" id="daterange" type="text" name="daterange" placeholder="deadline" value="{{ request('daterange') }}">
                        </div>
                        <div class="col-lg">
                            <button class="btn btn-success" style="width: 100px">Filtrer</button>
                            <button type="button" class="btn btn-primary" id="apercuPdfBtn">Apercu PDF</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-3" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Numero</th>
                                <th>Debut</th>
                                <th>Section</th>
                                <th>Constat</th>
                                <th>Moyens/Actions</th>
                                <th>Priorité</th>
                                <th>Responsable</th>
                                <th>Deadline</th>
                                <th>DateAvancement</th>
                                <th>Avancement</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @for ($i = 0; $i < count($planActions); $i++)
                                <tr>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planActions[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;"> {{ $planActions[$i]->planaction_id }}</td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planActions[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">{{ $planActions[$i]->numero }}</td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planActions[$i]->planaction_id]) }}';"
                                            style="cursor: pointer;">{{ $planActions[$i]->datedebut }}</td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planActions[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">{{ $planActions[$i]->section }}</td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planActions[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">
                                        <?php
                                        $descriptions1 = substr($planActions[$i]->constat, 0, 50);
                                        $hasMore1 = strlen($planActions[$i]->constat) > 50; // Vérifie si le texte est plus long que 50 caractères
                                        ?>
                                        {{ $descriptions1 }} @if ($hasMore1)
                                            ...
                                        @endif
                                    </td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planActions[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">
                                        <?php
                                        $descriptions = substr($planActions[$i]->moyens, 0, 50);
                                        $hasMore = strlen($planActions[$i]->moyens) > 50; // Vérifie si le texte est plus long que 50 caractères
                                        ?>
                                        {{ $descriptions }} @if ($hasMore)
                                            ...
                                        @endif
                                    </td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planActions[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">
                                        @if ($planActions[$i]->priorite == 1)
                                            Faible
                                        @elseif ($planActions[$i]->priorite == 2)
                                            Moyenne
                                        @elseif ($planActions[$i]->priorite == 3)
                                            Elevée
                                        @endif
                                    </td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planActions[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;"> {{ $planActions[$i]->prenom_responsable }}
                                    </td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planActions[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">{{ $planActions[$i]->deadline }}</td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planActions[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">{{ $planActions[$i]->dateavancement }}</td>
                                    <td onclick="window.location.href = '{{ route('COMPLIANCE.detailPlanAction', ['id' => $planActions[$i]->planaction_id]) }}';"
                                        style="cursor: pointer;">
                                        @if ($planActions[$i]->avancement != 0)
                                            {{ $planActions[$i]->avancement }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-finish mt-1 btn-sm"
                                            style="width: 120px;" data-toggle="modal" data-target="#avancement"
                                            data-id="{{ $planActions[$i]->planaction_id }}">
                                            <i class="fas fa-hourglass-half"></i> Avancement
                                        </button>
                                    </td>
                                </tr>
                            @endfor


                        </tbody>
                    </table>
                </div>


            </div>
        </div>


        <!-- Modal avancement -->
        <div class="modal fade" id="avancement" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Insertion avancement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('COMPLIANCE.ajoutAvancement') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <input type="hidden" id="idPlanAction" name="idPlanAction">
                                            <label class="col-form-label texte">Date opération</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="date" name="dateOper" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                           
                                        </div>
                                        <div class="col-12">
                                            <input type="hidden" name="designation" class="form-control" value="" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row no-gutters  mt-3">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Avancement(%)</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" name="avancement" class="form-control" required>
                                        </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        $('#avancement').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var etapeId = button.data('id');
            var modal = $(this);
            modal.find('#idPlanAction').val(etapeId);
        });
    });
</script>
<script>
    // Afficher automatiquement le modal si une erreur est présente
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            $('#errorModal').modal('show');
        @endif
    });
</script>
@include('COMPLIANCE.JS.jsPlanAction')
<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
