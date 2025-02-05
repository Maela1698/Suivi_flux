@include('CRM.header')
@include('CRM.sidebar')
@include('STYLE.MES.styleListeDemandeConfirme')

<div class="content-body">
    <div class="container-fluid">
        @include('MES.headerMES')
        <div class="row">
            <div class="card col-12">
                <div class="card">
                    <div class="card-header d-flex justify-center">
                        <h4 class="card-title titre entete">LISTE DEMANDES CONFIRMÉS</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('MES.demande') }}" method="GET">
                                <div class="form-row">
                                    <div class="col-sm-0">
                                        <label class="control-label">SAISON</label>
                                        <select class="form-control" name="id_saison">
                                            <option value="">Tout</option>
                                            @foreach ($saisons as $saison)
                                                <option value="{{ $saison->id }}" 
                                                    {{ request('id_saison') == $saison->id ? 'selected' : '' }}>
                                                    {{ $saison->type_saison }}
                                                </option>                                                
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col mt-0 mt-sm-0">
                                        <label class="control-label">CLIENT</label>
                                        <input class="form-control" list="tiersList" id="clientInput" placeholder="CLIENT" value="{{ $selectedTier ? $selectedTier->nomtier : '' }}">
                                        <input type="hidden" name="id_tier" id="clientIdInput" value="{{ request('id_tier') }}">
                                        
                                        <datalist id="tiersList">
                                            @foreach ($tiers as $tier)
                                                <option data-id="{{ $tier->id }}" value="{{ $tier->nomtier }}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col mt-0 mt-sm-0">
                                        <label class="control-label">MODÈLE</label>
                                        <input type="text" class="form-control" placeholder="" name="nom_modele" value="{{ request('nom_modele') }}">
                                    </div>
                                    <div class="col mt-0 mt-sm-0">
                                        <label class="control-label" style="color: white">---------------------------------------------------------------</label>
                                        <button type="submit" class="btn btn-success">Filtrer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if($demandesConfirmes->isEmpty())
                            <div class="alert alert-warning" style="margin-top: 3%">
                                <p>Aucune commande confirmée</p> 
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <th>SAISON</th>
                                            <td>DATE ENTRÉE</td>
                                            <th>DATE LIVRAISON</th>
                                            <th>CLIENT</th>
                                            <th>MODÈLE</th>
                                            <th>QUANTITÉ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($demandesConfirmes as $demandeConfirme)
                                            <tr onclick="window.location.href='{{ route('MES.fiche-demande',['id' => $demandeConfirme->id]) }}'">
                                                <td>
                                                    <div class="code">
                                                        <div class="circle{{ $demandeConfirme->hasof ? ' hasOF' : ' noOF' }}"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $demandeConfirme->type_saison }}</td>
                                                <td>{{ $demandeConfirme->date_entree }}</td>
                                                <td>{{ $demandeConfirme->date_livraison }}</td>
                                                <td>{{ $demandeConfirme->nomtier }}</td>
                                                <td>{{ $demandeConfirme->nom_modele }}</td>
                                                <td>{{ $demandeConfirme->qte_commande_provisoire }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
    </div>
</div>
@include('JS.MES.jsListeDemandeConfirme')
@include('CRM.footer')