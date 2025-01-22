@include('CRM.header')
@include('CRM.sidebar')
@include('STYLE.MES.styleFicheDemandeConfirme')

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('MES.headerMES')

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">FICHE DEMANDE CONFIRMÉ</h4>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">LISTE NUM OF</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-responsive-sm hover-table">
                                <thead>
                                    <tr>
                                        <th>CLIENT</th>
                                        <th>CODE COULEUR</th>
                                        <th>STYLE</th>
                                        <th>NUM COMMANDE</th>
                                        <th>DESIGNATION</th>
                                        <th>MIN SIZE</th>
                                        <th>MAX SIZE</th>
                                        <th>QUANTITÉ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-toggle="modal" data-target=".bd-example-modal-lg">
                                        <td>ORCHESTRA</td>
                                        <td>--</td>
                                        <td>CALFAN</td>
                                        <td>5091072</td>
                                        <td>ROBE+BANDEAU</td>
                                        <td>3 MOIS</td>
                                        <td>23 MOIS</td>
                                        <td>3112</td>
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

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-responsive-sm">
                        <thead>
                            <tr>
                                <th>CLIENT</th>
                                <th>CODE COULEUR</th>
                                <th>STYLE</th>
                                <th>NUM COMMANDE</th>
                                <th>DESIGNATION</th>
                                <th>SIZE</th>
                                <th>QUANTITÉ</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="modal-tr">
                                <td>ORCHESTRA</td>
                                <td>--</td>
                                <td>CALFAN</td>
                                <td>5091072</td>
                                <td>ROBE+BANDEAU</td>
                                <td>3 MOIS</td>
                                <td>389</td>
                                <td>
                                    <div class="basic-form">
                                        <form>
                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" value="">hahahahahahaahahah
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>ORCHESTRA</td>
                                <td>--</td>
                                <td>CALFAN</td>
                                <td>5091072</td>
                                <td>ROBE+BANDEAU</td>
                                <td>6 MOIS</td>
                                <td>389</td>
                                <td>
                                    <div class="basic-form">
                                        <form>
                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" value="">
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>ORCHESTRA</td>
                                <td>--</td>
                                <td>CALFAN</td>
                                <td>5091072</td>
                                <td>ROBE+BANDEAU</td>
                                <td>9 MOIS</td>
                                <td>389</td>
                                <td>
                                    <div class="basic-form">
                                        <form>
                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" value="">
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>ORCHESTRA</td>
                                <td>--</td>
                                <td>CALFAN</td>
                                <td>5091072</td>
                                <td>ROBE+BANDEAU</td>
                                <td>12 MOIS</td>
                                <td>389</td>
                                <td>
                                    <div class="basic-form">
                                        <form>
                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" value="">
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>ORCHESTRA</td>
                                <td>--</td>
                                <td>CALFAN</td>
                                <td>5091072</td>
                                <td>ROBE+BANDEAU</td>
                                <td>18 MOIS</td>
                                <td>778</td>
                                <td>
                                    <div class="basic-form">
                                        <form>
                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" value="">
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>ORCHESTRA</td>
                                <td>--</td>
                                <td>CALFAN</td>
                                <td>5091072</td>
                                <td>ROBE+BANDEAU</td>
                                <td>23 MOIS</td>
                                <td>778</td>
                                <td>
                                    <div class="basic-form">
                                        <form>
                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input" value="">
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Suivre Flux</button>
            </div>
        </div>
    </div>
</div>
@include('CRM.footer')
