@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">

    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card">

            <div class="card-header py-3">
                <h4 class="text-primary m -0 font-weight-bold">Historique de retour de {{ $typeWMS->type }}</h4>
            </div>
            <div class="card-body">
                {{-- <form action="#" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idcategorietissu">
                                    <optgroup label="Catégorie du tissu">
                                        <option value="#">BIO</option>
                                        <option value="#">NON-BIO</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclassematierepremiere">
                                    <optgroup label="Catégorie de la matière">
                                        <option value="#">Current</option>
                                        <option value="#">En cours</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idutilisationwms">
                                    <optgroup label="Utilisation">
                                        <option value="#">Coupe type</option>
                                        <option value="#">Production</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idclient">
                                    <optgroup label="Client">
                                        <option value="#">JACADI</option>
                                        <option value="#">ORCHESTRA</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 mb-3">
                            <div class="input-group">
                                <select class="form-control w-50" name="idfournisseur">
                                    <optgroup label="Fournisseur">
                                        <option value="#">SOMACOU</option>
                                        <option value="#">SOCOTA</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="date" class="form-control" name="startEntree"
                                    value="{{ request()->startEntree }}">
                                <span class="input-group-addon b-0 text-white"
                                    style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                <input type="date" class="form-control" name="endEntree"
                                    value="{{ request()->endEntree }}">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group" id="date-range">
                                <input type="text" class="form-control" name="startEntree" placeholder="Recherche"
                                    value="{{ request()->startEntree }}">
                            </div>
                        </div>

                        <div class="col-1">
                            <button class="btn btn-success">Filtrer</button>
                        </div>
                    </div>
                </form> --}}
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Désignation</th>
                                <th>Réference</th>
                                <th>Couleur</th>
                                <th>Classe</th>
                                <th>Date du retour</th>
                                <th>Quantite retourner</th>
                                <th>Commentaire</th>
                            </tr>
                        </thead>
                        <tbody style="color: black">
                            @foreach ($retourWMS as $WMSretour)
                                <tr>
                                    <th>{{ $WMSretour->designation }}</th>
                                    <th>{{ $WMSretour->reference }}</th>
                                    <th>{{ $WMSretour->couleur }}</th>
                                    <th>{{ $WMSretour->classe }}</th>
                                    <th>{{ $WMSretour->dateretour }}</th>
                                    <th>{{ $WMSretour->qteretour }}</th>
                                    <th>{{ $WMSretour->commentaire }}</th>
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
