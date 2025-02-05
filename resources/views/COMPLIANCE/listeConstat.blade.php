@include('CRM.header')
@include('CRM.sidebar')
<title>ListeConstat</title>

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
                    <h3 class="entete">LISTE CONSTAT</h3>
                    <button type="button" data-toggle="modal" data-target="#constat"
                        class="btn btn-primary">Ajouter</button>
                </div>

                <form action="{{ route('COMPLIANCE.listeConstat') }}" method="post" autocomplete="off">
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


                </form>

                <div class="table-responsive" style="margin-top: -15px;">
                    <table class="table student-data-table m-t-20 table-hover mt-3" style="color: black">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Date</th>
                                <th>Constat</th>
                                <th>Section</th>
                                <th>Priorite</th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @for ($i = 0; $i < count($constat); $i++)
                                <tr onclick="window.location.href = '{{ route('COMPLIANCE.detailConstat', ['id' => $constat[$i]->constat_id]) }}';"
                                    style="cursor: pointer;">
                                    <td>{{ $constat[$i]->constat_id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($constat[$i]->dateconstat)->format('d/m/y') }}</td>
                                    <td>
                                        <?php
                                        $descriptions = substr($constat[$i]->description, 0, 50);
                                        $hasMore = strlen($constat[$i]->description) > 50; // Vérifie si le texte est plus long que 50 caractères
                                        ?>
                                        {{ $descriptions }} @if($hasMore)...@endif
                                    </td>
                                    <td>{{ $constat[$i]->section }}</td>
                                    <td>
                                        @if ($constat[$i]->priorite == 1)
                                            Faible
                                        @elseif ($constat[$i]->priorite == 2)
                                            Moyenne
                                        @elseif ($constat[$i]->priorite == 3)
                                            Elevée
                                        @endif
                                    </td>
                                </tr>
                            @endfor


                        </tbody>
                    </table>
                </div>


            </div>
        </div>


        <!-- Modal ajout constat -->
        <div class="modal fade" id="constat" tabindex="-1" role="dialog" aria-labelledby="choixEtapeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 450px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="choixEtapeModalLabel">Insertion constat
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('COMPLIANCE.ajoutConstat') }}" method="POST" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 mt-1">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Date constat</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="date" class="form-control" name="dateConstat">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-2">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Section</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="section">
                                                @for ($s = 0; $s < count($section); $s++)
                                                    <option value="{{ $section[$s]->id }}">
                                                        {{ $section[$s]->designation }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-2">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Priorité</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="priorite">
                                                <option value="1">Faible</option>
                                                <option value="2">Moyenne</option>
                                                <option value="3">Elevée</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-2">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Description</label>
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-2">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label texte">Fichier</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="file" class="form-control" name="fichierConstat"
                                                accept="image/*" capture="camera">
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
        javascript start
***********************************-->

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
