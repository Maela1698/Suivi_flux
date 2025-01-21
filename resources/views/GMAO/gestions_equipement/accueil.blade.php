@include('CRM.header')
@include('CRM.sidebar')

<style>
    .edit-icon i, .delete-icon i, .affect-icon i, .move-icon i {
        transition: color 0.3s ease;
    }

    .edit-icon:hover i {
        color: rgb(68, 255, 0);
    }

    .delete-icon:hover i {
        color: red;
    }

    .affect-icon:hover i {
        color: rgb(0, 89, 253);
    }

    .move-icon:hover i {
        color: rgb(255, 0, 140);
    }

    button i {
        margin-right: 5px;
    }

    button {
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0069d9; /* Couleur modifiée lors du hover */
    }

    thead th {
        font-weight: bold;
        color: black;
    }
    tbody td {
        color: black;
    }
    .d-block{
        color : black;
    }
    .card-body ul li {
        color: #333;
    }
    @media (max-width: 800px) {
        .card-body label {
            font-size: 14px; /* Réduit la taille des labels */
        }
        .card-body button {
            width: 100%; /* Le bouton occupe toute la largeur de l'écran */
            margin-top: 10px; /* Espacement supérieur */
        }
        .card-body ul li {
            flex-direction: column; /* Les icônes passent sous le texte sur les petits écrans */
            text-align: left;
            color: #333;
        }
    }

</style>
{{-- filtres --}}
<style>
        .form-container {
        padding: 15px; /* Ajoute un padding autour de l'ensemble du formulaire */
    }

    .form-container .input-group {
        margin-bottom: 10px; /* Espace entre les champs */
    }

    @media (max-width: 768px) {
        .form-container .input-group {
            margin-bottom: 15px; /* Plus d'espace sur les petits écrans */
        }

        .form-container .text-end {
            text-align: center; /* Centrer le bouton sur petits écrans */
        }
    }

    .input-group-addon {
        background-color: #6c757d; /* Ajuster la couleur de fond */
    }
</style>
{{-- ul nav bar --}}
<style>
        .nav-tabs-container {
        padding: 15px; /* Ajoute un padding autour de la navigation */
    }

    .nav-tabs .nav-link {
        margin-right: 5px; /* Ajoute un espace entre les liens */
    }

    .nav-tabs-container ul {
        border-bottom: 1px solid #ddd; /* Ajoute une bordure pour un effet propre */
    }
    .content-section{
        display: none;
    }
    .content-section.active{
        display: block;
    }

</style>
{{-- boutons dans les tableaux --}}
<style>
    .list-inline-item a {
        font-size: 19px;
        transition: transform 0.2s;
    }

    .list-inline-item a:hover {
        transform: scale(1.1);
    }
</style>
{{-- autocompletion --}}
<style>
    #suggestionsListMachine {
    max-height: 200px;
    overflow-y: auto;
    color: #767575;
    z-index: 5000;
    position: absolute; /* Permet de positionner l'élément par rapport à son conteneur */
    background-color: #fff;
    border: 1px solid #ccc;
    width: 100%; /* Assure que la largeur de la liste correspond à celle du champ */
    top: 100%; /* Place la liste juste en dessous du champ */
    left: 0; /* Aligne la liste avec le champ */
    }

    #suggestionsListCategorie{
    max-height: 200px;
    overflow-y: auto;
    color: #767575;
    z-index: 5000;
    position: absolute; /* Permet de positionner l'élément par rapport à son conteneur */
    background-color: #fff;
    border: 1px solid #ccc;
    width: 100%; /* Assure que la largeur de la liste correspond à celle du champ */
    top: 100%; /* Place la liste juste en dessous du champ */
    left: 0; /* Aligne la liste avec le champ */
    }
</style>
{{-- end auto-completion --}}

{{-- qr code --}}
<style>
    #reader{
        width: 300px;
    }
    #result{
        text-align: center;
    }
</style>
{{-- qr code --}}

