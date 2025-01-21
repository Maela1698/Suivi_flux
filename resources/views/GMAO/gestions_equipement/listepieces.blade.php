@include('CRM.header')
@include('CRM.sidebar')

<style>
    .edit-icon i, .delete-icon i {
        transition: color 0.3s ease;
    }

    .edit-icon:hover i {
        color: rgb(68, 255, 0);
    }

    .delete-icon:hover i {
        color: red;
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
<div class="content-body">
    <div class="container-fluid">
        @include('GMAO.headerGMAO')
        {{-- <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="fas fa-fan text-warning"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">Nbr Pièces</div>
                            <div class="stat-digit">1,012</div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            {{-- CONTENT --}}
            <div class="col-lg-12">

                <div class="card">
                    <div class="row form-container">
                        <!-- Fournisseur -->
                        {{-- <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <label>Id Fournisseur</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="fournisseur" placeholder="Fournisseur"
                                    value="{{ request()->fournisseur }}">
                            </div>
                        </div> --}}

                        <!-- Marque -->
                        {{-- <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <label>Marques</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="marque" placeholder="Marque"
                                    value="{{ request()->marque }}">
                            </div>
                        </div> --}}

                        <!-- Code -->
                        {{-- <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <label>Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="code" placeholder="Code"
                                    value="{{ request()->code }}">
                            </div>
                        </div> --}}

                        <!-- Catégorie -->
                        {{-- <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                            <label>Catégorie</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="categorie" placeholder="Catégorie"
                                    value="{{ request()->categorie }}">
                            </div>
                        </div> --}}

                        <!-- Dates de fin de Service -->
                        {{-- <div class="col-xs-12 col-md-6 col-lg-4">
                            <label>Dates de fin de Service</label>
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="start_fin_service">
                                <span class="input-group-addon b-0 text-white" style="width: 20px; text-align: center; justify-content: center; background-color: gray;">au</span>
                                <input type="date" class="form-control" name="end_fin_service">
                            </div>
                        </div> --}}

                        <!-- Dates de fin de Contrat -->
                        {{-- <div class="col-xs-12 col-md-6 col-lg-4">
                            <label>Dates de fin de Contrat</label>
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="start_fin_contrat">
                                <span class="input-group-addon b-0 text-white" style="width: 20px; text-align: center; justify-content: center; background-color: gray;">au</span>
                                <input type="date" class="form-control" name="end_fin_contrat">
                            </div>
                        </div> --}}

                        <!-- Filtrer Button -->
                        {{-- <div class="col-xs-12 col-md-12 text-end">
                            <button type="submit" class="btn btn-sm btn-success mt-2">
                                Filtrer
                            </button>
                        </div> --}}
                        <div class="col-xs-12 col-md-12 text-end">
                            <a href="{{route('GMAO.accueilgmao')}}">
                                <button type="submit" class="btn btn-sm btn-info mt-2">
                                    Retour à l'accueil
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="card-header">
                        <h4 class="card-title">Nos Pièces</h4>
                    </div>

                    {{-- <div class="nav-tabs-container">
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
                    </div> --}}

                    {{-- toutes --}}
                    <div id="toutes" class="card-body content-section active">
                        <div class="table-responsive">
                            <h4 class="card-title">Toutes nos pièces</h4>
                            <table class="table student-data-table m-t-20">
                                <thead>
                                    <tr class="head_table">
                                        <th>Photo</th>
                                        <th>ID PIECE</th>
                                        <th>Designation</th>
                                        <th>Reference</th>
                                        <th>Duree Vie</th>
                                        <th>Nombre</th>
                                        <th>Date ajout</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pieces as $p)
                                    <tr>
                                        <td>
                                            {{-- {{$p->photo}} --}}
                                            @if ($p->photo)
                                                    <img src="data:image/png;base64;{{ $p->photo }}" style="width: 50px; height: 50px;"/>
                                                @else
                                                    <span>azertyuio</span>
                                                @endif

                                        </td>
                                        <td><span class="badge badge-primary">{{$p->id}}</span></td>
                                        <td>{{$p->designation}}</td>
                                        <td>{{$p->reference}}</td>
                                        <td>{{$p->dureevie}}</td>
                                        <td>
                                            {{$p->nombre}}
                                        </td>
                                        <td>
                                            {{$p->date_ajout_piece}}
                                        </td>
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- toutes --}}
                </div>
            </div>
            {{-- END CONTENT --}}
        </div>
        <!-- Modal pour ajouter une localisation -->


        <!-- Modal pour ajouter un secteur -->

    </div>
</div>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> --}}


{{-- <script>
    function showSection(id) {
    let sections = document.querySelectorAll('.content-section');
    sections.forEach(section => section.classList.remove('active'));

    // Affiche la section avec l'ID correspondant
    document.getElementById(id).classList.add('active');
}
</script> --}}

@include('CRM.footer')
