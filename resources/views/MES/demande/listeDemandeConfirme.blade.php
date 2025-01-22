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
                            <table class="table table-hover table-responsive-sm">
                                <thead>
                                    <tr>
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
                                    <tr onclick="window.location.href='{{ route('MES.fiche-demande') }}'">
                                        <td>E25</td>
                                        <td>18/11/24</td>
                                        <td>18/12/24</td>
                                        <td>JACADI</td>
                                        <td>JACADI MODELE A</td>
                                        <td>PROTO_1</td>
                                        <td>1000</td>
                                    </tr>
                                    <tr onclick="window.location.href='{{ route('MES.fiche-demande') }}'">
                                        <td>E25</td>
                                        <td>17/11/24</td>
                                        <td>28/01/25</td>
                                        <td>JACADI</td>
                                        <td>JACADI MODELE Z</td>
                                        <td>PROTO_1</td>
                                        <td>1000</td>
                                    </tr>
                                    <tr onclick="window.location.href='{{ route('MES.fiche-demande') }}'">
                                        <td>E25</td>
                                        <td>17/11/24</td>
                                        <td>17/01/25</td>
                                        <td>JACADI</td>
                                        <td>JACADI MODELE X</td>
                                        <td>PROTO_1</td>
                                        <td>1000</td>
                                    </tr>
                                    <tr onclick="window.location.href='{{ route('MES.fiche-demande') }}'">
                                        <td>E24</td>
                                        <td>17/11/24</td>
                                        <td>17/12/24</td>
                                        <td>JACADI</td>
                                        <td>JACADI MODELE Y</td>
                                        <td>Non alloue</td>
                                        <td>1000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
    </div>
</div>
@include('CRM.footer')