<div class="content-body">
    <div class="container-fluid">
        @include('GMAO.headerGMAO')
        <form action="{{route('GMAO.accueilgmao')}}" method="get" autocomplete="off">
        {{-- KPI --}}
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="fas fa-fan text-warning"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Nbr Machines</div>
                            <div class="stat-digit">{{ number_format($nbrMachines) }} machine(s)</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="fa-regular fa-house text-success"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Nbr Locales</div>
                            <div class="stat-digit">{{ number_format($nbrMachineLocales) }} machine(s)</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-hand-point-right"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Nbr Empruntées</div>
                            <div class="stat-digit">{{ number_format($nbrMachineEmprunt) }} machine(s)</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-link text-danger border-danger"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Côut des Emprunts</div>
                            <div class="stat-digit">{{ number_format($cout_presta) }} €</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         {{--end  KPI --}}

         {{-- CONTENT --}}
            <div class="row">

        @csrf
            <div class="col-lg-2">
                <div class="card">
                    {{-- localisation et secteur --}}
                    <div class="card-body">
                        <div class="Localisation">
                            <label for="" class="d-block"><b>Localisations</b></label>
                            <ul class="list-unstyled">
                                @foreach($localisations as $localisation)
                                    <li>
                                        <button class="btn btn-xs btn-dark mt-2 localisation-btn"  id="id_localisation" data-id="{{ $localisation->id }}" name="idlocalisation">
                                            {{ $localisation->localisation }}

                                            <a href="#" class="edit-icon" data-id={{ $localisation->id }} data-bs-toggle="modal" data-bs-target="#updateLocalisationModal"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="delete-icon" data-id="{{ $localisation->id }}" data-localisation="{{ $localisation->localisation }}" data-bs-toggle="modal" data-bs-target="#deleteLocalisationModal">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </button>
                                    </li>
                                    {{-- <br> --}}
                                @endforeach
                            </ul>
                            <button type="button" class="btn btn-xs btn-primary mt-2 secteur-btn" data-bs-toggle="modal" data-bs-target="#addLocalisationModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="secteur">
                            <label for="" class="d-block"><b>Secteurs</b></label>
                            <ul>
                                <ul class="secteur-list">
                                </ul>
                            </ul>
                            <a href="{{route('GMAO.showajoutsecteur')}}">
                                <button type="button" class="btn btn-xs btn-primary mt-2" >
                                    <i class="fas fa-plus"></i>
                                </button>
                            </a>
                            {{-- data-bs-toggle="modal" data-bs-target="#addSecteurModal" --}}
                        </div>
                    </div>
                    {{-- localisation et secteur --}}
                </div>
            </div>
            {{-- CONTENT --}}
            <div class="col-lg-10">
                <div class="card">
                    {{-- filtre --}}
                    <div class="row form-container">
                        <!-- Fournisseur -->
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <label>Id Fournisseur</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="fournisseur" placeholder="ID depuis Fournisseur"
                                    value="{{ request()->fournisseur }}">
                            </div>
                        </div>

                        <!-- Marque -->
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            {{-- <label>Marques</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="marque" placeholder="Marque"
                                    value="{{ request()->marque }}">
                            </div> --}}
                            <label for="marque" class="col-form-label">Marque</label>
                            <input type="text" id="marque" class="form-control" required>
                            <input type="hidden" id="idmarque" class="form-control" name="marque">
                            <ul id="suggestionsListMarque" class="list-group mt-2" style="display: none;"></ul>
                        </div>

                        <!-- Code -->
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <label>Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="code" placeholder="Code"
                                    value="{{ request()->code }}">
                            </div>
                        </div>

                        <!-- Catégorie -->
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            {{-- <label>Catégorie</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="categorie" placeholder="Catégorie"
                                    value="{{ request()->categorie }}">
                            </div> --}}
                            <label for="categorie" class="col-form-label">Catégorie <small><em>**</em></small></label>
                            <input type="text" id="categorie" class="form-control" placeholder="Catégorie" required>
                            <input type="hidden" id="idcategorie" class="form-control" name="categorie">
                            <ul id="suggestionsListCategorie" class="list-group mt-2" style="display: none;"></ul>
                        </div>

                        <!-- Dates de fin de Service -->
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <label>Dates de fin de Service</label>
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="start_fin_service">
                                <span class="input-group-addon b-0 text-white" style="width: 20px; text-align: center; justify-content: center; background-color: gray;">au</span>
                                <input type="date" class="form-control" name="end_fin_service">
                            </div>
                        </div>

                        <!-- Dates de fin de Contrat -->
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <label>Dates de fin de Contrat</label>
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="start_fin_contrat">
                                <span class="input-group-addon b-0 text-white" style="width: 20px; text-align: center; justify-content: center; background-color: gray;">au</span>
                                <input type="date" class="form-control" name="end_fin_contrat">
                            </div>
                        </div>
                        {{-- QR CODE --}}
                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2" id="result">
                            <label>Code Scannée</label>
                            <div class="input-group" id="date-range">
                                <input type="text" name="scanned_code" id='scanned_code' class="form-control"  placeholder="Code Scannée">
                            </div>
                        </div>


                        <div class="col-xs-12 col-md-6 col-lg-4" id="reader">
                            <video id="preview" width="100%"></video>
                        </div>


                        {{-- QR CODE --}}

                             {{-- <video id="preview" width="100%"></video> --}}

                        <!-- Filtrer Button -->

                        <div class="col-xs-12 col-md-12 text-end">
                            <button type="submit" class="btn btn-sm btn-success mt-2">
                                Filtrer
                            </button>
                        </div>
                        <div class="col-xs-12 col-md-12 text-end">
                            <a href="{{route('GMAO.showajoutmachine')}}">
                                <button type="button" class="btn btn-sm btn-info mt-2">
                                    Ajouter une Machine
                                </button>
                            </a>
                        </div>
                        <div class="col-xs-12 col-md-12 text-end">
                            <a href="">
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="qrScanButton">
                                    Scanner un QR Code
                                </button>
                            </a>
                        </div>
                        <div class="col-xs-12 col-md-12 text-end">
                        <a href="{{route('GMAO.showajoutpiece')}}">
                            <button type="button" class="btn btn-sm btn-warning mt-2">
                            <i class="fas fa-plus"></i> Ajouter une/des Pièces
                            </button>
                        </a>
                    </div>
                        {{-- <div id="qr-code-region" style="width: 300px; height: 300px; margin: auto; display: none;"></div> --}}
                        <div id="error-message" style="display: none; color: red; border: 1px solid red; padding: 10px; margin: 10px 0;">
                            <span id="error-text"></span>
                            <button onclick="closeError()">Fermer</button>
                        </div>
                    </div>
                    {{-- filtre --}}

                    <div class="card-header">
                        <h4 class="card-title">Nos Machines</h4>
                    </div>

                    <div class="nav-tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#" class="nav-link active" onclick="showSection('toutes')">Toutes les machines</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" onclick="showSection('locales')">Locales</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" onclick="showSection('empruntees')">Empruntées</a>
                            </li>
                        </ul>
                    </div>

                    {{-- toutes --}}
                    <div id="toutes" class="card-body content-section active">
                        <div class="table-responsive">
                            <h4 class="card-title">Toutes nos machines</h4>
                            <table class="table student-data-table m-t-20">
                                <thead>
                                    <tr class="head_table">
                                        <th>Type</th>
                                        <th>Photo</th>
                                        <th>Id depuis Fournisseur</th>
                                        <th>Marque</th>
                                        <th>Code</th>
                                        <th>Documentation</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($machines_all as $machine)
                                        <tr onclick="window.location.href = '{{ route('GMAO.detailsmachine', ['idmachine' => $machine->id_machine]) }}';" style="cursor: pointer;">
                                            @if ($machine->proprietee == 100)
                                            <td><span class="badge badge-primary">Proprietée</span></td>
                                            @else
                                            <td><span class="badge badge-warning">Emprunt</span></td>
                                            @endif
                                            <td>
                                                @if ($machine->photo)
                                                    <img src="data:image/jpeg;base64;{{ $machine->photo }}"  style="width: 50px; height: 50px;"/>
                                                @else
                                                    <img src="data:image/png;base64;{{ $machine->photo }}"  style="width: 50px; height: 50px;"/>
                                                @endif
                                            </td>
                                            <td>{{ $machine->id_from_fournisseur }}</td>
                                            <td>{{ $machine->marque }}</td>
                                            <td>{{ $machine->codemachine }}</td>
                                            <td>
                                                @if ($machine->dossier)
                                                    <a href="data:application/pdf;base64,{{ $machine->dossier }}" download="fiche_machine.pdf">{{$machine->nomdossier}}</a>
                                                @else
                                                    <span>No Document</span>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{route('GMAO.showaffectermachine',['idmachine' => $machine->id_machine])}}" class="affect-icon" title="AFFECTER">
                                                            <i class="fas fa-vector-square" c></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="{{route('GMAO.showdeplacermachine',['idmachine' => $machine->id_machine])}}"  title="DEPLACER" data-id={{ $machine->id}}  class="move-icon">
                                                            <i class="fas fa-share"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="{{route('GMAO.showupdatemachine',['idmachine' => $machine->id_machine])}}" class="edit-icon" title="Modifier">
                                                            <i class="fas fa-edit text-success"></i>
                                                        </a>
                                                    </li>

                                                    <li class="list-inline-item">
                                                        <a href="#" class="delete-icon" title="Supprimer" data-id="{{ $machine->id_machine }}" data-bs-toggle="modal" data-bs-target="#deleteMachineModal">
                                                            <i class="fas fa-trash-alt text-danger"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- toutes --}}

                    {{-- local --}}
                    <div id="locales" class="card-body content-section">
                        <div class="table-responsive">
                            <h4 class="card-title">Nos Machines : Locales</h4>
                            <table class="table student-data-table m-t-20">
                                <thead>
                                    <tr class="head_table">
                                        <th>Type</th>
                                        <th>Photo</th>
                                        <th>Id depuis Fournisseur</th>
                                        <th>Marque</th>
                                        <th>Code</th>
                                        <th>Documentation</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($locales as $machine)
                                        <tr onclick="window.location.href = '{{ route('GMAO.detailsmachine', ['idmachine' => $machine->id_machine]) }}';" style="cursor: pointer;">
                                            <td><span class="badge badge-primary">Proprietée</span></td>

                                            <td>
                                                @if ($machine->photo)
                                                    <img src="data:image/jpeg;base64,{{ $machine->photo }}" alt="Image" style="width: 50px; height: 50px;"/>
                                                @else
                                                    <span>No Image</span>
                                                @endif
                                            </td>
                                            <td>ID Fournisseur : {{ $machine->id_from_fournisseur }}</td>
                                            <td>{{ $machine->marque }}</td>
                                            <td>{{ $machine->codemachine}}</td>
                                            <td>
                                                @if ($machine->dossier)
                                                    <a href="data:application/pdf;base64,{{ $machine->dossier }}" download="fiche_machine.pdf">{{$machine->nomdossier}}</a>
                                                @else
                                                    <span>No Document</span>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="#" class="edit-icon" title="Modifier">
                                                            <i class="fas fa-edit text-success"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#" class="delete-icon" title="Supprimer" data-id="{{ $machine->id_machine }}" data-bs-toggle="modal" data-bs-target="#deleteMachineModal">
                                                            <i class="fas fa-trash-alt text-danger"></i>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- local --}}

                    {{-- emprunté --}}
                    <div id="empruntees" class="card-body content-section">
                        <div class="table-responsive">
                            <h4 class="card-title">Nos Machines : Empruntées</h4>
                            <table class="table student-data-table m-t-20">
                                <thead>
                                    <tr>
                                        <th>type</th>
                                        <th>Photo</th>
                                        <th>Id depuis Fournisseur</th>
                                        <th>Marque</th>
                                        <th>Code</th>
                                        <th>Catégorie</th>
                                        <th>Fournisseur</th>
                                        <th>Date Débute de Service</th>
                                        <th>Date Fin de Contrat</th>
                                        <th>Coût</th>
                                        <th>Documentation</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($emprunts as $emprunt)
                                        <tr onclick="window.location.href = '{{ route('GMAO.detailsmachine', ['idmachine' => $machine->id_machine]) }}';" style="cursor: pointer;" >
                                            <td><span class="badge badge-warning">Emprunt</span></td>
                                            <td>
                                                @if ($emprunt->photo)
                                                    <img src="data:image/jpeg;base64,{{ $emprunt->photo }}" alt="Image" style="width: 50px; height: 50px;"/>
                                                @else
                                                    <span>No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $emprunt->id_fournisseur_machine }}</td>
                                            <td>{{ $emprunt->marque }}</td>
                                            <td>{{ $emprunt->codemachine }}</td>
                                            <td>{{ $emprunt->categorie }}</td>
                                            <td>{{ $emprunt->nom_fournisseur }}</td>
                                            <td>{{ $emprunt->dateentreemachine }}</td>
                                            <td>{{ $emprunt->datefincontrat }}</td>
                                            <td>{{ $emprunt->cout_prestation }}</td>
                                            <td>
                                                @if ($emprunt->dossier)
                                                    <a href="data:application/pdf;base64,{{ $emprunt->dossier }}" download="fiche_machine.pdf">{{{$emprunt->nomdossier }}}</a>
                                                @else
                                                    <span>No Document</span>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="#" class="edit-icon" title="Modifier">
                                                            <i class="fas fa-edit text-success"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="#" class="delete-icon" title="Supprimer" data-id="{{ $machine->id_machine }}" data-bs-toggle="modal" data-bs-target="#deleteMachineModal">
                                                            <i class="fas fa-trash-alt text-danger"></i>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                     {{-- emprunté --}}
                </div>
            </div>
            {{-- END CONTENT --}}
        </form>


            </div>
        {{-- END CONTENT --}}
        <!-- Modal pour ajouter une localisation -->
        <div class="modal fade" id="addLocalisationModal" tabindex="-1" aria-labelledby="addLocalisationLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLocalisationLabel">Ajouter une nouvelle localisation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <form id="localisationForm">
                            <div class="mb-3">
                                <label for="localisation" class="form-label">Localisation</label>
                                <input type="text" class="form-control" id="localisation" name="localisation" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary" id="saveLocalisation">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal pour ajouter une localisation -->

        <!-- Modal pour supprimer une Localisation -->
        <div class="modal fade" id="updateLocalisationModal" tabindex="-1" aria-labelledby="updateLocalisationLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateLocalisationLabel">Modifier une localisation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <p>Apportez vos modifications</p>
                        <input type="text" name="modified_loc" id="modified_loc" value="">
                        <input type="hidden" name="idlocalisation_hidden" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="updateLocalisation">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal pour supprimer une machine -->

         <!-- Modal pour supprimer une Localisation -->
         <div class="modal fade" id="deleteLocalisationModal" tabindex="-1" aria-labelledby="deleteLocalisationLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteLocalisationLabel">Supprimer une localisation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous réellement retirer cette localisation ?
                        <input type="hidden" name="idlocalisation_hidden" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="deleteLocalisation">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal pour supprimer une machine -->

        <!-- Modal pour ajouter un secteur à une localisation-->
        <div class="modal fade" id="addSecteurModal" tabindex="-1" aria-labelledby="addSecteurLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSecteurLabel">Ajouter un nouveau secteur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="secteurForm">
                            <div class="mb-3">
                                <label for="secteurName" class="form-label">Nom du secteur</label>
                                <input type="text" class="form-control" id="secteurName" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary" id="saveSecteur">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal pour ajouter un secteur à une localisation-->

        {{-- Modal pour confirmation pour retirer la machine--}}
        <div class="modal fade custom-modal" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="fa fa-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous réellement retirer cette machine ?
                        <input type="hidden" name="idmachine_hidden" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                        <button type="button" class="btn btn-primary" id="confirmDeleteButton">Oui</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- end Modal pour confirmation --}}

        <!-- Modal pour supprimer une machine -->
        <div class="modal fade" id="deleteMachineModal" tabindex="-1" aria-labelledby="deleteMachineLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteMachineLabel">Supprimer une machine</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous réellement retirer cette machine ?
                        <input type="hidden" name="idmachine_hidden2" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="deleteMachine">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal pour supprimer une machine -->

        {{-- modifier un secteur --}}
        <div class="modal fade" id="updateSecteurModal" tabindex="-1" aria-labelledby="updateSecteurLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateSecteurLabel">Modifier le secteur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <form id="updateSecteurForm" method="POST" action="">
                        @csrf
                        @method('PUT') <!-- Utilisez PUT pour la mise à jour -->
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="idlocalisation" class="form-label">ID Localisation</label>
                                <input type="text" class="form-control" name="idlocalisation" id="idlocalisation" required>
                            </div>
                            <div class="mb-3">
                                <label for="secteur" class="form-label">Secteur</label>
                                <input type="text" class="form-control" name="secteur" id="secteur" required>
                            </div>
                            <input type="hidden" name="secteur_id" id="secteur_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- end modifier un secteur --}}

        <!-- Modal pour supprimer un secteur -->
        <div class="modal fade" id="deleteSecteurModal" tabindex="-1" aria-labelledby="deleteSecteurLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteSecteurLabel">Supprimer un secteur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous réellement supprimer ce secteur ?
                        <input type="hidden" name="idsecteur_hidden" id="idsecteur_hidden" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="confirmDeleteSecteur">Confirmer</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Modal pour supprimer un secteur -->

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jsqr/1.4.0/jsQR.js"></script>


