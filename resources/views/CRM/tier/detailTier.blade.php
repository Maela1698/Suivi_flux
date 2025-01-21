@include('CRM.header')
@include('CRM.sidebar')

<style>
    .entete {
        color: #7571f9;
        background-color: white;
    }

    .carte {
        color: white;
        background-color: white;
    }

    b {
        color: black;
    }

    th {
        color: black;
    }

    .texte {
        color: rgb(93, 93, 93);
    }

    .table {
        color: rgb(93, 93, 93);
    }

    .p-margin-left {
        margin-left: 100px;
    }
</style>

<div class="content-body">
    <div class="container-fluid mt-3">
        <!-- Include HeaderCrm and Reglage -->
        @include('CRM.headerCrm')
        <div style="margin-top: 10px;">
            @include('CRM.reglage')
        </div>

        <div class="card col-12 carte">
            <div class="card-header d-flex justify-content-between align-items-center entete">
                <h3 class="entete">DETAILS TIERS</h3>
            </div>

            <div class="card-body">
                <div class="card mb-2">
                    <div class="row g-0">
                        <div class="col-md-2 mt-2">
                            <center>
                                <!-- Dynamic Image and Links -->
                                <img src="data:image/png;base64,{{ $detail[0]->logo }}"
                                    class="img-fluid rounded-start mb-5" alt="Logo" width="200px" height="200px">
                                <p class="texte ms-3" style="margin-left: 10px;"><b>Site web:</b>
                                    {{ $detail[0]->website ? $detail[0]->website : 'Pas de site web' }}</p>

                                <p class="texte"><b>
                                    @if(count($cahiertier)>0)
                                        <a href="#"
                                        onclick="openPdfInNewTab('{{$cahiertier[0]->cahiercharge }}', event)">
                                        Dossier technique
                                        </a>
                                        @else
                                        <p>pas de dossier technique</p>
                                    @endif
                                   
                                </b>
                                </p>
                            </center>
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <p class="texte p-margin-left"><b>Date entrée :</b> {{ $detail[0]->dateentree }}</p>
                                <p class="texte p-margin-left"><b>Nom du tiers :</b> {{ $detail[0]->nomtier }}</p>
                                <p class="texte p-margin-left"><b>Pays :</b> {{ $detail[0]->pays }}</p>
                                <p class="texte p-margin-left"><b>Ville :</b> {{ $detail[0]->ville }}</p>
                                <p class="texte p-margin-left"><b>Code postal :</b> {{ $detail[0]->codepostal }}</p>
                                <p class="texte p-margin-left"><b>Adresse :</b> {{ $detail[0]->adresse }}</p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <p class="texte p-margin-left"><b>Tel :</b> {{ $detail[0]->numphone }}</p>
                                <p class="texte p-margin-left"><b>Email :</b> {{ $detail[0]->emailtier }}</p>
                                <p class="texte p-margin-left"><b>Acteur :</b> {{ $detail[0]->acteur }}</p>
                                <p class="texte p-margin-left"><b>Unité monétaire :</b>
                                    {{ $detail[0]->unite_monetaire }}</p>
                                <p class="texte p-margin-left"><b>Qualité :</b> {{ $detail[0]->qualite }}</p>
                                <p class="texte p-margin-left"><b>Etat :</b> {{ $detail[0]->etat }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Responsable</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Senior</th>
                                    <td>{{ $detail[0]->merchsenior }}</td>
                                    <td>{{ $detail[0]->emailmerchsenior }}</td>
                                    <td>{{ $detail[0]->contactmerchsenior }}</td>
                                </tr>
                                <tr>
                                    <th>Junior</th>
                                    <td>{{ $detail[0]->merchjunior }}</td>
                                    <td>{{ $detail[0]->emailmerchjunior }}</td>
                                    <td>{{ $detail[0]->contactmerchjunior }}</td>
                                </tr>
                                <tr>
                                    <th>Assistant(e)</th>
                                    <td>{{ $detail[0]->assistant }}</td>
                                    <td>{{ $detail[0]->emailassistant }}</td>
                                    <td>{{ $detail[0]->contactassistant }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nom Interlocuteur</th>
                                    <th>Email Interlocuteur</th>
                                    <th>Contact Interlocuteur</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($interlocateur as $inter)
                                    <tr>
                                        <td>{{ $inter->nominterlocateur }}</td>
                                        <td>{{ $inter->emailinterlocateur }}</td>
                                        <td>{{ $inter->contactinterlocateur }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                    <form action="{{ route('CRM.accueil') }}" method="GET">
                        <button type="submit" class="btn btn-info mr-3">Voir liste</button>
                    </form>

                    <form action="{{ route('CRM.updateTiers') }}" method="POST">
                        @csrf
                        <input type="hidden" name="idTiers" value="{{ $detail[0]->id }}">
                        <button type="submit" class="btn btn-warning mr-3">Modifier</button>
                    </form>

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                        Supprimer
                    </button>
                </div>
            </div>
        </div>


        <!-- Modal suppr demande -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous vraiment supprimer cet élément ?
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('CRM.deleteTiers') }}" method="POST">
                            @csrf
                            <input type="hidden" name="idTiers" id="deleteTiersId" value="{{ $detail[0]->id }}">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom JS -->
        <script>
            document.getElementById('confirmDelete').addEventListener('click', function() {
                // Action de suppression ici
                console.log("L'élément a été supprimé.");
                $('#deleteModal').modal('hide');
            });
        </script>
    </div>
</div>
</div>
@include('CRM.footer')
