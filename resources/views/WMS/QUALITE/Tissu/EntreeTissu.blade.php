@include('CRM.header')
@include('CRM.sidebar')
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
                            </tr>
                        </thead>
                        <tbody style="color: black">
                            @foreach ($historyEntree as $historyEntrees)
                                <tr>
                                    <th style="display: flex; align-items: center;">
                                        <div class="code" style="margin-right: 5px;">
                                            <div class="fa-circle"></div>
                                        </div>
                                        <div class="code" style="margin-right: 5px;">
                                            <div class="fa-circle"></div>
                                        </div>
                                        <div class="code" style="margin-right: 5px;">
                                            <div class="fa-circle"></div>
                                        </div>
                                        <div class="code" style="margin-right: 5px;">
                                            <div class="fa-circle"></div>
                                        </div>
                                        <div class="code">
                                            <div class="fa-circle"></div>
                                        </div>
                                    </th>


                                    <th>{{ $historyEntrees->famille_tissus }}</th>
                                    <th>{{ $historyEntrees->categorie }}</th>
                                    <th>{{ $historyEntrees->client }}</th>
                                    <th>{{ $historyEntrees->modele }}</th>
                                    <th>{{ $historyEntrees->des_tissu }}</th>
                                    <th>{{ $historyEntrees->classe }}</th>
                                    <th>{{ $historyEntrees->dateentree }}</th>
                                    <th>{{ $historyEntrees->qtecommande }}</th>
                                    <td>
                                        <a class="btn btn-facebook"
                                            href="{{ route('QUALITE.page-entree-rouleau-qualite', ['identreetissu' => $historyEntrees->id]) }}">Inspection</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@include('CRM.footer')