{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script> --}}
{{-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}



{{-- <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script> --}}



{{-- <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script> --}}
{{-- <script type="text/javascript" src="instascan.min.js"></script> --}}

{{-- auto-completion --}}
    {{-- marquemachine --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var marque = document.getElementById('marque');
            var idmarque= document.getElementById('idmarque');
            var suggestionsList = document.getElementById('suggestionsListMarque');

            marque.addEventListener('input', function () {
                var query = marque.value;

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route("findmarquemachine") }}?marque=' + encodeURIComponent(query), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var marque_machine = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';
                        if (marque_machine.length > 0) {
                            marque_machine.forEach(function (f) {
                                var li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = f.marque;
                                li.addEventListener('click', function () {
                                    marque.value = f.marque;
                                    idmarque.value = f.id;
                                    suggestionsList.style.display = 'none';
                                });
                                suggestionsList.appendChild(li);
                            });
                            suggestionsList.style.display = 'block';
                        } else {
                            suggestionsList.style.display = 'none';
                        }
                    }
                };
                xhr.send();
            });

            document.addEventListener('click', function (event) {
                if (!marque.contains(event.target) && !suggestionsList.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script>
    {{-- marquemachine --}}

    {{-- categoriemachine--}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var categorie = document.getElementById('categorie');
            var idcategorie= document.getElementById('idcategorie');
            var suggestionsList = document.getElementById('suggestionsListCategorie');

            categorie.addEventListener('input', function () {
                var query = categorie.value;

                if (query.length < 1) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route("findcategoriemachine") }}?categorie=' + encodeURIComponent(query), true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var categorie_machine = JSON.parse(xhr.responseText);
                        suggestionsList.innerHTML = '';
                        if (categorie_machine.length > 0) {
                            categorie_machine.forEach(function (f) {
                                var li = document.createElement('li');
                                li.className = 'list-group-item';
                                li.textContent = f.categorie;
                                li.addEventListener('click', function () {
                                    categorie.value = f.categorie;
                                    idcategorie.value = f.id;
                                    suggestionsList.style.display = 'none';
                                });
                                suggestionsList.appendChild(li);
                            });
                            suggestionsList.style.display = 'block';
                        } else {
                            suggestionsList.style.display = 'none';
                        }
                    }
                };
                xhr.send();
            });

            document.addEventListener('click', function (event) {
                if (!categorie.contains(event.target) && !suggestionsList.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script>
    {{-- categoriemachine --}}

{{-- end auto-completion --}}
{{-- pour les menus de tableaux --}}
<script>
    function showSection(id) {
    let sections = document.querySelectorAll('.content-section');
    sections.forEach(section => section.classList.remove('active'));

    // Affiche la section avec l'ID correspondant
    document.getElementById(id).classList.add('active');
    }
</script>
{{--end pour les menus de tableaux --}}

{{-- ajout localisation --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const saveElementButton = document.getElementById('saveLocalisation');

        saveElementButton.addEventListener('click', function () {
            const localisationForm = document.getElementById('localisationForm');
            const formData = new FormData(localisationForm);

            const localisation = formData.get('localisation');

            // Valider les données avant de continuer
            if (!localisation) {
                alert('Veuillez remplir tous les champs requis.');
                return;
            }

            fetch('{{route('GMAO.createlocalisation')}}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const addLocalisationModal = new bootstrap.Modal(document.getElementById('addLocalisationModal'));
                    addLocalisationModal.hide();

                    localisationForm.reset();

                    alert('Localisation ajouté avec succès.');
                    location.reload();
                } else {
                    alert('Erreur lors de l\'ajout de la localisation.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'ajout de la localisation.');
            });
        });
    });
</script>
{{-- end ajout localisation --}}

{{-- supprimer une machine --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Écoutez les clics sur les icônes de suppression
        document.querySelectorAll('.delete-icon').forEach(function (element) {
            element.addEventListener('click', function () {
                // Récupérez l'ID de la machine à partir de l'attribut data-id
                const machineId = this.getAttribute('data-id');

                // Mettez à jour l'input caché avec l'ID de la machine
                document.querySelector('input[name="idmachine_hidden2"]').value = machineId;
            });
        });
    });

    document.getElementById('deleteMachine').addEventListener('click', function () {
        const machineId = document.querySelector('input[name="idmachine_hidden2"]').value;

        // Émettez une requête POST pour supprimer la machine
        fetch('{{ route('delete_update_machine') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: machineId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Vous pouvez ajouter ici le code pour retirer la ligne de la table
                alert('Machine supprimée avec succès');
                location.reload(); // Recharger la page pour voir les changements
            } else {
                alert(data.message || 'Erreur lors de la suppression de la machine');
            }
        })
        .catch(error => console.error('Erreur:', error));
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const localisationButtons = document.querySelectorAll('.localisation-btn');
        localisationButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Empêche le rechargement de la page
                const localisationId = this.dataset.id;

                // Appel AJAX pour récupérer les secteurs
                fetch(`/get-secteurs/${localisationId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur réseau'); // Gérer les erreurs réseau
                        }
                        return response.json();
                    })
                    .then(secteurs => {
                        const secteurList = document.querySelector('.secteur-list');
                        secteurList.innerHTML = ''; // Vider la liste actuelle des secteurs

                        // Remplir la liste des secteurs
                        secteurs.forEach(secteur => {
                            const li = document.createElement('li');
                            li.innerHTML = `
                                <button class="btn btn-xs btn-dark mt-2 secteur-btn" data-id="${secteur.id}">
                                    ${secteur.secteur}
                                    <input type="hidden" name="secteur" value="${secteur.id}">
                                    <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#updateSecteurModal"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="delete-icon" data-bs-toggle="modal" data-bs-target="#deleteSecteurModal"><i class="fas fa-trash-alt"></i></a>
                                </button>
                            `;
                            secteurList.appendChild(li);
                        });
                    })
                    .catch(error => console.error('Erreur lors de la récupération des secteurs:', error));
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        // Ajout d'un écouteur d'événements pour les boutons de secteur
        const secteurButtons = document.querySelectorAll('.secteur-btn');
        secteurButtons.forEach(button => {
            button.addEventListener('click', function () {
                const secteurId = this.dataset.id;

                // Appel AJAX pour récupérer les machines
                fetch(`/get-machines/${secteurId}`)
                    .then(response => response.json())
                    .then(machines => {
                        // Logique pour afficher les machines dans votre tableau
                        const machinesTableBody = document.querySelector('#machines-table-body');
                        machinesTableBody.innerHTML = ''; // Vider le tableau actuel

                        machines.forEach(machine => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${machine.type}</td>
                                <td><img src="data:image/jpeg;base64,${machine.photo}" alt="Image" style="width: 50px; height: 50px;"/></td>
                                <td>${machine.id_fournisseur_machine}</td>
                                <td>${machine.marque}</td>
                                <td>${machine.codemachine}</td>
                                <td>${machine.categorie}</td>
                                <td>${machine.nom_fournisseur}</td>
                                <td>${machine.dateentreemachine}</td>
                                <td>${machine.datefincontrat}</td>
                                <td>${machine.cout_prestation}</td>
                                <td>${machine.dossier ? '<a href="data:application/pdf;base64,' + machine.dossier + '" download="fiche_machine.pdf">' + machine.nomdossier + '</a>' : 'No Document'}</td>
                                <td>
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="#" class="edit-icon" title="Modifier">
                                                <i class="fas fa-edit text-success"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" class="delete-icon" title="Supprimer" data-id="${machine.id_machine}">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            `;
                            machinesTableBody.appendChild(tr);
                        });
                    })
                    .catch(error => console.error('Erreur lors de la récupération des machines:', error));
            });
        });
    });
