@include('CRM.header')
@include('CRM.sidebar')
@include('STYLE.MES.styleListeDemandeConfirme')


<div class="content-body">
    <div class="container-fluid">
        @include('MES.headerMES')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">LISTE DEMANDES CONFIRMÉS</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if($demandesConfirmes->isEmpty())
                                <p>Aucune demande confirmée disponible pour le moment.</p>
                            @else
                                <table class="table table-hover table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>id</th>
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
                                                <td>{{ $demandeConfirme->id }}</td>
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
