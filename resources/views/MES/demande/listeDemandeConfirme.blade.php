@include('CRM.header')
@include('CRM.sidebar')
@include('STYLE.MES.styleListeDemandeConfirme')


<div class="content-body">
    <div class="container-fluid">
        @include('MES.headerMES')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-center">
                        <h4 class="card-title titre">LISTE DEMANDES CONFIRMÉS</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('MES.demande') }}" method="GET">
                                <div class="form-row">
                                    <div class="col-sm-0">
                                        <label class="control-label">SAISON</label>
                                        <select class="form-control">
                                            <option selected>--</option>
                                            <option>H24</option>
                                            <option>E24</option>
                                            <option>H25</option>
                                            <option>E25</option>
                                        </select>
                                    </div>
                                    <div class="col mt-2 mt-sm-0">
                                        <label class="control-label">DATE ENTRÉE</label>
                                        <div class="input-group" id="date-range">
                                            <input type="date" class="form-control" name="startEmmission">
                                            <span class="input-group-addon b-0 text-white"
                                                style="width: 20px; text-align: center; justify-content: center; background-color: gray;">à</span>
                                            <input type="date" class="form-control" name="endEmmission">
                                        </div>
                                    </div>
                                    <div class="col mt-2 mt-sm-0">
                                        <label class="control-label">DATE LIVRAISON</label>
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                    <div class="col mt-2 mt-sm-0">
                                        <label class="control-label">CLIENT</label>
                                        <input class="form-control" list="tiersList" name="id_tier" placeholder="CLIENT">
                                        <datalist id="tiersList">
                                            @foreach ($tiers as $tier)
                                                <option value="{{ $tier->nomtier }}">{{ $tier->nomtier }}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col mt-2 mt-sm-0">
                                        <label class="control-label">MODÈLE</label>
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                    <div class="col mt-2 mt-sm-0">
                                        <label class="control-label">STADE</label>
                                        <select class="form-control">
                                            <option selected>--</option>
                                            <option>En cours de nego</option>
                                            <option>Proto 1</option>
                                        </select>
                                    </div>
                                    <div class="col mt-2 mt-sm-0">
                                        <label class="control-label" style="color: white">---------------------------------------------------------------</label>
                                        <button type="submit" class="btn btn-success">Filtrer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            @if($demandesConfirmes->isEmpty())
                                <p>Aucune demande confirmée disponible pour le moment.</p>
                            @else
                                <table class="table table-hover table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <th>SAISON</th>
                                            <th>DATE ENTRÉE</th>
                                            <th>DATE LIVRAISON</th>
                                            <th>CLIENT</th>
                                            <th>MODÈLE</th>
                                            <th>STADE</th>
                                            <th>QUANTITÉ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($demandesConfirmes as $demandeConfirme)
                                            <tr onclick="window.location.href='{{ route('MES.fiche-demande',['id' => $demandeConfirme->id]) }}'">
                                                {{-- <td>{{ $demandeConfirme->id }}</td> --}}
                                                <td>
                                                    <div class="code">
                                                        <div class="circle{{ $demandeConfirme->hasOF ? ' hasOF' : ' noOF' }}"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $demandeConfirme->type_saison }}</td>
                                                <td>{{ $demandeConfirme->date_entree }}</td>
                                                <td>{{ $demandeConfirme->date_livraison }}</td>
                                                <td>{{ $demandeConfirme->nomtier }}</td>
                                                <td>{{ $demandeConfirme->nom_modele }}</td>
                                                <td>{{ $demandeConfirme->type_stade }}</td>
                                                <td>{{ $demandeConfirme->qte_commande_provisoire }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
    </div>
</div>
@include('CRM.footer')