</script>
{{-- end supprimer une machine --}}


{{-- modifier localisation --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ouvrir le modal avec les informations actuelles de la localisation
        document.querySelectorAll('.edit-icon').forEach(function (element) {
            element.addEventListener('click', function () {
                const localisationId = this.getAttribute('data-id');
                const localisationNom = this.getAttribute('data-localisation');

                // Remplir les champs dans le modal
                document.querySelector('#modified_loc').value = localisationNom;
                document.querySelector('input[name="idlocalisation_hidden"]').value = localisationId;
            });
        });
    });

    // Écouter le clic pour la mise à jour
    document.getElementById('updateLocalisation').addEventListener('click', function () {
        const localisationId = document.querySelector('input[name="idlocalisation_hidden"]').value;
        const modifiedLoc = document.getElementById('modified_loc').value;

        fetch('{{ route('update_localisation_machine') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: localisationId, modified_loc: modifiedLoc })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Localisation mise à jour avec succès');
                location.reload(); // Recharger la page pour voir les modifications
            } else {
                alert(data.message || 'Erreur lors de la mise à jour de la localisation');
            }
        })
        .catch(error => console.error('Erreur:', error));
    });
</script>
{{-- modifier localisation --}}

{{-- supprimer une localisation --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-icon').forEach(function (element) {
            element.addEventListener('click', function () {
                const localisationId = this.getAttribute('data-id');

                document.querySelector('input[name="idlocalisation_hidden"]').value = localisationId;

                // Initialisation du modal
                let deleteModal = new bootstrap.Modal(document.getElementById('deleteLocalisationModal'));
                deleteModal.show();
            });
        });

        document.getElementById('deleteLocalisation').addEventListener('click', function () {
            const localisationId = document.querySelector('input[name="idlocalisation_hidden"]').value;

            if (localisationId) {
                fetch('{{ route('delete_update_localisation') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id: localisationId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Localisation supprimée avec succès');

                        // Masquer le modal avant le rechargement
                        let deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteLocalisationModal'));
                        deleteModal.hide();

                        // Recharger la page après un léger délai
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        alert(data.message || 'Erreur lors de la suppression de la localisation');
                    }
                })
                .catch(error => console.error('Erreur:', error));
            } else {
                alert('ID de localisation non défini');
            }
        });
    });
