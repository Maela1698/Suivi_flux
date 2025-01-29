<style>
    .entete {
        color: #7571f9;
        background-color: white;
        padding: 10px;
        border-bottom: 2px solid #7571f9;
    }

    .carte {
        color: black;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .texte {
        color: #333;
        font-size: 16px;
    }

    .table {
        color: black;
    }

    .qte {
        height: 50px;
        width: 100px;
    }

    .card-body {
        padding: 20px;
    }

    .card-header {
        background-color: #f7f7f7;
        border-bottom: 1px solid #ddd;
        padding: 10px 20px;
        font-size: 18px;
        font-weight: bold;
    }
</style>

@include('CRM.header')
<title>DetailConstat</title>
@include('CRM.sidebar')

<!--**********************************
        Content body start
***********************************-->

<div class="content-body">
    <div class="container-fluid">
        @include('COMPLIANCE.headerCompliance')

        <div class="col-md-12">
            <div class="card col-12 carte">
                <div class="card-header entete text-center">
                    <h3 class="mt-3">DETAILS QUESTIONNAIRE PROCEDURE</h3>
                </div>
                <div class="card-body">
                    <div class="row g-0" style="background-color: rgb(239, 238, 238); border-radius: 10px;">
                        <div class="col-md-5">
                            <div class="card-body">
                                <p class="texte"><b>Numéro :</b> {{ $questionnairesbyid[0]->numero }}</p>
                                <p class="texte"><b>Type Audit :</b> {{ $questionnairesbyid[0]->typeaudit }}</p>
                                <p class="texte"><b>Procédures :</b> {{ $questionnairesbyid[0]->departement }}</p>
                                <p class="texte"><b>Procédé :</b> {{ $questionnairesbyid[0]->procede }}</p>
                                <p class="texte"><b>Score :</b> {{ $questionnairesbyid[0]->score }}</p>
                                <p class="texte"><b>Question :</b> {{ $questionnairesbyid[0]->question }}</p>
                                <p class="texte"><b>Statut :</b> {{ $questionnairesbyid[0]->statut }}</p>
                                <p class="texte"><b>Criticité :</b> {{ $questionnairesbyid[0]->criticite }}
                                </p>
                                <p class="texte"><b>Liste des constats associés : <button type="submit"
                                            class="btn btn-info">Voir liste</button></b></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#ajoutConstatModal">Ajout Constat</button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="ajoutConstatModal" tabindex="-1" role="dialog"
                    aria-labelledby="ajoutConstatModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ajoutConstatModalLabel">Ajout Constat</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('COMPLIANCE.ajoutConstatProcedure') }}" method="POST"
                                    autocomplete="off" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="dateconstat">Date</label>
                                        <input type="date" class="form-control" id="dateconstat" name="dateconstat">
                                    </div>
                                    <div class="form-group">
                                        <label for="section_id">Section</label>
                                        <select class="form-control" id="section_id" name="section_id">
                                            @foreach ($section as $s)
                                                <option value="{{ $s->id }}">{{ $s->designation }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="priorite">Priorité</label>
                                        <select class="form-control" id="priorite" name="priorite">
                                            <option value="1">Faible</option>
                                            <option value="2">Moyenne</option>
                                            <option value="3">Élevée</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                    </div>
                                    <input type="hidden" id="typeaudit_id" name="typeaudit_id" value="<Perimetre>">
                                    <div class="form-group">
                                        <input type="file" class="form-control-file" id="file" name="file">
                                    </div>
                                    <input type="hidden" id="questionnaire_id" name="questionnaire_id"
                                        value="{{ $questionnairesbyid[0]->questionnaire_id }}">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulé</button>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade bd-example-modal-xl" id="listeConstatsModal" tabindex="-1" role="dialog"
            aria-labelledby="listeConstatsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="listeConstatsModalLabel">Liste des constats associés</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Constat</th>
                                    <th>Section</th>
                                    <th>Priorité</th>
                                    <th>Question</th>
                                </tr>
                            </thead>
                            <tbody style="cursor: pointer;">
                                @foreach ($constatassocie as $c)
                                    <tr
                                        onclick="window.location.href='{{ route('COMPLIANCE.detailConstatPerimetre', ['idconstat' => $c->constat_id]) }}';">
                                        <td>{{ \Carbon\Carbon::parse($c->dateconstat)->format('d/m/y') }}</td>
                                        <td>{{ Str::limit($c->description, 50, '...') }}</td>
                                        <td>{{ $c->section }}</td>
                                        @if($c->priorite==1)
                                        <td>Faible</td>
                                        @endif
                                        @if($c->priorite==2)
                                        <td>Moyen</td>
                                        @endif
                                        @if($c->priorite==3)
                                        <td>Elevé</td>
                                        @endif
                                        <td>{{ $c->question }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
        @include('CRM.footer')
    </div>

    <script>
        $(document).ready(function() {
            $('.btn-info').click(function() {
                $('#listeConstatsModal').modal('show');
            });
        });
    </script>
