@include('CRM.header')
@include('CRM.sidebar')
<style>
    .status-circle {
        display: inline-block;
        width: 20px;
        /* Adjust size */
        height: 20px;
        border-radius: 50%;
        /* Makes the element circular */
        border: 2px solid #000;
        /* Optional: Add a border */
    }

    .status-container {
        display: flex;
        align-items: center;
        gap: 10px;
        /* Adds space between the circle and label */
    }

    .status-label {
        font-size: 16px;
        font-weight: bold;
    }

    .red {
        background-color: red;
    }

    .yellow {
        background-color: yellow;
        border-color: #000;
    }

    .green {
        background-color: green;
    }

    .grey {
        background-color: grey;
        border-color: greenyellow;
    }

    .grey-red {
        background-color: grey;
        border-color: red;
    }
</style>
<div class="content-body">

    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card">
            <div class="card-header py-3">
                <h4 class="text-primary m -0 font-weight-bold">Liste entrée tissu</h4>
            </div>
            <div class="card-body">
                <form class="mb-4" action="{{ route('QUALITE.filtre-entree-tissu') }}" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idcategorietissu">
                                    <optgroup label="Catégorie du tissu">
                                        <option value="">Selection du catégorie du tissu</option>
                                        @foreach ($categorie as $categories)
                                            <option value="{{ $categories->id }}">{{ $categories->categorie }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclassematierepremiere">
                                    <optgroup label="Classe du tissu">
                                        <option value="">Sélection de la classe</option>
                                        @foreach ($classeMatiere as $classeMatieres)
                                            <option value="{{ $classeMatieres->id }}">{{ $classeMatieres->classe }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idutilisationwms">
                                    <optgroup label="Utilisation">
                                        <option value="">Sélection de l'utilisation</option>
                                        @foreach ($utilisation as $utilisations)
                                            <option value="{{ $utilisations->id }}">{{ $utilisations->utilisation }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclient">
                                    <optgroup label="Client">
                                        <option value="">Sélection du client</option>
                                        @foreach ($client as $clients)
                                            <option value="{{ $clients->id }}">{{ $clients->nomtier }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idfournisseur">
                                    <optgroup label="Fournisseur">
                                        <option value="">Sélection du fournisseur</option>
                                        @foreach ($fournisseur as $fournisseurs)
                                            <option value="{{ $fournisseurs->id }}">{{ $fournisseurs->nomtier }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idfamilletissu">
                                    <optgroup label="Famille du tissu">
                                        <option value="">Selection de la famille du tissu</option>
                                        @foreach ($familleTissu as $familleTissus)
                                            <option value="{{ $familleTissus->id }}">
                                                {{ $familleTissus->famille_tissus }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="debut">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="fin">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="text" class="form-control" name="recherche" placeholder="Recherche">
                            </div>
                        </div>

                        <div class="col-1">
                            <button class="btn btn-success">Filtrer</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive table mt-2" id="dataTable" role="grid"
                    aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Inspection</th>
                                <th>Famille</th>
                                <th>Catégorie</th>
                                <th>Client</th>
                                <th>Modèle</th>
                                <th>Désignation</th>
                                <th>Classe</th>
                                <th>Date Entrée</th>
                                <th>Quantité commander</th>
                                <th>Inspection</th>
                                <th>Rapport Inspection</th>

                            </tr>
                        </thead>
                        <tbody style="color: black">
                            @foreach ($historyEntree as $historyEntrees)
                                <tr>
                                    <th data-identreetissu="{{ $historyEntrees->id }}"  onclick="importCSV(this)">
                                        <div class="status-container">
                                            @php
                                                $targetDate = \Carbon\Carbon::parse($historyEntrees->dateentree); // Replace with your target date
                                                $today = \Carbon\Carbon::now();
                                                $daysDifference = $today->diffInDays($targetDate);

                                                $statusClass = '';
                                                $statusLabel = '';

                                                if ($historyEntrees->conformite == 1) {
                                                    $statusClass = 'grey-red';
                                                    $statusLabel = 'Non conforme';
                                                } elseif (
                                                    isset(
                                                        $historyEntrees->conformite,
                                                        $historyEntrees->fabricinspection,
                                                        $historyEntrees->elongation,
                                                        $historyEntrees->nuance,
                                                        $historyEntrees->disgorging,
                                                    ) &&
                                                    $historyEntrees->conformite == 0 &&
                                                    $historyEntrees->fabricinspection == 0 &&
                                                    $historyEntrees->elongation == 0 &&
                                                    $historyEntrees->nuance == 0 &&
                                                    $historyEntrees->disgorging == 0
                                                ) {
                                                    $statusClass = 'grey';
                                                    $statusLabel = 'Finished';
                                                } elseif ($daysDifference >= 7) {
                                                    $statusClass = 'red';
                                                    $statusLabel = 'Critical';
                                                } elseif ($daysDifference >= 5) {
                                                    $statusClass = 'yellow';
                                                    $statusLabel = 'Warning';
                                                } else {
                                                    $statusClass = 'green';
                                                    $statusLabel = 'Safe';
                                                }

                                            @endphp
                                            <span class="status-circle {{ $statusClass }}"></span>
                                            <span class="status-label">{{ $statusLabel }}</span>
                                        </div>
                                    </th>


                                    <th data-identreetissu="{{ $historyEntrees->id }}"  onclick="importCSV(this)">{{ $historyEntrees->famille_tissus }}/{{ $historyEntrees->id }}</th>
                                    <th data-identreetissu="{{ $historyEntrees->id }}"  onclick="importCSV(this)">{{ $historyEntrees->categorie }}</th>
                                    <th data-identreetissu="{{ $historyEntrees->id }}"  onclick="importCSV(this)">{{ $historyEntrees->client }}</th>
                                    <th data-identreetissu="{{ $historyEntrees->id }}"  onclick="importCSV(this)">{{ $historyEntrees->modele }}</th>
                                    <th data-identreetissu="{{ $historyEntrees->id }}"  onclick="importCSV(this)">{{ $historyEntrees->des_tissu }}</th>
                                    <th data-identreetissu="{{ $historyEntrees->id }}"  onclick="importCSV(this)">{{ $historyEntrees->classe }}</th>
                                    <th data-identreetissu="{{ $historyEntrees->id }}"  onclick="importCSV(this)">{{ $historyEntrees->dateentree }}</th>
                                    <th data-identreetissu="{{ $historyEntrees->id }}"  onclick="importCSV(this)">{{ $historyEntrees->qtecommande }}</th>
                                    <td>
                                        <a class="btn btn-facebook"
                                            href="{{ route('QUALITETISSU.inspectionTissu',['identreetissu'=> $historyEntrees->id]) }}">Inspection</a>
                                    </td>
                                    <td>


                                        {{--  <a class="btn btn-facebook"
                                            href="{{ route('QUALITE.page-rapport-inspection-tissu', ['identreetissu' => $historyEntrees->id]) }}">Rapport
                                            Inspection</a  --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal import csv -->
            <div class="modal fade" id="formImportCSV" tabindex="-1" role="dialog"
                aria-labelledby="confirmationAccessoireLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="width: 360px" role="document">
                    <div class="modal-content modal-content-custom">
                        <form action="{{ route('QUALITE.import-rouleau-qualite-tissu') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationAccessoireLabel">Import CSV</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body texte">
                                <div class="form-validation mt-4">
                                    <input type="hidden" name="identreetissu"  id="identreetissus">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group">
                                                <label>Fichier CSV</label>
                                                <input type="file" class="form-control" name="csvImport"
                                                    accept=".csv" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Importer des Rouleaux</button>
                            </div>
                        </form>
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
                            @if (session('error'))
                                <ul style="color: red;">
                                    <li>{{ session('error') }}</li>
                                </ul>
                            @endif
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

</div>
@include('CRM.footer')


<script>
    function importCSV(element) {

        var identreetissu = element.getAttribute('data-identreetissu');
        document.getElementById('identreetissus').value = identreetissu;

        var modal = new bootstrap.Modal(document.getElementById('formImportCSV'));
        modal.show();
    }
</script>

<script>
    // Afficher automatiquement le modal si une erreur est présente
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            $('#errorModal').modal('show');
        @endif
    });
</script>