</script>
{{-- end supprimer une localisation --}}


{{-- modifier et delte secteur --}}
<script>
        $(document).on('click', '.secteur-btn', function() {
        const id = $(this).data('id');
        const secteurName = $(this).text().trim();

        $('#secteur_id').val(id);
        $('#secteur').val(secteurName);

        // Mettre à jour l'action du formulaire
        $('#updateSecteurForm').attr('action', `/secteurs/${id}`); // Assurez-vous que l'URL est correcte
    });

    $(document).on('click', '.delete-icon', function() {
        const id = $(this).closest('.secteur-btn').data('id');
        $('#idsecteur_hidden').val(id);
    });

    // Assurez-vous de gérer la confirmation de la suppression
    $('#confirmDeleteSecteur').on('click', function() {
        const id = $('#idsecteur_hidden').val();
        // Effectuer une requête pour supprimer le secteur
        $.ajax({
            url: `/secteurs/${id}/update-etat`, // Assurez-vous que l'URL est correcte
            type: 'PUT', // Ou DELETE selon votre route
            success: function(response) {
                location.reload(); // Rechargez la page après la suppression
            },
            error: function(xhr) {
                // alert('Erreur lors de la suppression : ' + xhr.responseText);
                console.logs('Erreur lors de la suppression : ' + xhr.responseText);

            }
        });
    });

</script>

{{-- Start QR CODE --}}


{{-- 02-11-2024 : TEST 2 --}}
<script>
    const scanner = new Html5QrcodeScanner('reader',{
        qrbox:{
            width : 150,
            height: 150,
            },
        fps:60,
    });

    scanner.render(success,error);

    function success(result) {
    console.log(result);
    document.getElementById('scanned_code').value = result;

    fetch(`/GMAO/getMachinesByCode/${result}`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 1) {
                // Redirection vers detailsmachine avec l'id de la machine trouvée
                window.location.href = `/GMAO/detailsmachine/${data[0]}`;
            } else if (data.length > 1) {
                showError('Plusieurs machines correspondent à ce code.');
            } else {
                showError('Aucune machine trouvée avec ce code.');
            }
        })
        .catch(error => showError('Erreur lors de la récupération des données : ' + error))
        .finally(() => {
            scanner.clear();
            document.getElementById('reader').remove();
        });
}

function showError(message) {
    document.getElementById('error-text').innerText = message;
    document.getElementById('error-message').style.display = 'block';
}

function closeError() {
    document.getElementById('error-message').style.display = 'none';
}

    function error(err)
    {
        console.error(err);
    }
</script>



{{-- END QR CODE --}}
@include('CRM.footer')


